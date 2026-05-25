<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ==========================================
        // 1. PROCEDURES (Actions / Mutations)
        // ==========================================

        // Procedure 1: Schedule patient appointments
        DB::unprepared("
            CREATE OR REPLACE PROCEDURE schedule_patient_appointment(
                IN p_user_id BIGINT,
                IN p_date DATE,
                IN p_time TIME,
                IN p_patient_type VARCHAR,
                IN p_reason VARCHAR
            )
            LANGUAGE plpgsql
            AS $$
            BEGIN
                INSERT INTO appointments (user_id, appointment_date, appointment_time, patient_type, reason_for_visit, status, created_at, updated_at)
                VALUES (p_user_id, p_date, p_time, p_patient_type, p_reason, 'pending', NOW(), NOW());
            END;
            $$;
        ");

        // Procedure 2: Record treatments, diagnoses, and procedures
        DB::unprepared("
            CREATE OR REPLACE PROCEDURE record_patient_treatment(
                IN p_user_id BIGINT,
                IN p_appointment_id BIGINT,
                IN p_treatment_name VARCHAR,
                IN p_description TEXT,
                IN p_date DATE,
                IN p_time TIME
            )
            LANGUAGE plpgsql
            AS $$
            BEGIN
                -- Insert the treatment record
                INSERT INTO treatments (user_id, appointment_id, treatment_name, description, treatment_date, treatment_time, status, created_at, updated_at)
                VALUES (p_user_id, p_appointment_id, p_treatment_name, p_description, p_date, p_time, 'scheduled', NOW(), NOW());

                -- Automatically update the corresponding appointment status to 'confirmed' or 'completed'
                IF p_appointment_id IS NOT NULL THEN
                    UPDATE appointments 
                    SET status = 'confirmed', updated_at = NOW() 
                    WHERE id = p_appointment_id;
                END IF;
            END;
            $$;
        ");

        // Procedure 3: Finalize and complete a treatment with clinical notes
        DB::unprepared("
            CREATE OR REPLACE PROCEDURE complete_patient_treatment(
                IN p_treatment_id BIGINT,
                IN p_notes TEXT
            )
            LANGUAGE plpgsql
            AS $$
            DECLARE
                v_appointment_id BIGINT;
            BEGIN
                -- Update treatment to completed
                UPDATE treatments 
                SET status = 'completed', notes = p_notes, updated_at = NOW()
                WHERE id = p_treatment_id
                RETURNING appointment_id INTO v_appointment_id;

                -- If linked to an appointment, complete the appointment as well
                IF v_appointment_id IS NOT NULL THEN
                    UPDATE appointments 
                    SET status = 'completed', notes = CONCAT('Treatment finalized. ', p_notes), updated_at = NOW() 
                    WHERE id = v_appointment_id;
                END IF;
            END;
            $$;
        ");


        // ==========================================
        // 2. FUNCTIONS (Read-only / Calculations)
        // ==========================================

        // Function 1: Maintain patient treatment history count
        DB::unprepared("
            CREATE OR REPLACE FUNCTION get_patient_treatment_count(p_user_id BIGINT)
            RETURNS INTEGER
            LANGUAGE plpgsql
            AS $$
            DECLARE
                v_count INTEGER;
            BEGIN
                SELECT COUNT(*) INTO v_count
                FROM treatments
                WHERE user_id = p_user_id;
                
                RETURN v_count;
            END;
            $$;
        ");

        // Function 2: Get total scheduled appointments for a patient on a specific day
        DB::unprepared("
            CREATE OR REPLACE FUNCTION get_patient_daily_appointment_count(p_user_id BIGINT, p_date DATE)
            RETURNS INTEGER
            LANGUAGE plpgsql
            AS $$
            DECLARE
                v_count INTEGER;
            BEGIN
                SELECT COUNT(*) INTO v_count
                FROM appointments
                WHERE user_id = p_user_id 
                  AND appointment_date = p_date
                  AND status != 'cancelled';
                
                RETURN v_count;
            END;
            $$;
        ");

        // Function 3: Check if a patient already has a scheduled treatment at a specific date/time slot
        DB::unprepared("
            CREATE OR REPLACE FUNCTION has_treatment_time_conflict(p_user_id BIGINT, p_date DATE, p_time TIME)
            RETURNS BOOLEAN
            LANGUAGE plpgsql
            AS $$
            DECLARE
                v_conflict BOOLEAN;
            BEGIN
                SELECT EXISTS(
                    SELECT 1 FROM treatments
                    WHERE user_id = p_user_id
                      AND treatment_date = p_date
                      AND treatment_time = p_time
                      AND status != 'completed'
                ) INTO v_conflict;
                
                RETURN v_conflict;
            END;
            $$;
        ");


        // ==========================================
        // 3. TRIGGERS (Automated Event Handling)
        // ==========================================

        // Trigger 1: Prevent scheduling conflicts (Stops double-booking the exact same date and time for a patient)
        DB::unprepared("
            CREATE OR REPLACE FUNCTION check_appointment_time_clash()
            RETURNS TRIGGER 
            LANGUAGE plpgsql AS $$
            BEGIN
                IF EXISTS (
                    SELECT 1 FROM appointments 
                    WHERE user_id = NEW.user_id 
                      AND appointment_date = NEW.appointment_date
                      AND appointment_time = NEW.appointment_time
                      AND status NOT IN ('cancelled', 'completed')
                ) THEN
                    RAISE EXCEPTION 'Patient already has an active appointment scheduled at this exact time slot.';
                END IF;
                RETURN NEW;
            END;
            $$;

            CREATE OR REPLACE TRIGGER trg_pre_appointment_check
            BEFORE INSERT ON appointments
            FOR EACH ROW
            EXECUTE FUNCTION check_appointment_time_clash();
        ");

        // Trigger 2: Automatically auto-fills missing Treatment Times with the linked Appointment Time
        DB::unprepared("
            CREATE OR REPLACE FUNCTION sync_treatment_time_with_appointment()
            RETURNS TRIGGER 
            LANGUAGE plpgsql AS $$
            DECLARE
                v_app_time TIME;
            BEGIN
                IF NEW.treatment_time IS NULL AND NEW.appointment_id IS NOT NULL THEN
                    SELECT appointment_time INTO v_app_time 
                    FROM appointments 
                    WHERE id = NEW.appointment_id;
                    
                    NEW.treatment_time := v_app_time;
                END IF;
                RETURN NEW;
            END;
            $$;

            CREATE OR REPLACE TRIGGER trg_sync_treatment_time
            BEFORE INSERT ON treatments
            FOR EACH ROW
            EXECUTE FUNCTION sync_treatment_time_with_appointment();
        ");

        // Trigger 3: Audit log or restriction whenever an active treatment is cancelled/altered
        DB::unprepared("
            CREATE OR REPLACE FUNCTION enforce_completed_treatment_protection()
            RETURNS TRIGGER 
            LANGUAGE plpgsql AS $$
            BEGIN
                IF OLD.status = 'completed' AND NEW.status != 'completed' THEN
                    RAISE EXCEPTION 'Completed treatments cannot be reverted to scheduled or altered for patient safety audits.';
                END IF;
                RETURN NEW;
            END;
            $$;

            CREATE OR REPLACE TRIGGER trg_treatment_status_protection
            BEFORE UPDATE ON treatments
            FOR EACH ROW
            EXECUTE FUNCTION enforce_completed_treatment_protection();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop Triggers and Trigger Functions
        DB::unprepared("DROP TRIGGER IF EXISTS trg_treatment_status_protection ON treatments;");
        DB::unprepared("DROP FUNCTION IF EXISTS enforce_completed_treatment_protection();");
        
        DB::unprepared("DROP TRIGGER IF EXISTS trg_sync_treatment_time ON treatments;");
        DB::unprepared("DROP FUNCTION IF EXISTS sync_treatment_time_with_appointment();");

        DB::unprepared("DROP TRIGGER IF EXISTS trg_pre_appointment_check ON appointments;");
        DB::unprepared("DROP FUNCTION IF EXISTS check_appointment_time_clash();");

        // Drop Functions
        DB::unprepared("DROP FUNCTION IF EXISTS has_treatment_time_conflict(BIGINT, DATE, TIME);");
        DB::unprepared("DROP FUNCTION IF EXISTS get_patient_daily_appointment_count(BIGINT, DATE);");
        DB::unprepared("DROP FUNCTION IF EXISTS get_patient_treatment_count(BIGINT);");

        // Drop Procedures
        DB::unprepared("DROP PROCEDURE IF EXISTS complete_patient_treatment(BIGINT, TEXT);");
        DB::unprepared("DROP PROCEDURE IF EXISTS record_patient_treatment(BIGINT, BIGINT, VARCHAR, TEXT, DATE, TIME);");
        DB::unprepared("DROP PROCEDURE IF EXISTS schedule_patient_appointment(BIGINT, DATE, TIME, VARCHAR, VARCHAR);");
    }
};
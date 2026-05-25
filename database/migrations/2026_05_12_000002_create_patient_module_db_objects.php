<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ================================================================
        //  FUNCTIONS (3)
        // ================================================================

        // FUNCTION 1: Get a patient's full name
        DB::unprepared("
            CREATE OR REPLACE FUNCTION get_patient_fullname(p_patient_id INT)
            RETURNS VARCHAR AS \$\$
            DECLARE
                v_fullname VARCHAR;
            BEGIN
                SELECT first_name || ' ' || last_name
                INTO v_fullname
                FROM patients
                WHERE id = p_patient_id;

                RETURN v_fullname;
            END;
            \$\$ LANGUAGE plpgsql;
        ");

        // FUNCTION 2: Count how many times a patient has been admitted
        DB::unprepared("
            CREATE OR REPLACE FUNCTION get_admission_count(p_patient_id INT)
            RETURNS INT AS \$\$
            DECLARE
                v_count INT;
            BEGIN
                SELECT COUNT(*)
                INTO v_count
                FROM admissions
                WHERE patient_id = p_patient_id;

                RETURN v_count;
            END;
            \$\$ LANGUAGE plpgsql;
        ");

        // FUNCTION 3: Check if a patient is currently admitted
        DB::unprepared("
            CREATE OR REPLACE FUNCTION is_patient_admitted(p_patient_id INT)
            RETURNS BOOLEAN AS \$\$
            DECLARE
                v_result BOOLEAN;
            BEGIN
                SELECT EXISTS (
                    SELECT 1
                    FROM admissions
                    WHERE patient_id = p_patient_id
                      AND date_actual_leave IS NULL
                )
                INTO v_result;

                RETURN v_result;
            END;
            \$\$ LANGUAGE plpgsql;
        ");

        // ================================================================
        //  STORED PROCEDURES (3)
        // ================================================================

        // PROCEDURE 1: Register a new patient
        DB::unprepared("
            CREATE OR REPLACE PROCEDURE register_patient(
                p_first_name        VARCHAR,
                p_last_name         VARCHAR,
                p_date_of_birth     DATE,
                p_sex               CHAR(1),
                p_marital_status    VARCHAR,
                p_address           VARCHAR,
                p_phone_number      VARCHAR
            )
            LANGUAGE plpgsql AS \$\$
            BEGIN
                INSERT INTO patients (
                    first_name,
                    last_name,
                    date_of_birth,
                    sex,
                    marital_status,
                    address,
                    phone_number,
                    date_registered
                )
                VALUES (
                    p_first_name,
                    p_last_name,
                    p_date_of_birth,
                    p_sex,
                    p_marital_status,
                    p_address,
                    p_phone_number,
                    CURRENT_DATE
                );

                RAISE NOTICE 'Patient % % registered successfully.', p_first_name, p_last_name;
            END;
            \$\$;
        ");

        // PROCEDURE 2: Admit a patient to a ward
        DB::unprepared("
            CREATE OR REPLACE PROCEDURE admit_patient(
                p_patient_id    INT,
                p_ward_id       INT,
                p_bed_number    VARCHAR,
                p_expected_days INT
            )
            LANGUAGE plpgsql AS \$\$
            BEGIN
                IF is_patient_admitted(p_patient_id) THEN
                    RAISE EXCEPTION 'Patient ID % is already currently admitted.', p_patient_id;
                END IF;

                INSERT INTO admissions (
                    patient_id,
                    ward_id,
                    bed_number,
                    date_on_waiting_list,
                    expected_stay_days,
                    date_admitted,
                    date_expected_leave
                )
                VALUES (
                    p_patient_id,
                    p_ward_id,
                    p_bed_number,
                    CURRENT_DATE,
                    p_expected_days,
                    CURRENT_DATE,
                    CURRENT_DATE + p_expected_days
                );

                RAISE NOTICE 'Patient ID % admitted to Ward ID %, Bed %.', p_patient_id, p_ward_id, p_bed_number;
            END;
            \$\$;
        ");

        // PROCEDURE 3: Discharge a patient
        DB::unprepared("
            CREATE OR REPLACE PROCEDURE discharge_patient(
                p_patient_id        INT,
                p_discharge_notes   TEXT DEFAULT NULL
            )
            LANGUAGE plpgsql AS \$\$
            BEGIN
                IF NOT is_patient_admitted(p_patient_id) THEN
                    RAISE EXCEPTION 'Patient ID % has no active admission to discharge.', p_patient_id;
                END IF;

                UPDATE admissions
                SET date_actual_leave = CURRENT_DATE,
                    discharge_notes   = p_discharge_notes
                WHERE patient_id      = p_patient_id
                  AND date_actual_leave IS NULL;

                RAISE NOTICE 'Patient ID % has been discharged on %.', p_patient_id, CURRENT_DATE;
            END;
            \$\$;
        ");

        // ================================================================
        //  TRIGGERS (3)
        // ================================================================

        // TRIGGER 1: Auto-set date_registered on new patient insert
        DB::unprepared("
            CREATE OR REPLACE FUNCTION trg_set_date_registered()
            RETURNS TRIGGER AS \$\$
            BEGIN
                IF NEW.date_registered IS NULL THEN
                    NEW.date_registered := CURRENT_DATE;
                END IF;
                RETURN NEW;
            END;
            \$\$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            DROP TRIGGER IF EXISTS set_date_registered ON patients;
            CREATE TRIGGER set_date_registered
                BEFORE INSERT ON patients
                FOR EACH ROW
                EXECUTE FUNCTION trg_set_date_registered();
        ");

        // TRIGGER 2: Prevent admitting an already admitted patient
        DB::unprepared("
            CREATE OR REPLACE FUNCTION trg_prevent_double_admission()
            RETURNS TRIGGER AS \$\$
            BEGIN
                IF EXISTS (
                    SELECT 1
                    FROM admissions
                    WHERE patient_id      = NEW.patient_id
                      AND date_actual_leave IS NULL
                ) THEN
                    RAISE EXCEPTION 'Patient ID % is already admitted. Discharge them first.', NEW.patient_id;
                END IF;
                RETURN NEW;
            END;
            \$\$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            DROP TRIGGER IF EXISTS prevent_double_admission ON admissions;
            CREATE TRIGGER prevent_double_admission
                BEFORE INSERT ON admissions
                FOR EACH ROW
                EXECUTE FUNCTION trg_prevent_double_admission();
        ");

        // TRIGGER 3: Log when a patient is discharged
        DB::unprepared("
            CREATE TABLE IF NOT EXISTS discharge_log (
                log_id          SERIAL PRIMARY KEY,
                patient_id      INT,
                patient_name    VARCHAR,
                discharge_date  DATE,
                logged_at       TIMESTAMP DEFAULT NOW()
            );
        ");

        DB::unprepared("
            CREATE OR REPLACE FUNCTION trg_log_discharge()
            RETURNS TRIGGER AS \$\$
            BEGIN
                IF OLD.date_actual_leave IS NULL AND NEW.date_actual_leave IS NOT NULL THEN
                    INSERT INTO discharge_log (patient_id, patient_name, discharge_date)
                    VALUES (
                        NEW.patient_id,
                        get_patient_fullname(NEW.patient_id),
                        NEW.date_actual_leave
                    );
                END IF;
                RETURN NEW;
            END;
            \$\$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            DROP TRIGGER IF EXISTS log_discharge ON admissions;
            CREATE TRIGGER log_discharge
                AFTER UPDATE ON admissions
                FOR EACH ROW
                EXECUTE FUNCTION trg_log_discharge();
        ");
    }

    public function down(): void
    {
        // Drop triggers
        DB::unprepared("DROP TRIGGER IF EXISTS log_discharge ON admissions;");
        DB::unprepared("DROP TRIGGER IF EXISTS prevent_double_admission ON admissions;");
        DB::unprepared("DROP TRIGGER IF EXISTS set_date_registered ON patients;");

        // Drop trigger functions
        DB::unprepared("DROP FUNCTION IF EXISTS trg_log_discharge();");
        DB::unprepared("DROP FUNCTION IF EXISTS trg_prevent_double_admission();");
        DB::unprepared("DROP FUNCTION IF EXISTS trg_set_date_registered();");

        // Drop procedures
        DB::unprepared("DROP PROCEDURE IF EXISTS discharge_patient(INT, TEXT);");
        DB::unprepared("DROP PROCEDURE IF EXISTS admit_patient(INT, INT, VARCHAR, INT);");
        DB::unprepared("DROP PROCEDURE IF EXISTS register_patient(VARCHAR, VARCHAR, DATE, CHAR, VARCHAR, VARCHAR, VARCHAR);");

        // Drop functions
        DB::unprepared("DROP FUNCTION IF EXISTS is_patient_admitted(INT);");
        DB::unprepared("DROP FUNCTION IF EXISTS get_admission_count(INT);");
        DB::unprepared("DROP FUNCTION IF EXISTS get_patient_fullname(INT);");

        // Drop log table
        DB::unprepared("DROP TABLE IF EXISTS discharge_log;");
    }
};

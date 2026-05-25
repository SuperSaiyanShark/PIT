<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Add missing columns to existing wards table
        Schema::table('wards', function (Blueprint $table) {
            if (!Schema::hasColumn('wards', 'allocationid')) {
                $table->string('allocationid')->nullable();
            }
            if (!Schema::hasColumn('wards', 'wardNumber')) {
                $table->string('wardNumber')->nullable();
            }
            if (!Schema::hasColumn('wards', 'wardName')) {
                $table->string('wardName')->nullable();
            }
            if (!Schema::hasColumn('wards', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('wards', 'telExtn')) {
                $table->string('telExtn')->nullable();
            }
        });

        // Create beds table if not exists
        if (!Schema::hasTable('beds')) {
            Schema::create('beds', function (Blueprint $table) {
                $table->id();
                $table->string('bedNumber')->nullable();
                $table->string('wardNumber')->nullable();
                $table->string('status')->default('Available');
                $table->boolean('is_occupied')->default(false);
                $table->string('patient_name')->nullable();
                $table->timestamps();
            });
        }

        // ========== FUNCTIONS ==========

        DB::unprepared('
            CREATE OR REPLACE FUNCTION fn_update_updated_at()
            RETURNS TRIGGER
            LANGUAGE plpgsql
            AS $$
            BEGIN
                NEW.updated_at = NOW();
                RETURN NEW;
            END;
            $$
        ');

        DB::unprepared('
            CREATE OR REPLACE FUNCTION fn_auto_bed_status()
            RETURNS TRIGGER
            LANGUAGE plpgsql
            AS $$
            BEGIN
                IF NEW.status = \'Occupied\' AND OLD.status != \'Occupied\' THEN
                    NEW.is_occupied := TRUE;
                ELSIF NEW.status = \'Available\' AND OLD.status != \'Available\' THEN
                    NEW.is_occupied := FALSE;
                    NEW.patient_name := NULL;
                END IF;
                RETURN NEW;
            END;
            $$
        ');

        DB::unprepared('
            CREATE OR REPLACE FUNCTION fn_check_ward_capacity()
            RETURNS TRIGGER
            LANGUAGE plpgsql
            AS $$
            DECLARE
                current_occupied INTEGER;
                ward_capacity INTEGER;
            BEGIN
                IF NEW.status = \'Occupied\' AND OLD.status != \'Occupied\' THEN
                    SELECT COUNT(*) INTO current_occupied
                    FROM beds
                    WHERE "wardNumber" = NEW."wardNumber" AND status = \'Occupied\';
                    
                    SELECT capacity INTO ward_capacity
                    FROM wards
                    WHERE "wardNumber" = NEW."wardNumber";
                    
                    IF current_occupied >= ward_capacity THEN
                        RAISE EXCEPTION \'Ward capacity reached! Max: %\', ward_capacity;
                    END IF;
                END IF;
                RETURN NEW;
            END;
            $$
        ');

        // ========== TRIGGERS ==========

        DB::unprepared('
            DROP TRIGGER IF EXISTS trigger_beds_updated_at ON beds;
            CREATE TRIGGER trigger_beds_updated_at 
                BEFORE UPDATE ON beds 
                FOR EACH ROW 
                EXECUTE FUNCTION fn_update_updated_at()
        ');

        DB::unprepared('
            DROP TRIGGER IF EXISTS trigger_auto_bed_status ON beds;
            CREATE TRIGGER trigger_auto_bed_status 
                BEFORE UPDATE ON beds 
                FOR EACH ROW 
                WHEN (NEW.status IS DISTINCT FROM OLD.status)
                EXECUTE FUNCTION fn_auto_bed_status()
        ');

        DB::unprepared('
            DROP TRIGGER IF EXISTS trigger_check_ward_capacity ON beds;
            CREATE TRIGGER trigger_check_ward_capacity 
                BEFORE UPDATE ON beds 
                FOR EACH ROW 
                WHEN (NEW.status = \'Occupied\' AND OLD.status != \'Occupied\')
                EXECUTE FUNCTION fn_check_ward_capacity()
        ');

        // ========== PROCEDURES ==========

        DB::unprepared('
            CREATE OR REPLACE PROCEDURE sp_assign_bed(
                IN p_bed_number VARCHAR,
                IN p_ward_number VARCHAR
            )
            LANGUAGE plpgsql
            AS $$
            BEGIN
                UPDATE beds 
                SET status = \'Occupied\'
                WHERE "bedNumber" = p_bed_number 
                AND "wardNumber" = p_ward_number
                AND status = \'Available\';
                
                IF FOUND THEN
                    RAISE NOTICE \'Bed % assigned to patient\', p_bed_number;
                END IF;
            END;
            $$
        ');

        DB::unprepared('
            CREATE OR REPLACE PROCEDURE sp_release_bed(
                IN p_bed_number VARCHAR,
                IN p_ward_number VARCHAR
            )
            LANGUAGE plpgsql
            AS $$
            BEGIN
                UPDATE beds 
                SET status = \'Available\',
                    patient_name = NULL,
                    is_occupied = FALSE
                WHERE "bedNumber" = p_bed_number 
                AND "wardNumber" = p_ward_number;
                
                RAISE NOTICE \'Bed % released\', p_bed_number;
            END;
            $$
        ');

        DB::unprepared('
            CREATE OR REPLACE PROCEDURE sp_ward_summary(
                IN p_ward_number VARCHAR
            )
            LANGUAGE plpgsql
            AS $$
            DECLARE
                v_ward_name VARCHAR;
                v_total_beds INTEGER;
                v_occupied_beds INTEGER;
                v_available_beds INTEGER;
                v_capacity INTEGER;
            BEGIN
                SELECT "wardName", capacity INTO v_ward_name, v_capacity
                FROM wards WHERE "wardNumber" = p_ward_number;
                
                SELECT COUNT(*) INTO v_total_beds
                FROM beds WHERE "wardNumber" = p_ward_number;
                
                SELECT COUNT(*) INTO v_occupied_beds
                FROM beds WHERE "wardNumber" = p_ward_number AND status = \'Occupied\';
                
                v_available_beds := v_total_beds - v_occupied_beds;
                
                RAISE NOTICE \'=== Ward Summary ===\';
                RAISE NOTICE \'Ward Name: %\', v_ward_name;
                RAISE NOTICE \'Total Beds: %\', v_total_beds;
                RAISE NOTICE \'Occupied Beds: %\', v_occupied_beds;
                RAISE NOTICE \'Available Beds: %\', v_available_beds;
                RAISE NOTICE \'Capacity: %\', v_capacity;
            END;
            $$
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_ward_summary');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_release_bed');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_assign_bed');

        DB::unprepared('DROP TRIGGER IF EXISTS trigger_check_ward_capacity ON beds');
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_auto_bed_status ON beds');
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_beds_updated_at ON beds');

        DB::unprepared('DROP FUNCTION IF EXISTS fn_check_ward_capacity() CASCADE');
        DB::unprepared('DROP FUNCTION IF EXISTS fn_auto_bed_status() CASCADE');
        DB::unprepared('DROP FUNCTION IF EXISTS fn_update_updated_at() CASCADE');

        Schema::dropIfExists('beds');

        Schema::table('wards', function (Blueprint $table) {
            $table->dropColumn(['allocationid', 'wardNumber', 'wardName', 'location', 'telExtn']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION enforce_ward_staffing_limit()
            RETURNS TRIGGER
            LANGUAGE plpgsql
            AS \$\$
            DECLARE
                v_current_count INT;
                v_total_beds    INT;
                v_max_staff     INT;
                v_ward_name     VARCHAR(50);
            BEGIN
                -- Skip validation if ward_id is NULL
                IF NEW.ward_id IS NULL THEN
                    RETURN NEW;
                END IF;

                SELECT name, total_beds
                INTO v_ward_name, v_total_beds
                FROM wards WHERE id = NEW.ward_id;

                IF NOT FOUND THEN
                    RAISE EXCEPTION 'Ward ID % does not exist.', NEW.ward_id;
                END IF;

                v_max_staff := GREATEST(3, LEAST(10, v_total_beds / 2));

                SELECT COUNT(*) INTO v_current_count
                FROM schedules
                WHERE ward_id = NEW.ward_id
                  AND shift_date = NEW.shift_date;

                IF v_current_count >= v_max_staff THEN
                    RAISE EXCEPTION 'Ward \"%\" is fully staffed on % (% of % max allowed).',
                        v_ward_name, NEW.shift_date, v_current_count, v_max_staff;
                END IF;

                RETURN NEW;
            END;
            \$\$;

            CREATE OR REPLACE TRIGGER trg_enforce_ward_staffing_limit
            BEFORE INSERT ON schedules
            FOR EACH ROW
            EXECUTE FUNCTION enforce_ward_staffing_limit();
        ");
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_enforce_ward_staffing_limit ON schedules;');
        DB::unprepared('DROP FUNCTION IF EXISTS enforce_ward_staffing_limit();');
    }
};
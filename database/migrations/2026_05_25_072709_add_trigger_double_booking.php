<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION prevent_double_booking()
            RETURNS TRIGGER
            LANGUAGE plpgsql
            AS \$\$
            DECLARE
                v_existing_ward VARCHAR(50);
                v_staff_name    TEXT;
            BEGIN
                SELECT CONCAT(name) INTO v_staff_name
                FROM users WHERE id = NEW.staff_id;

                SELECT w.name INTO v_existing_ward
                FROM schedules sa
                JOIN wards w ON sa.ward_id = w.id
                WHERE sa.staff_id = NEW.staff_id
                  AND sa.shift_date = NEW.shift_date
                LIMIT 1;

                IF FOUND THEN
                    RAISE EXCEPTION '% is already assigned to Ward \"%\" on %. Cannot assign to multiple wards on the same day.',
                        v_staff_name, v_existing_ward, NEW.shift_date;
                END IF;

                RETURN NEW;
            END;
            \$\$;

            CREATE OR REPLACE TRIGGER trg_prevent_double_booking
            BEFORE INSERT ON schedules
            FOR EACH ROW
            EXECUTE FUNCTION prevent_double_booking();
        ");
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_prevent_double_booking ON schedules;');
        DB::unprepared('DROP FUNCTION IF EXISTS prevent_double_booking();');
    }
};
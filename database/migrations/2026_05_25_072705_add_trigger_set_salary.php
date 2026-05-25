<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION validate_salary_change()
            RETURNS TRIGGER
            LANGUAGE plpgsql
            AS \$\$
            DECLARE
                v_decrease_pct DECIMAL;
            BEGIN
                IF NEW.current_salary <= 0 THEN
                    RAISE EXCEPTION 'Salary must be a positive value. Update rejected.';
                END IF;

                IF OLD.current_salary IS NOT NULL AND NEW.current_salary < OLD.current_salary THEN
                    v_decrease_pct := ROUND(
                        ((OLD.current_salary - NEW.current_salary) / OLD.current_salary) * 100, 2
                    );

                    IF v_decrease_pct > 20 THEN
                        RAISE EXCEPTION 'Salary decrease of % %% exceeds the 20%% maximum allowed. Update rejected.',
                            v_decrease_pct;
                    END IF;
                END IF;

                NEW.salary_scale := CASE
                    WHEN NEW.current_salary >= 200000 THEN 'Scale 15'
                    WHEN NEW.current_salary >= 170000 THEN 'Scale 11'
                    WHEN NEW.current_salary >= 140000 THEN 'Scale 10'
                    WHEN NEW.current_salary >= 110000 THEN 'Scale 9'
                    WHEN NEW.current_salary >= 90000  THEN 'Scale 8'
                    WHEN NEW.current_salary >= 75000  THEN 'Scale 7'
                    WHEN NEW.current_salary >= 60000  THEN 'Scale 6'
                    WHEN NEW.current_salary >= 50000  THEN 'Scale 5'
                    WHEN NEW.current_salary >= 40000  THEN 'Scale 4'
                    ELSE 'Scale 3'
                END;

                RETURN NEW;
            END;
            \$\$;

            CREATE OR REPLACE TRIGGER trg_validate_salary_change
            BEFORE UPDATE OF current_salary ON users
            FOR EACH ROW
            EXECUTE FUNCTION validate_salary_change();
        ");
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_validate_salary_change ON users;');
        DB::unprepared('DROP FUNCTION IF EXISTS validate_salary_change();');
    }
};
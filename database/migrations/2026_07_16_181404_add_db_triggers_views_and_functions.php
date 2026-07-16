<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_create_settings');
        DB::unprepared("
            CREATE TRIGGER trg_user_create_settings
            AFTER INSERT ON users
            FOR EACH ROW
            INSERT INTO settings (user_id, created_at, updated_at)
            VALUES (NEW.id, NOW(), NOW())
        ");

        DB::unprepared('DROP TRIGGER IF EXISTS trg_archivo_delete_log');
        DB::unprepared("
            CREATE TRIGGER trg_archivo_delete_log
            BEFORE DELETE ON archivos
            FOR EACH ROW
            INSERT INTO actividades (user_id, action, subject_type, subject_id, subject_label, description, created_at, updated_at)
            VALUES (OLD.user_id, 'delete', 'App\\\\Models\\\\Archivo', OLD.id, OLD.nombre_original, 'Eliminacion directa por SQL', NOW(), NOW())
        ");

        DB::unprepared('DROP TRIGGER IF EXISTS trg_tarea_complete_proyecto');
        DB::unprepared("
            CREATE TRIGGER trg_tarea_complete_proyecto
            AFTER UPDATE ON tareas
            FOR EACH ROW
            BEGIN
                DECLARE total INT DEFAULT 0;
                DECLARE completadas INT DEFAULT 0;
                IF NEW.completada = TRUE AND OLD.completada = FALSE THEN
                    SELECT COUNT(*), COALESCE(SUM(completada), 0) INTO total, completadas
                    FROM tareas WHERE proyecto_id = NEW.proyecto_id;
                    IF total > 0 AND total = completadas THEN
                        UPDATE proyectos
                        SET estado = 'completado', updated_at = NOW()
                        WHERE id = NEW.proyecto_id AND estado != 'completado';
                    END IF;
                END IF;
            END
        ");

        DB::unprepared('DROP VIEW IF EXISTS v_dashboard_stats');
        DB::unprepared("
            CREATE VIEW v_dashboard_stats AS
            SELECT
                u.id AS user_id,
                (SELECT COUNT(*) FROM clientes WHERE user_id = u.id) AS total_clientes,
                (SELECT COUNT(*) FROM proyectos WHERE user_id = u.id) AS total_proyectos,
                (SELECT COUNT(*) FROM proyectos WHERE user_id = u.id AND estado = 'en_progreso') AS proyectos_activos,
                (SELECT COUNT(*) FROM tareas WHERE user_id = u.id) AS total_tareas,
                (SELECT COUNT(*) FROM tareas WHERE user_id = u.id AND completada = FALSE) AS tareas_pendientes,
                (SELECT COUNT(*) FROM tareas WHERE user_id = u.id AND completada = TRUE) AS tareas_completadas,
                (SELECT COUNT(*) FROM archivos WHERE user_id = u.id) AS total_archivos
            FROM users u
        ");

        DB::unprepared('DROP FUNCTION IF EXISTS fn_proyecto_progreso');
        DB::unprepared("
            CREATE FUNCTION fn_proyecto_progreso(p_proyecto_id INT)
            RETURNS DECIMAL(5,2)
            DETERMINISTIC
            BEGIN
                DECLARE total INT DEFAULT 0;
                DECLARE completadas INT DEFAULT 0;
                SELECT COUNT(*), COALESCE(SUM(completada), 0) INTO total, completadas
                FROM tareas WHERE proyecto_id = p_proyecto_id;
                IF total = 0 THEN RETURN 0; END IF;
                RETURN (completadas / total) * 100;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_create_settings');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_archivo_delete_log');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_tarea_complete_proyecto');
        DB::unprepared('DROP VIEW IF EXISTS v_dashboard_stats');
        DB::unprepared('DROP FUNCTION IF EXISTS fn_proyecto_progreso');
    }
};

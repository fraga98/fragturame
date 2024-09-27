-- DIVIDIDO POR MODELOS --

--USUARIOMODEL
    -- LISTADO
        DELIMITER //
        CREATE PROCEDURE listado_usuario(IN filtro VARCHAR(255))
        BEGIN

            -- Condiciones
            IF filtro = '' THEN
                SELECT
                    u.*,
                    r.TIPO,
                    c.EMAIL,
                    c.TELEFONO,
                    l.CALLE,
                    l.NUMERO,
                    l.LOCALIDAD,
                    l.PROVINCIA,
                    l.PAIS,
                    l.ZONA, MAX(s.FECHA_INICIO) AS INCIO_SESION, MAX(s.FECHA_CIERRE) AS CIERRE_SESION,
                    IF(TIMESTAMPDIFF(HOUR, MAX(s.FECHA_INICIO), MAX(s.FECHA_CIERRE)) < 5, "Activo", "Fuera de linea") AS ESTADO_SESION
                FROM usuarios u
                LEFT JOIN roles r ON r.ID = u.ID_ROL
                LEFT JOIN sesiones s ON s.ID_USUARIO = u.ID
                LEFT JOIN contactos c ON c.ID_USUARIO = u.ID
                LEFT JOIN localidades l ON l.ID_USUARIO = u.ID
                GROUP BY u.ID, r.TIPO, c.EMAIL, c.TELEFONO, l.CALLE, l.NUMERO, l.LOCALIDAD, l.PROVINCIA, l.PAIS, l.ZONA;

            ELSE

        END //
        DELIMITER;

    -- FIN LISTADO
    -- LOGIN

            BEGIN
                DECLARE usuario_existente INT;
                DECLARE PERMITIR_LOGIN BOOLEAN;

                -- Verificar si existe el usuario con el email y la contraseña
                SELECT COUNT(*) INTO usuario_existente
                FROM usuarios u
                WHERE u.CONTRASENIA = PASS;

                -- Asignar el valor a PERMITIR_LOGIN
                IF usuario_existente > 0 THEN
                    SET PERMITIR_LOGIN = TRUE;
                ELSE
                    SET PERMITIR_LOGIN = FALSE;
                END IF;

                -- Retornar el valor de PERMITIR_LOGIN
                SELECT PERMITIR_LOGIN;
            END
    -- FIN LOGIN
--FIN USUARIOMODEL


-- MENUMODAL
    DELIMITER //
    CREATE PROCEDURE getMenu(IN idUsuario INT(11))
    BEGIN
        SELECT
             m.*,
           IFNULL(CONCAT('[', GROUP_CONCAT(CONCAT('{"opcion":', s.SUBOPCION, ',"url":', s.URL, '}') SEPARATOR ','), ']'), NULL) AS JSON_SUB_OPCION
        FROM usuarios u
        LEFT JOIN rol_menu rm ON rm.ID_ROL = u.ID_ROL
        LEFT JOIN menu m ON m.ID = rm.ID_MENU
        LEFT JOIN submenu s ON s.ID_MENU = m.ID
        WHERE u.ID = idUsuario
        GROUP BY m.ID;
    END //
    DELIMITER;
--- FIN MENUMODAL


/*Ejemplo de como usar el concat en un procedimiento almanacenado, puede ser costoso*/

    /*
        DELIMITER //
        CREATE PROCEDURE listado_usuario(IN filtrado VARCHAR(50))
        BEGIN
            -- variables
            SET @condicion = '';

            -- Construir condición
            IF filtrado = '' THEN
                SET @condicion = '1=1';
            ELSE
                SET @condicion = CONCAT('u.nombre LIKE "%', filtrado, '%"');
            END IF;

            SET @sql = CONCAT('
                SELECT
                    u.*,
                    r.TIPO,
                    c.EMAIL,
                    c.TELEFONO,
                    l.CALLE,
                    l.NUMERO,
                    l.LOCALIDAD,
                    l.PROVINCIA,
                    l.PAIS,
                    l.ZONA,
                    MAX(s.FECHA_INICIO) AS INCIO_SESION,
                    MAX(s.FECHA_CIERRE) AS CIERRE_SESION,
                    IF(TIMESTAMPDIFF(HOUR, MAX(s.FECHA_INICIO), MAX(s.FECHA_CIERRE)) < 5, "Activo", "Fuera de linea") AS ESTADO_SESION
                FROM usuarios u
                LEFT JOIN roles r ON r.ID = u.ID_ROL
                LEFT JOIN sesiones s ON s.ID_USUARIO = u.ID
                LEFT JOIN contactos c ON c.ID_USUARIO = u.ID
                LEFT JOIN localidades l ON l.ID_USUARIO = u.ID
                WHERE ', @condicion, '
                GROUP BY u.ID
            ');

            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        END //
        DELIMITER ;
    */

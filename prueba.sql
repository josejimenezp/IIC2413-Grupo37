CREATE OR REPLACE FUNCTION capacidad_agotada(
fecha_entrada date,
fecha_salida date,
instalacion integer
) RETURNS table(fecha date) as $$
DECLARE
capacidad integer;
instalacion RECORD;
fecha RECORD;
id_instalacion integer;
fecha_atraque integer;

BEGIN
CREATE TEMP TABLE IF NOT EXISTS aux(fecha date);
DELETE FROM aux;

FOR instalacion IN (select * from instalaciones where instalaciones.iid = instalacion)
LOOP
capacidad = instalacion.capacidad;
id_instalacion = instalacion.iid;
    FOR fecha IN (select permisos.fecha_atraque, count(permisos.fecha_atraque) from instalaciones, permisos WHERE instalaciones.iid = id_instalacion AND permisos.iid = instalaciones.iid and fecha_atraque >= fecha_entrada and fecha_atraque <= fecha_salida GROUP BY permisos.fecha_atraque)
        LOOP
        if capacidad > fecha.count THEN
		INSERT INTO aux VALUES(fecha.fecha_atraque);
	END if;
	END LOOP;
RETURN QUERY (SELECT * FROM aux);
END LOOP;
END;
$$ language plpgsql;
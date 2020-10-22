CREATE OR REPLACE FUNCTION fechas(
fecha_entrada date,
fecha_salida date
) returns table(fecha date) as $$

DECLARE
fecha date;

BEGIN

CREATE TEMP TABLE IF NOT EXISTS fecha_table(fecha date); 
DELETE FROM fecha_table;
fecha = fecha_entrada;
WHILE fecha != fecha_salida + 1
LOOP
INSERT INTO fecha_table VALUES (fecha);
fecha = fecha + 1;
END LOOP;
RETURN QUERY SELECT * FROM fecha_table;
END;
$$ language plpgsql;




CREATE OR REPLACE FUNCTION capacidad_agotada(
fecha_entrada date,
fecha_salida date,
instalacion_in integer
) RETURNS table(fecha date, porcentaje real) as $$
DECLARE
capacidad integer;
instalacion RECORD;
fecha RECORD;
id_instalacion integer;
fecha_atraque integer;
porcentaje_capacidadvar real;

BEGIN
CREATE TEMP TABLE IF NOT EXISTS aux(fecha date, porcentaje_capacidad real);
DELETE FROM aux;

PERFORM fechas(fecha_entrada,fecha_salida);

FOR instalacion IN (select instalaciones.iid, instalaciones.capacidad from instalaciones where instalaciones.iid = instalacion_in)
LOOP
capacidad = instalacion.capacidad;
id_instalacion = instalacion.iid;
    FOR fecha IN (select permisos.fecha_atraque, count(permisos.fecha_atraque) from instalaciones, permisos WHERE instalaciones.iid = id_instalacion AND permisos.iid = instalaciones.iid and permisos.fecha_atraque >= fecha_entrada and permisos.fecha_atraque <= fecha_salida GROUP BY permisos.fecha_atraque)
        LOOP
        if capacidad <= fecha.count THEN
		porcentaje_capacidadvar = fecha.count/capacidad;
		INSERT INTO aux VALUES(fecha.fecha_atraque, porcentaje_capacidadvar);
	END if;
	END LOOP;
RETURN QUERY SELECT * FROM (SELECT * FROM fecha_table EXCEPT (SELECT aux.fecha FROM aux)) as foo ORDER BY foo.fecha;
END LOOP;
END;
$$ language plpgsql;
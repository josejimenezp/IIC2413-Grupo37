CREATE OR REPLACE FUNCTION fechas(
fecha_entrada date,
fecha_salida date
) returns table(fechaxd date, capacidad_porcentual real) as $$

DECLARE
fecha date;

BEGIN

CREATE TEMP TABLE IF NOT EXISTS fecha_table(fechaxd date, capacidad_porcentual real); 
DELETE FROM fecha_table;
fecha = fecha_entrada;
WHILE fecha != fecha_salida + 1
LOOP
INSERT INTO fecha_table VALUES (fecha,100);
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
		porcentaje_capacidadvar = 0;
		INSERT INTO aux VALUES(fecha.fecha_atraque, 0);
	else
		porcentaje_capacidadvar = 100-100*(CAST( fecha.count as decimal) / cast(capacidad as decimal));
		UPDATE fecha_table SET capacidad_porcentual = porcentaje_capacidadvar WHERE fecha_table.fechaxd = fecha.fecha_atraque;
	END if;
	UPDATE fecha_table SET capacidad_porcentual = porcentaje_capacidadvar WHERE fecha_table.fechaxd = fecha.fecha_atraque;
	END LOOP;
RETURN QUERY SELECT * FROM (SELECT * FROM fecha_table EXCEPT (SELECT * FROM aux)) as foo ORDER BY foo.fechaxd ;
END LOOP;
END;
$$ language plpgsql;


CREATE OR REPLACE FUNCTION porcentaje_prom(num integer) RETURNS real as $$
BEGIN
FOR promedio in SELECT AVG(foo.capacidad_porcentual) FROM ((SELECT * FROM (SELECT * FROM fecha_table EXCEPT (SELECT * FROM aux)) as foo ORDER BY foo.fechaxd)) as prueba
LOOP
RETURN promedio;
END LOOP;
END;
$$ language plpgsql;

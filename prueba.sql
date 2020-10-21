CREATE OR REPLACE FUNCTION capacidad_agotada(
fecha_entrada date,
fecha_salida date,
puerto integer
) RETURNS table(fecha date) as $$
DECLARE
capacidad integer;
instalacion RECORD;
fecha RECORD;
id_instalacion integer;
fecha_atraque integer;
aux table(fecha date)
BEGIN
FOR instalacion IN (select * from instalaciones where instalaciones.iid = puerto)
LOOP
capacidad = instalacion.capacidad;
id_instalacion = instalacion.iid;
    FOR fecha IN (select permisos.fecha_atraque, count(permisos.fecha_atraque) from instalaciones, permisos WHERE instalaciones.iid = id_instalacion AND permisos.iid = instalaciones.iid GROUP BY permisos.fecha_atraque)
        LOOP
        if capacidad > fecha.count THEN
		INSERT INTO aux VALUES(fecha.fecha_atraque);
	END if;
	END LOOP;
RETURN aux;
END LOOP;
END;
$$ language plpgsql;
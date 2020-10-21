CREATE OR REPLACE FUNCTION capacidad_agotada(
fecha_entrada integer,
fecha_salida integer,
puerto integer
) RETURNS INTEGER as $$
DECLARE
capacidad integer;
instalacion RECORD;
fecha RECORD;
id_instalacion integer;
fecha_atraque integer;
BEGIN
FOR instalacion IN (select * from instalaciones where instalaciones.iid = puerto)
LOOP
capacidad = instalacion.capacidad;
id_instalacion = instalacion.iid;
    FOR fecha IN (select permisos.fecha_atraque, count(permisos.fecha_atraque) from instalaciones, permisos WHERE instalaciones.iid = id_instalacion AND permisos.iid = instalaciones.iid GROUP BY fecha_atraque)
        LOOP
        fecha_atraque = fecha;
	END LOOP;
RETURN instalacion.capacidad;
END LOOP;
END;
$$ language plpgsql;
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
    FOR fecha IN (select fecha_atraque, count(fecha_atraque) from instalaciones, permisos WHERE instalaciones.iid = id_instalacion AND permisos.iid = instalaciones.iid GROUP BY fecha_atraque)
        LOOP
        fecha = fecha_atraque;
	END LOOP;
RETURN instalacion.capacidad;
END LOOP;
END;
$$ language plpgsql;
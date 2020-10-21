CREATE OR REPLACE FUNCTION fechas(
fecha_entrada date,
fecha_salida date
) RETURNS table(fecha date) as $$

DECLARE
fecha date;

BEGIN

CREATE TEMP TABLE IF NOT EXISTS fecha_table(fecha date); 
fecha = fecha_entrada;
WHILE fecha != fecha_salida + 1
LOOP
INSERT INTO fecha_table VALUES (fecha);
fecha = fecha + 1;
END LOOP;
RETURN QUERY (SELECT * FROM fecha_table);
END;
$$ language plpgsql;
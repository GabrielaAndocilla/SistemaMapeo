BEGIN
Select rc.id ,rc.rda_carrera, rpm.nivel, count(rpm.nivel) as cantidad
 FROM materia as m 
 INNER JOIN periodo as p,
 periodo_materia as pm, 
 carrera as c, 
 carrera_materia as cm,
 rda_carrera as rc, 
 rda_periodo_materia as rpm
 WHERE
 c.codigo = cm.cod_carrera and
 cm.cod_materia = m.codigo_materia and
 pm.periodo = '2018_2' and
 p.estado = 1 and
 pm.c_materia = cm.id and
 c.codigo = 1 and rc.carrera = c.codigo
 and rpm.periodo_materia = pm.id and
 rpm.rda_carrera_id = rc.id
 group by rc.id,rpm.nivel
 order by rpm.nivel asc;
END

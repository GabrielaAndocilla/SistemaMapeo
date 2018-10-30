BEGIN
START TRANSACTION;
INSERT INTO periodo_materia (periodo,c_materia,responsable,creditos,semestre,tipo_asignatura,area_formacion,silabo,observacion, responsables) 
SELECT periodoSiguiente,c_materia,responsable,creditos,semestre,tipo_asignatura,area_formacion,'','', ''
FROM periodo_materia
WHERE periodo = periodoAnterior;

INSERT INTO pm_co_requisito (materia_codigo,pm_materia_id,type)
SELECT pcr.materia_codigo, pm2.id AS pm_materia_id,pcr.type 
FROM pm_co_requisito AS pcr 
INNER JOIN periodo_materia AS pm ON pm.id = pcr.pm_materia_id 
INNER JOIN periodo_materia AS pm2 ON pm2.c_materia = pm.c_materia 
WHERE pm.periodo = periodoAnterior and pm2.periodo = periodoSiguiente;

INSERT INTO rda_carrera (carrera,periodo,rda_carrera,created_at,user_created) 
SELECT carrera,periodoSiguiente,rda_carrera,NOW(),1 
FROM rda_carrera
WHERE periodo = periodoAnterior;

INSERT INTO rda_universidad (rda_universidad, logros, rda_universidad_abrev, periodo_id)
SELECT ru.rda_universidad, ru.logros, ru.rda_universidad_abrev, periodoSiguiente
FROM rda_universidad as ru
WHERE (periodo_id = periodoAnterior);

INSERT INTO rda_universidad_carrera (rda_carrera_id, rda_universidad_id, created_at, user_created) 
SELECT rc2.id AS rda_carrera_id, ru2.id as rda_universidad_id, NOW(), 1  
FROM rda_universidad_carrera AS ruc 
INNER JOIN rda_carrera AS rc ON rc.id = ruc.rda_carrera_id 
INNER JOIN rda_carrera AS rc2 ON rc2.rda_carrera LIKE rc.rda_carrera 
INNER JOIN rda_universidad AS ru ON ru.id= ruc.rda_universidad_id
INNER JOIN rda_universidad AS ru2 ON ru2.rda_universidad LIKE ru.rda_universidad
WHERE rc.periodo = periodoAnterior and rc2.periodo = periodoSiguiente and ru.periodo_id = periodoAnterior and ru2.periodo_id = periodoSiguiente;

INSERT INTO rda_periodo_materia(rda_carrera_id, periodo_materia, rda, mde, nivel, created_at, updated_at) 
SELECT rc2.id AS rda_carrera_id, pm2.id AS periodo_materia,rda,mde,nivel, NOW(), NOW() FROM rda_periodo_materia AS rpm 
INNER JOIN periodo_materia AS pm ON pm.id = rpm.periodo_materia 
INNER JOIN rda_carrera AS rc ON rc.id = rpm.rda_carrera_id 
INNER JOIN rda_carrera AS rc2 ON rc2.carrera = rc.carrera AND rc2.periodo = periodoSiguiente AND rc2.rda_carrera LIKE rc.rda_carrera 
INNER JOIN periodo_materia AS pm2 ON pm2.periodo = periodoSiguiente AND pm.c_materia = pm2.c_materia 
WHERE pm.periodo = periodoAnterior;

INSERT INTO rda_uni_carrera_logro(rda_uni_id, carrera_codigo, logro_carrera)
SELECT ru2.id, rucl.carrera_codigo, rucl.logro_carrera
FROM rda_uni_carrera_logro AS rucl
INNER JOIN rda_universidad AS ru ON ru.id = rucl.rda_uni_id
INNER JOIN rda_universidad as ru2 ON ru2.rda_universidad LIKE ru.rda_universidad
WHERE ru.periodo_id = periodoAnterior and ru2.periodo_id = periodoSiguiente;

COMMIT;
END

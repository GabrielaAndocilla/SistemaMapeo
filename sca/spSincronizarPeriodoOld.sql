CREATE DEFINER=`root`@`localhost` PROCEDURE `spSincronizarPeriodo`(IN `periodoAnterior` CHAR(6), IN `periodoSiguiente` CHAR(6))
BEGIN
START TRANSACTION;
	INSERT INTO periodo_materia (periodo,c_materia,responsable,creditos,semestre,tipo_asignatura,area_formacion,silabo,observacion) SELECT periodoSiguiente,c_materia,responsable,creditos,semestre,tipo_asignatura,area_formacion,'','' FROM `periodo_materia` WHERE periodo = periodoAnterior;
    
INSERT INTO pm_co_requisito (materia_codigo,pm_materia_id,type) SELECT pcr.materia_codigo, pm2.id as pm_materia_id,pcr.type FROM pm_co_requisito as pcr INNER JOIN periodo_materia as pm ON pm.id = pcr.pm_materia_id INNER JOIN periodo_materia as pm2 ON pm2.c_materia = pm.c_materia WHERE pm.periodo = periodoAnterior and pm2.periodo = periodoSiguiente;
    
   
	INSERT INTO rda_carrera (carrera,periodo,rda_carrera,created_at,user_created) SELECT carrera,periodoSiguiente,rda_carrera,NOW(),1 FROM `rda_carrera` WHERE 			periodo = periodoAnterior;

INSERT INTO rda_universidad_carrera (rda_carrera_id, rda_universidad_id, created_at, user_created) SELECT rc2.id as rda_carrera_id, ruc.rda_universidad_id,NOW(),1  FROM rda_universidad_carrera as ruc INNER JOIN rda_carrera as rc ON rc.id = ruc.rda_carrera_id INNER JOIN rda_carrera as rc2 ON rc2.rda_carrera like rc.rda_carrera WHERE rc.periodo = periodoAnterior and rc2.periodo = periodoSiguiente;

INSERT INTO rda_periodo_materia(rda_carrera_id, periodo_materia, rda, mde, nivel, created_at, updated_at) SELECT rc2.id as rda_carrera_id, pm2.id as periodo_materia,rda,mde,nivel, NOW(), NOW() FROM rda_periodo_materia as rpm INNER JOIN periodo_materia as pm ON pm.id = rpm.periodo_materia INNER JOIN rda_carrera as rc ON rc.id = rpm.rda_carrera_id INNER JOIN rda_carrera as rc2 ON rc2.carrera = rc.carrera AND rc2.periodo = periodoSiguiente and rc2.rda_carrera like rc.rda_carrera INNER JOIN periodo_materia as pm2 ON pm2.periodo = periodoSiguiente AND pm.c_materia = pm2.c_materia WHERE pm.periodo = periodoAnterior;


COMMIT;
END
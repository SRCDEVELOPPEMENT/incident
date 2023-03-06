-- --------------------------------------------------------
-- Hôte :                        DEFFO-ARMEL\MSSQL2
-- Version du serveur:           Microsoft SQL Server 2014 - 12.0.2000.8
-- SE du serveur:                Windows NT 6.3 <X64> (Build 19043: )
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES  */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour checklistdb
CREATE DATABASE IF NOT EXISTS "checklistdb";
USE "checklistdb";

-- Listage de la structure de la table checklistdb. notification
CREATE TABLE IF NOT EXISTS "notification" (
	"id_notification" INT(10,0) NOT NULL,
	"notif_date" DATETIME(3) NOT NULL,
	"notif_header" TEXT(2147483647) NOT NULL,
	"notif_body" TEXT(2147483647) NOT NULL,
	"notif_major_sender" BIT NOT NULL DEFAULT ((0)),
	"see" BIT NOT NULL DEFAULT ((0)),
	"id_task_instance" INT(10,0) NOT NULL,
	PRIMARY KEY ("id_notification")
);

-- Listage des données de la table checklistdb.notification : -1 rows
/*!40000 ALTER TABLE "notification" DISABLE KEYS */;
/*!40000 ALTER TABLE "notification" ENABLE KEYS */;

-- Listage de la structure de la table checklistdb. permission
CREATE TABLE IF NOT EXISTS "permission" (
	"id_permission" INT(10,0) NOT NULL,
	"permission_name" NVARCHAR(50) NOT NULL,
	"permission_description" NVARCHAR(200) NULL DEFAULT NULL,
	PRIMARY KEY ("id_permission")
);

-- Listage des données de la table checklistdb.permission : -1 rows
/*!40000 ALTER TABLE "permission" DISABLE KEYS */;
/*!40000 ALTER TABLE "permission" ENABLE KEYS */;

-- Listage de la structure de la table checklistdb. pilot
CREATE TABLE IF NOT EXISTS "pilot" (
	"id_pilot" INT(10,0) NOT NULL,
	"pilot_fulname" NVARCHAR(50) NOT NULL,
	"pilot_email" NVARCHAR(50) NOT NULL,
	"pilot_username" NVARCHAR(50) NOT NULL,
	"pilot_password" NVARCHAR(500) NOT NULL,
	"id_role" INT(10,0) NOT NULL,
	PRIMARY KEY ("id_pilot")
);

-- Listage des données de la table checklistdb.pilot : -1 rows
/*!40000 ALTER TABLE "pilot" DISABLE KEYS */;
/*!40000 ALTER TABLE "pilot" ENABLE KEYS */;

-- Listage de la structure de la table checklistdb. process
CREATE TABLE IF NOT EXISTS "process" (
	"process_code" NCHAR(10) NOT NULL,
	"process_name" NVARCHAR(50) NOT NULL,
	"process_description" NVARCHAR(200) NULL DEFAULT NULL,
	PRIMARY KEY ("process_code")
);

-- Listage des données de la table checklistdb.process : -1 rows
/*!40000 ALTER TABLE "process" DISABLE KEYS */;
/*!40000 ALTER TABLE "process" ENABLE KEYS */;

-- Listage de la structure de la table checklistdb. processpilot
CREATE TABLE IF NOT EXISTS "processpilot" (
	"process_code" NCHAR(10) NOT NULL,
	"id_pilot" INT(10,0) NOT NULL
);

-- Listage des données de la table checklistdb.processpilot : -1 rows
/*!40000 ALTER TABLE "processpilot" DISABLE KEYS */;
/*!40000 ALTER TABLE "processpilot" ENABLE KEYS */;

-- Listage de la structure de la table checklistdb. role
CREATE TABLE IF NOT EXISTS "role" (
	"id_role" INT(10,0) NOT NULL,
	"role_name" NVARCHAR(50) NOT NULL,
	"role_description" NVARCHAR(200) NULL DEFAULT NULL,
	PRIMARY KEY ("id_role")
);

-- Listage des données de la table checklistdb.role : -1 rows
/*!40000 ALTER TABLE "role" DISABLE KEYS */;
/*!40000 ALTER TABLE "role" ENABLE KEYS */;

-- Listage de la structure de la table checklistdb. rolepermission
CREATE TABLE IF NOT EXISTS "rolepermission" (
	"id_role" INT(10,0) NOT NULL,
	"id_permission" INT(10,0) NOT NULL
);

-- Listage des données de la table checklistdb.rolepermission : -1 rows
/*!40000 ALTER TABLE "rolepermission" DISABLE KEYS */;
/*!40000 ALTER TABLE "rolepermission" ENABLE KEYS */;

-- Listage de la structure de la table checklistdb. state
CREATE TABLE IF NOT EXISTS "state" (
	"id_state" INT(10,0) NOT NULL,
	"state_name" NCHAR(15) NOT NULL,
	"state_description" NVARCHAR(200) NULL DEFAULT NULL,
	"state_task_instance" BIT NOT NULL DEFAULT ((0)),
	"state_sub_process_instance" BIT NOT NULL DEFAULT ((0)),
	PRIMARY KEY ("id_state")
);

-- Listage des données de la table checklistdb.state : -1 rows
/*!40000 ALTER TABLE "state" DISABLE KEYS */;
/*!40000 ALTER TABLE "state" ENABLE KEYS */;

-- Listage de la structure de la table checklistdb. subprocess
CREATE TABLE IF NOT EXISTS "subprocess" (
	"sub_process_code" NCHAR(10) NOT NULL,
	"sub_process_name" NCHAR(200) NOT NULL,
	"sub_process_cycle" TEXT(2147483647) NOT NULL,
	"process_code" NCHAR(10) NOT NULL,
	PRIMARY KEY ("sub_process_code")
);

-- Listage des données de la table checklistdb.subprocess : -1 rows
/*!40000 ALTER TABLE "subprocess" DISABLE KEYS */;
/*!40000 ALTER TABLE "subprocess" ENABLE KEYS */;

-- Listage de la structure de la table checklistdb. subprocessinstance
CREATE TABLE IF NOT EXISTS "subprocessinstance" (
	"sub_process_instance_code" NCHAR(10) NOT NULL,
	"sub_process_instance_date" DATETIME(3) NOT NULL,
	"sub_process_instance_name" NVARCHAR(200) NOT NULL,
	"sub_process_instance_object" NVARCHAR(400) NOT NULL,
	"sub_process_instance_value" FLOAT(53) NULL DEFAULT NULL,
	"sub_process_instance_filepath" NVARCHAR(300) NOT NULL,
	"sub_process_instance_priority_degree" NCHAR(20) NOT NULL,
	"sub_process_code" NCHAR(10) NOT NULL,
	"id_state" INT(10,0) NOT NULL,
	"id_pilot" INT(10,0) NOT NULL,
	PRIMARY KEY ("sub_process_instance_code")
);

-- Listage des données de la table checklistdb.subprocessinstance : -1 rows
/*!40000 ALTER TABLE "subprocessinstance" DISABLE KEYS */;
/*!40000 ALTER TABLE "subprocessinstance" ENABLE KEYS */;

-- Listage de la structure de la table checklistdb. task
CREATE TABLE IF NOT EXISTS "task" (
	"id_task" INT(10,0) NOT NULL,
	"task_name" NVARCHAR(100) NOT NULL,
	"task_number" INT(10,0) NOT NULL,
	"sub_process_code" NCHAR(10) NOT NULL,
	"id_pilot" INT(10,0) NOT NULL,
	PRIMARY KEY ("id_task")
);

-- Listage des données de la table checklistdb.task : -1 rows
/*!40000 ALTER TABLE "task" DISABLE KEYS */;
/*!40000 ALTER TABLE "task" ENABLE KEYS */;

-- Listage de la structure de la table checklistdb. taskinstance
CREATE TABLE IF NOT EXISTS "taskinstance" (
	"id_task_instance" INT(10,0) NOT NULL,
	"task_resolution_date" DATETIME(3) NULL DEFAULT NULL,
	"task_observation" TEXT(2147483647) NULL DEFAULT NULL,
	"task_signature" TEXT(2147483647) NULL DEFAULT NULL,
	"id_task" INT(10,0) NOT NULL,
	"id_state" INT(10,0) NOT NULL,
	"sub_process_instance_code" NCHAR(10) NOT NULL COMMENT '',
	PRIMARY KEY ("id_task_instance")
);

-- Listage des données de la table checklistdb.taskinstance : -1 rows
/*!40000 ALTER TABLE "taskinstance" DISABLE KEYS */;
/*!40000 ALTER TABLE "taskinstance" ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

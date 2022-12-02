-- MariaDB dump 10.19  Distrib 10.5.16-MariaDB, for Linux (x86_64)
--
-- Host: fedimg.box    Database: fedimg
-- ------------------------------------------------------
-- Server version	8.0.30-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20221114233734','2022-11-30 01:01:03',1705),('DoctrineMigrations\\Version20221117020318','2022-11-30 01:01:05',125),('DoctrineMigrations\\Version20221118231830','2022-11-30 01:01:05',67),('DoctrineMigrations\\Version20221119235409','2022-11-30 01:01:05',52),('DoctrineMigrations\\Version20221120000259','2022-11-30 01:01:05',310),('DoctrineMigrations\\Version20221120000422','2022-11-30 01:01:06',55),('DoctrineMigrations\\Version20221120050027','2022-11-30 01:01:06',270),('DoctrineMigrations\\Version20221120165530','2022-11-30 01:01:06',38),('DoctrineMigrations\\Version20221121025729','2022-11-30 01:01:06',164),('DoctrineMigrations\\Version20221121163413','2022-11-30 01:01:06',201),('DoctrineMigrations\\Version20221121165810','2022-11-30 01:01:07',12),('DoctrineMigrations\\Version20221124182416','2022-11-30 01:01:07',198),('DoctrineMigrations\\Version20221130011400','2022-11-30 01:14:35',51);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `owner_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public` tinyint(1) NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_size` int NOT NULL,
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8D7E3C61F9` (`owner_id`),
  CONSTRAINT `FK_5A8A6C8D7E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,2,'wet willy',1,'10402046-10203012609596785-4478727315357834964-n-6386afcb4b8fd851802566.jpg',47530,'2022-11-30 01:20:11'),(2,2,'cyberpunk chicky',1,'crop-6386afde09598042521282.jpeg',140959,'2022-11-30 01:20:30'),(3,2,'couch redhead',1,'0i2zbrivm9f61-6386aff628e59339578490.jpeg',160034,'2022-11-30 01:20:54'),(4,1,'pirate',0,'13094147-990174507734554-410392073632458017-n-6386b00bd43df860337610.jpg',79497,'2022-11-30 01:21:15'),(5,1,'peacock soul',0,'0f9d0300a159f806c399140ef91e2ea5-6386b01839937568147186.jpg',80984,'2022-11-30 01:21:28'),(6,2,'carefree in the street',1,'ut8qikp-6386b02c6b62f500107814.jpeg',248243,'2022-11-30 01:21:48'),(7,1,'val',1,'2012-07-04-20-39-44-6386b064d430a840257434.jpg',1072852,'2022-11-30 01:22:44');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `heading` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `friends` json DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (1,'Full Name',NULL,NULL,'[\"bunny@fedimgdev\", \"jason@fedimgdev\"]'),(2,'Full Name',NULL,NULL,'[]');
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `sess_id` varbinary(128) NOT NULL,
  `sess_data` blob NOT NULL,
  `sess_lifetime` int unsigned NOT NULL,
  `sess_time` int unsigned NOT NULL,
  PRIMARY KEY (`sess_id`),
  KEY `sessions_sess_lifetime_idx` (`sess_lifetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('5bi6gp7sj5vfujcokqfovre8v7','_sf2_attributes|a:1:{s:26:\"_security.main.target_path\";s:25:\"http://fedimg.box/profile\";}_sf2_meta|a:3:{s:1:\"u\";i:1669777022;s:1:\"c\";i:1669777022;s:1:\"l\";i:0;}',1669778462,1669777022),('b4fiadcfst4b8los75aqg9ntf8','_sf2_attributes|a:4:{s:18:\"_csrf/authenticate\";s:43:\"FmJHVmk8ldRgN01M4AAQzIeDMx-4gLvIddkKXEDLEZY\";s:23:\"_security.last_username\";s:18:\"bunnysir@proton.me\";s:14:\"_security_main\";s:3086:\"O:75:\"Symfony\\Component\\Security\\Http\\Authenticator\\Token\\PostAuthenticationToken\":2:{i:0;s:4:\"main\";i:1;a:5:{i:0;O:15:\"App\\Entity\\User\":8:{s:19:\"\0App\\Entity\\User\0id\";i:2;s:22:\"\0App\\Entity\\User\0email\";s:18:\"bunnysir@proton.me\";s:22:\"\0App\\Entity\\User\0roles\";a:0:{}s:25:\"\0App\\Entity\\User\0password\";s:60:\"$2y$13$jeeWV3nqU/jLpbA2CbOrZeESjwrC6G3L8/srhYuZEEGLiJS.SpcTO\";s:27:\"\0App\\Entity\\User\0isVerified\";b:0;s:24:\"\0App\\Entity\\User\0profile\";O:33:\"Proxies\\__CG__\\App\\Entity\\Profile\":6:{s:17:\"__isInitialized__\";b:1;s:22:\"\0App\\Entity\\Profile\0id\";i:2;s:24:\"\0App\\Entity\\Profile\0name\";s:9:\"Full Name\";s:28:\"\0App\\Entity\\Profile\0location\";N;s:27:\"\0App\\Entity\\Profile\0heading\";N;s:27:\"\0App\\Entity\\Profile\0friends\";a:0:{}}s:22:\"\0App\\Entity\\User\0posts\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:13:\"\0*\0collection\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:4:{i:0;O:15:\"App\\Entity\\Post\":8:{s:19:\"\0App\\Entity\\Post\0id\";i:1;s:22:\"\0App\\Entity\\Post\0title\";s:9:\"wet willy\";s:22:\"\0App\\Entity\\Post\0owner\";r:4;s:23:\"\0App\\Entity\\Post\0public\";b:1;s:26:\"\0App\\Entity\\Post\0imageName\";s:75:\"10402046-10203012609596785-4478727315357834964-n-6386afcb4b8fd851802566.jpg\";s:26:\"\0App\\Entity\\Post\0imageFile\";N;s:26:\"\0App\\Entity\\Post\0imageSize\";i:47530;s:26:\"\0App\\Entity\\Post\0updatedAt\";O:17:\"DateTimeImmutable\":3:{s:4:\"date\";s:26:\"2022-11-30 01:20:11.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}i:1;O:15:\"App\\Entity\\Post\":8:{s:19:\"\0App\\Entity\\Post\0id\";i:2;s:22:\"\0App\\Entity\\Post\0title\";s:16:\"cyberpunk chicky\";s:22:\"\0App\\Entity\\Post\0owner\";r:4;s:23:\"\0App\\Entity\\Post\0public\";b:1;s:26:\"\0App\\Entity\\Post\0imageName\";s:32:\"crop-6386afde09598042521282.jpeg\";s:26:\"\0App\\Entity\\Post\0imageFile\";N;s:26:\"\0App\\Entity\\Post\0imageSize\";i:140959;s:26:\"\0App\\Entity\\Post\0updatedAt\";O:17:\"DateTimeImmutable\":3:{s:4:\"date\";s:26:\"2022-11-30 01:20:30.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}i:2;O:15:\"App\\Entity\\Post\":8:{s:19:\"\0App\\Entity\\Post\0id\";i:3;s:22:\"\0App\\Entity\\Post\0title\";s:13:\"couch redhead\";s:22:\"\0App\\Entity\\Post\0owner\";r:4;s:23:\"\0App\\Entity\\Post\0public\";b:1;s:26:\"\0App\\Entity\\Post\0imageName\";s:41:\"0i2zbrivm9f61-6386aff628e59339578490.jpeg\";s:26:\"\0App\\Entity\\Post\0imageFile\";N;s:26:\"\0App\\Entity\\Post\0imageSize\";i:160034;s:26:\"\0App\\Entity\\Post\0updatedAt\";O:17:\"DateTimeImmutable\":3:{s:4:\"date\";s:26:\"2022-11-30 01:20:54.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}i:3;O:15:\"App\\Entity\\Post\":8:{s:19:\"\0App\\Entity\\Post\0id\";i:6;s:22:\"\0App\\Entity\\Post\0title\";s:22:\"carefree in the street\";s:22:\"\0App\\Entity\\Post\0owner\";r:4;s:23:\"\0App\\Entity\\Post\0public\";b:1;s:26:\"\0App\\Entity\\Post\0imageName\";s:35:\"ut8qikp-6386b02c6b62f500107814.jpeg\";s:26:\"\0App\\Entity\\Post\0imageFile\";N;s:26:\"\0App\\Entity\\Post\0imageSize\";i:248243;s:26:\"\0App\\Entity\\Post\0updatedAt\";O:17:\"DateTimeImmutable\":3:{s:4:\"date\";s:26:\"2022-11-30 01:21:48.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}}}s:14:\"\0*\0initialized\";b:1;}s:25:\"\0App\\Entity\\User\0username\";s:5:\"bunny\";}i:1;b:1;i:2;N;i:3;a:0:{}i:4;a:1:{i:0;s:9:\"ROLE_USER\";}}}\";s:10:\"_csrf/post\";s:43:\"X60zdagdMXe6EdN2RGOilSL04oSXCBqcAifM35rM2OA\";}_sf2_meta|a:3:{s:1:\"u\";i:1669772695;s:1:\"c\";i:1669770648;s:1:\"l\";i:0;}',1669774135,1669772695),('ebcah1oqe9t5f1e8a5sq45vl85','_sf2_attributes|a:4:{s:26:\"_security.main.target_path\";s:30:\"http://fedimg.box/profile/feed\";s:18:\"_csrf/authenticate\";s:43:\"TxE527clOzFZmS8QJmcjFYJLeaFxarvWCHEPqiIJ8Rg\";s:23:\"_security.last_username\";s:18:\"bunnysir@proton.me\";s:14:\"_security_main\";s:3086:\"O:75:\"Symfony\\Component\\Security\\Http\\Authenticator\\Token\\PostAuthenticationToken\":2:{i:0;s:4:\"main\";i:1;a:5:{i:0;O:15:\"App\\Entity\\User\":8:{s:19:\"\0App\\Entity\\User\0id\";i:2;s:22:\"\0App\\Entity\\User\0email\";s:18:\"bunnysir@proton.me\";s:22:\"\0App\\Entity\\User\0roles\";a:0:{}s:25:\"\0App\\Entity\\User\0password\";s:60:\"$2y$13$jeeWV3nqU/jLpbA2CbOrZeESjwrC6G3L8/srhYuZEEGLiJS.SpcTO\";s:27:\"\0App\\Entity\\User\0isVerified\";b:0;s:24:\"\0App\\Entity\\User\0profile\";O:33:\"Proxies\\__CG__\\App\\Entity\\Profile\":6:{s:17:\"__isInitialized__\";b:1;s:22:\"\0App\\Entity\\Profile\0id\";i:2;s:24:\"\0App\\Entity\\Profile\0name\";s:9:\"Full Name\";s:28:\"\0App\\Entity\\Profile\0location\";N;s:27:\"\0App\\Entity\\Profile\0heading\";N;s:27:\"\0App\\Entity\\Profile\0friends\";a:0:{}}s:22:\"\0App\\Entity\\User\0posts\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:13:\"\0*\0collection\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:4:{i:0;O:15:\"App\\Entity\\Post\":8:{s:19:\"\0App\\Entity\\Post\0id\";i:1;s:22:\"\0App\\Entity\\Post\0title\";s:9:\"wet willy\";s:22:\"\0App\\Entity\\Post\0owner\";r:4;s:23:\"\0App\\Entity\\Post\0public\";b:1;s:26:\"\0App\\Entity\\Post\0imageName\";s:75:\"10402046-10203012609596785-4478727315357834964-n-6386afcb4b8fd851802566.jpg\";s:26:\"\0App\\Entity\\Post\0imageFile\";N;s:26:\"\0App\\Entity\\Post\0imageSize\";i:47530;s:26:\"\0App\\Entity\\Post\0updatedAt\";O:17:\"DateTimeImmutable\":3:{s:4:\"date\";s:26:\"2022-11-30 01:20:11.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}i:1;O:15:\"App\\Entity\\Post\":8:{s:19:\"\0App\\Entity\\Post\0id\";i:2;s:22:\"\0App\\Entity\\Post\0title\";s:16:\"cyberpunk chicky\";s:22:\"\0App\\Entity\\Post\0owner\";r:4;s:23:\"\0App\\Entity\\Post\0public\";b:1;s:26:\"\0App\\Entity\\Post\0imageName\";s:32:\"crop-6386afde09598042521282.jpeg\";s:26:\"\0App\\Entity\\Post\0imageFile\";N;s:26:\"\0App\\Entity\\Post\0imageSize\";i:140959;s:26:\"\0App\\Entity\\Post\0updatedAt\";O:17:\"DateTimeImmutable\":3:{s:4:\"date\";s:26:\"2022-11-30 01:20:30.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}i:2;O:15:\"App\\Entity\\Post\":8:{s:19:\"\0App\\Entity\\Post\0id\";i:3;s:22:\"\0App\\Entity\\Post\0title\";s:13:\"couch redhead\";s:22:\"\0App\\Entity\\Post\0owner\";r:4;s:23:\"\0App\\Entity\\Post\0public\";b:1;s:26:\"\0App\\Entity\\Post\0imageName\";s:41:\"0i2zbrivm9f61-6386aff628e59339578490.jpeg\";s:26:\"\0App\\Entity\\Post\0imageFile\";N;s:26:\"\0App\\Entity\\Post\0imageSize\";i:160034;s:26:\"\0App\\Entity\\Post\0updatedAt\";O:17:\"DateTimeImmutable\":3:{s:4:\"date\";s:26:\"2022-11-30 01:20:54.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}i:3;O:15:\"App\\Entity\\Post\":8:{s:19:\"\0App\\Entity\\Post\0id\";i:6;s:22:\"\0App\\Entity\\Post\0title\";s:22:\"carefree in the street\";s:22:\"\0App\\Entity\\Post\0owner\";r:4;s:23:\"\0App\\Entity\\Post\0public\";b:1;s:26:\"\0App\\Entity\\Post\0imageName\";s:35:\"ut8qikp-6386b02c6b62f500107814.jpeg\";s:26:\"\0App\\Entity\\Post\0imageFile\";N;s:26:\"\0App\\Entity\\Post\0imageSize\";i:248243;s:26:\"\0App\\Entity\\Post\0updatedAt\";O:17:\"DateTimeImmutable\":3:{s:4:\"date\";s:26:\"2022-11-30 01:21:48.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}}}s:14:\"\0*\0initialized\";b:1;}s:25:\"\0App\\Entity\\User\0username\";s:5:\"bunny\";}i:1;b:1;i:2;N;i:3;a:0:{}i:4;a:1:{i:0;s:9:\"ROLE_USER\";}}}\";}_sf2_meta|a:3:{s:1:\"u\";i:1669774627;s:1:\"c\";i:1669774627;s:1:\"l\";i:0;}',1669776067,1669774627),('lh1iskufiti7auvtnlrnm4j79q','_sf2_attributes|a:4:{s:26:\"_security.main.target_path\";s:25:\"http://fedimg.box/profile\";s:18:\"_csrf/authenticate\";s:43:\"tUhuh-tpDuxbu-xMd_QxT3VahTrwzRbbvepyQ9YttJc\";s:23:\"_security.last_username\";s:29:\"jasonmarshallselene@gmail.com\";s:14:\"_security_main\";s:1118:\"O:75:\"Symfony\\Component\\Security\\Http\\Authenticator\\Token\\PostAuthenticationToken\":2:{i:0;s:4:\"main\";i:1;a:5:{i:0;O:15:\"App\\Entity\\User\":8:{s:19:\"\0App\\Entity\\User\0id\";i:1;s:22:\"\0App\\Entity\\User\0email\";s:29:\"jasonmarshallselene@gmail.com\";s:22:\"\0App\\Entity\\User\0roles\";a:0:{}s:25:\"\0App\\Entity\\User\0password\";s:60:\"$2y$13$05GKSd/RnBdHMeC4lbD2ze0E.iFMKRLpKzCxuQU0Oy9CZmmg53rkS\";s:27:\"\0App\\Entity\\User\0isVerified\";b:0;s:24:\"\0App\\Entity\\User\0profile\";O:33:\"Proxies\\__CG__\\App\\Entity\\Profile\":6:{s:17:\"__isInitialized__\";b:1;s:22:\"\0App\\Entity\\Profile\0id\";i:1;s:24:\"\0App\\Entity\\Profile\0name\";s:9:\"Full Name\";s:28:\"\0App\\Entity\\Profile\0location\";N;s:27:\"\0App\\Entity\\Profile\0heading\";N;s:27:\"\0App\\Entity\\Profile\0friends\";a:2:{i:0;s:15:\"bunny@fedimgdev\";i:1;s:15:\"jason@fedimgdev\";}}s:22:\"\0App\\Entity\\User\0posts\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:13:\"\0*\0collection\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:0:{}}s:14:\"\0*\0initialized\";b:0;}s:25:\"\0App\\Entity\\User\0username\";s:5:\"jason\";}i:1;b:1;i:2;N;i:3;a:0:{}i:4;a:1:{i:0;s:9:\"ROLE_USER\";}}}\";}_sf2_meta|a:3:{s:1:\"u\";i:1669781900;s:1:\"c\";i:1669777009;s:1:\"l\";i:0;}',1669783340,1669781900),('u94sn5kb32oh2bvev6ft0m4qd4','_sf2_attributes|a:1:{s:18:\"_csrf/authenticate\";s:43:\"64zFFqH6LcKp9qNy8hD3r_czXnRkEYcfff3UKq8vBLA\";}_sf2_meta|a:3:{s:1:\"u\";i:1669777022;s:1:\"c\";i:1669777022;s:1:\"l\";i:0;}',1669778462,1669777022);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES (1,'sitename','FedImg'),(2,'sitenick','fedimgdev'),(3,'sitedesc','My New FedImg Instance'),(4,'emailverify','no');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `profile_id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D649CCFA12B8` (`profile_id`),
  CONSTRAINT `FK_8D93D649CCFA12B8` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,1,'jasonmarshallselene@gmail.com','[]','$2y$13$05GKSd/RnBdHMeC4lbD2ze0E.iFMKRLpKzCxuQU0Oy9CZmmg53rkS',0,'jason'),(2,2,'bunnysir@proton.me','[]','$2y$13$jeeWV3nqU/jLpbA2CbOrZeESjwrC6G3L8/srhYuZEEGLiJS.SpcTO',0,'bunny');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-29 23:24:14

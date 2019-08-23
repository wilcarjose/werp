
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `address_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address_company` (
  `address_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  KEY `address_company_address_id_foreign` (`address_id`),
  KEY `address_company_company_id_foreign` (`company_id`),
  CONSTRAINT `address_company_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `address_company_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `address_company` WRITE;
/*!40000 ALTER TABLE `address_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `address_company` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `address_partner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address_partner` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partner_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `address_partner_partner_id_foreign` (`partner_id`),
  KEY `address_partner_address_id_foreign` (`address_id`),
  KEY `address_partner_company_id_foreign` (`company_id`),
  CONSTRAINT `address_partner_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `address_partner_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `address_partner_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `address_partner` WRITE;
/*!40000 ALTER TABLE `address_partner` DISABLE KEYS */;
/*!40000 ALTER TABLE `address_partner` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urbanization` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_company_id_foreign` (`company_id`),
  CONSTRAINT `addresses_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `admin_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_company` (
  `admin_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  KEY `admin_company_admin_id_foreign` (`admin_id`),
  KEY `admin_company_company_id_foreign` (`company_id`),
  CONSTRAINT `admin_company_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  CONSTRAINT `admin_company_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `admin_company` WRITE;
/*!40000 ALTER TABLE `admin_company` DISABLE KEYS */;
INSERT INTO `admin_company` VALUES ('91a2981b-26da-435d-b726-34fa1cbf4c8a','d44b8fee-707a-47e3-b118-d6fa73296698',NULL);
/*!40000 ALTER TABLE `admin_company` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `admin_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  KEY `admin_password_resets_company_id_foreign` (`company_id`),
  KEY `admin_password_resets_email_index` (`email`),
  KEY `admin_password_resets_token_index` (`token`),
  CONSTRAINT `admin_password_resets_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `admin_password_resets` WRITE;
/*!40000 ALTER TABLE `admin_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_password_resets` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `admin_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role` (
  `role_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`,`admin_id`),
  KEY `admin_role_admin_id_foreign` (`admin_id`),
  KEY `admin_role_company_id_foreign` (`company_id`),
  CONSTRAINT `admin_role_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  CONSTRAINT `admin_role_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `admin_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `admin_role` WRITE;
/*!40000 ALTER TABLE `admin_role` DISABLE KEYS */;
INSERT INTO `admin_role` VALUES ('40538c2d-dd38-4353-ba26-b57bff3e9d67','91a2981b-26da-435d-b726-34fa1cbf4c8a',NULL,NULL);
/*!40000 ALTER TABLE `admin_role` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Manager',
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admins_company_id_foreign` (`company_id`),
  CONSTRAINT `admins_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES ('91a2981b-26da-435d-b726-34fa1cbf4c8a','admin','admin@mail.com','$2y$10$K52eHFVk6gG8tD0sEYzNEe.c8UXdmJUpHS.9PlKGtEtd/OPqouAQG',NULL,'Manager',NULL,'on','VaV6XayubYjdPGUsfTrxBWZG90aSSIDhJdOO0ICGEWb9gQG92GhS94D7YI9H','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `amount_operations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amount_operations` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `operation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` double(20,2) DEFAULT NULL,
  `config_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `round` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `amount_operations_company_id_foreign` (`company_id`),
  CONSTRAINT `amount_operations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `amount_operations` WRITE;
/*!40000 ALTER TABLE `amount_operations` DISABLE KEYS */;
INSERT INTO `amount_operations` VALUES ('a47503ea-2153-4819-9ee6-80acfa28dd06','+ 10%',NULL,'add_percent',10.00,NULL,'2',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-20 17:28:18',NULL),('fed66451-5555-4a90-bd07-d1d5a5eadca4','- 15%',NULL,'sub_percent',15.00,NULL,'2',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-20 17:28:18',NULL);
/*!40000 ALTER TABLE `amount_operations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `basedocs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basedocs` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `basedocs_company_id_foreign` (`company_id`),
  CONSTRAINT `basedocs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `basedocs` WRITE;
/*!40000 ALTER TABLE `basedocs` DISABLE KEYS */;
INSERT INTO `basedocs` VALUES ('02ee1325-5ddf-46f6-8e72-7425fd39841b','Sale Order','SO','Sale Order','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('0bbfc69c-3bb6-49da-b351-b100f24a2e60','Inventory Movement','IM','Inventory movement','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('6dd15c35-9524-432a-b964-79041098a2a6','Price List','PL','Price List','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('7b10a005-4df6-45b2-a330-c206aa7b023b','Inventory Output','IO','Inventory output','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('9b6f3d6e-72b7-4309-bb75-c7d5e6a81c96','Inventory Entry','IE','Inventory entry','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('9ed22d23-af33-4fdf-9533-240c2dc074c2','Purchase Order','PO','Purchase Order','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('a209542b-84ad-499a-9146-64b85675bde1','Inventory','IN','Inventory','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL);
/*!40000 ALTER TABLE `basedocs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `branch_offices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branch_offices` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_offices_company_id_foreign` (`company_id`),
  KEY `branch_offices_address_id_foreign` (`address_id`),
  CONSTRAINT `branch_offices_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `branch_offices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `branch_offices` WRITE;
/*!40000 ALTER TABLE `branch_offices` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_offices` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brands_company_id_foreign` (`company_id`),
  CONSTRAINT `brands_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES ('59de7fbc-39a5-4f65-97f4-48856a6080dd','LMV',NULL,NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-21 19:23:46','2019-08-21 19:23:46',NULL),('856f079d-dbb7-42aa-ab52-f5d7fef5a852','KRS',NULL,NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-21 19:23:46','2019-08-21 19:23:46',NULL);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `category_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_category_id_foreign` (`category_id`),
  KEY `categories_company_id_foreign` (`company_id`),
  CONSTRAINT `categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES ('51f620c8-aeef-436b-9fdd-49caffd683ef','Ligas','product','on',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 19:23:46','2019-08-21 19:23:46',NULL),('cd71a386-8f2c-4c5c-9b35-2a1a9383604b','Lubricantes','product','on',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 19:23:46','2019-08-21 19:23:46',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES ('d44b8fee-707a-47e3-b118-d6fa73296698','Lubricantes la 14 C.A. y asociados','fdfsdfsdfsdf','123456',NULL,NULL,NULL,NULL,NULL,NULL,'on','2019-08-20 17:06:20','2019-08-23 13:33:06',NULL);
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `translate_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `config_company_id_foreign` (`company_id`),
  CONSTRAINT `config_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES ('0458a682-6139-4f8b-9d4b-b2faf8b74fe0','view.products.default_io_doc','inv_default_io_doc',NULL,'doctype','inv','view.products.default_io_doc',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('0ecc9646-7793-4cb0-9bff-16a4128b807c','Valor del Dolar ($)','current_dolar_convertion','0','amount','mai','view.maintenance.dolar_value',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('3fafbad0-b80e-4af1-af07-675a7e3dcc56','view.maintenance.base_currency','mai_base_currency',NULL,'currency','mai','view.maintenance.base_currency',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('631df2f1-b3ab-4bf4-8d39-50e3bc91d050','view.products.default_im_doc','inv_default_im_doc',NULL,'doctype','inv','view.products.default_im_doc',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('8f80ec47-eaae-42e5-b89a-c71cecc2f07e','view.products.default_po_doc','inv_default_po_doc',NULL,'doctype','inv','view.products.default_po_doc',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('9f4515ee-75b6-4690-ad69-84fc0551e0d4','view.products.default_ie_doc','inv_default_ie_doc',NULL,'doctype','inv','view.products.default_ie_doc',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('c3ff4883-1430-4d89-b39e-e55f330695b1','view.maintenance.default_currency','mai_default_currency',NULL,'currency','mai','view.maintenance.default_currency',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('df24374b-5152-48a1-8ecd-6921cd98acaf','view.products.default_price_list_doc','pri_default_pl_doc',NULL,'doctype','pri','view.products.default_price_list_doc',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('e4d0fc3f-6feb-4c08-8a0a-5222343d3721','view.products.default_so_doc','inv_default_so_doc',NULL,'doctype','inv','view.products.default_so_doc',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('ec9e6bb7-8b2a-467b-bb08-4500675e4c7a','view.products.default_inventory_doc','inv_default_in_doc',NULL,'doctype','inv','view.products.default_inventory_doc',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('f7f21e16-9474-4999-b87b-60ea58a9ab83','view.products.default_warehouse','inv_default_warehouse',NULL,'entity','inv','view.products.default_warehouse',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL);
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currencies` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `abbr` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numeric_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `currencies_company_id_foreign` (`company_id`),
  CONSTRAINT `currencies_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES ('141ae3b6-ed30-4d68-bacf-4daac1c312f1','Bolívar',NULL,'VEF','Bs','937','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('a9e75763-1d30-4f7f-8d0f-9b9c869c2159','Dolar',NULL,'USD','$','840','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('e1722ec9-625c-4038-a2fd-c4d36f165c09','Peso Colombiano',NULL,'COP','$','170','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL);
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `doctypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctypes` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `basedoc_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `increment_number` int(11) NOT NULL DEFAULT '1',
  `last_number` int(11) NOT NULL DEFAULT '0',
  `use_zeros` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `number_long` int(11) NOT NULL DEFAULT '3',
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctypes_basedoc_id_foreign` (`basedoc_id`),
  KEY `doctypes_company_id_foreign` (`company_id`),
  CONSTRAINT `doctypes_basedoc_id_foreign` FOREIGN KEY (`basedoc_id`) REFERENCES `basedocs` (`id`),
  CONSTRAINT `doctypes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `doctypes` WRITE;
/*!40000 ALTER TABLE `doctypes` DISABLE KEYS */;
INSERT INTO `doctypes` VALUES ('0bc49e09-b98f-4159-a0bb-85c5fa29c405','Inventario','a209542b-84ad-499a-9146-64b85675bde1','IN',1,2,'y',5,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-22 02:11:41',NULL),('2131efa5-5a8b-4b20-8ace-17bdb268d6be','Lista de precio','6dd15c35-9524-432a-b964-79041098a2a6','LP',1,2,'y',5,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 20:18:06',NULL),('4615ca3b-47cd-4081-9ee7-6f8ae112fcc5','Orden de Compra','9ed22d23-af33-4fdf-9533-240c2dc074c2','OC',1,1,'y',5,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-22 02:54:28',NULL),('77cb2ee8-2e76-4329-b610-d98fc13eebbc','Entrada de productos','9b6f3d6e-72b7-4309-bb75-c7d5e6a81c96','EP',1,0,'y',5,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('9ed88bb9-c812-4dcc-8afb-c400f290a29c','Movimiento de productos','0bbfc69c-3bb6-49da-b351-b100f24a2e60','MP',1,0,'y',5,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('ba98e50c-4032-48bd-9bde-97c589357058','Salida de productos','7b10a005-4df6-45b2-a330-c206aa7b023b','SP',1,0,'y',5,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('c06ebdca-744f-4975-ad62-58c117cb64bc','Orden de Venta','02ee1325-5ddf-46f6-8e72-7425fd39841b','OV',1,0,'y',5,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL);
/*!40000 ALTER TABLE `doctypes` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `exchange_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchange_rates` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double NOT NULL,
  `starting_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `currency_from_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_to_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exchange_rates_currency_from_id_foreign` (`currency_from_id`),
  KEY `exchange_rates_currency_to_id_foreign` (`currency_to_id`),
  KEY `exchange_rates_company_id_foreign` (`company_id`),
  CONSTRAINT `exchange_rates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `exchange_rates_currency_from_id_foreign` FOREIGN KEY (`currency_from_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `exchange_rates_currency_to_id_foreign` FOREIGN KEY (`currency_to_id`) REFERENCES `currencies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `exchange_rates` WRITE;
/*!40000 ALTER TABLE `exchange_rates` DISABLE KEYS */;
INSERT INTO `exchange_rates` VALUES ('2942cdc5-5aaf-4f02-870e-41823583606e','USD/VEF',15900,'2019-08-20 20:16:18','a9e75763-1d30-4f7f-8d0f-9b9c869c2159','141ae3b6-ed30-4d68-bacf-4daac1c312f1','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 20:16:18','2019-08-20 20:16:18',NULL),('64d36b25-88b2-440c-a825-84520d7c652c','USD/VEF',15800,'2019-08-20 20:16:06','a9e75763-1d30-4f7f-8d0f-9b9c869c2159','141ae3b6-ed30-4d68-bacf-4daac1c312f1','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 20:16:06','2019-08-20 20:16:06',NULL);
/*!40000 ALTER TABLE `exchange_rates` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `inout_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inout_detail` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(20,4) NOT NULL DEFAULT '0.0000',
  `tax` double(20,4) NOT NULL DEFAULT '0.0000',
  `discount` double(20,4) NOT NULL DEFAULT '0.0000',
  `full_price` double(20,4) NOT NULL DEFAULT '0.0000',
  `total_price` double(20,4) NOT NULL DEFAULT '0.0000',
  `total_tax` double(20,4) NOT NULL DEFAULT '0.0000',
  `total_discount` double(20,4) NOT NULL DEFAULT '0.0000',
  `total` double(20,4) NOT NULL DEFAULT '0.0000',
  `currency_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` double NOT NULL,
  `inout_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_detail_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inout_detail_currency_id_foreign` (`currency_id`),
  KEY `inout_detail_inout_id_foreign` (`inout_id`),
  KEY `inout_detail_warehouse_id_foreign` (`warehouse_id`),
  KEY `inout_detail_product_id_foreign` (`product_id`),
  KEY `inout_detail_order_detail_id_foreign` (`order_detail_id`),
  KEY `inout_detail_tax_id_foreign` (`tax_id`),
  KEY `inout_detail_discount_id_foreign` (`discount_id`),
  KEY `inout_detail_company_id_foreign` (`company_id`),
  CONSTRAINT `inout_detail_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `inout_detail_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `inout_detail_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `taxs_discounts` (`id`),
  CONSTRAINT `inout_detail_inout_id_foreign` FOREIGN KEY (`inout_id`) REFERENCES `inouts` (`id`),
  CONSTRAINT `inout_detail_order_detail_id_foreign` FOREIGN KEY (`order_detail_id`) REFERENCES `order_detail` (`id`),
  CONSTRAINT `inout_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `inout_detail_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxs_discounts` (`id`),
  CONSTRAINT `inout_detail_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `inout_detail` WRITE;
/*!40000 ALTER TABLE `inout_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `inout_detail` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `inout_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inout_order` (
  `inout_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  KEY `inout_order_inout_id_foreign` (`inout_id`),
  KEY `inout_order_order_id_foreign` (`order_id`),
  CONSTRAINT `inout_order_inout_id_foreign` FOREIGN KEY (`inout_id`) REFERENCES `inouts` (`id`),
  CONSTRAINT `inout_order_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `inout_order` WRITE;
/*!40000 ALTER TABLE `inout_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `inout_order` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `inouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inouts` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternate_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` double(20,4) NOT NULL DEFAULT '0.0000',
  `total_tax` double(20,4) NOT NULL DEFAULT '0.0000',
  `total_discount` double(20,4) NOT NULL DEFAULT '0.0000',
  `total` double(20,4) NOT NULL DEFAULT '0.0000',
  `currency_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('OUT','IN') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUT',
  `state` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PE',
  `partner_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctype_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inouts_currency_id_foreign` (`currency_id`),
  KEY `inouts_partner_id_foreign` (`partner_id`),
  KEY `inouts_doctype_id_foreign` (`doctype_id`),
  KEY `inouts_warehouse_id_foreign` (`warehouse_id`),
  KEY `inouts_tax_id_foreign` (`tax_id`),
  KEY `inouts_discount_id_foreign` (`discount_id`),
  KEY `inouts_company_id_foreign` (`company_id`),
  CONSTRAINT `inouts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `inouts_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `inouts_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `taxs_discounts` (`id`),
  CONSTRAINT `inouts_doctype_id_foreign` FOREIGN KEY (`doctype_id`) REFERENCES `doctypes` (`id`),
  CONSTRAINT `inouts_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  CONSTRAINT `inouts_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxs_discounts` (`id`),
  CONSTRAINT `inouts_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `inouts` WRITE;
/*!40000 ALTER TABLE `inouts` DISABLE KEYS */;
/*!40000 ALTER TABLE `inouts` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventories` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text COLLATE utf8mb4_unicode_ci,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PE',
  `doctype_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventories_doctype_id_foreign` (`doctype_id`),
  KEY `inventories_warehouse_id_foreign` (`warehouse_id`),
  KEY `inventories_company_id_foreign` (`company_id`),
  CONSTRAINT `inventories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `inventories_doctype_id_foreign` FOREIGN KEY (`doctype_id`) REFERENCES `doctypes` (`id`),
  CONSTRAINT `inventories_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `inventories` WRITE;
/*!40000 ALTER TABLE `inventories` DISABLE KEYS */;
INSERT INTO `inventories` VALUES ('33b0f8b4-4488-4b5d-92b2-81bc98fad2d6','IN00002','2019-08-22 02:11:16',NULL,NULL,'PE','0bc49e09-b98f-4159-a0bb-85c5fa29c405','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-22 02:11:41','2019-08-22 02:11:41',NULL),('68290c38-ed32-4fc0-836d-38b039409e0d','IN00001','2019-08-21 00:59:54',NULL,NULL,'PR','0bc49e09-b98f-4159-a0bb-85c5fa29c405','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 00:58:43','2019-08-21 00:59:54',NULL);
/*!40000 ALTER TABLE `inventories` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `inventory_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_detail` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text COLLATE utf8mb4_unicode_ci,
  `qty` double NOT NULL,
  `inventory_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_detail_inventory_id_foreign` (`inventory_id`),
  KEY `inventory_detail_product_id_foreign` (`product_id`),
  KEY `inventory_detail_warehouse_id_foreign` (`warehouse_id`),
  KEY `inventory_detail_company_id_foreign` (`company_id`),
  CONSTRAINT `inventory_detail_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `inventory_detail_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`),
  CONSTRAINT `inventory_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `inventory_detail_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `inventory_detail` WRITE;
/*!40000 ALTER TABLE `inventory_detail` DISABLE KEYS */;
INSERT INTO `inventory_detail` VALUES ('14f6c218-7de7-4560-8bae-e32d354fe8a4','IN00001','2019-08-21 00:58:33',NULL,10,'68290c38-ed32-4fc0-836d-38b039409e0d','bb7a776c-6361-4258-acfa-3a703620d59c','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 00:59:20','2019-08-21 00:59:20',NULL),('23755c03-1ae9-469b-ae67-b21e18724b22','IN00002','2019-08-22 02:11:16',NULL,4,'33b0f8b4-4488-4b5d-92b2-81bc98fad2d6','84e10702-422f-42b0-b907-5ec4375aeada','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-23 13:45:45','2019-08-23 13:45:45',NULL),('527e5501-5d34-4fe2-9384-090279ecc22d','IN00001','2019-08-21 00:58:33',NULL,20,'68290c38-ed32-4fc0-836d-38b039409e0d','5e6e023e-db94-4f15-9477-5f678238be35','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 00:59:48','2019-08-21 00:59:48',NULL),('bf13122a-9710-491b-8ad5-0a53af7b04d8','IN00002','2019-08-22 02:11:16',NULL,77,'33b0f8b4-4488-4b5d-92b2-81bc98fad2d6','107fb4a0-f0b4-4e01-b6b6-6e88dff9096d','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-22 02:12:09','2019-08-22 02:12:09',NULL),('d8a37333-4292-41d7-b387-f1b4f55f97aa','IN00001','2019-08-21 00:58:33',NULL,12,'68290c38-ed32-4fc0-836d-38b039409e0d','74f8e534-eb31-426b-8672-98a4f1b0d2cd','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 00:59:39','2019-08-21 00:59:39',NULL);
/*!40000 ALTER TABLE `inventory_detail` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_01_01_000000_create_companies_table',1),(4,'2018_01_02_000000_create_addresses_table',1),(5,'2018_01_03_000000_create_branch_offices_table',1),(6,'2018_03_02_054249_create_admins_table',1),(7,'2018_03_02_054250_create_admin_password_resets_table',1),(8,'2018_03_02_054631_create_roles_table',1),(9,'2018_04_01_000000_create_admin_company_table',1),(10,'2019_03_01_000000_create_config_table',1),(11,'2019_04_02_000000_create_address_company_table',1),(12,'2019_05_01_000000_create_currencies_table',1),(13,'2019_05_02_000000_create_exchange_rates_table',1),(14,'2019_05_20_000000_create_uom_table',1),(15,'2019_05_21_000000_create_uom_conversion_table',1),(16,'2019_05_22_000000_create_brands_table',1),(17,'2019_05_23_000000_create_categories_table',1),(18,'2019_05_23_000001_create_partners_table',1),(19,'2019_05_24_000000_create_products_table',1),(20,'2019_05_24_000001_create_amount_operations_table',1),(21,'2019_05_25_000000_create_warehouses_table',1),(22,'2019_05_25_000001_create_basedocs_table',1),(23,'2019_05_25_000002_create_doctypes_table',1),(24,'2019_05_26_000000_create_transactions_table',1),(25,'2019_05_26_000001_create_payment_methods_table',1),(26,'2019_05_26_000002_create_sales_channels_table',1),(27,'2019_05_26_000003_create_taxs_discounts_table',1),(28,'2019_05_27_000000_create_stock_table',1),(29,'2019_05_28_000000_create_inventories_table',1),(30,'2019_05_29_000000_create_inventory_detail_table',1),(31,'2019_06_03_000000_create_address_partner_table',1),(32,'2019_06_04_000000_create_social_networks_table',1),(33,'2019_06_05_000000_create_partner_category_table',1),(34,'2019_06_06_000000_create_product_category_table',1),(35,'2019_06_07_000000_create_product_uom_table',1),(36,'2019_06_08_000000_create_product_brand_table',1),(37,'2019_06_09_000000_create_product_partner_table',1),(38,'2019_06_10_000000_create_stock_limit_table',1),(39,'2019_06_11_000000_create_price_list_types_table',1),(40,'2019_06_12_000000_create_price_lists_table',1),(41,'2019_06_13_000000_create_prices_table',1),(42,'2019_06_15_000000_create_orders_table',1),(43,'2019_06_16_000000_create_order_detail_table',1),(44,'2019_06_18_000000_create_inouts_table',1),(45,'2019_06_19_000000_create_inout_detail_table',1),(46,'2019_06_20_000000_create_inout_order_table',1),(47,'2019_06_21_000000_create_movements_table',1),(48,'2019_06_22_000000_create_movement_detail_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `movement_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movement_detail` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double NOT NULL,
  `movement_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_from_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_to_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `movement_detail_movement_id_foreign` (`movement_id`),
  KEY `movement_detail_warehouse_from_id_foreign` (`warehouse_from_id`),
  KEY `movement_detail_warehouse_to_id_foreign` (`warehouse_to_id`),
  KEY `movement_detail_product_id_foreign` (`product_id`),
  KEY `movement_detail_company_id_foreign` (`company_id`),
  CONSTRAINT `movement_detail_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `movement_detail_movement_id_foreign` FOREIGN KEY (`movement_id`) REFERENCES `movements` (`id`),
  CONSTRAINT `movement_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `movement_detail_warehouse_from_id_foreign` FOREIGN KEY (`warehouse_from_id`) REFERENCES `warehouses` (`id`),
  CONSTRAINT `movement_detail_warehouse_to_id_foreign` FOREIGN KEY (`warehouse_to_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `movement_detail` WRITE;
/*!40000 ALTER TABLE `movement_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `movement_detail` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movements` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text COLLATE utf8mb4_unicode_ci,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PE',
  `doctype_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_from_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_to_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `movements_doctype_id_foreign` (`doctype_id`),
  KEY `movements_warehouse_from_id_foreign` (`warehouse_from_id`),
  KEY `movements_warehouse_to_id_foreign` (`warehouse_to_id`),
  KEY `movements_company_id_foreign` (`company_id`),
  CONSTRAINT `movements_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `movements_doctype_id_foreign` FOREIGN KEY (`doctype_id`) REFERENCES `doctypes` (`id`),
  CONSTRAINT `movements_warehouse_from_id_foreign` FOREIGN KEY (`warehouse_from_id`) REFERENCES `warehouses` (`id`),
  CONSTRAINT `movements_warehouse_to_id_foreign` FOREIGN KEY (`warehouse_to_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `movements` WRITE;
/*!40000 ALTER TABLE `movements` DISABLE KEYS */;
/*!40000 ALTER TABLE `movements` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_detail` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(20,4) NOT NULL DEFAULT '0.0000',
  `tax` double(20,4) NOT NULL DEFAULT '0.0000',
  `discount` double(20,4) NOT NULL DEFAULT '0.0000',
  `full_price` double(20,4) NOT NULL DEFAULT '0.0000',
  `total_price` double(20,4) NOT NULL DEFAULT '0.0000',
  `total_tax` double(20,4) NOT NULL DEFAULT '0.0000',
  `total_discount` double(20,4) NOT NULL DEFAULT '0.0000',
  `total` double(20,4) NOT NULL DEFAULT '0.0000',
  `currency_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double NOT NULL,
  `qty_delivered` double NOT NULL DEFAULT '0',
  `qty_invoiced` double NOT NULL DEFAULT '0',
  `order_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_detail_currency_id_foreign` (`currency_id`),
  KEY `order_detail_order_id_foreign` (`order_id`),
  KEY `order_detail_warehouse_id_foreign` (`warehouse_id`),
  KEY `order_detail_product_id_foreign` (`product_id`),
  KEY `order_detail_tax_id_foreign` (`tax_id`),
  KEY `order_detail_discount_id_foreign` (`discount_id`),
  KEY `order_detail_price_id_foreign` (`price_id`),
  KEY `order_detail_company_id_foreign` (`company_id`),
  CONSTRAINT `order_detail_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `order_detail_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `order_detail_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `taxs_discounts` (`id`),
  CONSTRAINT `order_detail_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_detail_price_id_foreign` FOREIGN KEY (`price_id`) REFERENCES `prices` (`id`),
  CONSTRAINT `order_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `order_detail_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxs_discounts` (`id`),
  CONSTRAINT `order_detail_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_detail` WRITE;
/*!40000 ALTER TABLE `order_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_detail` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text COLLATE utf8mb4_unicode_ci,
  `alternate_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` double(20,4) NOT NULL DEFAULT '0.0000',
  `total_tax` double(20,4) NOT NULL DEFAULT '0.0000',
  `total_discount` double(20,4) NOT NULL DEFAULT '0.0000',
  `total` double(20,4) NOT NULL DEFAULT '0.0000',
  `currency_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('SALE','PURC') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SALE',
  `is_invoice_pending` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `is_delivery_pending` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `state` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PE',
  `partner_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctype_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_list_type_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_channel_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_currency_id_foreign` (`currency_id`),
  KEY `orders_partner_id_foreign` (`partner_id`),
  KEY `orders_doctype_id_foreign` (`doctype_id`),
  KEY `orders_warehouse_id_foreign` (`warehouse_id`),
  KEY `orders_price_list_type_id_foreign` (`price_list_type_id`),
  KEY `orders_sale_channel_id_foreign` (`sale_channel_id`),
  KEY `orders_tax_id_foreign` (`tax_id`),
  KEY `orders_discount_id_foreign` (`discount_id`),
  KEY `orders_company_id_foreign` (`company_id`),
  KEY `orders_payment_method_id_foreign` (`payment_method_id`),
  CONSTRAINT `orders_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `orders_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `orders_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `taxs_discounts` (`id`),
  CONSTRAINT `orders_doctype_id_foreign` FOREIGN KEY (`doctype_id`) REFERENCES `doctypes` (`id`),
  CONSTRAINT `orders_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  CONSTRAINT `orders_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  CONSTRAINT `orders_price_list_type_id_foreign` FOREIGN KEY (`price_list_type_id`) REFERENCES `price_list_types` (`id`),
  CONSTRAINT `orders_sale_channel_id_foreign` FOREIGN KEY (`sale_channel_id`) REFERENCES `sales_channels` (`id`),
  CONSTRAINT `orders_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxs_discounts` (`id`),
  CONSTRAINT `orders_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES ('a37a874f-3700-4b7b-b3ef-6a74cb4125a3','OC00001','2019-08-22 02:53:50',NULL,NULL,NULL,0.0000,0.0000,0.0000,0.0000,'a9e75763-1d30-4f7f-8d0f-9b9c869c2159','PURC','y','y','PE','5b401199-076c-405b-aefc-e344f4e65522','4615ca3b-47cd-4081-9ee7-6f8ae112fcc5','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','a8b3be93-305d-4ce9-8120-88f525cc4bb5',NULL,NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698',NULL,'2019-08-22 02:54:28','2019-08-22 02:54:28',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `partner_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_category` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partner_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `partner_category_partner_id_foreign` (`partner_id`),
  KEY `partner_category_category_id_foreign` (`category_id`),
  KEY `partner_category_company_id_foreign` (`company_id`),
  CONSTRAINT `partner_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `partner_category_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `partner_category_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `partner_category` WRITE;
/*!40000 ALTER TABLE `partner_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `partner_category` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partners` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_supplier` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `is_customer` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `description` text COLLATE utf8mb4_unicode_ci,
  `birthdate` date DEFAULT NULL,
  `contact_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `economic_activity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('m','f','o') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `partners_category_id_foreign` (`category_id`),
  KEY `partners_address_id_foreign` (`address_id`),
  KEY `partners_company_id_foreign` (`company_id`),
  CONSTRAINT `partners_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `partners_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `partners_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES ('5b401199-076c-405b-aefc-e344f4e65522','123456','Proveedor de Prueba',NULL,NULL,NULL,NULL,NULL,NULL,'supplier','y','n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-20 17:28:18',NULL),('69ebc2b3-d605-4cd3-9c70-9c6e70438bdf','00000000','Cliente de Prueba',NULL,NULL,NULL,NULL,NULL,NULL,'customer','n','y',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-20 17:28:18',NULL);
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `amount_operation_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_methods_amount_operation_id_foreign` (`amount_operation_id`),
  KEY `payment_methods_company_id_foreign` (`company_id`),
  CONSTRAINT `payment_methods_amount_operation_id_foreign` FOREIGN KEY (`amount_operation_id`) REFERENCES `amount_operations` (`id`),
  CONSTRAINT `payment_methods_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES ('3c09bab2-4c61-4fd1-9959-a226ddefbfc7','Punto de venta',NULL,NULL,'SALE','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-20 17:28:18',NULL),('3cb97063-8242-4aac-97fe-634f65e013b2','Efectivo',NULL,NULL,'SALE','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-20 17:28:18',NULL),('f07fbff8-6550-4c39-89e2-3360f1fc5aa5','Transferencia',NULL,NULL,'SALE','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-20 17:28:18',NULL);
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `permission_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  KEY `permission_role_company_id_foreign` (`company_id`),
  CONSTRAINT `permission_role_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES ('e204a98e-cab4-410c-a134-a67405b44bd6','40538c2d-dd38-4353-ba26-b57bff3e9d67',NULL,NULL);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_group` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `permission_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES ('005a6e7e-7db8-4c87-8400-9bbed4c3332d','admin.products.products.index','Listar productos','n','b6416142-452c-4c4f-9204-23c1b115d4fb','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('2a6ebcea-13bd-4e9b-bd56-8cce87045ebe','admin.update','Actualizar Usuarios','n','d9acf208-812b-4de7-b3e6-79aead2a796f','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('488a1f36-efbb-427c-88c7-5570e9953758','permissions.assign','Asignar Permisos','n','d9acf208-812b-4de7-b3e6-79aead2a796f','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('4e6bf14f-2a29-4add-bc46-bb0eab0d7a9d','admin.products.categories.index','Listar categorías de productos','n','b6416142-452c-4c4f-9204-23c1b115d4fb','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('5a32a58f-a5ab-4e70-9c8a-2df983208ba1','admin.products.brands.index','Listar marcas','n','b6416142-452c-4c4f-9204-23c1b115d4fb','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('5d78a65e-200f-4a04-94cc-a38c5a7c1dc5','admin.purchases.suppliers.index','Listar Proveedores','n','e04c3187-4f43-4806-9ae3-99415e0050f3','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('729bdb6c-c3df-4182-b228-299a44432b2f','roles.list','Listar Roles','n','d9acf208-812b-4de7-b3e6-79aead2a796f','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('746a30fa-256e-4639-bfb0-e25633ca3d01','admin.products.inventories.index','Listar inventarios','n','b6416142-452c-4c4f-9204-23c1b115d4fb','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('930392fe-700b-4c1a-8d9d-80302b638ba6','admin.create','Crear Usuarios','n','d9acf208-812b-4de7-b3e6-79aead2a796f','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('a34f4630-b2f4-4d94-8131-0d807c72d660','admin.products.warehouses.index','Listar almacenes','n','b6416142-452c-4c4f-9204-23c1b115d4fb','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('b6416142-452c-4c4f-9204-23c1b115d4fb','admin.products','Módulo de productos','y',NULL,'2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('cc2c41b4-9927-4ff1-89d9-80c98944b360','admin.edit','Editar Usuarios','n','d9acf208-812b-4de7-b3e6-79aead2a796f','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('d050127f-82df-48db-81fe-e2f500dc9a84','admin.purchases.categories.index','Listar categorías de proveedores','n','e04c3187-4f43-4806-9ae3-99415e0050f3','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('d999aae5-af2e-4340-b1e7-ffbfd827aa03','admin.list','Listar Usuarios','n','d9acf208-812b-4de7-b3e6-79aead2a796f','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('d9acf208-812b-4de7-b3e6-79aead2a796f','security','Módulo de Seguridad','y',NULL,'2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('dab3d356-6c29-40ad-8410-cd8a8e1bcd69','admin.remove','Eliminar Usuarios','n','d9acf208-812b-4de7-b3e6-79aead2a796f','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('e04c3187-4f43-4806-9ae3-99415e0050f3','admin.purchases','Módulo de Compras','y',NULL,'2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('e204a98e-cab4-410c-a134-a67405b44bd6','developerOnly','developerOnly','y',NULL,'2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('fc4f8117-392b-48a0-8196-c5c06131bb06','admin.products.config.edit','Configurar módulo de productos','n','b6416142-452c-4c4f-9204-23c1b115d4fb','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `price_list_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price_list_types` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_abbr` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('sales','purchases','all') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sales',
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `price_list_types_currency_id_foreign` (`currency_id`),
  KEY `price_list_types_company_id_foreign` (`company_id`),
  CONSTRAINT `price_list_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `price_list_types_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `price_list_types` WRITE;
/*!40000 ALTER TABLE `price_list_types` DISABLE KEYS */;
INSERT INTO `price_list_types` VALUES ('127fc803-a279-44e4-844b-a7fc4a15d166','Lista de venta en dolares','a9e75763-1d30-4f7f-8d0f-9b9c869c2159','USD',NULL,'sales','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-20 20:09:45',NULL),('492f23f1-f704-4276-a747-3b4202d3dfee','Lista de ventas en Bolívares','141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF',NULL,'sales','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 20:10:06','2019-08-20 20:10:06',NULL),('a8b3be93-305d-4ce9-8120-88f525cc4bb5','Lista de compras USD','a9e75763-1d30-4f7f-8d0f-9b9c869c2159','USD',NULL,'purchases','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-22 02:53:47','2019-08-22 02:53:47',NULL);
/*!40000 ALTER TABLE `price_list_types` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `price_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price_lists` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starting_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price_list_type_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctype_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_price_list_type_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PE',
  `amount_operation_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `price_lists_price_list_type_id_foreign` (`price_list_type_id`),
  KEY `price_lists_doctype_id_foreign` (`doctype_id`),
  KEY `price_lists_exchange_rate_id_foreign` (`exchange_rate_id`),
  KEY `price_lists_reference_price_list_type_id_foreign` (`reference_price_list_type_id`),
  KEY `price_lists_amount_operation_id_foreign` (`amount_operation_id`),
  KEY `price_lists_company_id_foreign` (`company_id`),
  CONSTRAINT `price_lists_amount_operation_id_foreign` FOREIGN KEY (`amount_operation_id`) REFERENCES `amount_operations` (`id`),
  CONSTRAINT `price_lists_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `price_lists_doctype_id_foreign` FOREIGN KEY (`doctype_id`) REFERENCES `doctypes` (`id`),
  CONSTRAINT `price_lists_exchange_rate_id_foreign` FOREIGN KEY (`exchange_rate_id`) REFERENCES `exchange_rates` (`id`),
  CONSTRAINT `price_lists_price_list_type_id_foreign` FOREIGN KEY (`price_list_type_id`) REFERENCES `price_list_types` (`id`),
  CONSTRAINT `price_lists_reference_price_list_type_id_foreign` FOREIGN KEY (`reference_price_list_type_id`) REFERENCES `price_list_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `price_lists` WRITE;
/*!40000 ALTER TABLE `price_lists` DISABLE KEYS */;
INSERT INTO `price_lists` VALUES ('4c80928f-8d63-4eee-969a-5d3bc8f72d45','LP00001','2019-08-20 20:14:29',NULL,'127fc803-a279-44e4-844b-a7fc4a15d166','2131efa5-5a8b-4b20-8ace-17bdb268d6be',NULL,NULL,'PR',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 20:12:13','2019-08-20 20:14:29',NULL),('77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','LP00002','2019-08-20 21:43:14',NULL,'492f23f1-f704-4276-a747-3b4202d3dfee','2131efa5-5a8b-4b20-8ace-17bdb268d6be','2942cdc5-5aaf-4f02-870e-41823583606e','127fc803-a279-44e4-844b-a7fc4a15d166','PR',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 20:18:06','2019-08-20 21:43:14',NULL);
/*!40000 ALTER TABLE `price_lists` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prices` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starting_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` double(20,4) NOT NULL DEFAULT '0.0000',
  `before_price` double(20,4) DEFAULT NULL,
  `base_price` double(20,4) DEFAULT NULL,
  `operation_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operation_calc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operation_value` double(20,4) DEFAULT NULL,
  `currency_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_abbr` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_list_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_list_type_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_operation_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prices_currency_id_foreign` (`currency_id`),
  KEY `prices_product_id_foreign` (`product_id`),
  KEY `prices_price_list_id_foreign` (`price_list_id`),
  KEY `prices_price_list_type_id_foreign` (`price_list_type_id`),
  KEY `prices_exchange_rate_id_foreign` (`exchange_rate_id`),
  KEY `prices_amount_operation_id_foreign` (`amount_operation_id`),
  KEY `prices_company_id_foreign` (`company_id`),
  CONSTRAINT `prices_amount_operation_id_foreign` FOREIGN KEY (`amount_operation_id`) REFERENCES `amount_operations` (`id`),
  CONSTRAINT `prices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `prices_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `prices_exchange_rate_id_foreign` FOREIGN KEY (`exchange_rate_id`) REFERENCES `exchange_rates` (`id`),
  CONSTRAINT `prices_price_list_id_foreign` FOREIGN KEY (`price_list_id`) REFERENCES `price_lists` (`id`),
  CONSTRAINT `prices_price_list_type_id_foreign` FOREIGN KEY (`price_list_type_id`) REFERENCES `price_list_types` (`id`),
  CONSTRAINT `prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `prices` WRITE;
/*!40000 ALTER TABLE `prices` DISABLE KEYS */;
INSERT INTO `prices` VALUES ('02cddb08-bab8-48e1-a426-c5e15a44ed10','2019-08-20 21:35:27',0.0000,0.0000,0.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,'a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:02','2019-08-20 21:35:27','2019-08-20 21:35:27'),('043dfeca-30c8-40d7-a89e-26cf9421606e','2019-08-20 21:42:47',30.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:38','2019-08-20 21:42:47','2019-08-20 21:42:47'),('0773a409-c2f1-4ad3-a0dc-4b2caf4d4818','2019-08-20 21:42:02',0.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:41:19','2019-08-20 21:42:02','2019-08-20 21:42:02'),('0a084b68-eb1a-4216-b68d-1f036e9f42ab','2019-08-20 21:36:20',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:36:00','2019-08-20 21:36:20','2019-08-20 21:36:20'),('0b9e368d-98f9-40fd-8a45-3c127b98e2fb','2019-08-20 21:42:31',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:25','2019-08-20 21:42:31','2019-08-20 21:42:31'),('0c0aee64-1e16-4369-bfbf-5bc499919a77','2019-08-20 21:43:01',318000.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:47','2019-08-20 21:43:01','2019-08-20 21:43:01'),('0edcaf88-fb21-4e9f-96fe-a41381004e24','2019-08-20 21:42:31',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:25','2019-08-20 21:42:31','2019-08-20 21:42:31'),('13b23b10-ef47-4cda-9549-819341eb73c6','2019-08-20 21:34:05',159000.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:00:39','2019-08-20 21:34:05','2019-08-20 21:34:05'),('1aaf2060-cad2-45c0-b945-febeb6d99a85','2019-08-20 20:14:29',30.0000,0.0000,NULL,NULL,NULL,NULL,'a9e75763-1d30-4f7f-8d0f-9b9c869c2159','USD','5e6e023e-db94-4f15-9477-5f678238be35','4c80928f-8d63-4eee-969a-5d3bc8f72d45','127fc803-a279-44e4-844b-a7fc4a15d166',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 20:14:16','2019-08-20 20:14:29',NULL),('1f57d58c-9f68-49da-b06e-6f223e1dd297','2019-08-20 21:43:14',318000.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 21:43:01','2019-08-20 21:43:14',NULL),('20191c59-200d-457b-9239-db9eea6293c9','2019-08-20 21:35:02',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:34:05','2019-08-20 21:35:02','2019-08-20 21:35:02'),('212a0f23-dde7-48db-887e-8ae0c6353569','2019-08-20 20:14:16',5.0000,0.0000,NULL,NULL,NULL,NULL,'a9e75763-1d30-4f7f-8d0f-9b9c869c2159','USD','5e6e023e-db94-4f15-9477-5f678238be35','4c80928f-8d63-4eee-969a-5d3bc8f72d45','127fc803-a279-44e4-844b-a7fc4a15d166',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:14:03','2019-08-20 20:14:16','2019-08-20 20:14:16'),('25c47a7d-c3c2-496c-8624-962dfab2e392','2019-08-20 21:42:38',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:31','2019-08-20 21:42:38','2019-08-20 21:42:38'),('317becb0-493a-4205-97c0-da0c1fa11509','2019-08-20 20:50:39',11.0000,0.0000,10.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,'a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:50:14','2019-08-20 20:50:39','2019-08-20 20:50:39'),('35cde6e1-f812-4f2a-b4fc-0057f143f017','2019-08-20 21:00:39',318000.0000,0.0000,20.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e','a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:50:39','2019-08-20 21:00:39','2019-08-20 21:00:39'),('3a284624-0b2d-4771-b43f-f6cd147b7069','2019-08-20 21:36:00',10.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:45','2019-08-20 21:36:00','2019-08-20 21:36:00'),('3cc09627-b8aa-455f-a25d-3fec232a9586','2019-08-20 21:41:04',318000.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:36:30','2019-08-20 21:41:04','2019-08-20 21:41:04'),('4955c5ea-f5b2-449a-ac8a-c6ed11d09f72','2019-08-20 20:48:13',477000.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:18:06','2019-08-20 20:48:13','2019-08-20 20:48:13'),('49ef189e-c287-41f7-8554-9999ffb43c58','2019-08-20 21:35:02',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:34:05','2019-08-20 21:35:02','2019-08-20 21:35:02'),('4d5c9489-1d27-4971-a7b4-77970b099bc8','2019-08-20 21:42:24',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:18','2019-08-20 21:42:24','2019-08-20 21:42:24'),('5109ca55-9aed-4eab-8ff8-74d9dfdb898f','2019-08-20 21:42:18',30.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:02','2019-08-20 21:42:18','2019-08-20 21:42:18'),('53e453e5-4286-421c-95e6-7aab23385232','2019-08-20 21:42:31',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:24','2019-08-20 21:42:31','2019-08-20 21:42:31'),('671a3a3d-48dd-440f-9c37-733c1410efed','2019-08-20 21:35:45',159000.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:36','2019-08-20 21:35:45','2019-08-20 21:35:45'),('6a1961d8-8329-469f-9442-e8309d51b215','2019-08-20 21:42:47',10.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:38','2019-08-20 21:42:47','2019-08-20 21:42:47'),('6c1309ea-0d23-42bd-84e8-cb0565e80bbf','2019-08-20 21:36:30',159000.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:36:20','2019-08-20 21:36:30','2019-08-20 21:36:30'),('7061acb0-ab71-4d34-9b12-2664cc25900f','2019-08-20 21:43:14',477000.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 21:43:01','2019-08-20 21:43:14',NULL),('71835954-e3a9-440d-803e-65dee7e91ad2','2019-08-20 20:14:03',30.0000,0.0000,NULL,NULL,NULL,NULL,'a9e75763-1d30-4f7f-8d0f-9b9c869c2159','USD','5e6e023e-db94-4f15-9477-5f678238be35','4c80928f-8d63-4eee-969a-5d3bc8f72d45','127fc803-a279-44e4-844b-a7fc4a15d166',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:12:57','2019-08-20 20:14:03','2019-08-20 20:14:03'),('71c057f3-e648-4708-a5a0-e7cc29662b46','2019-08-20 20:50:39',22.0000,0.0000,20.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,'a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:50:14','2019-08-20 20:50:39','2019-08-20 20:50:39'),('72ae6e91-273b-4820-8c14-0249ba548009','2019-08-20 21:35:27',0.0000,0.0000,0.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,'a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:02','2019-08-20 21:35:27','2019-08-20 21:35:27'),('74343f50-44c6-43a3-b7d9-b4d208e75310','2019-08-20 20:50:14',318000.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:48:34','2019-08-20 20:50:14','2019-08-20 20:50:14'),('76b0e43c-b4b3-48ae-b677-85a31424ebf4','2019-08-20 21:42:38',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:31','2019-08-20 21:42:38','2019-08-20 21:42:38'),('793a4898-16f6-4482-b7e0-c9e101540586','2019-08-20 20:50:14',159000.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:48:34','2019-08-20 20:50:14','2019-08-20 20:50:14'),('83ac9106-8025-4adb-9d7e-241822b0fb9a','2019-08-20 21:36:30',477000.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:36:20','2019-08-20 21:36:30','2019-08-20 21:36:30'),('86afa05e-03b1-426c-a0a9-3bba6e512ff7','2019-08-20 21:43:01',477000.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:47','2019-08-20 21:43:01','2019-08-20 21:43:01'),('90e754c1-fdaf-4a34-97cd-2d98ec630e7e','2019-08-20 21:42:18',10.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:02','2019-08-20 21:42:18','2019-08-20 21:42:18'),('928d67a4-371e-46a3-9a4e-4836dc035fd1','2019-08-20 21:36:30',318000.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:36:20','2019-08-20 21:36:30','2019-08-20 21:36:30'),('9347c7aa-f4df-401f-a454-7202535a0b70','2019-08-20 21:42:47',20.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:38','2019-08-20 21:42:47','2019-08-20 21:42:47'),('96ef83b9-5fce-497a-b22c-4bd1a1f0cc44','2019-08-20 21:00:39',477000.0000,0.0000,30.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e','a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:50:39','2019-08-20 21:00:39','2019-08-20 21:00:39'),('970c66f6-39ce-45ff-ab13-125cf8eb7ee4','2019-08-20 20:50:39',33.0000,0.0000,30.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,'a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:50:14','2019-08-20 20:50:39','2019-08-20 20:50:39'),('98533638-a9aa-4239-b61e-ff6754d2725c','2019-08-20 20:48:13',159000.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:18:06','2019-08-20 20:48:13','2019-08-20 20:48:13'),('9a0e35bf-31ec-4595-b829-0f82ec1d71e0','2019-08-20 20:14:29',10.0000,0.0000,NULL,NULL,NULL,NULL,'a9e75763-1d30-4f7f-8d0f-9b9c869c2159','USD','bb7a776c-6361-4258-acfa-3a703620d59c','4c80928f-8d63-4eee-969a-5d3bc8f72d45','127fc803-a279-44e4-844b-a7fc4a15d166',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 20:12:41','2019-08-20 20:14:29',NULL),('9a6f31ce-155a-4684-b658-2cc53f150188','2019-08-20 21:34:05',318000.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:00:39','2019-08-20 21:34:05','2019-08-20 21:34:05'),('9b1a107e-d864-4d4d-b180-38041ca98e32','2019-08-20 21:42:02',0.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:41:19','2019-08-20 21:42:02','2019-08-20 21:42:02'),('9b4e6930-423a-4056-96c0-f12f6603e970','2019-08-20 21:41:04',159000.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:36:30','2019-08-20 21:41:04','2019-08-20 21:41:04'),('a01191f7-e7e3-4711-baf3-22ee4f21d40e','2019-08-20 21:35:36',22.0000,0.0000,20.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,'a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:27','2019-08-20 21:35:36','2019-08-20 21:35:36'),('a0b8788b-4565-4453-b6d6-8c712ec8f3eb','2019-08-20 21:36:00',20.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:45','2019-08-20 21:36:00','2019-08-20 21:36:00'),('a1782709-58a0-4b95-94b1-08ce3444e152','2019-08-20 21:35:36',11.0000,0.0000,10.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,'a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:27','2019-08-20 21:35:36','2019-08-20 21:35:36'),('a57f289c-4116-49da-b933-1ca6914fc626','2019-08-20 20:14:29',20.0000,0.0000,NULL,NULL,NULL,NULL,'a9e75763-1d30-4f7f-8d0f-9b9c869c2159','USD','74f8e534-eb31-426b-8672-98a4f1b0d2cd','4c80928f-8d63-4eee-969a-5d3bc8f72d45','127fc803-a279-44e4-844b-a7fc4a15d166',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 20:12:50','2019-08-20 20:14:29',NULL),('a58a20c5-c6d3-4504-8aff-0d7a5ecbb89d','2019-08-20 20:12:50',0.0000,0.0000,0.0000,NULL,NULL,NULL,'a9e75763-1d30-4f7f-8d0f-9b9c869c2159','USD','74f8e534-eb31-426b-8672-98a4f1b0d2cd','4c80928f-8d63-4eee-969a-5d3bc8f72d45','127fc803-a279-44e4-844b-a7fc4a15d166',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:12:27','2019-08-20 20:12:50','2019-08-20 20:12:50'),('a683391d-94b9-449c-a384-2f07c7509fe6','2019-08-20 21:36:20',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:36:00','2019-08-20 21:36:20','2019-08-20 21:36:20'),('ab7203a5-ea58-4fc2-8880-c1af814fb478','2019-08-20 21:41:19',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:41:04','2019-08-20 21:41:19','2019-08-20 21:41:19'),('abb9bc80-3511-46af-af81-fda75479b0a8','2019-08-20 21:35:36',33.0000,0.0000,30.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,'a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:27','2019-08-20 21:35:36','2019-08-20 21:35:36'),('b4a7b414-21c6-4aa9-8435-8b413d3954e1','2019-08-20 21:34:05',477000.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:00:39','2019-08-20 21:34:05','2019-08-20 21:34:05'),('b66f8a40-6a73-402e-96e3-46ea8db914cc','2019-08-20 20:48:13',318000.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:18:06','2019-08-20 20:48:13','2019-08-20 20:48:13'),('b93955b1-86f1-4687-9249-961fe672322c','2019-08-20 21:35:27',0.0000,0.0000,0.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,'a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:02','2019-08-20 21:35:27','2019-08-20 21:35:27'),('b99b50f2-75f3-48bb-b9ae-ada5fe8ccc49','2019-08-20 21:41:19',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:41:04','2019-08-20 21:41:19','2019-08-20 21:41:19'),('be480e0a-e3b7-4d4b-9c38-548d8cb25a65','2019-08-20 21:42:24',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:18','2019-08-20 21:42:24','2019-08-20 21:42:24'),('be699ebc-4871-4a22-b5e6-883016bccdcc','2019-08-20 21:42:38',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:31','2019-08-20 21:42:38','2019-08-20 21:42:38'),('bee2f50b-cbb5-49a5-b583-9bd505db5c55','2019-08-20 21:36:00',30.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:45','2019-08-20 21:36:00','2019-08-20 21:36:00'),('bf7bf351-7b86-4040-a660-03a26da4331e','2019-08-20 21:36:20',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:36:00','2019-08-20 21:36:20','2019-08-20 21:36:20'),('c6b5f6e9-eab9-4b93-b239-6aee8f566111','2019-08-20 21:42:25',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:18','2019-08-20 21:42:25','2019-08-20 21:42:25'),('cbca881e-ca1e-40ec-81ba-59310424673d','2019-08-20 20:12:57',0.0000,0.0000,0.0000,NULL,NULL,NULL,'a9e75763-1d30-4f7f-8d0f-9b9c869c2159','USD','5e6e023e-db94-4f15-9477-5f678238be35','4c80928f-8d63-4eee-969a-5d3bc8f72d45','127fc803-a279-44e4-844b-a7fc4a15d166',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:12:27','2019-08-20 20:12:57','2019-08-20 20:12:57'),('cd54a490-4ed5-4899-a426-25071c1ed298','2019-08-20 21:41:19',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:41:04','2019-08-20 21:41:19','2019-08-20 21:41:19'),('d0f8d52b-4118-49d8-a2c7-7336e357b2cc','2019-08-20 20:48:34',30.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:48:13','2019-08-20 20:48:34','2019-08-20 20:48:34'),('d2a9926e-7091-4b0a-8747-665e47a715e6','2019-08-20 21:43:01',159000.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:47','2019-08-20 21:43:01','2019-08-20 21:43:01'),('d72043b6-293c-4bb6-9a01-4c9c6361b830','2019-08-20 21:35:45',477000.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:36','2019-08-20 21:35:45','2019-08-20 21:35:45'),('dad9214d-1898-483c-a78e-520e1d25206f','2019-08-20 20:12:41',0.0000,0.0000,0.0000,NULL,NULL,NULL,'a9e75763-1d30-4f7f-8d0f-9b9c869c2159','USD','bb7a776c-6361-4258-acfa-3a703620d59c','4c80928f-8d63-4eee-969a-5d3bc8f72d45','127fc803-a279-44e4-844b-a7fc4a15d166',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:12:27','2019-08-20 20:12:41','2019-08-20 20:12:41'),('dd7ef4ab-58d5-4b60-8d1f-6dc362c52b82','2019-08-20 20:48:34',20.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:48:13','2019-08-20 20:48:34','2019-08-20 20:48:34'),('e058aab9-262a-461c-9992-c06a251d52c1','2019-08-20 21:35:45',318000.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:35:36','2019-08-20 21:35:45','2019-08-20 21:35:45'),('e6b086a4-6344-4617-bd9e-9c7d4b987c72','2019-08-20 21:35:02',0.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:34:05','2019-08-20 21:35:02','2019-08-20 21:35:02'),('e8faf769-0941-4037-87e2-b5acc79a902a','2019-08-20 21:42:02',0.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:41:19','2019-08-20 21:42:02','2019-08-20 21:42:02'),('e9bcc07f-61bf-4309-b39e-ba0747d619cc','2019-08-20 21:43:14',159000.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 21:43:01','2019-08-20 21:43:14',NULL),('eaa8f1cf-a797-4962-b322-b822db650a30','2019-08-20 21:00:39',159000.0000,0.0000,10.0000,'+ 10%','add_percent',10.0000,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e','a47503ea-2153-4819-9ee6-80acfa28dd06','d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:50:39','2019-08-20 21:00:39','2019-08-20 21:00:39'),('eda9e1fe-5c28-4f5c-87ec-2052c9e7f2eb','2019-08-20 21:42:18',20.0000,0.0000,20.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','74f8e534-eb31-426b-8672-98a4f1b0d2cd','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:42:02','2019-08-20 21:42:18','2019-08-20 21:42:18'),('eea8de59-a18d-4035-860b-ffa3e0fe45a8','2019-08-20 20:48:34',10.0000,0.0000,10.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','bb7a776c-6361-4258-acfa-3a703620d59c','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:48:13','2019-08-20 20:48:34','2019-08-20 20:48:34'),('f647cbf6-dfc1-4789-b870-ebbf8b806d68','2019-08-20 21:41:04',477000.0000,0.0000,0.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 21:36:30','2019-08-20 21:41:04','2019-08-20 21:41:04'),('fc704496-f6a3-4f22-810b-d7ceefad1c15','2019-08-20 20:50:14',477000.0000,0.0000,30.0000,NULL,NULL,NULL,'141ae3b6-ed30-4d68-bacf-4daac1c312f1','VEF','5e6e023e-db94-4f15-9477-5f678238be35','77e2bdd9-fcfc-42ea-8867-8d1a553ab9d1','492f23f1-f704-4276-a747-3b4202d3dfee','2942cdc5-5aaf-4f02-870e-41823583606e',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','off','2019-08-20 20:48:34','2019-08-20 20:50:14','2019-08-20 20:50:14');
/*!40000 ALTER TABLE `prices` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `product_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_brand` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_brand_product_id_foreign` (`product_id`),
  KEY `product_brand_brand_id_foreign` (`brand_id`),
  KEY `product_brand_company_id_foreign` (`company_id`),
  CONSTRAINT `product_brand_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `product_brand_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `product_brand_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `product_brand` WRITE;
/*!40000 ALTER TABLE `product_brand` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_brand` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_category_product_id_foreign` (`product_id`),
  KEY `product_category_category_id_foreign` (`category_id`),
  KEY `product_category_company_id_foreign` (`company_id`),
  CONSTRAINT `product_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `product_category_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `product_category_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `product_partner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_partner` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_partner_product_id_foreign` (`product_id`),
  KEY `product_partner_partner_id_foreign` (`partner_id`),
  KEY `product_partner_company_id_foreign` (`company_id`),
  CONSTRAINT `product_partner_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `product_partner_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  CONSTRAINT `product_partner_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `product_partner` WRITE;
/*!40000 ALTER TABLE `product_partner` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_partner` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `product_uom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_uom` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uom_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_uom_uom_id_foreign` (`uom_id`),
  KEY `product_uom_product_id_foreign` (`product_id`),
  KEY `product_uom_company_id_foreign` (`company_id`),
  CONSTRAINT `product_uom_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `product_uom_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `product_uom_uom_id_foreign` FOREIGN KEY (`uom_id`) REFERENCES `uom` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `product_uom` WRITE;
/*!40000 ALTER TABLE `product_uom` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_uom` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alternate_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `part_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qrcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uom_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_service` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `brand_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partner_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_uom_id_foreign` (`uom_id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_brand_id_foreign` (`brand_id`),
  KEY `products_partner_id_foreign` (`partner_id`),
  KEY `products_company_id_foreign` (`company_id`),
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `products_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `products_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  CONSTRAINT `products_uom_id_foreign` FOREIGN KEY (`uom_id`) REFERENCES `uom` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES ('107fb4a0-f0b4-4e01-b6b6-6e88dff9096d','0002','Producto 2',NULL,NULL,'Descripción 2','54121322659324',NULL,NULL,'d225e7a6-8493-46c6-a4f8-6ca9636e3897',NULL,NULL,'n','59de7fbc-39a5-4f65-97f4-48856a6080dd',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-21 19:23:46','2019-08-21 19:23:46',NULL),('5e6e023e-db94-4f15-9477-5f678238be35','0003','Producto de Prueba 3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'n',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-21 19:22:40','2019-08-21 19:22:40'),('74f8e534-eb31-426b-8672-98a4f1b0d2cd','0002','Producto de Prueba 2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'n',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-21 19:22:40','2019-08-21 19:22:40'),('84e10702-422f-42b0-b907-5ec4375aeada','2343','sfsfsdfsdf',NULL,'sdfsdf','sdfsdf','sdfsdfs',NULL,'sdfsdf',NULL,NULL,NULL,'n',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-23 13:42:21','2019-08-23 13:42:21',NULL),('b9d627eb-3dcd-4ccf-84f8-467f12f54eac','0003','Producto 3',NULL,'55233','Descripción 3','54121322659325',NULL,'www.producto1.com',NULL,'51f620c8-aeef-436b-9fdd-49caffd683ef',NULL,'n',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-21 19:23:46','2019-08-21 19:23:46',NULL),('bb7a776c-6361-4258-acfa-3a703620d59c','0001','Producto de Prueba',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'n',NULL,NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-21 19:22:40','2019-08-21 19:22:40'),('e91f6dc7-9491-4875-9752-e129a5f4aa21','0001','Producto 1',NULL,'4523','Descripción 1','54121322659323',NULL,'www.producto1.com','4cf21481-36c2-42eb-bb89-4dc75deb66fa','cd71a386-8f2c-4c5c-9b35-2a1a9383604b',NULL,'n','856f079d-dbb7-42aa-ab52-f5d7fef5a852',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-21 19:23:46','2019-08-22 02:40:18',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `role_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  KEY `role_user_company_id_foreign` (`company_id`),
  CONSTRAINT `role_user_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_company_id_foreign` (`company_id`),
  CONSTRAINT `roles_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES ('40538c2d-dd38-4353-ba26-b57bff3e9d67','developer','Developer','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('75396ece-1141-4e78-8d1c-acb01b72ae51','Super','Super Admin','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('c9b68fea-b4e4-4f96-837f-7c424f66a5bb','Admin','Admin','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `sales_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_channels` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `amount_operation_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_channels_amount_operation_id_foreign` (`amount_operation_id`),
  KEY `sales_channels_company_id_foreign` (`company_id`),
  CONSTRAINT `sales_channels_amount_operation_id_foreign` FOREIGN KEY (`amount_operation_id`) REFERENCES `amount_operations` (`id`),
  CONSTRAINT `sales_channels_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `sales_channels` WRITE;
/*!40000 ALTER TABLE `sales_channels` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_channels` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `social_networks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_networks` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `social_network` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_networks_company_id_foreign` (`company_id`),
  CONSTRAINT `social_networks_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `social_networks` WRITE;
/*!40000 ALTER TABLE `social_networks` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_networks` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double NOT NULL,
  `ordered_qty` double NOT NULL DEFAULT '0',
  `reserved_qty` double NOT NULL DEFAULT '0',
  `available_qty` double NOT NULL DEFAULT '0',
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_product_id_foreign` (`product_id`),
  KEY `stock_warehouse_id_foreign` (`warehouse_id`),
  KEY `stock_company_id_foreign` (`company_id`),
  CONSTRAINT `stock_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `stock_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `stock_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
INSERT INTO `stock` VALUES ('3e8ff9a1-6df2-443c-8853-dfcba1069acb',20,0,0,0,'5e6e023e-db94-4f15-9477-5f678238be35','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 00:59:54','2019-08-21 00:59:54',NULL),('559a1166-ee53-4e79-97c0-9ebcd3567678',10,0,0,0,'bb7a776c-6361-4258-acfa-3a703620d59c','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 00:59:54','2019-08-21 00:59:54',NULL),('c79a9f87-5d56-4f4b-adc1-673d929f748f',12,0,0,0,'74f8e534-eb31-426b-8672-98a4f1b0d2cd','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 00:59:54','2019-08-21 00:59:54',NULL);
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `stock_limit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_limit` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_qty` double NOT NULL,
  `min_qty` double DEFAULT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_limit_product_id_foreign` (`product_id`),
  KEY `stock_limit_warehouse_id_foreign` (`warehouse_id`),
  KEY `stock_limit_company_id_foreign` (`company_id`),
  CONSTRAINT `stock_limit_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `stock_limit_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `stock_limit_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `stock_limit` WRITE;
/*!40000 ALTER TABLE `stock_limit` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_limit` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `taxs_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxs_discounts` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `amount_operation_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_tax` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `taxs_discounts_amount_operation_id_foreign` (`amount_operation_id`),
  KEY `taxs_discounts_company_id_foreign` (`company_id`),
  CONSTRAINT `taxs_discounts_amount_operation_id_foreign` FOREIGN KEY (`amount_operation_id`) REFERENCES `amount_operations` (`id`),
  CONSTRAINT `taxs_discounts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `taxs_discounts` WRITE;
/*!40000 ALTER TABLE `taxs_discounts` DISABLE KEYS */;
INSERT INTO `taxs_discounts` VALUES ('48661a87-dd43-4a34-9c1c-71afd0869252','Descuento 15%',NULL,'fed66451-5555-4a90-bd07-d1d5a5eadca4','n','SALE','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-20 17:28:18',NULL),('ada7fed4-1de2-4dbb-b355-a5261b05b5b8','Impuesto 10%',NULL,'a47503ea-2153-4819-9ee6-80acfa28dd06','y','SALE','d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-20 17:28:18',NULL);
/*!40000 ALTER TABLE `taxs_discounts` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text COLLATE utf8mb4_unicode_ci,
  `qty` double NOT NULL,
  `sign` enum('add','sub') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'add',
  `process_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_product_id_foreign` (`product_id`),
  KEY `transactions_warehouse_id_foreign` (`warehouse_id`),
  KEY `transactions_company_id_foreign` (`company_id`),
  CONSTRAINT `transactions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `transactions_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES ('435f4783-e20a-47df-9640-739d021cb8db','IN00001','IN','2019-08-21 00:58:33',NULL,20,'add','527e5501-5d34-4fe2-9384-090279ecc22d','5e6e023e-db94-4f15-9477-5f678238be35','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 00:59:54','2019-08-21 00:59:54',NULL),('76bc8db6-7eb4-4c89-b02b-e8a7bb478a65','IN00001','IN','2019-08-21 00:58:33',NULL,10,'add','14f6c218-7de7-4560-8bae-e32d354fe8a4','bb7a776c-6361-4258-acfa-3a703620d59c','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 00:59:54','2019-08-21 00:59:54',NULL),('cbd7cbef-e62a-47e4-828f-e6b5be2a65a1','IN00001','IN','2019-08-21 00:58:33',NULL,12,'add','d8a37333-4292-41d7-b387-f1b4f55f97aa','74f8e534-eb31-426b-8672-98a4f1b0d2cd','5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','d44b8fee-707a-47e3-b118-d6fa73296698','2019-08-21 00:59:54','2019-08-21 00:59:54',NULL);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `uom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uom` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `abbr` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uom_company_id_foreign` (`company_id`),
  CONSTRAINT `uom_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `uom` WRITE;
/*!40000 ALTER TABLE `uom` DISABLE KEYS */;
INSERT INTO `uom` VALUES ('4cf21481-36c2-42eb-bb89-4dc75deb66fa','Unidad',NULL,'Unidad',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('d225e7a6-8493-46c6-a4f8-6ca9636e3897','Kilo',NULL,'Kg',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('d29daa8d-9a70-4bd6-ab33-b2864e995d11','Galón',NULL,'Gl',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL),('e74b0960-9bc8-48e5-9204-26b8e71c0cf8','Litro',NULL,'Lt',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:06:20','2019-08-20 17:06:20',NULL);
/*!40000 ALTER TABLE `uom` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `uom_conversion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uom_conversion` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_from` double NOT NULL,
  `amount_to` double NOT NULL,
  `uom_from_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uom_to_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uom_conversion_uom_from_id_foreign` (`uom_from_id`),
  KEY `uom_conversion_uom_to_id_foreign` (`uom_to_id`),
  CONSTRAINT `uom_conversion_uom_from_id_foreign` FOREIGN KEY (`uom_from_id`) REFERENCES `uom` (`id`),
  CONSTRAINT `uom_conversion_uom_to_id_foreign` FOREIGN KEY (`uom_to_id`) REFERENCES `uom` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `uom_conversion` WRITE;
/*!40000 ALTER TABLE `uom_conversion` DISABLE KEYS */;
/*!40000 ALTER TABLE `uom_conversion` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `profile_pic` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `warehouses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouses` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouses_address_id_foreign` (`address_id`),
  KEY `warehouses_company_id_foreign` (`company_id`),
  CONSTRAINT `warehouses_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `warehouses_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `warehouses` WRITE;
/*!40000 ALTER TABLE `warehouses` DISABLE KEYS */;
INSERT INTO `warehouses` VALUES ('5b9e7b23-bc7b-4ed2-a1ed-dc01a0a5930b','Almacén principal',NULL,'d44b8fee-707a-47e3-b118-d6fa73296698','on','2019-08-20 17:28:18','2019-08-20 17:28:18',NULL);
/*!40000 ALTER TABLE `warehouses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


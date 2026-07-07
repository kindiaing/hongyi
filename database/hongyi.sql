/*
 Navicat Premium Data Transfer

 Source Server         : laragon
 Source Server Type    : MySQL
 Source Server Version : 80403 (8.4.3)
 Source Host           : localhost:3306
 Source Schema         : hongyi

 Target Server Type    : MySQL
 Target Server Version : 80403 (8.4.3)
 File Encoding         : 65001

 Date: 07/07/2026 18:11:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for audit_configs
-- ----------------------------
DROP TABLE IF EXISTS `audit_configs`;
CREATE TABLE `audit_configs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `audit_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '审计类型标识',
  `audit_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '审计类型名称',
  `audit_module` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '所属模块',
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否启用审计',
  `record_create` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否记录创建操作',
  `record_update` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否记录编辑操作',
  `record_delete` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否记录删除操作',
  `record_view` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否记录查看操作',
  `record_old_data` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否记录变更前数据',
  `record_new_data` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否记录变更后数据',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '说明',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `audit_configs_audit_type_unique`(`audit_type` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of audit_configs
-- ----------------------------
INSERT INTO `audit_configs` VALUES (1, 'contract', '合同管理', '合同管理', 1, 1, 1, 1, 0, 1, 1, '主合同、分包合同的创建、编辑、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (2, 'contract_attachment', '合同附件', '合同管理', 1, 1, 0, 1, 0, 0, 1, '合同附件上传、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (3, 'device', '硬件设备', '资产管理', 1, 1, 1, 1, 0, 1, 1, '硬件设备的创建、编辑、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (4, 'software', '软件系统', '资产管理', 1, 1, 1, 1, 0, 1, 1, '软件系统的创建、编辑、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (5, 'vendor', '运维单位', '运维管理', 1, 1, 1, 1, 0, 1, 1, '运维单位的创建、编辑、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (6, 'personnel', '运维人员', '运维管理', 1, 1, 1, 1, 0, 1, 1, '运维人员的创建、编辑、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (7, 'service_unit', '服务单位', '运维管理', 1, 1, 1, 1, 0, 1, 1, '服务单位的创建、编辑、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (8, 'inspection_task', '巡检/回访任务', '巡检任务', 1, 1, 1, 1, 0, 1, 1, '巡检/回访任务的创建、编辑、删除、执行、审核操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (9, 'inspection_plan', '巡检计划', '巡检计划', 1, 1, 1, 1, 0, 1, 1, '巡检计划的创建、编辑、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (10, 'schedule', '排班管理', '排班管理', 1, 1, 1, 1, 0, 1, 1, '排班的创建、编辑、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (11, 'satisfaction', '回访/满意度调查', '回访管理', 1, 1, 1, 1, 0, 1, 1, '回访/满意度调查记录的创建、编辑、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (12, 'satisfaction_plan', '回访计划', '回访计划', 1, 1, 1, 1, 0, 1, 1, '回访计划的创建、编辑、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (13, 'system_user', '用户管理', '系统管理', 1, 1, 1, 1, 0, 1, 1, '系统用户的创建、编辑、删除、状态切换操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (14, 'system_role', '角色权限', '系统管理', 1, 0, 1, 0, 0, 1, 1, '角色权限配置的修改操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (15, 'system_dictionary', '数据字典', '系统管理', 1, 1, 1, 1, 0, 1, 1, '数据字典的创建、编辑、删除操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (16, 'system_audit_config', '审计配置', '系统管理', 1, 0, 1, 0, 0, 1, 1, '审计配置的修改操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');
INSERT INTO `audit_configs` VALUES (17, 'login', '登录/登出', '系统管理', 1, 1, 0, 0, 0, 0, 0, '用户登录、登出操作', '2026-07-07 06:11:57', '2026-07-07 06:11:57');

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache
-- ----------------------------
INSERT INTO `cache` VALUES ('laravel-cache-592544932fc6a8a338eb848b30f9f42c', 'i:1;', 1783409771);
INSERT INTO `cache` VALUES ('laravel-cache-592544932fc6a8a338eb848b30f9f42c:timer', 'i:1783409771;', 1783409771);

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_locks_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for contract_attachments
-- ----------------------------
DROP TABLE IF EXISTS `contract_attachments`;
CREATE TABLE `contract_attachments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'main主合同,sub分包合同',
  `contract_id` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint UNSIGNED NOT NULL DEFAULT 0,
  `file_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '附件版本类型: word电子版, pdf_sealed盖章版',
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_sealed` tinyint NOT NULL DEFAULT 0 COMMENT '是否盖章',
  `uploaded_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_attachments_uploaded_by_foreign`(`uploaded_by` ASC) USING BTREE,
  INDEX `contract_attachments_contract_type_contract_id_index`(`contract_type` ASC, `contract_id` ASC) USING BTREE,
  INDEX `contract_attachments_version_type_index`(`version_type` ASC) USING BTREE,
  CONSTRAINT `contract_attachments_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contract_attachments
-- ----------------------------

-- ----------------------------
-- Table structure for contract_renewals
-- ----------------------------
DROP TABLE IF EXISTS `contract_renewals`;
CREATE TABLE `contract_renewals`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_id` bigint UNSIGNED NOT NULL,
  `renewal_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_end_date` date NOT NULL,
  `new_start_date` date NOT NULL,
  `new_end_date` date NOT NULL,
  `new_amount` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `renewal_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` tinyint NOT NULL DEFAULT 0 COMMENT '0待审批,1已生效,2已驳回',
  `approved_by` bigint UNSIGNED NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_renewals_approved_by_foreign`(`approved_by` ASC) USING BTREE,
  INDEX `contract_renewals_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `contract_renewals_contract_type_contract_id_index`(`contract_type` ASC, `contract_id` ASC) USING BTREE,
  INDEX `contract_renewals_status_index`(`status` ASC) USING BTREE,
  CONSTRAINT `contract_renewals_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `contract_renewals_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contract_renewals
-- ----------------------------

-- ----------------------------
-- Table structure for data_dictionaries
-- ----------------------------
DROP TABLE IF EXISTS `data_dictionaries`;
CREATE TABLE `data_dictionaries`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_enabled` tinyint NOT NULL DEFAULT 1,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `data_dictionaries_category_code_unique`(`category` ASC, `code` ASC) USING BTREE,
  INDEX `data_dictionaries_category_index`(`category` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of data_dictionaries
-- ----------------------------
INSERT INTO `data_dictionaries` VALUES (1, 'device_type', 'server', '服务器', NULL, 1, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (2, 'device_type', 'ups', 'UPS电源', NULL, 2, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (3, 'device_type', 'switch', '交换机', NULL, 3, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (4, 'device_type', 'firewall', '防火墙', NULL, 4, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (5, 'device_type', 'storage', '存储设备', NULL, 5, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (6, 'device_type', 'air_conditioner', '精密空调', NULL, 6, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (7, 'device_type', 'power_distribution', '配电柜', NULL, 7, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (8, 'contract_type', 'software', '软件运维', NULL, 1, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (9, 'contract_type', 'hardware', '硬件运维', NULL, 2, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (10, 'contract_type', 'infrastructure', '机房建设', NULL, 3, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (11, 'contract_type', 'integrated', '综合运维', NULL, 4, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (12, 'contract_status', 'draft', '草稿', NULL, 1, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (13, 'contract_status', 'active', '生效中', NULL, 2, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (14, 'contract_status', 'expired', '已到期', NULL, 3, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (15, 'contract_status', 'terminated', '已终止', NULL, 4, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (16, 'maintenance_cycle', 'monthly', '月度', '1', 1, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (17, 'maintenance_cycle', 'quarterly', '季度', '3', 2, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (18, 'maintenance_cycle', 'semi_annual', '半年', '6', 3, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (19, 'maintenance_cycle', 'annual', '年度', '12', 4, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (20, 'inspection_cycle', 'daily', '日巡检', '1', 1, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (21, 'inspection_cycle', 'weekly', '周巡检', '7', 2, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (22, 'inspection_cycle', 'bi_weekly', '双周巡检', '14', 3, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (23, 'inspection_cycle', 'monthly', '月巡检', '30', 4, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (24, 'fault_level', 'critical', '紧急', NULL, 1, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (25, 'fault_level', 'major', '重大', NULL, 2, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (26, 'fault_level', 'minor', '一般', NULL, 3, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (27, 'vendor_type', 'software', '软件运维商', NULL, 1, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (28, 'vendor_type', 'hardware', '硬件运维商', NULL, 2, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (29, 'vendor_type', 'infrastructure', '机房建设商', NULL, 3, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (30, 'vendor_type', 'integrated', '综合服务商', NULL, 4, 1, NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `data_dictionaries` VALUES (31, 'project_level', 'provincial_unified', '省统建', NULL, 1, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');
INSERT INTO `data_dictionaries` VALUES (32, 'project_level', 'provincial', '省建', NULL, 2, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');
INSERT INTO `data_dictionaries` VALUES (33, 'project_level', 'municipal', '市建', NULL, 3, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');
INSERT INTO `data_dictionaries` VALUES (34, 'maintenance_type', 'resident_original', '原建设方驻场', NULL, 1, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');
INSERT INTO `data_dictionaries` VALUES (35, 'maintenance_type', 'remote_original', '原建设方远程运维', NULL, 2, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');
INSERT INTO `data_dictionaries` VALUES (36, 'maintenance_type', 'self_inspection', '自主巡检', NULL, 3, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');
INSERT INTO `data_dictionaries` VALUES (37, 'maintenance_type', 'self_resident', '自主运维驻场', NULL, 4, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');
INSERT INTO `data_dictionaries` VALUES (38, 'maintenance_type', 'purchased', '购买服务', NULL, 5, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');
INSERT INTO `data_dictionaries` VALUES (39, 'satisfaction_level', 'very_satisfied', '非常满意', NULL, 1, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');
INSERT INTO `data_dictionaries` VALUES (40, 'satisfaction_level', 'satisfied', '满意', NULL, 2, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');
INSERT INTO `data_dictionaries` VALUES (41, 'satisfaction_level', 'general', '一般', NULL, 3, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');
INSERT INTO `data_dictionaries` VALUES (42, 'satisfaction_level', 'dissatisfied', '不满意', NULL, 4, 1, NULL, '2026-07-07 02:25:48', '2026-07-07 02:25:48');

-- ----------------------------
-- Table structure for device_maintenance_logs
-- ----------------------------
DROP TABLE IF EXISTS `device_maintenance_logs`;
CREATE TABLE `device_maintenance_logs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `device_id` bigint UNSIGNED NOT NULL,
  `maintenance_date` date NOT NULL,
  `maintenance_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '定期/故障/升级',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `result` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cost` decimal(15, 2) NULL DEFAULT NULL,
  `service_provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `technician` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `next_maintenance_date` date NULL DEFAULT NULL,
  `attachments` json NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `device_maintenance_logs_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `device_maintenance_logs_device_id_index`(`device_id` ASC) USING BTREE,
  INDEX `device_maintenance_logs_maintenance_date_index`(`maintenance_date` ASC) USING BTREE,
  CONSTRAINT `device_maintenance_logs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `device_maintenance_logs_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `hardware_devices` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of device_maintenance_logs
-- ----------------------------

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE,
  INDEX `failed_jobs_connection_queue_failed_at_index`(`connection` ASC, `queue` ASC, `failed_at` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for hardware_devices
-- ----------------------------
DROP TABLE IF EXISTS `hardware_devices`;
CREATE TABLE `hardware_devices`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `device_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '服务器/UPS/交换机/防火墙/存储/空调/配电柜',
  `brand` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `model` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `serial_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `specification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sub_contract_id` bigint UNSIGNED NULL DEFAULT NULL,
  `vendor_id` bigint UNSIGNED NULL DEFAULT NULL,
  `purchase_date` date NULL DEFAULT NULL,
  `supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `purchase_amount` decimal(15, 2) NULL DEFAULT NULL,
  `warranty_period` int NULL DEFAULT NULL COMMENT '质保期(月)',
  `start_date` date NULL DEFAULT NULL,
  `expiry_date` date NULL DEFAULT NULL,
  `scrap_date` date NULL DEFAULT NULL,
  `maintenance_cycle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '月/季/半年/年',
  `next_maintenance_date` date NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '0报废,1在用,2维修中,3闲置',
  `qrcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `hardware_devices_device_no_unique`(`device_no` ASC) USING BTREE,
  INDEX `hardware_devices_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `hardware_devices_device_type_index`(`device_type` ASC) USING BTREE,
  INDEX `hardware_devices_sub_contract_id_index`(`sub_contract_id` ASC) USING BTREE,
  INDEX `hardware_devices_vendor_id_index`(`vendor_id` ASC) USING BTREE,
  INDEX `hardware_devices_status_index`(`status` ASC) USING BTREE,
  INDEX `hardware_devices_expiry_date_index`(`expiry_date` ASC) USING BTREE,
  INDEX `hardware_devices_next_maintenance_date_index`(`next_maintenance_date` ASC) USING BTREE,
  CONSTRAINT `hardware_devices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `hardware_devices_sub_contract_id_foreign` FOREIGN KEY (`sub_contract_id`) REFERENCES `sub_contracts` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `hardware_devices_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hardware_devices
-- ----------------------------
INSERT INTO `hardware_devices` VALUES (1, 'SRV-2026-001', '华为FusionServer 2288H V6', 'server', '华为', 'FusionServer 2288H V6', NULL, NULL, '机房A-机柜1', NULL, 1, NULL, NULL, 45000.00, 36, NULL, NULL, NULL, NULL, '2026-08-06', 1, NULL, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `hardware_devices` VALUES (2, 'UPS-2026-001', '华为UPS5000-E', 'ups', '华为', 'UPS5000-E 400kVA', NULL, NULL, '机房A-配电间', NULL, 1, NULL, NULL, 120000.00, 60, NULL, NULL, NULL, NULL, '2026-09-06', 1, NULL, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `hardware_devices` VALUES (3, 'SW-2026-001', '华为CloudEngine S12700E', 'switch', '华为', 'S12700E-8', NULL, NULL, '机房A-网络区', NULL, 1, NULL, NULL, 85000.00, 36, NULL, NULL, NULL, NULL, '2026-10-06', 1, NULL, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `hardware_devices` VALUES (4, 'FW-2026-001', '华为USG6300E', 'firewall', '华为', 'USG6300E', NULL, NULL, '机房A-安全区', NULL, 1, NULL, NULL, 32000.00, 36, NULL, NULL, NULL, NULL, '2026-08-06', 1, NULL, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `hardware_devices` VALUES (5, 'STG-2026-001', '浪潮AS5500G5', 'storage', '浪潮', 'AS5500G5', NULL, NULL, '机房A-存储区', NULL, 3, NULL, NULL, 180000.00, 60, NULL, NULL, NULL, NULL, '2026-09-06', 1, NULL, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `hardware_devices` VALUES (6, 'AC-2026-001', '海康威视精密空调', 'air_conditioner', '海康威视', 'HVAC-50KW', NULL, NULL, '机房A-空调区', NULL, 5, NULL, NULL, 65000.00, 24, NULL, NULL, NULL, NULL, '2026-08-06', 1, NULL, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `hardware_devices` VALUES (7, 'PD-2026-001', '配电柜A01', 'power_distribution', '海康威视', 'PD-400A', NULL, NULL, '机房A-配电间', NULL, 5, NULL, NULL, 28000.00, 24, NULL, NULL, NULL, NULL, '2026-10-06', 1, NULL, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `hardware_devices` VALUES (8, 'SRV-2026-002', '浪潮NF5280M6', 'server', '浪潮', 'NF5280M6', NULL, NULL, '机房B-机柜2', NULL, 3, NULL, NULL, 38000.00, 36, NULL, NULL, NULL, NULL, '2026-08-06', 2, NULL, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);

-- ----------------------------
-- Table structure for inspection_plans
-- ----------------------------
DROP TABLE IF EXISTS `inspection_plans`;
CREATE TABLE `inspection_plans`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `plan_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint UNSIGNED NOT NULL,
  `target_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'software/hardware',
  `target_id` bigint UNSIGNED NOT NULL,
  `cycle_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '日/周/双周/月/季度/自定义',
  `cycle_days` int NULL DEFAULT NULL COMMENT '自定义周期天数',
  `execute_time` time NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NULL DEFAULT NULL,
  `assignee_id` bigint UNSIGNED NULL DEFAULT NULL,
  `is_enabled` tinyint NOT NULL DEFAULT 1,
  `last_generated_at` timestamp NULL DEFAULT NULL,
  `next_generate_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `inspection_plans_assignee_id_foreign`(`assignee_id` ASC) USING BTREE,
  INDEX `inspection_plans_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `inspection_plans_template_id_index`(`template_id` ASC) USING BTREE,
  INDEX `inspection_plans_vendor_id_index`(`vendor_id` ASC) USING BTREE,
  INDEX `inspection_plans_target_type_target_id_index`(`target_type` ASC, `target_id` ASC) USING BTREE,
  INDEX `inspection_plans_is_enabled_index`(`is_enabled` ASC) USING BTREE,
  CONSTRAINT `inspection_plans_assignee_id_foreign` FOREIGN KEY (`assignee_id`) REFERENCES `personnel` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `inspection_plans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `inspection_plans_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `inspection_templates` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `inspection_plans_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inspection_plans
-- ----------------------------
INSERT INTO `inspection_plans` VALUES (1, '机房A周巡检', 1, 1, 'hardware', 1, 'weekly', NULL, '09:00:00', '2026-07-07', NULL, 1, 1, NULL, NULL, 1, '2026-07-07 00:55:17', '2026-07-07 01:06:43');

-- ----------------------------
-- Table structure for inspection_task_items
-- ----------------------------
DROP TABLE IF EXISTS `inspection_task_items`;
CREATE TABLE `inspection_task_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` bigint UNSIGNED NOT NULL,
  `template_item_id` bigint UNSIGNED NOT NULL,
  `result_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_normal` tinyint NULL DEFAULT NULL COMMENT '0异常,1正常',
  `abnormal_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `inspection_task_items_task_id_index`(`task_id` ASC) USING BTREE,
  INDEX `inspection_task_items_template_item_id_index`(`template_item_id` ASC) USING BTREE,
  CONSTRAINT `inspection_task_items_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `inspection_tasks` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `inspection_task_items_template_item_id_foreign` FOREIGN KEY (`template_item_id`) REFERENCES `inspection_template_items` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inspection_task_items
-- ----------------------------

-- ----------------------------
-- Table structure for inspection_task_photos
-- ----------------------------
DROP TABLE IF EXISTS `inspection_task_photos`;
CREATE TABLE `inspection_task_photos`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` bigint UNSIGNED NOT NULL,
  `task_item_id` bigint UNSIGNED NULL DEFAULT NULL,
  `photo_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `taken_at` timestamp NULL DEFAULT NULL,
  `lat` decimal(10, 7) NULL DEFAULT NULL,
  `lng` decimal(10, 7) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `inspection_task_photos_task_id_index`(`task_id` ASC) USING BTREE,
  INDEX `inspection_task_photos_task_item_id_index`(`task_item_id` ASC) USING BTREE,
  CONSTRAINT `inspection_task_photos_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `inspection_tasks` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `inspection_task_photos_task_item_id_foreign` FOREIGN KEY (`task_item_id`) REFERENCES `inspection_task_items` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inspection_task_photos
-- ----------------------------

-- ----------------------------
-- Table structure for inspection_tasks
-- ----------------------------
DROP TABLE IF EXISTS `inspection_tasks`;
CREATE TABLE `inspection_tasks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_id` bigint UNSIGNED NULL DEFAULT NULL,
  `template_id` bigint UNSIGNED NOT NULL,
  `task_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '巡检/回访',
  `vendor_id` bigint UNSIGNED NOT NULL,
  `target_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_id` bigint UNSIGNED NOT NULL,
  `assignee_id` bigint UNSIGNED NOT NULL,
  `planned_date` date NOT NULL,
  `planned_time` time NULL DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `sign_in_lat` decimal(10, 7) NULL DEFAULT NULL,
  `sign_in_lng` decimal(10, 7) NULL DEFAULT NULL,
  `sign_in_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `overall_result` tinyint NULL DEFAULT NULL COMMENT '0异常,1正常',
  `exception_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` tinyint NOT NULL DEFAULT 0 COMMENT '0待执行,1执行中,2待审核,3已完成,4已逾期',
  `auditor_id` bigint UNSIGNED NULL DEFAULT NULL,
  `audit_time` timestamp NULL DEFAULT NULL,
  `audit_result` tinyint NULL DEFAULT NULL COMMENT '0不通过,1通过',
  `audit_comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `rectification_required` tinyint NOT NULL DEFAULT 0,
  `rectification_deadline` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `inspection_tasks_task_no_unique`(`task_no` ASC) USING BTREE,
  INDEX `inspection_tasks_template_id_foreign`(`template_id` ASC) USING BTREE,
  INDEX `inspection_tasks_auditor_id_foreign`(`auditor_id` ASC) USING BTREE,
  INDEX `inspection_tasks_plan_id_index`(`plan_id` ASC) USING BTREE,
  INDEX `inspection_tasks_vendor_id_index`(`vendor_id` ASC) USING BTREE,
  INDEX `inspection_tasks_assignee_id_index`(`assignee_id` ASC) USING BTREE,
  INDEX `inspection_tasks_status_index`(`status` ASC) USING BTREE,
  INDEX `inspection_tasks_planned_date_index`(`planned_date` ASC) USING BTREE,
  CONSTRAINT `inspection_tasks_assignee_id_foreign` FOREIGN KEY (`assignee_id`) REFERENCES `personnel` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `inspection_tasks_auditor_id_foreign` FOREIGN KEY (`auditor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `inspection_tasks_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `inspection_plans` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `inspection_tasks_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `inspection_templates` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `inspection_tasks_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inspection_tasks
-- ----------------------------
INSERT INTO `inspection_tasks` VALUES (1, 'INS-20260707-001', 1, 1, '机房A周巡检任务', 'inspection', 1, 'hardware', 1, 1, '2026-07-07', '09:00:00', '2026-07-06 22:55:17', '2026-07-06 23:55:17', NULL, NULL, '市政府数据中心机房A', 1, NULL, 2, NULL, NULL, NULL, NULL, 0, NULL, '2026-07-07 00:55:17', '2026-07-07 00:55:17');
INSERT INTO `inspection_tasks` VALUES (2, 'INS-20260707-002', NULL, 1, '机房B紧急巡检', 'inspection', 1, 'hardware', 1, 1, '2026-07-08', '10:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, '2026-07-07 00:55:17', '2026-07-07 00:55:17');
INSERT INTO `inspection_tasks` VALUES (3, 'VIS-20260707-001', NULL, 2, '政务云平台月度回访', 'visit', 2, 'software', 1, 3, '2026-07-07', '14:00:00', '2026-07-06 21:55:17', '2026-07-06 22:55:17', NULL, NULL, NULL, 1, NULL, 3, 1, '2026-07-06 23:55:17', 1, '回访结果良好，系统运行稳定', 0, NULL, '2026-07-07 00:55:17', '2026-07-07 00:55:17');

-- ----------------------------
-- Table structure for inspection_template_items
-- ----------------------------
DROP TABLE IF EXISTS `inspection_template_items`;
CREATE TABLE `inspection_template_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `template_id` bigint UNSIGNED NOT NULL,
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文本/单选/多选/数值/拍照',
  `options` json NULL,
  `standard` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_required` tinyint NOT NULL DEFAULT 1,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `inspection_template_items_template_id_index`(`template_id` ASC) USING BTREE,
  CONSTRAINT `inspection_template_items_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `inspection_templates` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inspection_template_items
-- ----------------------------
INSERT INTO `inspection_template_items` VALUES (1, 1, '机房温度', 'number', NULL, '18-27°C', 1, 1, '2026-07-07 00:55:17', '2026-07-07 00:55:17');
INSERT INTO `inspection_template_items` VALUES (2, 1, '机房湿度', 'number', NULL, '40%-60%', 1, 2, '2026-07-07 00:55:17', '2026-07-07 00:55:17');
INSERT INTO `inspection_template_items` VALUES (3, 1, 'UPS运行状态', 'single_choice', '\"[\\\"\\\\u6b63\\\\u5e38\\\",\\\"\\\\u5f02\\\\u5e38\\\"]\"', '正常', 1, 3, '2026-07-07 00:55:17', '2026-07-07 00:55:17');
INSERT INTO `inspection_template_items` VALUES (4, 1, '空调运行状态', 'single_choice', '\"[\\\"\\\\u6b63\\\\u5e38\\\",\\\"\\\\u5f02\\\\u5e38\\\"]\"', '正常', 1, 4, '2026-07-07 00:55:17', '2026-07-07 00:55:17');
INSERT INTO `inspection_template_items` VALUES (5, 1, '消防设备检查', 'single_choice', '\"[\\\"\\\\u6b63\\\\u5e38\\\",\\\"\\\\u5f02\\\\u5e38\\\"]\"', '正常', 1, 5, '2026-07-07 00:55:17', '2026-07-07 00:55:17');
INSERT INTO `inspection_template_items` VALUES (6, 1, '巡检照片', 'photo', NULL, NULL, 1, 6, '2026-07-07 00:55:17', '2026-07-07 00:55:17');

-- ----------------------------
-- Table structure for inspection_templates
-- ----------------------------
DROP TABLE IF EXISTS `inspection_templates`;
CREATE TABLE `inspection_templates`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '巡检/回访',
  `category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '软件/硬件/机房/综合',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_enabled` tinyint NOT NULL DEFAULT 1,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `inspection_templates_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `inspection_templates_template_type_index`(`template_type` ASC) USING BTREE,
  INDEX `inspection_templates_category_index`(`category` ASC) USING BTREE,
  CONSTRAINT `inspection_templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inspection_templates
-- ----------------------------
INSERT INTO `inspection_templates` VALUES (1, '机房环境巡检', 'inspection', '硬件', '机房温湿度、UPS、空调等设备巡检', 1, 1, '2026-07-07 00:55:17', '2026-07-07 00:55:17', NULL);
INSERT INTO `inspection_templates` VALUES (2, '软件系统回访', 'visit', '软件', '软件系统运行状态回访', 1, 1, '2026-07-07 00:55:17', '2026-07-07 00:55:17', NULL);

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for main_contract_managers
-- ----------------------------
DROP TABLE IF EXISTS `main_contract_managers`;
CREATE TABLE `main_contract_managers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `main_contract_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `mcm_unique`(`main_contract_id` ASC, `user_id` ASC) USING BTREE,
  INDEX `main_contract_managers_main_contract_id_index`(`main_contract_id` ASC) USING BTREE,
  INDEX `main_contract_managers_user_id_index`(`user_id` ASC) USING BTREE,
  CONSTRAINT `main_contract_managers_main_contract_id_foreign` FOREIGN KEY (`main_contract_id`) REFERENCES `main_contracts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `main_contract_managers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_contract_managers
-- ----------------------------

-- ----------------------------
-- Table structure for main_contracts
-- ----------------------------
DROP TABLE IF EXISTS `main_contracts`;
CREATE TABLE `main_contracts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_a_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_a_contact` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `party_a_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `party_b_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_b_manager_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '乙方管理人姓名',
  `party_b_manager_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '乙方管理人电话',
  `service_unit_id` bigint UNSIGNED NULL DEFAULT NULL,
  `total_amount` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `signed_date` date NULL DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `payment_terms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `service_scope` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft' COMMENT 'draft草稿,active生效中,expired已到期,terminated已终止',
  `attachment_visible` tinyint NOT NULL DEFAULT 1 COMMENT '附件是否展示: 0隐藏,1展示',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `main_contracts_contract_no_unique`(`contract_no` ASC) USING BTREE,
  INDEX `main_contracts_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `main_contracts_status_index`(`status` ASC) USING BTREE,
  INDEX `main_contracts_end_date_index`(`end_date` ASC) USING BTREE,
  INDEX `main_contracts_party_a_name_index`(`party_a_name` ASC) USING BTREE,
  INDEX `main_contracts_attachment_visible_index`(`attachment_visible` ASC) USING BTREE,
  INDEX `main_contracts_service_unit_id_foreign`(`service_unit_id` ASC) USING BTREE,
  CONSTRAINT `main_contracts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `main_contracts_service_unit_id_foreign` FOREIGN KEY (`service_unit_id`) REFERENCES `service_units` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_contracts
-- ----------------------------
INSERT INTO `main_contracts` VALUES (1, 'MC-2026-182B33', '2025年第一批市本级政务信息化运维项目', '洛阳数智科技发展有限公司', NULL, NULL, '洛阳弘义智慧城市运营管理有限公司', NULL, NULL, NULL, 0.00, '2026-07-07', '2026-05-22', '2027-05-21', NULL, NULL, 'draft', 1, NULL, 1, '2026-07-07 06:45:21', '2026-07-07 06:45:21', NULL);
INSERT INTO `main_contracts` VALUES (2, 'MC-2026-4E283B', '2025年第二批市本级政务信息化运维项目', '洛阳数智科技发展有限公司', NULL, NULL, '洛阳弘义智慧城市运营管理有限公司', NULL, NULL, NULL, 0.00, '2026-07-07', '2026-09-22', '2027-09-21', NULL, NULL, 'draft', 0, NULL, 1, '2026-07-07 06:46:33', '2026-07-07 08:01:14', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2024_01_01_000000_create_passkeys_table', 1);
INSERT INTO `migrations` VALUES (5, '2025_08_14_170933_add_two_factor_columns_to_users_table', 1);
INSERT INTO `migrations` VALUES (6, '2026_07_06_000001_create_roles_table', 1);
INSERT INTO `migrations` VALUES (7, '2026_07_06_000002_create_permissions_table', 1);
INSERT INTO `migrations` VALUES (8, '2026_07_06_000003_create_model_has_roles_table', 1);
INSERT INTO `migrations` VALUES (9, '2026_07_06_000004_create_model_has_permissions_table', 1);
INSERT INTO `migrations` VALUES (10, '2026_07_06_000005_create_role_has_permissions_table', 1);
INSERT INTO `migrations` VALUES (11, '2026_07_06_000006_create_operation_logs_table', 1);
INSERT INTO `migrations` VALUES (12, '2026_07_06_000007_create_data_dictionaries_table', 1);
INSERT INTO `migrations` VALUES (13, '2026_07_06_000008_create_vendors_table', 1);
INSERT INTO `migrations` VALUES (14, '2026_07_06_000009_create_vendor_contacts_table', 1);
INSERT INTO `migrations` VALUES (15, '2026_07_06_000010_create_personnel_table', 1);
INSERT INTO `migrations` VALUES (16, '2026_07_06_000011_create_personnel_certificates_table', 1);
INSERT INTO `migrations` VALUES (17, '2026_07_06_000012_create_main_contracts_table', 1);
INSERT INTO `migrations` VALUES (18, '2026_07_06_000013_create_sub_contracts_table', 1);
INSERT INTO `migrations` VALUES (19, '2026_07_06_000014_create_contract_attachments_table', 1);
INSERT INTO `migrations` VALUES (20, '2026_07_06_000015_create_contract_renewals_table', 1);
INSERT INTO `migrations` VALUES (21, '2026_07_06_000016_create_hardware_devices_table', 1);
INSERT INTO `migrations` VALUES (22, '2026_07_06_000017_create_device_maintenance_logs_table', 1);
INSERT INTO `migrations` VALUES (23, '2026_07_06_000018_create_software_table', 1);
INSERT INTO `migrations` VALUES (24, '2026_07_06_000019_create_software_maintenance_logs_table', 1);
INSERT INTO `migrations` VALUES (25, '2026_07_06_000020_create_software_faults_table', 1);
INSERT INTO `migrations` VALUES (26, '2026_07_06_000021_create_schedules_table', 1);
INSERT INTO `migrations` VALUES (27, '2026_07_06_000022_create_inspection_templates_table', 1);
INSERT INTO `migrations` VALUES (28, '2026_07_06_000023_create_inspection_template_items_table', 1);
INSERT INTO `migrations` VALUES (29, '2026_07_06_000024_create_inspection_plans_table', 1);
INSERT INTO `migrations` VALUES (30, '2026_07_06_000025_create_inspection_tasks_table', 1);
INSERT INTO `migrations` VALUES (31, '2026_07_06_000026_create_inspection_task_items_table', 1);
INSERT INTO `migrations` VALUES (32, '2026_07_06_000027_create_inspection_task_photos_table', 1);
INSERT INTO `migrations` VALUES (33, '2026_07_06_000028_create_notifications_table', 1);
INSERT INTO `migrations` VALUES (34, '2026_07_06_000029_add_foreign_keys', 1);
INSERT INTO `migrations` VALUES (35, '2026_07_07_000030_add_project_level_to_main_contracts', 2);
INSERT INTO `migrations` VALUES (36, '2026_07_07_000031_add_maintenance_type_to_sub_contracts', 2);
INSERT INTO `migrations` VALUES (37, '2026_07_07_000032_create_service_units_table', 2);
INSERT INTO `migrations` VALUES (38, '2026_07_07_000033_create_sub_contract_personnel_table', 2);
INSERT INTO `migrations` VALUES (39, '2026_07_07_000034_create_satisfaction_survey_plans_table', 2);
INSERT INTO `migrations` VALUES (40, '2026_07_07_000035_create_satisfaction_surveys_table', 2);
INSERT INTO `migrations` VALUES (41, '2026_07_07_000036_add_version_type_to_contract_attachments', 3);
INSERT INTO `migrations` VALUES (42, '2026_07_07_114301_add_permission_fields_to_users', 4);
INSERT INTO `migrations` VALUES (43, '2026_07_07_114302_create_service_unit_contacts_table', 4);
INSERT INTO `migrations` VALUES (44, '2026_07_07_114303_create_main_contract_managers_table', 4);
INSERT INTO `migrations` VALUES (45, '2026_07_07_114304_create_sub_contract_managers_table', 4);
INSERT INTO `migrations` VALUES (46, '2026_07_07_114305_add_attachment_visible_to_main_contracts', 4);
INSERT INTO `migrations` VALUES (47, '2026_07_07_114306_add_attachment_visible_to_sub_contracts', 4);
INSERT INTO `migrations` VALUES (48, '2026_07_08_000043_create_audit_configs_table', 5);
INSERT INTO `migrations` VALUES (49, '2026_07_08_000044_add_service_unit_id_to_contracts', 6);
INSERT INTO `migrations` VALUES (50, '2026_07_08_000045_add_party_b_manager_to_main_contracts', 7);
INSERT INTO `migrations` VALUES (51, '2026_07_08_000046_move_project_level_to_sub_contracts', 8);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 1);
INSERT INTO `model_has_roles` VALUES (3, 'App\\Models\\User', 2);
INSERT INTO `model_has_roles` VALUES (4, 'App\\Models\\User', 3);
INSERT INTO `model_has_roles` VALUES (7, 'App\\Models\\User', 4);
INSERT INTO `model_has_roles` VALUES (8, 'App\\Models\\User', 5);
INSERT INTO `model_has_roles` VALUES (6, 'App\\Models\\User', 6);

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `related_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `related_id` bigint UNSIGNED NULL DEFAULT NULL,
  `is_read` tinyint NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `channel` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'system' COMMENT 'system/sms/email',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `notifications_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `notifications_is_read_index`(`is_read` ASC) USING BTREE,
  INDEX `notifications_related_type_related_id_index`(`related_type` ASC, `related_id` ASC) USING BTREE,
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notifications
-- ----------------------------

-- ----------------------------
-- Table structure for operation_logs
-- ----------------------------
DROP TABLE IF EXISTS `operation_logs`;
CREATE TABLE `operation_logs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `method` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `action` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `old_data` json NULL,
  `new_data` json NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `operation_logs_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `operation_logs_created_at_index`(`created_at` ASC) USING BTREE,
  CONSTRAINT `operation_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of operation_logs
-- ----------------------------
INSERT INTO `operation_logs` VALUES (1, 1, 'POST', '/contracts/main', '127.0.0.1', NULL, '创建主合同', '创建主合同：数据中心运维服务合同', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (2, 1, 'PUT', '/assets/hardware/1', '127.0.0.1', NULL, '更新设备', '更新硬件设备：SRV-2026-001', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (3, 1, 'DELETE', '/personnel/1', '127.0.0.1', NULL, '删除人员', '删除人员信息', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (4, 1, 'POST', '/login', '127.0.0.1', NULL, '用户登录', '用户登录系统', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (5, 1, 'POST', '/inspection/plans', '127.0.0.1', NULL, '创建巡检计划', '创建巡检计划：机房A周巡检', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (6, 1, 'POST', '/contracts/main', '127.0.0.1', NULL, '创建主合同', '创建主合同：数据中心运维服务合同', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (7, 1, 'PUT', '/assets/hardware/1', '127.0.0.1', NULL, '更新设备', '更新硬件设备：SRV-2026-001', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (8, 1, 'DELETE', '/personnel/1', '127.0.0.1', NULL, '删除人员', '删除人员信息', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (9, 1, 'POST', '/login', '127.0.0.1', NULL, '用户登录', '用户登录系统', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (10, 1, 'POST', '/inspection/plans', '127.0.0.1', NULL, '创建巡检计划', '创建巡检计划：机房A周巡检', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (11, 1, 'POST', '/contracts/main', '127.0.0.1', NULL, '创建主合同', '创建主合同：数据中心运维服务合同', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (12, 1, 'PUT', '/assets/hardware/1', '127.0.0.1', NULL, '更新设备', '更新硬件设备：SRV-2026-001', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (13, 1, 'DELETE', '/personnel/1', '127.0.0.1', NULL, '删除人员', '删除人员信息', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (14, 1, 'POST', '/login', '127.0.0.1', NULL, '用户登录', '用户登录系统', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (15, 1, 'POST', '/inspection/plans', '127.0.0.1', NULL, '创建巡检计划', '创建巡检计划：机房A周巡检', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (16, 1, 'POST', '/contracts/main', '127.0.0.1', NULL, '创建主合同', '创建主合同：数据中心运维服务合同', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (17, 1, 'PUT', '/assets/hardware/1', '127.0.0.1', NULL, '更新设备', '更新硬件设备：SRV-2026-001', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (18, 1, 'DELETE', '/personnel/1', '127.0.0.1', NULL, '删除人员', '删除人员信息', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (19, 1, 'POST', '/login', '127.0.0.1', NULL, '用户登录', '用户登录系统', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (20, 1, 'POST', '/inspection/plans', '127.0.0.1', NULL, '创建巡检计划', '创建巡检计划：机房A周巡检', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (21, 1, 'POST', '/contracts/main', '127.0.0.1', NULL, '创建主合同', '创建主合同：数据中心运维服务合同', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (22, 1, 'PUT', '/assets/hardware/1', '127.0.0.1', NULL, '更新设备', '更新硬件设备：SRV-2026-001', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (23, 1, 'DELETE', '/personnel/1', '127.0.0.1', NULL, '删除人员', '删除人员信息', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (24, 1, 'POST', '/login', '127.0.0.1', NULL, '用户登录', '用户登录系统', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (25, 1, 'POST', '/inspection/plans', '127.0.0.1', NULL, '创建巡检计划', '创建巡检计划：机房A周巡检', NULL, NULL, NULL);
INSERT INTO `operation_logs` VALUES (26, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '编辑用户', '编辑用户：项目经理', '{\"id\": 2, \"name\": \"项目经理A\", \"email\": \"pm1@example.com\", \"phone\": \"13900000001\", \"avatar\": null, \"status\": 1, \"vendor_id\": 1, \"created_at\": \"2026-07-07T04:35:13.000000Z\", \"deleted_at\": null, \"department\": null, \"updated_at\": \"2026-07-07T04:35:13.000000Z\", \"can_view_pdf\": false, \"can_view_word\": false, \"last_login_at\": null, \"is_system_user\": true, \"service_unit_id\": null, \"email_verified_at\": null, \"two_factor_confirmed_at\": null}', '{\"id\": 2, \"name\": \"项目经理\", \"email\": \"pm1@example.com\", \"phone\": \"13900000001\", \"avatar\": null, \"status\": 1, \"vendor_id\": 1, \"created_at\": \"2026-07-07T04:35:13.000000Z\", \"deleted_at\": null, \"department\": null, \"updated_at\": \"2026-07-07T06:41:23.000000Z\", \"can_view_pdf\": false, \"can_view_word\": false, \"last_login_at\": null, \"is_system_user\": true, \"service_unit_id\": null, \"email_verified_at\": null, \"two_factor_confirmed_at\": null}', '2026-07-07 06:41:23');
INSERT INTO `operation_logs` VALUES (27, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建合同', '创建合同：2025年第一批市本级政务信息化运维项目', NULL, '{\"id\": 1, \"status\": \"draft\", \"end_date\": \"2027-05-21T00:00:00.000000Z\", \"created_at\": \"2026-07-07T06:45:21.000000Z\", \"created_by\": 1, \"start_date\": \"2026-05-22T00:00:00.000000Z\", \"updated_at\": \"2026-07-07T06:45:21.000000Z\", \"contract_no\": \"MC-2026-182B33\", \"signed_date\": \"2026-07-07T00:00:00.000000Z\", \"party_a_name\": \"洛阳数智科技发展有限公司\", \"party_b_name\": \"洛阳弘义智慧城市运营管理有限公司\", \"total_amount\": \"0.00\", \"contract_name\": \"2025年第一批市本级政务信息化运维项目\", \"attachment_visible\": true}', '2026-07-07 06:45:22');
INSERT INTO `operation_logs` VALUES (28, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建合同', '创建合同：2025年第二批市本级政务信息化运维项目', NULL, '{\"id\": 2, \"status\": \"draft\", \"end_date\": \"2027-09-29T00:00:00.000000Z\", \"created_at\": \"2026-07-07T06:46:33.000000Z\", \"created_by\": 1, \"start_date\": \"2026-09-30T00:00:00.000000Z\", \"updated_at\": \"2026-07-07T06:46:33.000000Z\", \"contract_no\": \"MC-2026-4E283B\", \"signed_date\": \"2026-07-07T00:00:00.000000Z\", \"party_a_name\": \"洛阳数智科技发展有限公司\", \"party_b_name\": \"洛阳弘义智慧城市运营管理有限公司\", \"total_amount\": \"0.00\", \"contract_name\": \"2025年第二批市本级政务信息化运维项目\", \"attachment_visible\": true}', '2026-07-07 06:46:33');
INSERT INTO `operation_logs` VALUES (29, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '编辑服务单位', '编辑服务单位：洛阳市政务服务和大数据管理局', '{\"id\": 1, \"name\": \"市政府数据中心\", \"remark\": null, \"status\": 1, \"address\": \"市政府大楼A座3楼\", \"created_at\": \"2026-07-07T02:27:02.000000Z\", \"created_by\": 1, \"deleted_at\": null, \"short_name\": \"市数据中心\", \"updated_at\": \"2026-07-07T02:27:02.000000Z\", \"contact_name\": \"王明\", \"contact_email\": null, \"contact_phone\": \"13800138100\"}', '{\"id\": 1, \"name\": \"洛阳市政务服务和大数据管理局\", \"remark\": null, \"status\": 1, \"address\": \"市政府大楼A座3楼\", \"contacts\": [], \"created_at\": \"2026-07-07T02:27:02.000000Z\", \"created_by\": 1, \"deleted_at\": null, \"short_name\": \"市数据中心\", \"updated_at\": \"2026-07-07T06:52:59.000000Z\", \"contact_name\": \"王明\", \"contact_email\": null, \"contact_phone\": \"13800138100\"}', '2026-07-07 06:52:59');
INSERT INTO `operation_logs` VALUES (30, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '编辑服务单位', '编辑服务单位：洛阳市人民政府国有资产监督管理委员会', '{\"id\": 2, \"name\": \"政务服务中心\", \"remark\": null, \"status\": 1, \"address\": \"市民广场B座\", \"created_at\": \"2026-07-07T02:27:02.000000Z\", \"created_by\": 1, \"deleted_at\": null, \"short_name\": \"政务中心\", \"updated_at\": \"2026-07-07T02:27:02.000000Z\", \"contact_name\": \"李红\", \"contact_email\": null, \"contact_phone\": \"13800138101\"}', '{\"id\": 2, \"name\": \"洛阳市人民政府国有资产监督管理委员会\", \"remark\": null, \"status\": 1, \"address\": \"市民广场B座\", \"contacts\": [], \"created_at\": \"2026-07-07T02:27:02.000000Z\", \"created_by\": 1, \"deleted_at\": null, \"short_name\": \"政务中心\", \"updated_at\": \"2026-07-07T06:53:06.000000Z\", \"contact_name\": \"李红\", \"contact_email\": null, \"contact_phone\": \"13800138101\"}', '2026-07-07 06:53:06');
INSERT INTO `operation_logs` VALUES (31, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '编辑服务单位', '编辑服务单位：中共洛阳市委政法委员会', '{\"id\": 3, \"name\": \"应急管理局\", \"remark\": null, \"status\": 1, \"address\": \"行政中心C座5楼\", \"created_at\": \"2026-07-07T02:27:02.000000Z\", \"created_by\": 1, \"deleted_at\": null, \"short_name\": \"应急局\", \"updated_at\": \"2026-07-07T02:27:02.000000Z\", \"contact_name\": \"张军\", \"contact_email\": null, \"contact_phone\": \"13800138102\"}', '{\"id\": 3, \"name\": \"中共洛阳市委政法委员会\", \"remark\": null, \"status\": 1, \"address\": \"行政中心C座5楼\", \"contacts\": [], \"created_at\": \"2026-07-07T02:27:02.000000Z\", \"created_by\": 1, \"deleted_at\": null, \"short_name\": \"应急局\", \"updated_at\": \"2026-07-07T06:53:12.000000Z\", \"contact_name\": \"张军\", \"contact_email\": null, \"contact_phone\": \"13800138102\"}', '2026-07-07 06:53:12');
INSERT INTO `operation_logs` VALUES (32, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市市场监督管理局', NULL, '{\"id\": 4, \"name\": \"洛阳市市场监督管理局\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:53:20.000000Z\", \"updated_at\": \"2026-07-07T06:53:20.000000Z\"}', '2026-07-07 06:53:20');
INSERT INTO `operation_logs` VALUES (33, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：中国人民政治协商会议洛阳市委员会', NULL, '{\"id\": 5, \"name\": \"中国人民政治协商会议洛阳市委员会\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:53:26.000000Z\", \"updated_at\": \"2026-07-07T06:53:26.000000Z\"}', '2026-07-07 06:53:26');
INSERT INTO `operation_logs` VALUES (34, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市统计局', NULL, '{\"id\": 6, \"name\": \"洛阳市统计局\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:53:33.000000Z\", \"updated_at\": \"2026-07-07T06:53:33.000000Z\"}', '2026-07-07 06:53:33');
INSERT INTO `operation_logs` VALUES (35, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市水利局', NULL, '{\"id\": 7, \"name\": \"洛阳市水利局\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:53:39.000000Z\", \"updated_at\": \"2026-07-07T06:53:39.000000Z\"}', '2026-07-07 06:53:39');
INSERT INTO `operation_logs` VALUES (36, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市教师发展中心', NULL, '{\"id\": 8, \"name\": \"洛阳市教师发展中心\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:53:44.000000Z\", \"updated_at\": \"2026-07-07T06:53:44.000000Z\"}', '2026-07-07 06:53:44');
INSERT INTO `operation_logs` VALUES (37, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市医疗保障中心', NULL, '{\"id\": 9, \"name\": \"洛阳市医疗保障中心\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:53:50.000000Z\", \"updated_at\": \"2026-07-07T06:53:50.000000Z\"}', '2026-07-07 06:53:50');
INSERT INTO `operation_logs` VALUES (38, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市社会保险中心', NULL, '{\"id\": 10, \"name\": \"洛阳市社会保险中心\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:53:54.000000Z\", \"updated_at\": \"2026-07-07T06:53:54.000000Z\"}', '2026-07-07 06:53:54');
INSERT INTO `operation_logs` VALUES (39, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市商务局', NULL, '{\"id\": 11, \"name\": \"洛阳市商务局\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:53:59.000000Z\", \"updated_at\": \"2026-07-07T06:53:59.000000Z\"}', '2026-07-07 06:53:59');
INSERT INTO `operation_logs` VALUES (40, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市水利事业发展中心', NULL, '{\"id\": 12, \"name\": \"洛阳市水利事业发展中心\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:54:05.000000Z\", \"updated_at\": \"2026-07-07T06:54:05.000000Z\"}', '2026-07-07 06:54:05');
INSERT INTO `operation_logs` VALUES (41, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市自然资源和规划局', NULL, '{\"id\": 13, \"name\": \"洛阳市自然资源和规划局\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:54:11.000000Z\", \"updated_at\": \"2026-07-07T06:54:11.000000Z\"}', '2026-07-07 06:54:11');
INSERT INTO `operation_logs` VALUES (42, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市住房公积金管理中心', NULL, '{\"id\": 14, \"name\": \"洛阳市住房公积金管理中心\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:54:17.000000Z\", \"updated_at\": \"2026-07-07T06:54:17.000000Z\"}', '2026-07-07 06:54:17');
INSERT INTO `operation_logs` VALUES (43, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市住房和城乡建设局', NULL, '{\"id\": 15, \"name\": \"洛阳市住房和城乡建设局\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:54:22.000000Z\", \"updated_at\": \"2026-07-07T06:54:22.000000Z\"}', '2026-07-07 06:54:22');
INSERT INTO `operation_logs` VALUES (44, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市城市管理局', NULL, '{\"id\": 16, \"name\": \"洛阳市城市管理局\", \"status\": 1, \"contacts\": [], \"created_at\": \"2026-07-07T06:54:27.000000Z\", \"updated_at\": \"2026-07-07T06:54:27.000000Z\"}', '2026-07-07 06:54:27');
INSERT INTO `operation_logs` VALUES (45, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '编辑合同', '编辑合同：2025年第二批市本级政务信息化运维项目', '{\"id\": 2, \"remark\": null, \"status\": \"draft\", \"end_date\": \"2027-09-29T00:00:00.000000Z\", \"created_at\": \"2026-07-07T06:46:33.000000Z\", \"created_by\": 1, \"deleted_at\": null, \"start_date\": \"2026-09-30T00:00:00.000000Z\", \"updated_at\": \"2026-07-07T06:46:33.000000Z\", \"contract_no\": \"MC-2026-4E283B\", \"signed_date\": \"2026-07-07T00:00:00.000000Z\", \"party_a_name\": \"洛阳数智科技发展有限公司\", \"party_b_name\": \"洛阳弘义智慧城市运营管理有限公司\", \"total_amount\": \"0.00\", \"contract_name\": \"2025年第二批市本级政务信息化运维项目\", \"party_a_phone\": null, \"payment_terms\": null, \"project_level\": null, \"service_scope\": null, \"party_a_contact\": null, \"service_unit_id\": null, \"attachment_visible\": 1, \"party_b_manager_name\": null, \"party_b_manager_phone\": null}', '{\"id\": 2, \"remark\": null, \"status\": \"draft\", \"end_date\": \"2027-09-21T00:00:00.000000Z\", \"created_at\": \"2026-07-07T06:46:33.000000Z\", \"created_by\": 1, \"deleted_at\": null, \"start_date\": \"2026-09-22T00:00:00.000000Z\", \"updated_at\": \"2026-07-07T08:01:14.000000Z\", \"contract_no\": \"MC-2026-4E283B\", \"signed_date\": \"2026-07-07T00:00:00.000000Z\", \"party_a_name\": \"洛阳数智科技发展有限公司\", \"party_b_name\": \"洛阳弘义智慧城市运营管理有限公司\", \"total_amount\": \"0.00\", \"contract_name\": \"2025年第二批市本级政务信息化运维项目\", \"party_a_phone\": null, \"payment_terms\": null, \"project_level\": null, \"service_scope\": null, \"party_a_contact\": null, \"service_unit_id\": null, \"attachment_visible\": false, \"party_b_manager_name\": null, \"party_b_manager_phone\": null}', '2026-07-07 08:01:14');
INSERT INTO `operation_logs` VALUES (46, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建服务单位', '创建服务单位：洛阳市洛龙区民生路1号', NULL, '{\"id\": 17, \"name\": \"洛阳市洛龙区民生路1号\", \"status\": 1, \"address\": \"洛阳市洛龙区民生路1号\", \"contacts\": [], \"created_at\": \"2026-07-07T08:26:12.000000Z\", \"short_name\": \"洛阳市财政局\", \"updated_at\": \"2026-07-07T08:26:12.000000Z\"}', '2026-07-07 08:26:12');
INSERT INTO `operation_logs` VALUES (47, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '编辑服务单位', '编辑服务单位：洛阳市洛龙区民生路1号', '{\"id\": 17, \"name\": \"洛阳市洛龙区民生路1号\", \"remark\": null, \"status\": 1, \"address\": \"洛阳市洛龙区民生路1号\", \"created_at\": \"2026-07-07T08:26:12.000000Z\", \"created_by\": null, \"deleted_at\": null, \"short_name\": \"洛阳市财政局\", \"updated_at\": \"2026-07-07T08:26:12.000000Z\", \"contact_name\": null, \"contact_email\": null, \"contact_phone\": null}', '{\"id\": 17, \"name\": \"洛阳市洛龙区民生路1号\", \"remark\": null, \"status\": 1, \"address\": \"洛阳市洛龙区民生路1号\", \"contacts\": [{\"id\": 4, \"name\": \"云衢\", \"email\": \"\", \"phone\": \"\", \"remark\": null, \"address\": \"\", \"user_id\": null, \"position\": \"\", \"created_at\": \"2026-07-07T08:26:12.000000Z\", \"is_primary\": false, \"updated_at\": \"2026-07-07T08:26:12.000000Z\", \"service_unit_id\": 17}], \"created_at\": \"2026-07-07T08:26:12.000000Z\", \"created_by\": null, \"deleted_at\": null, \"short_name\": \"洛阳市财政局\", \"updated_at\": \"2026-07-07T08:26:12.000000Z\", \"contact_name\": null, \"contact_email\": null, \"contact_phone\": null}', '2026-07-07 09:13:56');
INSERT INTO `operation_logs` VALUES (48, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '配置角色权限', '配置角色权限：服务单位', '{\"role_name\": \"服务单位\", \"permissions\": [\"satisfaction.view\"]}', '{\"role_name\": \"服务单位\", \"permissions\": [\"contract.view\", \"inspection.view\", \"vendor.view\", \"service_unit.view\", \"inspection_plan.view\", \"satisfaction.view\", \"satisfaction_plan.view\"]}', '2026-07-07 09:16:48');
INSERT INTO `operation_logs` VALUES (49, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '编辑运维单位', '编辑运维单位：北京久其政务软件股份有限公司', '{\"id\": 1, \"name\": \"华为技术服务有限公司\", \"type\": \"hardware\", \"remark\": null, \"address\": \"深圳市龙岗区\", \"bank_name\": null, \"created_at\": \"2026-07-06T10:16:32.000000Z\", \"deleted_at\": null, \"short_name\": \"华为\", \"updated_at\": \"2026-07-06T10:16:32.000000Z\", \"bank_account\": null, \"contact_name\": \"张伟\", \"legal_person\": null, \"unified_code\": null, \"contact_email\": null, \"contact_phone\": \"13800138001\", \"cooperation_status\": 1, \"qualification_level\": null}', '{\"id\": 1, \"name\": \"北京久其政务软件股份有限公司\", \"type\": \"software\", \"remark\": null, \"address\": \"深圳市龙岗区\", \"bank_name\": null, \"created_at\": \"2026-07-06T10:16:32.000000Z\", \"deleted_at\": null, \"short_name\": \"久其\", \"updated_at\": \"2026-07-07T09:29:02.000000Z\", \"bank_account\": null, \"contact_name\": \"张伟\", \"legal_person\": null, \"unified_code\": null, \"contact_email\": null, \"contact_phone\": \"13800138001\", \"cooperation_status\": 1, \"qualification_level\": null}', '2026-07-07 09:29:02');
INSERT INTO `operation_logs` VALUES (50, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '编辑服务单位', '编辑服务单位：洛阳市财政局', '{\"id\": 17, \"name\": \"洛阳市洛龙区民生路1号\", \"remark\": null, \"status\": 1, \"address\": \"洛阳市洛龙区民生路1号\", \"created_at\": \"2026-07-07T08:26:12.000000Z\", \"created_by\": null, \"deleted_at\": null, \"short_name\": \"洛阳市财政局\", \"updated_at\": \"2026-07-07T08:26:12.000000Z\", \"contact_name\": null, \"contact_email\": null, \"contact_phone\": null}', '{\"id\": 17, \"name\": \"洛阳市财政局\", \"remark\": null, \"status\": 1, \"address\": \"洛阳市洛龙区民生路1号\", \"contacts\": [{\"id\": 4, \"name\": \"云衢\", \"email\": \"\", \"phone\": \"13800080001\", \"remark\": null, \"address\": \"\", \"user_id\": null, \"position\": \"科员\", \"created_at\": \"2026-07-07T08:26:12.000000Z\", \"is_primary\": false, \"updated_at\": \"2026-07-07T09:13:56.000000Z\", \"service_unit_id\": 17}, {\"id\": 5, \"name\": \"局长\", \"email\": \"\", \"phone\": \"13800080002\", \"remark\": null, \"address\": \"\", \"user_id\": null, \"position\": \"主任\", \"created_at\": \"2026-07-07T09:13:56.000000Z\", \"is_primary\": false, \"updated_at\": \"2026-07-07T09:13:56.000000Z\", \"service_unit_id\": 17}], \"created_at\": \"2026-07-07T08:26:12.000000Z\", \"created_by\": null, \"deleted_at\": null, \"short_name\": \"洛阳市财政局\", \"updated_at\": \"2026-07-07T09:30:17.000000Z\", \"contact_name\": null, \"contact_email\": null, \"contact_phone\": null}', '2026-07-07 09:30:17');
INSERT INTO `operation_logs` VALUES (51, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '创建分包合同', '创建分包合同：财政局预决算公开报告辅助生成及公开监督服务系统', NULL, '{\"id\": 1, \"status\": \"draft\", \"end_date\": \"2026-07-07T00:00:00.000000Z\", \"vendor_id\": \"1\", \"created_at\": \"2026-07-07T09:30:48.000000Z\", \"created_by\": 1, \"start_date\": \"2026-07-07T00:00:00.000000Z\", \"sub_amount\": \"0.00\", \"updated_at\": \"2026-07-07T09:30:48.000000Z\", \"contract_no\": \"SC-2026-0F3C65\", \"contract_name\": \"财政局预决算公开报告辅助生成及公开监督服务系统\", \"contract_type\": \"software\", \"service_unit_id\": \"17\", \"main_contract_id\": \"1\", \"attachment_visible\": true}', '2026-07-07 09:30:48');
INSERT INTO `operation_logs` VALUES (52, 1, 'POST', 'livewire-4ea0cfb7/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '编辑分包合同', '编辑分包合同：财政局预决算公开报告辅助生成及公开监督服务系统', '{\"id\": 1, \"remark\": null, \"status\": \"draft\", \"end_date\": \"2026-07-07T00:00:00.000000Z\", \"sla_level\": null, \"vendor_id\": 1, \"created_at\": \"2026-07-07T09:30:48.000000Z\", \"created_by\": 1, \"deleted_at\": null, \"start_date\": \"2026-07-07T00:00:00.000000Z\", \"sub_amount\": \"0.00\", \"updated_at\": \"2026-07-07T09:30:48.000000Z\", \"contract_no\": \"SC-2026-0F3C65\", \"signed_date\": null, \"contract_name\": \"财政局预决算公开报告辅助生成及公开监督服务系统\", \"contract_type\": \"software\", \"payment_terms\": null, \"project_level\": null, \"service_scope\": null, \"service_unit_id\": 17, \"main_contract_id\": 1, \"maintenance_type\": null, \"attachment_visible\": 1}', '{\"id\": 1, \"remark\": null, \"status\": \"draft\", \"end_date\": \"2026-07-07T00:00:00.000000Z\", \"sla_level\": null, \"vendor_id\": 1, \"created_at\": \"2026-07-07T09:30:48.000000Z\", \"created_by\": 1, \"deleted_at\": null, \"start_date\": \"2026-07-07T00:00:00.000000Z\", \"sub_amount\": \"0.00\", \"updated_at\": \"2026-07-07T09:32:58.000000Z\", \"contract_no\": \"SC-2026-0F3C65\", \"signed_date\": null, \"contract_name\": \"财政局预决算公开报告辅助生成及公开监督服务系统\", \"contract_type\": \"software\", \"payment_terms\": null, \"project_level\": \"provincial\", \"service_scope\": null, \"service_unit_id\": 17, \"main_contract_id\": 1, \"maintenance_type\": \"remote_original\", \"attachment_visible\": 1}', '2026-07-07 09:32:58');

-- ----------------------------
-- Table structure for passkeys
-- ----------------------------
DROP TABLE IF EXISTS `passkeys`;
CREATE TABLE `passkeys`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credential_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credential` json NOT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `passkeys_credential_id_unique`(`credential_id` ASC) USING BTREE,
  INDEX `passkeys_user_id_index`(`user_id` ASC) USING BTREE,
  CONSTRAINT `passkeys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of passkeys
-- ----------------------------

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `group` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 62 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'contract.view', 'web', '查看合同', '合同管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (2, 'contract.create', 'web', '创建合同', '合同管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (3, 'contract.edit', 'web', '编辑合同', '合同管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (4, 'contract.delete', 'web', '删除合同', '合同管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (5, 'device.view', 'web', '查看设备', '设备管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (6, 'device.create', 'web', '创建设备', '设备管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (7, 'device.edit', 'web', '编辑设备', '设备管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (8, 'device.delete', 'web', '删除设备', '设备管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (9, 'software.view', 'web', '查看软件', '软件管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (10, 'software.create', 'web', '创建软件', '软件管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (11, 'software.edit', 'web', '编辑软件', '软件管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (12, 'software.delete', 'web', '删除软件', '软件管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (13, 'personnel.view', 'web', '查看人员', '人员管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (14, 'personnel.create', 'web', '创建人员', '人员管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (15, 'personnel.edit', 'web', '编辑人员', '人员管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (16, 'personnel.delete', 'web', '删除人员', '人员管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (17, 'inspection.view', 'web', '查看巡检', '巡检任务', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (18, 'inspection.create', 'web', '创建巡检', '巡检任务', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (19, 'inspection.execute', 'web', '执行巡检', '巡检任务', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (20, 'inspection.audit', 'web', '审核巡检', '巡检任务', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (21, 'system.user', 'web', '用户管理', '系统管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (22, 'system.role', 'web', '角色管理', '系统管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (23, 'system.log', 'web', '日志查看', '系统管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (24, 'system.config', 'web', '系统配置', '系统管理', '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `permissions` VALUES (25, 'contract.attachment', 'web', '管理合同附件', '合同管理', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (26, 'vendor.view', 'web', '查看运维单位', '运维管理-单位', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (27, 'vendor.create', 'web', '创建运维单位', '运维管理-单位', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (28, 'vendor.edit', 'web', '编辑运维单位', '运维管理-单位', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (29, 'vendor.delete', 'web', '删除运维单位', '运维管理-单位', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (30, 'service_unit.view', 'web', '查看服务单位', '运维管理-服务单位', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (31, 'service_unit.create', 'web', '创建服务单位', '运维管理-服务单位', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (32, 'service_unit.edit', 'web', '编辑服务单位', '运维管理-服务单位', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (33, 'service_unit.delete', 'web', '删除服务单位', '运维管理-服务单位', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (34, 'inspection.delete', 'web', '删除巡检任务', '巡检任务', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (35, 'inspection_plan.view', 'web', '查看巡检计划', '巡检计划', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (36, 'inspection_plan.create', 'web', '创建巡检计划', '巡检计划', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (37, 'inspection_plan.edit', 'web', '编辑巡检计划', '巡检计划', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (38, 'inspection_plan.delete', 'web', '删除巡检计划', '巡检计划', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (39, 'schedule.view', 'web', '查看排班', '排班管理', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (40, 'schedule.create', 'web', '创建排班', '排班管理', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (41, 'schedule.edit', 'web', '编辑排班', '排班管理', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (42, 'schedule.delete', 'web', '删除排班', '排班管理', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (43, 'satisfaction.view', 'web', '查看回访记录', '回访管理', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (44, 'satisfaction.create', 'web', '创建回访记录', '回访管理', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (45, 'satisfaction.edit', 'web', '编辑回访记录', '回访管理', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (46, 'satisfaction.delete', 'web', '删除回访记录', '回访管理', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (47, 'satisfaction_plan.view', 'web', '查看回访计划', '回访计划', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (48, 'satisfaction_plan.create', 'web', '创建回访计划', '回访计划', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (49, 'satisfaction_plan.edit', 'web', '编辑回访计划', '回访计划', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (50, 'satisfaction_plan.delete', 'web', '删除回访计划', '回访计划', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (51, 'system.user.view', 'web', '查看用户', '系统管理-用户', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (52, 'system.user.create', 'web', '创建用户', '系统管理-用户', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (53, 'system.user.edit', 'web', '编辑用户', '系统管理-用户', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (54, 'system.user.delete', 'web', '删除用户', '系统管理-用户', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (55, 'system.role.view', 'web', '查看角色', '系统管理-角色', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (56, 'system.role.edit', 'web', '配置角色权限', '系统管理-角色', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (57, 'system.log.view', 'web', '查看操作日志', '系统管理-日志', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (58, 'system.dictionary.view', 'web', '查看数据字典', '系统管理-数据字典', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (59, 'system.dictionary.create', 'web', '创建数据字典', '系统管理-数据字典', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (60, 'system.dictionary.edit', 'web', '编辑数据字典', '系统管理-数据字典', '2026-07-07 05:03:26', '2026-07-07 05:03:26');
INSERT INTO `permissions` VALUES (61, 'system.dictionary.delete', 'web', '删除数据字典', '系统管理-数据字典', '2026-07-07 05:03:26', '2026-07-07 05:03:26');

-- ----------------------------
-- Table structure for personnel
-- ----------------------------
DROP TABLE IF EXISTS `personnel`;
CREATE TABLE `personnel`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_card` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `gender` tinyint NULL DEFAULT NULL COMMENT '0女,1男',
  `birth_date` date NULL DEFAULT NULL,
  `position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `job_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `entry_date` date NULL DEFAULT NULL,
  `leave_date` date NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '0离职,1在职,2休假',
  `is_resident` tinyint NOT NULL DEFAULT 0 COMMENT '是否驻场',
  `resident_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `work_start_time` time NULL DEFAULT NULL,
  `work_end_time` time NULL DEFAULT NULL,
  `emergency_contact` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `emergency_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `personnel_vendor_id_index`(`vendor_id` ASC) USING BTREE,
  INDEX `personnel_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `personnel_status_index`(`status` ASC) USING BTREE,
  INDEX `personnel_is_resident_index`(`is_resident` ASC) USING BTREE,
  CONSTRAINT `personnel_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `personnel_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personnel
-- ----------------------------
INSERT INTO `personnel` VALUES (1, 1, NULL, '张伟', NULL, '13800138001', NULL, 1, NULL, '高级工程师', NULL, NULL, NULL, 1, 1, '市政府数据中心', NULL, NULL, NULL, NULL, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `personnel` VALUES (2, 1, NULL, '陈明', NULL, '13900139001', NULL, 1, NULL, '工程师', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `personnel` VALUES (3, 2, NULL, '李娜', NULL, '13800138002', NULL, 0, NULL, '项目经理', NULL, NULL, NULL, 1, 1, '政务云平台', NULL, NULL, NULL, NULL, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `personnel` VALUES (4, 2, NULL, '孙涛', NULL, '13900139002', NULL, 1, NULL, '开发工程师', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `personnel` VALUES (5, 3, NULL, '王强', NULL, '13800138003', NULL, 1, NULL, '技术主管', NULL, NULL, NULL, 1, 1, '机房A', NULL, NULL, NULL, NULL, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `personnel` VALUES (6, 4, NULL, '赵敏', NULL, '13800138004', NULL, 0, NULL, '运维经理', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `personnel` VALUES (7, 4, NULL, '周杰', NULL, '13900139004', NULL, 1, NULL, '运维工程师', NULL, NULL, NULL, 1, 1, '数据中心', NULL, NULL, NULL, NULL, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `personnel` VALUES (8, 5, NULL, '刘洋', NULL, '13800138005', NULL, 1, NULL, '安防工程师', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);

-- ----------------------------
-- Table structure for personnel_certificates
-- ----------------------------
DROP TABLE IF EXISTS `personnel_certificates`;
CREATE TABLE `personnel_certificates`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `personnel_id` bigint UNSIGNED NOT NULL,
  `certificate_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `certificate_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `issuing_authority` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `issue_date` date NULL DEFAULT NULL,
  `expiry_date` date NULL DEFAULT NULL,
  `attachment_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '0过期,1有效',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `personnel_certificates_personnel_id_index`(`personnel_id` ASC) USING BTREE,
  INDEX `personnel_certificates_expiry_date_index`(`expiry_date` ASC) USING BTREE,
  CONSTRAINT `personnel_certificates_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personnel_certificates
-- ----------------------------

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_index`(`role_id` ASC) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (1, 1);
INSERT INTO `role_has_permissions` VALUES (2, 1);
INSERT INTO `role_has_permissions` VALUES (3, 1);
INSERT INTO `role_has_permissions` VALUES (4, 1);
INSERT INTO `role_has_permissions` VALUES (5, 1);
INSERT INTO `role_has_permissions` VALUES (6, 1);
INSERT INTO `role_has_permissions` VALUES (7, 1);
INSERT INTO `role_has_permissions` VALUES (8, 1);
INSERT INTO `role_has_permissions` VALUES (9, 1);
INSERT INTO `role_has_permissions` VALUES (10, 1);
INSERT INTO `role_has_permissions` VALUES (11, 1);
INSERT INTO `role_has_permissions` VALUES (12, 1);
INSERT INTO `role_has_permissions` VALUES (13, 1);
INSERT INTO `role_has_permissions` VALUES (14, 1);
INSERT INTO `role_has_permissions` VALUES (15, 1);
INSERT INTO `role_has_permissions` VALUES (16, 1);
INSERT INTO `role_has_permissions` VALUES (17, 1);
INSERT INTO `role_has_permissions` VALUES (18, 1);
INSERT INTO `role_has_permissions` VALUES (19, 1);
INSERT INTO `role_has_permissions` VALUES (20, 1);
INSERT INTO `role_has_permissions` VALUES (21, 1);
INSERT INTO `role_has_permissions` VALUES (22, 1);
INSERT INTO `role_has_permissions` VALUES (23, 1);
INSERT INTO `role_has_permissions` VALUES (24, 1);
INSERT INTO `role_has_permissions` VALUES (25, 1);
INSERT INTO `role_has_permissions` VALUES (26, 1);
INSERT INTO `role_has_permissions` VALUES (27, 1);
INSERT INTO `role_has_permissions` VALUES (28, 1);
INSERT INTO `role_has_permissions` VALUES (29, 1);
INSERT INTO `role_has_permissions` VALUES (30, 1);
INSERT INTO `role_has_permissions` VALUES (31, 1);
INSERT INTO `role_has_permissions` VALUES (32, 1);
INSERT INTO `role_has_permissions` VALUES (33, 1);
INSERT INTO `role_has_permissions` VALUES (34, 1);
INSERT INTO `role_has_permissions` VALUES (35, 1);
INSERT INTO `role_has_permissions` VALUES (36, 1);
INSERT INTO `role_has_permissions` VALUES (37, 1);
INSERT INTO `role_has_permissions` VALUES (38, 1);
INSERT INTO `role_has_permissions` VALUES (39, 1);
INSERT INTO `role_has_permissions` VALUES (40, 1);
INSERT INTO `role_has_permissions` VALUES (41, 1);
INSERT INTO `role_has_permissions` VALUES (42, 1);
INSERT INTO `role_has_permissions` VALUES (43, 1);
INSERT INTO `role_has_permissions` VALUES (44, 1);
INSERT INTO `role_has_permissions` VALUES (45, 1);
INSERT INTO `role_has_permissions` VALUES (46, 1);
INSERT INTO `role_has_permissions` VALUES (47, 1);
INSERT INTO `role_has_permissions` VALUES (48, 1);
INSERT INTO `role_has_permissions` VALUES (49, 1);
INSERT INTO `role_has_permissions` VALUES (50, 1);
INSERT INTO `role_has_permissions` VALUES (51, 1);
INSERT INTO `role_has_permissions` VALUES (52, 1);
INSERT INTO `role_has_permissions` VALUES (53, 1);
INSERT INTO `role_has_permissions` VALUES (54, 1);
INSERT INTO `role_has_permissions` VALUES (55, 1);
INSERT INTO `role_has_permissions` VALUES (56, 1);
INSERT INTO `role_has_permissions` VALUES (57, 1);
INSERT INTO `role_has_permissions` VALUES (58, 1);
INSERT INTO `role_has_permissions` VALUES (59, 1);
INSERT INTO `role_has_permissions` VALUES (60, 1);
INSERT INTO `role_has_permissions` VALUES (61, 1);
INSERT INTO `role_has_permissions` VALUES (1, 2);
INSERT INTO `role_has_permissions` VALUES (2, 2);
INSERT INTO `role_has_permissions` VALUES (3, 2);
INSERT INTO `role_has_permissions` VALUES (5, 2);
INSERT INTO `role_has_permissions` VALUES (6, 2);
INSERT INTO `role_has_permissions` VALUES (7, 2);
INSERT INTO `role_has_permissions` VALUES (9, 2);
INSERT INTO `role_has_permissions` VALUES (10, 2);
INSERT INTO `role_has_permissions` VALUES (11, 2);
INSERT INTO `role_has_permissions` VALUES (13, 2);
INSERT INTO `role_has_permissions` VALUES (14, 2);
INSERT INTO `role_has_permissions` VALUES (15, 2);
INSERT INTO `role_has_permissions` VALUES (17, 2);
INSERT INTO `role_has_permissions` VALUES (18, 2);
INSERT INTO `role_has_permissions` VALUES (20, 2);
INSERT INTO `role_has_permissions` VALUES (26, 2);
INSERT INTO `role_has_permissions` VALUES (27, 2);
INSERT INTO `role_has_permissions` VALUES (28, 2);
INSERT INTO `role_has_permissions` VALUES (30, 2);
INSERT INTO `role_has_permissions` VALUES (31, 2);
INSERT INTO `role_has_permissions` VALUES (32, 2);
INSERT INTO `role_has_permissions` VALUES (35, 2);
INSERT INTO `role_has_permissions` VALUES (36, 2);
INSERT INTO `role_has_permissions` VALUES (37, 2);
INSERT INTO `role_has_permissions` VALUES (39, 2);
INSERT INTO `role_has_permissions` VALUES (40, 2);
INSERT INTO `role_has_permissions` VALUES (41, 2);
INSERT INTO `role_has_permissions` VALUES (43, 2);
INSERT INTO `role_has_permissions` VALUES (44, 2);
INSERT INTO `role_has_permissions` VALUES (45, 2);
INSERT INTO `role_has_permissions` VALUES (47, 2);
INSERT INTO `role_has_permissions` VALUES (48, 2);
INSERT INTO `role_has_permissions` VALUES (49, 2);
INSERT INTO `role_has_permissions` VALUES (51, 2);
INSERT INTO `role_has_permissions` VALUES (52, 2);
INSERT INTO `role_has_permissions` VALUES (53, 2);
INSERT INTO `role_has_permissions` VALUES (55, 2);
INSERT INTO `role_has_permissions` VALUES (56, 2);
INSERT INTO `role_has_permissions` VALUES (57, 2);
INSERT INTO `role_has_permissions` VALUES (58, 2);
INSERT INTO `role_has_permissions` VALUES (59, 2);
INSERT INTO `role_has_permissions` VALUES (60, 2);
INSERT INTO `role_has_permissions` VALUES (1, 3);
INSERT INTO `role_has_permissions` VALUES (2, 3);
INSERT INTO `role_has_permissions` VALUES (3, 3);
INSERT INTO `role_has_permissions` VALUES (5, 3);
INSERT INTO `role_has_permissions` VALUES (6, 3);
INSERT INTO `role_has_permissions` VALUES (7, 3);
INSERT INTO `role_has_permissions` VALUES (9, 3);
INSERT INTO `role_has_permissions` VALUES (10, 3);
INSERT INTO `role_has_permissions` VALUES (11, 3);
INSERT INTO `role_has_permissions` VALUES (13, 3);
INSERT INTO `role_has_permissions` VALUES (14, 3);
INSERT INTO `role_has_permissions` VALUES (15, 3);
INSERT INTO `role_has_permissions` VALUES (17, 3);
INSERT INTO `role_has_permissions` VALUES (18, 3);
INSERT INTO `role_has_permissions` VALUES (19, 3);
INSERT INTO `role_has_permissions` VALUES (20, 3);
INSERT INTO `role_has_permissions` VALUES (25, 3);
INSERT INTO `role_has_permissions` VALUES (26, 3);
INSERT INTO `role_has_permissions` VALUES (30, 3);
INSERT INTO `role_has_permissions` VALUES (31, 3);
INSERT INTO `role_has_permissions` VALUES (32, 3);
INSERT INTO `role_has_permissions` VALUES (35, 3);
INSERT INTO `role_has_permissions` VALUES (36, 3);
INSERT INTO `role_has_permissions` VALUES (37, 3);
INSERT INTO `role_has_permissions` VALUES (39, 3);
INSERT INTO `role_has_permissions` VALUES (40, 3);
INSERT INTO `role_has_permissions` VALUES (41, 3);
INSERT INTO `role_has_permissions` VALUES (43, 3);
INSERT INTO `role_has_permissions` VALUES (44, 3);
INSERT INTO `role_has_permissions` VALUES (45, 3);
INSERT INTO `role_has_permissions` VALUES (47, 3);
INSERT INTO `role_has_permissions` VALUES (48, 3);
INSERT INTO `role_has_permissions` VALUES (49, 3);
INSERT INTO `role_has_permissions` VALUES (1, 4);
INSERT INTO `role_has_permissions` VALUES (5, 4);
INSERT INTO `role_has_permissions` VALUES (6, 4);
INSERT INTO `role_has_permissions` VALUES (7, 4);
INSERT INTO `role_has_permissions` VALUES (9, 4);
INSERT INTO `role_has_permissions` VALUES (10, 4);
INSERT INTO `role_has_permissions` VALUES (11, 4);
INSERT INTO `role_has_permissions` VALUES (13, 4);
INSERT INTO `role_has_permissions` VALUES (14, 4);
INSERT INTO `role_has_permissions` VALUES (15, 4);
INSERT INTO `role_has_permissions` VALUES (17, 4);
INSERT INTO `role_has_permissions` VALUES (18, 4);
INSERT INTO `role_has_permissions` VALUES (19, 4);
INSERT INTO `role_has_permissions` VALUES (30, 4);
INSERT INTO `role_has_permissions` VALUES (39, 4);
INSERT INTO `role_has_permissions` VALUES (40, 4);
INSERT INTO `role_has_permissions` VALUES (41, 4);
INSERT INTO `role_has_permissions` VALUES (5, 5);
INSERT INTO `role_has_permissions` VALUES (9, 5);
INSERT INTO `role_has_permissions` VALUES (17, 5);
INSERT INTO `role_has_permissions` VALUES (19, 5);
INSERT INTO `role_has_permissions` VALUES (1, 6);
INSERT INTO `role_has_permissions` VALUES (5, 6);
INSERT INTO `role_has_permissions` VALUES (9, 6);
INSERT INTO `role_has_permissions` VALUES (13, 6);
INSERT INTO `role_has_permissions` VALUES (17, 6);
INSERT INTO `role_has_permissions` VALUES (26, 6);
INSERT INTO `role_has_permissions` VALUES (30, 6);
INSERT INTO `role_has_permissions` VALUES (35, 6);
INSERT INTO `role_has_permissions` VALUES (39, 6);
INSERT INTO `role_has_permissions` VALUES (43, 6);
INSERT INTO `role_has_permissions` VALUES (47, 6);
INSERT INTO `role_has_permissions` VALUES (1, 7);
INSERT INTO `role_has_permissions` VALUES (5, 7);
INSERT INTO `role_has_permissions` VALUES (9, 7);
INSERT INTO `role_has_permissions` VALUES (17, 7);
INSERT INTO `role_has_permissions` VALUES (19, 7);
INSERT INTO `role_has_permissions` VALUES (39, 7);
INSERT INTO `role_has_permissions` VALUES (1, 8);
INSERT INTO `role_has_permissions` VALUES (17, 8);
INSERT INTO `role_has_permissions` VALUES (26, 8);
INSERT INTO `role_has_permissions` VALUES (30, 8);
INSERT INTO `role_has_permissions` VALUES (35, 8);
INSERT INTO `role_has_permissions` VALUES (43, 8);
INSERT INTO `role_has_permissions` VALUES (47, 8);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'super_admin', 'web', '系统超级管理员', NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `roles` VALUES (2, 'admin', 'web', '系统管理员', NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `roles` VALUES (3, 'project_manager', 'web', '项目经理', NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `roles` VALUES (4, 'vendor_admin', 'web', '运维单位管理员', NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `roles` VALUES (5, 'engineer', 'web', '运维工程师', NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `roles` VALUES (6, 'viewer', 'web', '访客', NULL, '2026-07-06 09:39:45', '2026-07-06 09:39:45');
INSERT INTO `roles` VALUES (7, 'vendor_staff', 'web', '运维单位人员', NULL, '2026-07-07 04:34:39', '2026-07-07 04:34:39');
INSERT INTO `roles` VALUES (8, 'service_unit', 'web', '服务单位', NULL, '2026-07-07 04:34:39', '2026-07-07 04:34:39');

-- ----------------------------
-- Table structure for satisfaction_survey_plans
-- ----------------------------
DROP TABLE IF EXISTS `satisfaction_survey_plans`;
CREATE TABLE `satisfaction_survey_plans`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `plan_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '计划名称',
  `service_unit_id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint UNSIGNED NULL DEFAULT NULL,
  `cycle_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '周期类型: monthly月度/quarterly季度/annually年度/custom自定义',
  `cycle_month` int NULL DEFAULT NULL COMMENT '执行月份(1-12)，年度/季度计划用',
  `cycle_day` int NULL DEFAULT NULL COMMENT '执行日期(1-31)',
  `start_date` date NOT NULL COMMENT '计划开始日期',
  `end_date` date NULL DEFAULT NULL COMMENT '计划结束日期',
  `remind_days` tinyint NOT NULL DEFAULT 3 COMMENT '提前提醒天数',
  `is_enabled` tinyint NOT NULL DEFAULT 1 COMMENT '是否启用: 0停用,1启用',
  `next_execute_at` timestamp NULL DEFAULT NULL COMMENT '下次执行时间',
  `last_executed_at` timestamp NULL DEFAULT NULL COMMENT '上次执行时间',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '备注',
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `satisfaction_survey_plans_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `satisfaction_survey_plans_service_unit_id_index`(`service_unit_id` ASC) USING BTREE,
  INDEX `satisfaction_survey_plans_vendor_id_index`(`vendor_id` ASC) USING BTREE,
  INDEX `satisfaction_survey_plans_cycle_type_index`(`cycle_type` ASC) USING BTREE,
  INDEX `satisfaction_survey_plans_is_enabled_index`(`is_enabled` ASC) USING BTREE,
  INDEX `satisfaction_survey_plans_next_execute_at_index`(`next_execute_at` ASC) USING BTREE,
  CONSTRAINT `satisfaction_survey_plans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `satisfaction_survey_plans_service_unit_id_foreign` FOREIGN KEY (`service_unit_id`) REFERENCES `service_units` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `satisfaction_survey_plans_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of satisfaction_survey_plans
-- ----------------------------
INSERT INTO `satisfaction_survey_plans` VALUES (1, '市数据中心月度回访', 1, 1, 'monthly', NULL, 15, '2026-07-07', NULL, 3, 1, '2026-07-15 00:00:00', NULL, NULL, 1, '2026-07-07 02:27:02', '2026-07-07 02:27:02', NULL);
INSERT INTO `satisfaction_survey_plans` VALUES (2, '政务中心季度满意度调查', 2, 2, 'quarterly', 3, 1, '2026-07-07', NULL, 5, 1, '2026-03-01 00:00:00', NULL, NULL, 1, '2026-07-07 02:27:02', '2026-07-07 02:27:02', NULL);

-- ----------------------------
-- Table structure for satisfaction_surveys
-- ----------------------------
DROP TABLE IF EXISTS `satisfaction_surveys`;
CREATE TABLE `satisfaction_surveys`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `plan_id` bigint UNSIGNED NULL DEFAULT NULL,
  `service_unit_id` bigint UNSIGNED NOT NULL,
  `personnel_id` bigint UNSIGNED NULL DEFAULT NULL,
  `survey_date` date NOT NULL COMMENT '回访日期',
  `satisfaction_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '满意度: very_satisfied非常满意/satisfied满意/general一般/dissatisfied不满意',
  `service_attitude_score` tinyint NULL DEFAULT NULL COMMENT '服务态度评分(1-5)',
  `response_speed_score` tinyint NULL DEFAULT NULL COMMENT '响应速度评分(1-5)',
  `technical_level_score` tinyint NULL DEFAULT NULL COMMENT '技术水平评分(1-5)',
  `overall_evaluation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '总体评价',
  `improvement_suggestions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '改进建议',
  `surveyor_id` bigint UNSIGNED NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT 0 COMMENT '状态: 0待回访,1已完成',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '备注',
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `satisfaction_surveys_surveyor_id_foreign`(`surveyor_id` ASC) USING BTREE,
  INDEX `satisfaction_surveys_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `satisfaction_surveys_plan_id_index`(`plan_id` ASC) USING BTREE,
  INDEX `satisfaction_surveys_service_unit_id_index`(`service_unit_id` ASC) USING BTREE,
  INDEX `satisfaction_surveys_personnel_id_index`(`personnel_id` ASC) USING BTREE,
  INDEX `satisfaction_surveys_survey_date_index`(`survey_date` ASC) USING BTREE,
  INDEX `satisfaction_surveys_satisfaction_level_index`(`satisfaction_level` ASC) USING BTREE,
  INDEX `satisfaction_surveys_status_index`(`status` ASC) USING BTREE,
  CONSTRAINT `satisfaction_surveys_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `satisfaction_surveys_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `satisfaction_surveys_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `satisfaction_survey_plans` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `satisfaction_surveys_service_unit_id_foreign` FOREIGN KEY (`service_unit_id`) REFERENCES `service_units` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `satisfaction_surveys_surveyor_id_foreign` FOREIGN KEY (`surveyor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of satisfaction_surveys
-- ----------------------------
INSERT INTO `satisfaction_surveys` VALUES (1, 1, 1, 1, '2026-06-27', 'very_satisfied', 5, 4, 5, '运维人员工作认真负责，响应及时，技术能力强', '建议增加定期技术培训', 1, 1, NULL, 1, '2026-07-07 02:27:02', '2026-07-07 02:27:02', NULL);
INSERT INTO `satisfaction_surveys` VALUES (2, NULL, 2, 3, '2026-07-02', 'satisfied', 4, 4, 4, '整体服务满意，云平台运行稳定', '希望优化部分系统响应速度', 1, 1, NULL, 1, '2026-07-07 02:27:02', '2026-07-07 02:27:02', NULL);
INSERT INTO `satisfaction_surveys` VALUES (3, NULL, 3, 5, '2026-07-05', 'general', 3, 3, 4, '服务基本满足需求，但响应速度有待提升', '加强节假日期间的运维保障', 1, 1, NULL, 1, '2026-07-07 02:27:02', '2026-07-07 02:27:02', NULL);

-- ----------------------------
-- Table structure for schedules
-- ----------------------------
DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `software_id` bigint UNSIGNED NULL DEFAULT NULL,
  `personnel_id` bigint UNSIGNED NOT NULL,
  `shift_date` date NOT NULL,
  `shift_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '白班/夜班/节假日班',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_replaced` tinyint NOT NULL DEFAULT 0,
  `replaced_by` bigint UNSIGNED NULL DEFAULT NULL,
  `replace_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '0取消,1正常',
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `schedules_unique`(`software_id` ASC, `personnel_id` ASC, `shift_date` ASC, `shift_type` ASC) USING BTREE,
  INDEX `schedules_replaced_by_foreign`(`replaced_by` ASC) USING BTREE,
  INDEX `schedules_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `schedules_software_id_index`(`software_id` ASC) USING BTREE,
  INDEX `schedules_personnel_id_index`(`personnel_id` ASC) USING BTREE,
  INDEX `schedules_shift_date_index`(`shift_date` ASC) USING BTREE,
  CONSTRAINT `schedules_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `schedules_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `schedules_replaced_by_foreign` FOREIGN KEY (`replaced_by`) REFERENCES `personnel` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `schedules_software_id_foreign` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of schedules
-- ----------------------------
INSERT INTO `schedules` VALUES (1, 1, 3, '2026-07-07', 'day', '08:00:00', '18:00:00', 0, NULL, NULL, 1, NULL, '2026-07-07 00:55:17', '2026-07-07 00:55:17');
INSERT INTO `schedules` VALUES (2, 1, 3, '2026-07-08', 'day', '08:00:00', '18:00:00', 0, NULL, NULL, 1, NULL, '2026-07-07 00:55:17', '2026-07-07 00:55:17');
INSERT INTO `schedules` VALUES (3, NULL, 1, '2026-07-07', 'night', '18:00:00', '08:00:00', 0, NULL, NULL, 1, NULL, '2026-07-07 00:55:17', '2026-07-07 00:55:17');

-- ----------------------------
-- Table structure for service_unit_contacts
-- ----------------------------
DROP TABLE IF EXISTS `service_unit_contacts`;
CREATE TABLE `service_unit_contacts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `service_unit_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手机号',
  `position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '职务',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '邮箱',
  `address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '地址',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '备注',
  `is_primary` tinyint NOT NULL DEFAULT 0 COMMENT '是否主要联系人: 0否,1是',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `service_unit_contacts_service_unit_id_index`(`service_unit_id` ASC) USING BTREE,
  INDEX `service_unit_contacts_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `service_unit_contacts_is_primary_index`(`is_primary` ASC) USING BTREE,
  CONSTRAINT `service_unit_contacts_service_unit_id_foreign` FOREIGN KEY (`service_unit_id`) REFERENCES `service_units` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `service_unit_contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of service_unit_contacts
-- ----------------------------
INSERT INTO `service_unit_contacts` VALUES (1, 1, NULL, '王明', '13800138100', '', NULL, '', NULL, 1, '2026-07-07 06:52:59', '2026-07-07 06:52:59');
INSERT INTO `service_unit_contacts` VALUES (2, 2, NULL, '李红', '13800138101', '', NULL, '', NULL, 1, '2026-07-07 06:53:06', '2026-07-07 06:53:06');
INSERT INTO `service_unit_contacts` VALUES (3, 3, NULL, '张军', '13800138102', '', NULL, '', NULL, 1, '2026-07-07 06:53:12', '2026-07-07 06:53:12');
INSERT INTO `service_unit_contacts` VALUES (4, 17, NULL, '云衢', '13800080001', '科员', '', '', NULL, 0, '2026-07-07 08:26:12', '2026-07-07 09:13:56');
INSERT INTO `service_unit_contacts` VALUES (5, 17, NULL, '局长', '13800080002', '主任', '', '', NULL, 0, '2026-07-07 09:13:56', '2026-07-07 09:13:56');

-- ----------------------------
-- Table structure for service_units
-- ----------------------------
DROP TABLE IF EXISTS `service_units`;
CREATE TABLE `service_units`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '服务单位名称',
  `short_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '简称',
  `address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '单位地址',
  `contact_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系人姓名',
  `contact_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系人电话',
  `contact_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系人邮箱',
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '状态: 0停用,1启用',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '备注',
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `service_units_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `service_units_name_index`(`name` ASC) USING BTREE,
  INDEX `service_units_status_index`(`status` ASC) USING BTREE,
  CONSTRAINT `service_units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of service_units
-- ----------------------------
INSERT INTO `service_units` VALUES (1, '洛阳市政务服务和大数据管理局', '市数据中心', '市政府大楼A座3楼', '王明', '13800138100', NULL, 1, NULL, 1, '2026-07-07 02:27:02', '2026-07-07 06:52:59', NULL);
INSERT INTO `service_units` VALUES (2, '洛阳市人民政府国有资产监督管理委员会', '政务中心', '市民广场B座', '李红', '13800138101', NULL, 1, NULL, 1, '2026-07-07 02:27:02', '2026-07-07 06:53:06', NULL);
INSERT INTO `service_units` VALUES (3, '中共洛阳市委政法委员会', '应急局', '行政中心C座5楼', '张军', '13800138102', NULL, 1, NULL, 1, '2026-07-07 02:27:02', '2026-07-07 06:53:12', NULL);
INSERT INTO `service_units` VALUES (4, '洛阳市市场监督管理局', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:53:20', '2026-07-07 06:53:20', NULL);
INSERT INTO `service_units` VALUES (5, '中国人民政治协商会议洛阳市委员会', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:53:26', '2026-07-07 06:53:26', NULL);
INSERT INTO `service_units` VALUES (6, '洛阳市统计局', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:53:33', '2026-07-07 06:53:33', NULL);
INSERT INTO `service_units` VALUES (7, '洛阳市水利局', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:53:39', '2026-07-07 06:53:39', NULL);
INSERT INTO `service_units` VALUES (8, '洛阳市教师发展中心', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:53:44', '2026-07-07 06:53:44', NULL);
INSERT INTO `service_units` VALUES (9, '洛阳市医疗保障中心', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:53:50', '2026-07-07 06:53:50', NULL);
INSERT INTO `service_units` VALUES (10, '洛阳市社会保险中心', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:53:54', '2026-07-07 06:53:54', NULL);
INSERT INTO `service_units` VALUES (11, '洛阳市商务局', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:53:59', '2026-07-07 06:53:59', NULL);
INSERT INTO `service_units` VALUES (12, '洛阳市水利事业发展中心', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:54:05', '2026-07-07 06:54:05', NULL);
INSERT INTO `service_units` VALUES (13, '洛阳市自然资源和规划局', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:54:11', '2026-07-07 06:54:11', NULL);
INSERT INTO `service_units` VALUES (14, '洛阳市住房公积金管理中心', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:54:17', '2026-07-07 06:54:17', NULL);
INSERT INTO `service_units` VALUES (15, '洛阳市住房和城乡建设局', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:54:22', '2026-07-07 06:54:22', NULL);
INSERT INTO `service_units` VALUES (16, '洛阳市城市管理局', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 06:54:27', '2026-07-07 06:54:27', NULL);
INSERT INTO `service_units` VALUES (17, '洛阳市财政局', '洛阳市财政局', '洛阳市洛龙区民生路1号', NULL, NULL, NULL, 1, NULL, NULL, '2026-07-07 08:26:12', '2026-07-07 09:30:17', NULL);

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('LG16PDjP068Zl1pzDDiYPbg7RJeqJUMJ4SjSlngs', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'eyJfdG9rZW4iOiJQUTNXT0ZVaFZKRGZDSmkzcG9TUjFOM2NkTmhzRGF3Z0pNcUJzZG9IIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwczpcL1wvaG9uZ3lpLnRlc3RcL3NlcnZpY2UtdW5pdHMiLCJyb3V0ZSI6InNlcnZpY2UtdW5pdHMuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJkYXNoYm9hcmRfcmVwb3J0X3Zpc2libGVfY29sdW1ucyI6WyJzZXEiLCJzZXJ2aWNlX3BlcmlvZCIsInNlcnZpY2VfdW5pdCIsImNvbnRyYWN0X25hbWUiLCJ2ZW5kb3IiLCJjb250cmFjdF90eXBlIiwibWFpbnRlbmFuY2VfdHlwZSIsInN1Yl9hbW91bnQiLCJwZXJzb25uZWxfY291bnQiLCJzdWJfcGVyaW9kIiwibWFpbl9jb250cmFjdCJdfQ==', 1783419012);
INSERT INTO `sessions` VALUES ('wCcWdDBNM5ZOp3eySoq0vrSBLeKWohARVDFaK5zS', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'eyJfdG9rZW4iOiJZTzlMbW9lc1JZOU9OUTk4cmpyc2RodTlqV0JpbXlHUXN0SThHOWphIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cHM6XC9cL2hvbmd5aS50ZXN0XC9hc3NldHNcL3NvZnR3YXJlIiwicm91dGUiOiJhc3NldHMuc29mdHdhcmUuaW5kZXgifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1783411143);

-- ----------------------------
-- Table structure for software
-- ----------------------------
DROP TABLE IF EXISTS `software`;
CREATE TABLE `software`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `software_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `software_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deploy_environment` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deploy_server` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `license_info` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sub_contract_id` bigint UNSIGNED NULL DEFAULT NULL,
  `vendor_id` bigint UNSIGNED NULL DEFAULT NULL,
  `maintenance_start_date` date NULL DEFAULT NULL,
  `maintenance_end_date` date NULL DEFAULT NULL,
  `maintenance_cycle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sla_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_resident_required` tinyint NOT NULL DEFAULT 0,
  `resident_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `resident_cycle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `work_start_time` time NULL DEFAULT NULL,
  `work_end_time` time NULL DEFAULT NULL,
  `emergency_response_time` int NULL DEFAULT NULL COMMENT '紧急响应时间(分钟)',
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '0停用,1运行中,2维护中',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `software_software_no_unique`(`software_no` ASC) USING BTREE,
  INDEX `software_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `software_sub_contract_id_index`(`sub_contract_id` ASC) USING BTREE,
  INDEX `software_vendor_id_index`(`vendor_id` ASC) USING BTREE,
  INDEX `software_status_index`(`status` ASC) USING BTREE,
  CONSTRAINT `software_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `software_sub_contract_id_foreign` FOREIGN KEY (`sub_contract_id`) REFERENCES `sub_contracts` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `software_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of software
-- ----------------------------
INSERT INTO `software` VALUES (1, 'SW-2026-001', '政务云平台管理系统', 'v3.2.1', '生产环境', 'srv-web-01, srv-web-02', '永久授权，50用户', NULL, 2, '2026-01-01', '2026-12-31', NULL, '7x24', 1, '政务云平台', NULL, '08:00:00', '18:00:00', 30, 1, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `software` VALUES (2, 'SW-2026-002', '数据交换平台', 'v2.5.0', '生产环境', 'srv-data-01', '年度授权，100节点', NULL, 2, '2026-01-01', '2026-12-31', NULL, '7x24', 0, NULL, NULL, '09:00:00', '17:30:00', 60, 1, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `software` VALUES (3, 'SW-2026-003', '统一身份认证系统', 'v4.0.2', '生产环境', 'srv-auth-01', '永久授权，无限用户', NULL, 4, '2026-01-01', '2026-12-31', NULL, '5x8', 1, '数据中心', NULL, '08:30:00', '17:30:00', 120, 1, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `software` VALUES (4, 'SW-2026-004', '视频监控管理平台', 'v5.1.0', '生产环境', 'srv-video-01', '按摄像头数量授权', NULL, 5, '2026-01-01', '2026-12-31', NULL, '7x24', 0, NULL, NULL, '08:00:00', '18:00:00', 60, 1, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `software` VALUES (5, 'SW-2026-005', '工单管理系统', 'v1.8.3', '生产环境', 'srv-ticket-01', '开源免费', NULL, 4, '2026-01-01', '2026-12-31', NULL, '5x8', 0, NULL, NULL, '09:00:00', '17:30:00', 240, 2, NULL, 1, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);

-- ----------------------------
-- Table structure for software_faults
-- ----------------------------
DROP TABLE IF EXISTS `software_faults`;
CREATE TABLE `software_faults`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `software_id` bigint UNSIGNED NOT NULL,
  `fault_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fault_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'critical紧急/major重大/minor一般',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `reporter_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reporter_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `report_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `handler_id` bigint UNSIGNED NULL DEFAULT NULL,
  `handle_time` timestamp NULL DEFAULT NULL,
  `handle_result` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `resolve_time` timestamp NULL DEFAULT NULL,
  `is_sla_met` tinyint NULL DEFAULT NULL COMMENT '是否满足SLA',
  `status` tinyint NOT NULL DEFAULT 0 COMMENT '0待处理,1处理中,2已解决,3已关闭',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `software_faults_fault_no_unique`(`fault_no` ASC) USING BTREE,
  INDEX `software_faults_handler_id_foreign`(`handler_id` ASC) USING BTREE,
  INDEX `software_faults_software_id_index`(`software_id` ASC) USING BTREE,
  INDEX `software_faults_fault_level_index`(`fault_level` ASC) USING BTREE,
  INDEX `software_faults_status_index`(`status` ASC) USING BTREE,
  INDEX `software_faults_report_time_index`(`report_time` ASC) USING BTREE,
  CONSTRAINT `software_faults_handler_id_foreign` FOREIGN KEY (`handler_id`) REFERENCES `personnel` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `software_faults_software_id_foreign` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of software_faults
-- ----------------------------

-- ----------------------------
-- Table structure for software_maintenance_logs
-- ----------------------------
DROP TABLE IF EXISTS `software_maintenance_logs`;
CREATE TABLE `software_maintenance_logs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `software_id` bigint UNSIGNED NOT NULL,
  `maintenance_date` date NOT NULL,
  `maintenance_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '日常/故障/升级/优化',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `result` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `duration` int NULL DEFAULT NULL COMMENT '耗时(分钟)',
  `personnel_id` bigint UNSIGNED NULL DEFAULT NULL,
  `attachments` json NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `software_maintenance_logs_personnel_id_foreign`(`personnel_id` ASC) USING BTREE,
  INDEX `software_maintenance_logs_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `software_maintenance_logs_software_id_index`(`software_id` ASC) USING BTREE,
  INDEX `software_maintenance_logs_maintenance_date_index`(`maintenance_date` ASC) USING BTREE,
  CONSTRAINT `software_maintenance_logs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `software_maintenance_logs_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `software_maintenance_logs_software_id_foreign` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of software_maintenance_logs
-- ----------------------------

-- ----------------------------
-- Table structure for sub_contract_managers
-- ----------------------------
DROP TABLE IF EXISTS `sub_contract_managers`;
CREATE TABLE `sub_contract_managers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `sub_contract_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `scm_unique`(`sub_contract_id` ASC, `user_id` ASC) USING BTREE,
  INDEX `sub_contract_managers_sub_contract_id_index`(`sub_contract_id` ASC) USING BTREE,
  INDEX `sub_contract_managers_user_id_index`(`user_id` ASC) USING BTREE,
  CONSTRAINT `sub_contract_managers_sub_contract_id_foreign` FOREIGN KEY (`sub_contract_id`) REFERENCES `sub_contracts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sub_contract_managers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sub_contract_managers
-- ----------------------------

-- ----------------------------
-- Table structure for sub_contract_personnel
-- ----------------------------
DROP TABLE IF EXISTS `sub_contract_personnel`;
CREATE TABLE `sub_contract_personnel`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `sub_contract_id` bigint UNSIGNED NOT NULL,
  `personnel_id` bigint UNSIGNED NOT NULL,
  `assigned_at` date NULL DEFAULT NULL COMMENT '人员分配日期',
  `ended_at` date NULL DEFAULT NULL COMMENT '人员结束日期',
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '状态: 0已移除,1在职',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '备注',
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `scp_unique_active`(`sub_contract_id` ASC, `personnel_id` ASC, `status` ASC) USING BTREE,
  INDEX `sub_contract_personnel_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `sub_contract_personnel_sub_contract_id_index`(`sub_contract_id` ASC) USING BTREE,
  INDEX `sub_contract_personnel_personnel_id_index`(`personnel_id` ASC) USING BTREE,
  CONSTRAINT `sub_contract_personnel_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `sub_contract_personnel_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sub_contract_personnel_sub_contract_id_foreign` FOREIGN KEY (`sub_contract_id`) REFERENCES `sub_contracts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sub_contract_personnel
-- ----------------------------

-- ----------------------------
-- Table structure for sub_contracts
-- ----------------------------
DROP TABLE IF EXISTS `sub_contracts`;
CREATE TABLE `sub_contracts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `main_contract_id` bigint UNSIGNED NOT NULL,
  `contract_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` bigint UNSIGNED NOT NULL,
  `service_unit_id` bigint UNSIGNED NULL DEFAULT NULL,
  `contract_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'software/hardware/infrastructure/integrated',
  `maintenance_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '运维类型: 原建设方驻场/原建设方远程运维/自主巡检/自主运维驻场/购买服务',
  `project_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '项目层级：省统建/省建/市建',
  `sub_amount` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `signed_date` date NULL DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `service_scope` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `sla_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `payment_terms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `attachment_visible` tinyint NOT NULL DEFAULT 1 COMMENT '附件是否展示: 0隐藏,1展示',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `sub_contracts_contract_no_unique`(`contract_no` ASC) USING BTREE,
  INDEX `sub_contracts_created_by_foreign`(`created_by` ASC) USING BTREE,
  INDEX `sub_contracts_main_contract_id_index`(`main_contract_id` ASC) USING BTREE,
  INDEX `sub_contracts_vendor_id_index`(`vendor_id` ASC) USING BTREE,
  INDEX `sub_contracts_status_index`(`status` ASC) USING BTREE,
  INDEX `sub_contracts_end_date_index`(`end_date` ASC) USING BTREE,
  INDEX `sub_contracts_maintenance_type_index`(`maintenance_type` ASC) USING BTREE,
  INDEX `sub_contracts_attachment_visible_index`(`attachment_visible` ASC) USING BTREE,
  INDEX `sub_contracts_service_unit_id_foreign`(`service_unit_id` ASC) USING BTREE,
  INDEX `sub_contracts_project_level_index`(`project_level` ASC) USING BTREE,
  CONSTRAINT `sub_contracts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `sub_contracts_main_contract_id_foreign` FOREIGN KEY (`main_contract_id`) REFERENCES `main_contracts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sub_contracts_service_unit_id_foreign` FOREIGN KEY (`service_unit_id`) REFERENCES `service_units` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `sub_contracts_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sub_contracts
-- ----------------------------
INSERT INTO `sub_contracts` VALUES (1, 1, 'SC-2026-0F3C65', '财政局预决算公开报告辅助生成及公开监督服务系统', 1, 17, 'software', 'remote_original', 'provincial', 0.00, NULL, '2026-07-07', '2026-07-07', NULL, NULL, NULL, 'draft', 1, NULL, 1, '2026-07-07 09:30:48', '2026-07-07 09:32:58', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vendor_id` bigint UNSIGNED NULL DEFAULT NULL,
  `service_unit_id` bigint UNSIGNED NULL DEFAULT NULL,
  `department` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '0禁用,1启用',
  `is_system_user` tinyint NOT NULL DEFAULT 1 COMMENT '是否系统用户: 0仅通讯录,1可登录',
  `can_view_word` tinyint NOT NULL DEFAULT 0 COMMENT '允许查看合同Word附件',
  `can_view_pdf` tinyint NOT NULL DEFAULT 0 COMMENT '允许查看合同PDF附件',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  INDEX `users_vendor_id_index`(`vendor_id` ASC) USING BTREE,
  INDEX `users_is_system_user_index`(`is_system_user` ASC) USING BTREE,
  INDEX `users_service_unit_id_index`(`service_unit_id` ASC) USING BTREE,
  CONSTRAINT `users_service_unit_id_foreign` FOREIGN KEY (`service_unit_id`) REFERENCES `service_units` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `users_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, '崔建强', 'seeding@ihopeso.cn', NULL, '$2y$12$AxLtUfeinQIXx80oWQdxOO/LAiTYX7T6wH.jC5TvJzdYMTSXWqAx6', NULL, NULL, NULL, NULL, NULL, NULL, '系统管理部', 1, 1, 0, 0, NULL, 'BGhc9jimZKiRYLu6F4MDI1ibrzhtK9RomA3nwrAnO1HxBEcC9e5u10e8ggrz', '2026-07-06 09:39:46', '2026-07-06 09:39:46', '2026-07-07 02:52:07', NULL);
INSERT INTO `users` VALUES (2, '项目经理', 'pm1@example.com', '13900000001', '$2y$12$Rgn1IFgkXOQl2JK7D7cbT.J2uxM.aG5nAeAd49H9pG9j4nyAvB8nW', NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, '2026-07-07 04:35:13', '2026-07-07 06:41:23', NULL);
INSERT INTO `users` VALUES (3, '运维单位管理员', 'vendor_admin@example.com', '13900000002', '$2y$12$py8XMHh2/M91jdcMehHQYe49DcBvzNiDburf/YbUlrvxZpKnStwZS', NULL, NULL, NULL, NULL, 2, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, '2026-07-07 04:35:14', '2026-07-07 04:35:14', NULL);
INSERT INTO `users` VALUES (4, '运维人员', 'vendor_staff@example.com', '13900000003', '$2y$12$BIcYowKukVdTwgKOift0ZuRBcZ4nMMl3YadyTEZTtTT1SJmNroUWa', NULL, NULL, NULL, NULL, 2, NULL, NULL, 1, 1, 1, 0, NULL, NULL, NULL, '2026-07-07 04:35:14', '2026-07-07 04:35:14', NULL);
INSERT INTO `users` VALUES (5, '服务单位联系人', 'service@example.com', '13900000004', '$2y$12$9DuDBcJbhOql1ZmCvSrtOeZlAx/7N2.51C3dvesviCSqB1PwRFZWO', NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 1, 0, 0, NULL, NULL, NULL, '2026-07-07 04:35:14', '2026-07-07 04:35:14', NULL);
INSERT INTO `users` VALUES (6, '访客用户', 'viewer@example.com', '13900000005', '$2y$12$Fky/gvPH0z3yBomzCnktYeryW0VwhGgJiBe9KR67ZNpSBaZLpMq.2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, '2026-07-07 04:35:14', '2026-07-07 04:35:14', NULL);
INSERT INTO `users` VALUES (7, '通讯录人员', 'contact@example.com', '13900000006', '$2y$12$zlp9.4PNSK0tAkx1j9ys1.PDbJUz5JCUMd6J2KqMunNNqnHa7ba..', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, NULL, NULL, NULL, '2026-07-07 04:35:15', '2026-07-07 04:53:01', NULL);

-- ----------------------------
-- Table structure for vendor_contacts
-- ----------------------------
DROP TABLE IF EXISTS `vendor_contacts`;
CREATE TABLE `vendor_contacts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_primary` tinyint NOT NULL DEFAULT 0 COMMENT '是否主要联系人',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `vendor_contacts_vendor_id_index`(`vendor_id` ASC) USING BTREE,
  CONSTRAINT `vendor_contacts_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vendor_contacts
-- ----------------------------

-- ----------------------------
-- Table structure for vendors
-- ----------------------------
DROP TABLE IF EXISTS `vendors`;
CREATE TABLE `vendors`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `unified_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '软件运维商/硬件运维商/机房建设商/综合服务商',
  `qualification_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `legal_person` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contact_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contact_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contact_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `bank_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `bank_account` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cooperation_status` tinyint NOT NULL DEFAULT 1 COMMENT '0终止,1合作中,2暂停',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `vendors_unified_code_unique`(`unified_code` ASC) USING BTREE,
  INDEX `vendors_type_index`(`type` ASC) USING BTREE,
  INDEX `vendors_cooperation_status_index`(`cooperation_status` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vendors
-- ----------------------------
INSERT INTO `vendors` VALUES (1, '北京久其政务软件股份有限公司', '久其', NULL, 'software', NULL, NULL, '张伟', '13800138001', NULL, '深圳市龙岗区', NULL, NULL, 1, NULL, '2026-07-06 10:16:32', '2026-07-07 09:29:02', NULL);
INSERT INTO `vendors` VALUES (2, '阿里云智能科技有限公司', '阿里云', NULL, 'software', NULL, NULL, '李娜', '13800138002', NULL, '杭州市余杭区', NULL, NULL, 1, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `vendors` VALUES (3, '北京浪潮电子信息产业有限公司', '浪潮', NULL, 'hardware', NULL, NULL, '王强', '13800138003', NULL, '北京市海淀区', NULL, NULL, 1, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `vendors` VALUES (4, '腾讯云智慧运维服务有限公司', '腾讯云', NULL, 'integrated', NULL, NULL, '赵敏', '13800138004', NULL, '深圳市南山区', NULL, NULL, 1, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);
INSERT INTO `vendors` VALUES (5, '杭州海康威视数字技术股份有限公司', '海康威视', NULL, 'infrastructure', NULL, NULL, '刘洋', '13800138005', NULL, '杭州市滨江区', NULL, NULL, 1, NULL, '2026-07-06 10:16:32', '2026-07-06 10:16:32', NULL);

SET FOREIGN_KEY_CHECKS = 1;

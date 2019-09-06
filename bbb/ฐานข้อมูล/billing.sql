/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50714
 Source Host           : 127.0.0.1:3306
 Source Schema         : billing

 Target Server Type    : MySQL
 Target Server Version : 50714
 File Encoding         : 65001

 Date: 28/07/2019 23:28:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment`  (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`, `user_id`) USING BTREE,
  INDEX `auth_assignment_user_id_idx`(`user_id`) USING BTREE,
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('admin', '1', 1535696400);
INSERT INTO `auth_assignment` VALUES ('user', '2', 1562226673);
INSERT INTO `auth_assignment` VALUES ('user', '3', 1562228852);

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `rule_name`(`rule_name`) USING BTREE,
  INDEX `idx-auth_item-type`(`type`) USING BTREE,
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('/admin/*', 2, NULL, NULL, NULL, 1535696373, 1535696373);
INSERT INTO `auth_item` VALUES ('/bill-chargers/*', 2, NULL, NULL, NULL, 1564329147, 1564329147);
INSERT INTO `auth_item` VALUES ('/bill-items/*', 2, NULL, NULL, NULL, 1564329144, 1564329144);
INSERT INTO `auth_item` VALUES ('/bill-items/preview-image', 2, NULL, NULL, NULL, 1564329816, 1564329816);
INSERT INTO `auth_item` VALUES ('/bill-packagers/*', 2, NULL, NULL, NULL, 1564329144, 1564329144);
INSERT INTO `auth_item` VALUES ('/bill-shippings/*', 2, NULL, NULL, NULL, 1564329144, 1564329144);
INSERT INTO `auth_item` VALUES ('/bill-shop/*', 2, NULL, NULL, NULL, 1564329144, 1564329144);
INSERT INTO `auth_item` VALUES ('/bill-status/*', 2, NULL, NULL, NULL, 1564329144, 1564329144);
INSERT INTO `auth_item` VALUES ('/bill-type/*', 2, NULL, NULL, NULL, 1564329144, 1564329144);
INSERT INTO `auth_item` VALUES ('/core/*', 2, NULL, NULL, NULL, 1535699352, 1535699352);
INSERT INTO `auth_item` VALUES ('/debug/*', 2, NULL, NULL, NULL, 1562222244, 1562222244);
INSERT INTO `auth_item` VALUES ('/gii/*', 2, NULL, NULL, NULL, 1535706951, 1535706951);
INSERT INTO `auth_item` VALUES ('/informations/*', 2, NULL, NULL, NULL, 1562299552, 1562299552);
INSERT INTO `auth_item` VALUES ('/options/*', 2, NULL, NULL, NULL, 1562243863, 1562243863);
INSERT INTO `auth_item` VALUES ('/product-list/*', 2, NULL, NULL, NULL, 1564330134, 1564330134);
INSERT INTO `auth_item` VALUES ('/sell-shipping/*', 2, NULL, NULL, NULL, 1564330822, 1564330822);
INSERT INTO `auth_item` VALUES ('/site/*', 2, NULL, NULL, NULL, 1562245386, 1562245386);
INSERT INTO `auth_item` VALUES ('/skin/*', 2, NULL, NULL, NULL, 1563731318, 1563731318);
INSERT INTO `auth_item` VALUES ('/text-editor/*', 2, NULL, NULL, NULL, 1563780854, 1563780854);
INSERT INTO `auth_item` VALUES ('/user-percent/*', 2, NULL, NULL, NULL, 1564330165, 1564330165);
INSERT INTO `auth_item` VALUES ('/user/*', 2, NULL, NULL, NULL, 1535697098, 1535697098);
INSERT INTO `auth_item` VALUES ('/user/registration/register', 2, NULL, NULL, NULL, 1562221007, 1562221007);
INSERT INTO `auth_item` VALUES ('/user/security/logout', 2, NULL, NULL, NULL, 1562227469, 1562227469);
INSERT INTO `auth_item` VALUES ('/user/settings/account', 2, NULL, NULL, NULL, 1562226761, 1562226761);
INSERT INTO `auth_item` VALUES ('/user/settings/profile', 2, NULL, NULL, NULL, 1562226734, 1562226734);
INSERT INTO `auth_item` VALUES ('admin', 1, 'Admin', NULL, NULL, 1535696302, 1535696302);
INSERT INTO `auth_item` VALUES ('billmanager', 1, 'billmanager', NULL, NULL, 1564328691, 1564328691);
INSERT INTO `auth_item` VALUES ('chargers', 1, 'chargers', NULL, NULL, 1564328713, 1564328713);
INSERT INTO `auth_item` VALUES ('edit_about', 1, 'แก้ไขหน้าเกี่ยวกับเรา', NULL, NULL, 1563780984, 1563781037);
INSERT INTO `auth_item` VALUES ('edit_contact', 1, 'แก้ไขหน้าติดต่อเรา', NULL, NULL, 1563781003, 1563781049);
INSERT INTO `auth_item` VALUES ('edit_home', 1, 'แก้ไขหน้าหลัก', NULL, NULL, 1563780961, 1563781059);
INSERT INTO `auth_item` VALUES ('manage_information', 1, 'จัดการข่าวประชาสัมพันธ์', NULL, NULL, 1563781024, 1563781024);
INSERT INTO `auth_item` VALUES ('packager', 1, 'packager', NULL, NULL, 1564328699, 1564328699);
INSERT INTO `auth_item` VALUES ('sell_shipping', 1, 'sell-shipping', NULL, NULL, 1564330813, 1564330813);
INSERT INTO `auth_item` VALUES ('shipping', 1, 'shipping', NULL, NULL, 1564328707, 1564328707);
INSERT INTO `auth_item` VALUES ('user', 1, 'User', NULL, NULL, 1535696315, 1535696315);

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child`  (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`, `child`) USING BTREE,
  INDEX `child`(`child`) USING BTREE,
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('admin', '/admin/*');
INSERT INTO `auth_item_child` VALUES ('chargers', '/bill-chargers/*');
INSERT INTO `auth_item_child` VALUES ('billmanager', '/bill-items/*');
INSERT INTO `auth_item_child` VALUES ('admin', '/bill-items/preview-image');
INSERT INTO `auth_item_child` VALUES ('billmanager', '/bill-items/preview-image');
INSERT INTO `auth_item_child` VALUES ('packager', '/bill-packagers/*');
INSERT INTO `auth_item_child` VALUES ('shipping', '/bill-shippings/*');
INSERT INTO `auth_item_child` VALUES ('admin', '/core/*');
INSERT INTO `auth_item_child` VALUES ('admin', '/debug/*');
INSERT INTO `auth_item_child` VALUES ('admin', '/gii/*');
INSERT INTO `auth_item_child` VALUES ('user', '/informations/*');
INSERT INTO `auth_item_child` VALUES ('admin', '/options/*');
INSERT INTO `auth_item_child` VALUES ('admin', '/product-list/*');
INSERT INTO `auth_item_child` VALUES ('sell_shipping', '/sell-shipping/*');
INSERT INTO `auth_item_child` VALUES ('user', '/site/*');
INSERT INTO `auth_item_child` VALUES ('admin', '/skin/*');
INSERT INTO `auth_item_child` VALUES ('admin', '/text-editor/*');
INSERT INTO `auth_item_child` VALUES ('admin', '/user-percent/*');
INSERT INTO `auth_item_child` VALUES ('admin', '/user/*');
INSERT INTO `auth_item_child` VALUES ('user', '/user/security/logout');
INSERT INTO `auth_item_child` VALUES ('user', '/user/settings/account');
INSERT INTO `auth_item_child` VALUES ('user', '/user/settings/profile');
INSERT INTO `auth_item_child` VALUES ('admin', 'billmanager');
INSERT INTO `auth_item_child` VALUES ('admin', 'chargers');
INSERT INTO `auth_item_child` VALUES ('admin', 'edit_about');
INSERT INTO `auth_item_child` VALUES ('admin', 'edit_contact');
INSERT INTO `auth_item_child` VALUES ('admin', 'edit_home');
INSERT INTO `auth_item_child` VALUES ('admin', 'manage_information');
INSERT INTO `auth_item_child` VALUES ('admin', 'packager');
INSERT INTO `auth_item_child` VALUES ('admin', 'sell_shipping');
INSERT INTO `auth_item_child` VALUES ('admin', 'shipping');
INSERT INTO `auth_item_child` VALUES ('admin', 'user');

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bill_chargers
-- ----------------------------
DROP TABLE IF EXISTS `bill_chargers`;
CREATE TABLE `bill_chargers`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` bigint(20) NOT NULL COMMENT 'Bill ID',
  `user_id` bigint(20) NOT NULL COMMENT 'พนักงานเก็บเงิน',
  `amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'จำนวนเงิน',
  `file_upload` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remark` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'หมายเหตุ',
  `rstat` int(1) DEFAULT NULL,
  `create_by` bigint(20) DEFAULT NULL COMMENT 'สร้างโดย',
  `create_date` datetime(0) DEFAULT NULL COMMENT 'สร้างเมื่อ',
  `update_by` bigint(20) DEFAULT NULL COMMENT 'แก้ไขโดย',
  `update_date` datetime(0) DEFAULT NULL COMMENT 'แก้ไขเมือ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bill_chargers
-- ----------------------------
INSERT INTO `bill_chargers` VALUES (1, 1, 1, '1', '', '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `bill_chargers` VALUES (2, 1, 1560232767, '1', '', '', 1, 1, '2019-06-11 16:10:49', NULL, NULL);
INSERT INTO `bill_chargers` VALUES (3, 1, 1560243602, '100', '', '', 1, 1, '2019-06-11 16:11:09', 1, '2019-06-11 16:15:27');
INSERT INTO `bill_chargers` VALUES (4, 1562326928048361300, 1, '100', '', '', 1, 1, '2019-07-11 15:44:11', NULL, NULL);
INSERT INTO `bill_chargers` VALUES (5, 1562326928048361300, 3, '500', '', '', 3, 1, '2019-07-11 15:46:09', 1, '2019-07-11 15:49:17');
INSERT INTO `bill_chargers` VALUES (6, 1562326928048361300, 3, '500', '', '', 3, 1, '2019-07-11 15:46:24', 1, '2019-07-11 15:47:39');
INSERT INTO `bill_chargers` VALUES (7, 1562326928048361300, 1, '400', '', '', 3, 1, '2019-07-11 15:49:24', 1, '2019-07-11 15:50:20');
INSERT INTO `bill_chargers` VALUES (8, 1562326928048361300, 2, '100', '', '', 3, 1, '2019-07-11 15:50:12', 1, '2019-07-11 15:50:15');
INSERT INTO `bill_chargers` VALUES (9, 1562326928048361300, 2, '100', '', '', 3, 1, '2019-07-11 15:50:27', 1, '2019-07-11 15:50:31');
INSERT INTO `bill_chargers` VALUES (10, 1562326928048361300, 2, '', '', '', 3, 1, '2019-07-11 15:50:37', 1, '2019-07-11 15:50:47');
INSERT INTO `bill_chargers` VALUES (11, 1562326928048361300, 3, '', '', '', 3, 1, '2019-07-11 15:50:44', 1, '2019-07-11 18:13:17');
INSERT INTO `bill_chargers` VALUES (12, 1562326928048361300, 1, '200', '', '', 1, 1, '2019-07-11 18:13:25', NULL, NULL);

-- ----------------------------
-- Table structure for bill_items
-- ----------------------------
DROP TABLE IF EXISTS `bill_items`;
CREATE TABLE `bill_items`  (
  `id` bigint(20) NOT NULL COMMENT 'Bill ID',
  `bookno` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'บิลเล่มที่ (Ref to next record)',
  `billno` int(11) DEFAULT NULL COMMENT 'หมายเลขบิล (Auto Number)',
  `billref` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'CR/CRV/CRA',
  `shop_id` bigint(20) DEFAULT NULL,
  `btype` tinyint(4) DEFAULT NULL COMMENT '1 = บิลลูกค้าฟ้า 2=บิลบัญชีแดง',
  `amount` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'จำนวนเงิน',
  `status` tinyint(4) DEFAULT NULL COMMENT 'สถานะบิล 0=ปกติ 1=ชำรุดเสียหาย 2=ยกเลิก',
  `shiping` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'สถานะการส่งสินค้า 0=ยังไม่จัดสินค้า 1=จัดสินค้าแล้ว 2=ออกไปส่งสินค้าแล้ว 3=',
  `charge` tinyint(4) DEFAULT NULL COMMENT 'สถานะเก็บเงิน 0=ยังไม่เรียกเก็บ 1=วางบิล 2=ฝากเก็บเงิน 3=เก็บเงิน/เช็ค/โอน 4=ตัดบัญชีแล้ว',
  `bill_upload` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remark` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'หมายเหตุ',
  `bill_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ประเภทบิล',
  `bill_date` date DEFAULT NULL COMMENT 'วันที่',
  `billtype` int(11) DEFAULT NULL COMMENT 'ประเภทบิล',
  `rstat` int(1) DEFAULT NULL COMMENT 'สถานะ',
  `create_by` bigint(20) DEFAULT NULL COMMENT 'สร้างโดย',
  `create_date` datetime(0) DEFAULT NULL COMMENT 'สร้างเมื่อ',
  `update_by` bigint(20) DEFAULT NULL COMMENT 'แก้ไขโดย',
  `update_date` datetime(0) DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `shop_id`(`shop_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bill_items
-- ----------------------------
INSERT INTO `bill_items` VALUES (1562326928048361300, '1234', 1, 'CR1904-00541', 0, NULL, '100', 1, '2', 10, NULL, '', '2', '2019-07-05', 9, 1, NULL, NULL, NULL, NULL);
INSERT INTO `bill_items` VALUES (1562833781078806000, '1234', 2, 'CR1904-00549', 0, NULL, '1000', 1, '1', 5, NULL, '<p>กำ</p>', '1', '2019-07-18', 10, 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for bill_packagers
-- ----------------------------
DROP TABLE IF EXISTS `bill_packagers`;
CREATE TABLE `bill_packagers`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัส',
  `bill_id` bigint(20) NOT NULL COMMENT 'Bill ID',
  `user_id` bigint(20) NOT NULL COMMENT 'ผู้จัดสินค้า',
  `file_upload` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remark` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'หมายเหตุ',
  `create_by` bigint(20) DEFAULT NULL COMMENT 'สร้างโดย',
  `create_date` datetime(0) DEFAULT NULL COMMENT 'สร้างเมื่อ',
  `update_by` bigint(20) DEFAULT NULL COMMENT 'แก้ไขโดย',
  `update_date` datetime(0) DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  `rstat` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bill_packagers
-- ----------------------------
INSERT INTO `bill_packagers` VALUES (1, 1, 1, '', '<p>d</p>', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `bill_packagers` VALUES (2, 2, 1, '', '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `bill_packagers` VALUES (3, 1, 1560232795, '', '', 1, '2019-06-11 03:15:04', 1, '2019-06-11 16:08:18', 1);
INSERT INTO `bill_packagers` VALUES (4, 1, 1560243341, '', '', 1, '2019-06-11 03:15:12', 1, '2019-06-11 16:08:11', 1);
INSERT INTO `bill_packagers` VALUES (5, 1, 1560243428, '', '', 1, '2019-06-11 03:15:18', 1, '2019-06-11 16:08:06', 1);
INSERT INTO `bill_packagers` VALUES (6, 1, 1560243602, '', '', 1, '2019-06-11 16:03:37', NULL, NULL, 1);
INSERT INTO `bill_packagers` VALUES (7, 1, 1560232767, '', '', 1, '2019-06-11 16:08:24', NULL, NULL, 1);
INSERT INTO `bill_packagers` VALUES (8, 2, 1560232767, '', '', 1, '2019-06-11 16:08:49', NULL, NULL, 1);
INSERT INTO `bill_packagers` VALUES (9, 2, 1560232795, '', '', 1, '2019-06-11 16:08:53', NULL, NULL, 1);
INSERT INTO `bill_packagers` VALUES (10, 3, 1560243602, '', '', 1, '2019-06-11 16:09:09', NULL, NULL, 1);
INSERT INTO `bill_packagers` VALUES (11, 1562326928048361300, 1, '', '', 1, '2019-07-10 23:30:49', NULL, NULL, 1);
INSERT INTO `bill_packagers` VALUES (12, 1562326928048361300, 2, '', '', 1, '2019-07-10 23:33:29', 1, '2019-07-10 23:33:37', 3);
INSERT INTO `bill_packagers` VALUES (13, 1562326928048361300, 3, '', '', 1, '2019-07-10 23:35:24', 1, '2019-07-10 23:52:24', 3);
INSERT INTO `bill_packagers` VALUES (14, 1562326928048361300, 1, '', '', 1, '2019-07-10 23:37:34', 1, '2019-07-10 23:52:18', 3);
INSERT INTO `bill_packagers` VALUES (15, 1562326928048361300, 1, '', '', 1, '2019-07-10 23:38:47', 1, '2019-07-10 23:48:32', 3);
INSERT INTO `bill_packagers` VALUES (16, 1562326928048361300, 3, '', '', 1, '2019-07-10 23:56:01', NULL, NULL, 1);
INSERT INTO `bill_packagers` VALUES (17, 1562326928048361300, 1, '', '', 1, '2019-07-10 23:56:05', NULL, NULL, 1);
INSERT INTO `bill_packagers` VALUES (18, 1562326928048361300, 2, '', '', 1, '2019-07-10 23:56:11', 1, '2019-07-11 15:36:17', 3);

-- ----------------------------
-- Table structure for bill_shippings
-- ----------------------------
DROP TABLE IF EXISTS `bill_shippings`;
CREATE TABLE `bill_shippings`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` bigint(20) NOT NULL COMMENT 'Bill ID',
  `user_id` bigint(20) NOT NULL COMMENT 'ผู้จัดส่งสินค้า',
  `file_upload` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remark` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'หมายเหตุ',
  `create_by` bigint(20) DEFAULT NULL COMMENT 'สร้างโดย',
  `create_date` datetime(0) DEFAULT NULL COMMENT 'สร้างเมื่อ',
  `update_by` bigint(20) DEFAULT NULL COMMENT 'แก้ไขโดย',
  `update_date` datetime(0) DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  `rstat` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bill_shippings
-- ----------------------------
INSERT INTO `bill_shippings` VALUES (1, 3, 1, '1559475773097269500.jpg', '', NULL, NULL, NULL, NULL, 1);
INSERT INTO `bill_shippings` VALUES (2, 1, 1, '', '', NULL, NULL, 1, '2019-06-11 03:56:11', 3);
INSERT INTO `bill_shippings` VALUES (3, 1, 1, '', '', 1, '2019-06-11 03:56:18', NULL, NULL, 1);
INSERT INTO `bill_shippings` VALUES (4, 1, 1560243341, '', '', 1, '2019-06-11 16:10:02', NULL, NULL, 1);
INSERT INTO `bill_shippings` VALUES (5, 2, 1560232767, '', '', 1, '2019-06-11 16:10:11', NULL, NULL, 1);
INSERT INTO `bill_shippings` VALUES (6, 2, 1560232767, '', '', 1, '2019-06-11 16:10:18', NULL, NULL, 1);
INSERT INTO `bill_shippings` VALUES (7, 3, 1, '', '', 1, '2019-06-11 16:10:29', NULL, NULL, 1);
INSERT INTO `bill_shippings` VALUES (8, 1562326928048361300, 1, '', '', 1, '2019-07-11 15:06:35', NULL, NULL, 1);
INSERT INTO `bill_shippings` VALUES (9, 1562326928048361300, 2, '', '', 1, '2019-07-11 15:07:30', 1, '2019-07-11 15:19:04', 3);
INSERT INTO `bill_shippings` VALUES (10, 1562326928048361300, 1, '', '', 1, '2019-07-11 15:08:30', 1, '2019-07-11 15:19:08', 3);
INSERT INTO `bill_shippings` VALUES (11, 1562326928048361300, 1, '', '', 1, '2019-07-11 15:19:56', 1, '2019-07-11 15:20:00', 3);
INSERT INTO `bill_shippings` VALUES (12, 1562326928048361300, 3, '', '', 1, '2019-07-11 15:22:55', NULL, NULL, 1);
INSERT INTO `bill_shippings` VALUES (13, 1562326928048361300, 2, '', '', 1, '2019-07-11 15:23:00', 1, '2019-07-11 15:23:03', 3);

-- ----------------------------
-- Table structure for bill_shop
-- ----------------------------
DROP TABLE IF EXISTS `bill_shop`;
CREATE TABLE `bill_shop`  (
  `id` bigint(20) NOT NULL COMMENT 'รหัสร้านค้า',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ชื่อร้าน',
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ที่อยู่',
  `lat` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ละติจูด',
  `lng` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ลองติจูด',
  `remark` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'หมายเหตุ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bill_shop
-- ----------------------------
INSERT INTO `bill_shop` VALUES (1, 'test1', '1', '1', '1', '1');
INSERT INTO `bill_shop` VALUES (2, 'test2', 'sfds', 'sdfds', 'sdf', 'sdf');
INSERT INTO `bill_shop` VALUES (3, 'test3', 'sfsdf', 'sdf', 'sdf', 'sfs');
INSERT INTO `bill_shop` VALUES (4, 'dsf', 'fs', 'sf', 'sdfs', 'sf');

-- ----------------------------
-- Table structure for bill_status
-- ----------------------------
DROP TABLE IF EXISTS `bill_status`;
CREATE TABLE `bill_status`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'สถานะบิล',
  `rstat` int(1) DEFAULT NULL COMMENT 'สถานะ',
  `create_by` bigint(20) DEFAULT NULL COMMENT 'สร้างโดย',
  `create_date` datetime(0) DEFAULT NULL COMMENT 'สร้างเมื่อ',
  `update_by` bigint(20) DEFAULT NULL COMMENT 'แก้ไขโดย',
  `update_date` datetime(0) DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bill_status
-- ----------------------------
INSERT INTO `bill_status` VALUES (1, 'ปกติ', 1, 1, '2019-06-10 23:04:22', NULL, NULL);
INSERT INTO `bill_status` VALUES (2, 'ชำรุดเสียหาย', 1, 1, '2019-06-10 23:04:46', NULL, NULL);
INSERT INTO `bill_status` VALUES (3, 'ยกเลิก', 1, 1, '2019-06-10 23:04:57', NULL, NULL);
INSERT INTO `bill_status` VALUES (4, 'ยืนยันยกเลิก', 1, 1, '2019-06-10 23:06:15', NULL, NULL);
INSERT INTO `bill_status` VALUES (5, 'ยืนยันชำรุด', 1, 1, '2019-06-21 20:35:30', 1, '2019-06-21 20:35:43');

-- ----------------------------
-- Table structure for bill_status_charge
-- ----------------------------
DROP TABLE IF EXISTS `bill_status_charge`;
CREATE TABLE `bill_status_charge`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'สถานะบิล',
  `rstat` int(1) DEFAULT NULL COMMENT 'สถานะ',
  `create_by` bigint(20) DEFAULT NULL COMMENT 'สร้างโดย',
  `create_date` datetime(0) DEFAULT NULL COMMENT 'สร้างเมื่อ',
  `update_by` bigint(20) DEFAULT NULL COMMENT 'แก้ไขโดย',
  `update_date` datetime(0) DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bill_status_charge
-- ----------------------------
INSERT INTO `bill_status_charge` VALUES (5, 'ยังไม่เรียกเก็บ', 1, 1, '2019-06-10 23:10:49', NULL, NULL);
INSERT INTO `bill_status_charge` VALUES (6, 'วางบิล', 1, 1, '2019-06-10 23:10:57', NULL, NULL);
INSERT INTO `bill_status_charge` VALUES (7, 'ฝากเก็บเงิน', 1, 1, '2019-06-10 23:11:10', NULL, NULL);
INSERT INTO `bill_status_charge` VALUES (8, 'เก็บเงิน/เช็ค/โอน', 1, 1, '2019-06-10 23:11:15', NULL, NULL);
INSERT INTO `bill_status_charge` VALUES (9, 'ตัดบัญชีแล้ว', 1, 1, '2019-06-10 23:11:24', NULL, NULL);
INSERT INTO `bill_status_charge` VALUES (10, 'ยืนยันตัดบัญชีแล้ว', 1, 1, '2019-06-21 20:38:20', NULL, NULL);

-- ----------------------------
-- Table structure for bill_status_shipping
-- ----------------------------
DROP TABLE IF EXISTS `bill_status_shipping`;
CREATE TABLE `bill_status_shipping`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'สถานะบิล',
  `rstat` int(1) DEFAULT NULL COMMENT 'สถานะ',
  `create_by` bigint(20) DEFAULT NULL COMMENT 'สร้างโดย',
  `create_date` datetime(0) DEFAULT NULL COMMENT 'สร้างเมื่อ',
  `update_by` bigint(20) DEFAULT NULL COMMENT 'แก้ไขโดย',
  `update_date` datetime(0) DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bill_status_shipping
-- ----------------------------
INSERT INTO `bill_status_shipping` VALUES (1, 'ยังไม่จัดสินค้า', 1, 1, '2019-06-10 23:08:35', NULL, NULL);
INSERT INTO `bill_status_shipping` VALUES (2, 'จัดสินค้าแล้ว', 1, 1, '2019-07-11 18:09:47', NULL, NULL);
INSERT INTO `bill_status_shipping` VALUES (3, 'ส่งสินค้าแล้ว', 1, 1, '2019-06-10 23:08:43', 1, '2019-06-21 20:37:15');
INSERT INTO `bill_status_shipping` VALUES (7, 'ยกเลิก', 1, 1, '2019-06-10 23:08:53', 1, '2019-07-11 17:49:16');
INSERT INTO `bill_status_shipping` VALUES (8, 'ยืนยันยกเลิก', 1, 1, '2019-07-11 17:49:41', 1, '2019-06-10 23:08:53');
INSERT INTO `bill_status_shipping` VALUES (9, 'ยืนยันจัดส่งสินค้า', 1, 1, '2019-07-11 18:09:47', NULL, NULL);

-- ----------------------------
-- Table structure for bill_type
-- ----------------------------
DROP TABLE IF EXISTS `bill_type`;
CREATE TABLE `bill_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ประเภทบิล',
  `create_by` bigint(20) DEFAULT NULL COMMENT 'สร้างโดย',
  `create_date` datetime(0) DEFAULT NULL COMMENT 'สร้างเมื่อ',
  `update_by` bigint(20) DEFAULT NULL COMMENT 'แก้ไขโดย',
  `update_date` datetime(0) DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  `rstat` int(1) DEFAULT NULL COMMENT 'สถานะ',
  `type` int(1) DEFAULT NULL COMMENT 'ประเภท',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bill_type
-- ----------------------------
INSERT INTO `bill_type` VALUES (1, 'CR', 1, '2019-06-21 14:08:25', NULL, NULL, 1, 1);
INSERT INTO `bill_type` VALUES (2, 'CR/CRV', 1, '2019-06-21 14:11:51', NULL, NULL, 1, 1);
INSERT INTO `bill_type` VALUES (3, 'CRA', 1, '2019-06-21 14:11:58', NULL, NULL, 1, 2);
INSERT INTO `bill_type` VALUES (4, 'บิลแดง', 1, '2019-07-02 14:00:47', NULL, NULL, 1, 3);
INSERT INTO `bill_type` VALUES (5, 'บิลเขียว', 1, '2019-07-02 14:00:56', NULL, NULL, 1, 3);
INSERT INTO `bill_type` VALUES (6, 'บิลฟ้า', 1, '2019-07-02 14:01:08', NULL, NULL, 1, 3);
INSERT INTO `bill_type` VALUES (7, 'CR Bill', 1, '2019-07-02 14:01:18', NULL, NULL, 1, 2);
INSERT INTO `bill_type` VALUES (8, 'บิลดำ', 1, '2019-07-02 17:06:51', NULL, NULL, 1, 3);
INSERT INTO `bill_type` VALUES (9, 'บิลขา', 1, '2019-07-02 17:07:24', NULL, NULL, 1, 3);
INSERT INTO `bill_type` VALUES (10, 'บิลน้ำเงิน', 1, '2019-07-02 17:31:28', NULL, NULL, 1, 3);

-- ----------------------------
-- Table structure for core_options
-- ----------------------------
DROP TABLE IF EXISTS `core_options`;
CREATE TABLE `core_options`  (
  `option_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `option_label` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `option_value` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`option_name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of core_options
-- ----------------------------
INSERT INTO `core_options` VALUES ('backend_url', 'Backend Url', 'backend.dconhub.com');
INSERT INTO `core_options` VALUES ('brand_file_type', 'File Upload Brand', '[\"jpg\",\"jpeg\",\"png\",\"gif\"]');
INSERT INTO `core_options` VALUES ('brand_types', 'DropDown Brand', '{ \"1\": \"หมวดหมู่หลัก\", \"2\": \"หมวดหมู่ย่อย\"}');
INSERT INTO `core_options` VALUES ('category_types', 'DropDown Brand', '{ \"1\": \"หมวดสินค้าหลัก\", \"2\": \"หมวดสินค้าย่อย\"}');
INSERT INTO `core_options` VALUES ('cn_brand', 'แบรนด์บริษัท', 'บจก. ดํารงค์พานิช คอนสตรัคชั่น');
INSERT INTO `core_options` VALUES ('cn_brand_address', 'ที่อยู่บริษัท', '92 หมู่ที่ 21 ต.หัวขวาง อ.โกสุมพิสัย จ.มหาสารคาม');
INSERT INTO `core_options` VALUES ('cn_brand_address2', 'เบอร์โทรศัพท์', '043761599');
INSERT INTO `core_options` VALUES ('cn_condition', 'เงื่อนไขการสั่งซื้อ', 'ราคาวัสดุ เป็นราคารับหน้าโรงงาน ยังไม่รวมค่าขนส่ง\r\nกรณีเงื่อนไขส่งฟรี เมื่อดำเนินการกรอกที่อยู่จัดส่งแล้ว ทางเจ้าหน้าที่จะติดต่อกลับไปเพื่อแก้ไขราคาค่าขนส่งให้\r\nค่าขนส่งที่ระบบคำนวณอัตโนมัติให้หลังการใส่ที่อยู่ เป็นเพียงการประมาณการเท่านั้น ทางบริษัทขอสงวนสิทธิ์เปลี่ยนแปลงโดยไม่แจ้งให้ทราบล่วงหน้า');
INSERT INTO `core_options` VALUES ('doc_logo', 'Logo ในเอกสาร', 'https://bn1305files.storage.live.com/y4mvIe7_8afjHcCPf92XY_ODuQyQIaWa7gwItZHjNssnJZmDHTZPkjOnevua_1-qNw9FscoPXhNaWZAv4_xvHmTHIIxa4WugMKDIKzbL33loI7prfRlW9lfh-snk7On8wAnprjG1DE35fZh84TrQ33FwCd4indq55Viz49R-xh5wnAQxxJ7nDcydDEPuKqJfFByJBlbtyX-6L22bnUdwcdb6A/IMG_0199.JPG?psid=1&width=2016&height=1309');
INSERT INTO `core_options` VALUES ('how_to_pay', 'วิธีการสั่งซื้อ', '<h1>ตัวอย่างวิธีการสั่งซื้อ</h1><h2><img alt=\"\" src=\"https://storage.dconhub.com/images/5c49d10bd366c.png\" class=\"fr-fic fr-dii\" data-id=\"5c49d10bd366c.png\"><img alt=\"\" src=\"https://storage.dconhub.com/images/5c49d10e0cb8e.png\" class=\"fr-fic fr-dii\" data-id=\"5c49d10e0cb8e.png\"><img alt=\"\" src=\"https://storage.dconhub.com/images/5c49d10cb7b4e.png\" class=\"fr-fic fr-dii\" data-id=\"5c49d10cb7b4e.png\"><img alt=\"\" src=\"https://storage.dconhub.com/images/5c49d10b01855.png\" class=\"fr-fic fr-dii\" data-id=\"5c49d10b01855.png\"></h2><h2>วิธีการสั่งซื้อสินค้า</h2><p>ขั้นตอนการทำรายการสั่งซื้อ<br>ติดต่อสอบถามเพิ่มเติม กรุณาติดต่อ customer service center โทร&nbsp;<strong>02-308-4666</strong> หรือ&nbsp;<a href=\"mailto:ccare@cmart.co.th\" title=\"\">ccare@cmart.co.th</a></p><h3>1. เลือกสินค้าของคุณ</h3><p>คุณสามารถเลือกสินค้าที่คุณต้องการสั่งซื้อโดยการคลิกที่ปุ่ม&nbsp;<strong>&ldquo;หยิบใส่ตะกร้า&rdquo;</strong> หรือ หากคุณต้องการเลือกสินค้าเก็บไว้และชำระเงินภายหลัง ให้คลิกที่ปุ่ม &ldquo;เพิ่มรายการที่ชอบ&rdquo; ซึ่ง ณ ที่นี้ คุณต้องทำการเข้าสู่ระบบก่อน เพื่อที่ระบบจะได้บันทึกสินค้าไว้ใน &ldquo;สินค้าที่สนใจ&rdquo;</p><h3>2. ตรวจสอบหรือแก้ไขรายการสินค้า</h3><p>คุณสามารถทำการตรวจสอบหรือแก้ไขรายการสินค้าที่คุณต้องการสั่งซื้อได้ในหน้า&nbsp;<strong>&ldquo;ตะกร้าของฉัน&quot;</strong> หลังจากนั้นคลิกที่ปุ่ม &ldquo;สั่งซื้อสินค้า&rdquo; เพื่อดำเนินการ การสั่งซื้อสินค้า</p><h3>3. เลือกทำรายการสั่งซื้อสินค้า</h3><p>คุณสามารถเลือกได้ดังนี้<br><br><strong>ทำรายการโดยไม่เป็นสมาชิก:</strong> กรอกข้อมูลการเรียกเก็บเงิน และข้อมูลการจัดส่งสินค้าของคุณ โดยไม่ได้เป็นสมาชิกของ&nbsp;<a href=\"https://www.cmart.co.th/\" title=\"\"><strong>cmart.co.th</strong></a><br><br><strong>ลูกค้าใหม่:</strong> สำหรับการสั่งซื้อครั้งแรก เพียงกรอกข้อมูลการเรียกชำระเงิน และข้อมูลการจัดส่งสินค้าของคุณ โดยเป็นสมาชิกกับ&nbsp;<a href=\"https://www.cmart.co.th/\" title=\"\"><strong>cmart.co.th</strong></a> เพื่อให้ง่ายต่อการสั่งซื้อครั้งต่อไป และสะดวกต่อการติดตามการสั่งซื้อ นอกจากนี้ คุณยังสามารถสั่งซื้อสินค้าโดยเข้าสู่ระบบผ่านทางบัญชี Facebook ของคุณได้ง่ายๆ ทั้งนี้จะได้รับจดหมายข่าวสารและโปรโมชั่นที่ดีที่สุดที่เรามอบให้<br><br><strong>ลูกค้าเก่า:</strong> สำหรับลูกค้าที่เป็นสมาชิกกับ CMART ทำรายการสั่งซื้อผ่านระบบได้ง่ายๆ เพียงแค่เข้าสู่ระบบ โดยกรอกอีเมลและรหัสผ่าน และทำรายการสั่งซื้อโดยไม่ต้องกรอกข้อมูลอื่นๆเพิ่มเติม<br><br></p><h3>4. เลือกวิธีการจัดส่งสินค้า</h3><p>CMART มีตัวเลือกในการจัดส่ง 2 แบบ คือ ส่งแบบด่วน (<strong>Express</strong>) และ ส่งแบบธรรมดา (<strong>Standard</strong>) สำหรับแต่ละวิธีการจัดส่ง จะมีการคำนวณระยะทาง และน้ำหนักของสินค้า จากการยืนยันการสั่งซื้อของคุณ (คุณสามารถอ่านรายละเอียดเพิ่มเติมได้ที่หน้า&nbsp;<a href=\"https://www.cmart.co.th/shipping-policy\">&ldquo;วิธีการจัดส่งสินค้า&rdquo;</a>)</p><h3>5. เลือกวิธีการชำระเงิน</h3><p>คุณสามารถเลือกวิธีการชำระเงินได้หลากหลายวิธี เช่น เก็บเงินปลายทาง บัตรเครดิต/บัตรเดบิต ผ่านทางเคาน์เตอร์เซอร์วิส หรือผ่านทางระบบออนไลน์ ซึ่งมีบริษัท 2C2P เป็น<br>ผู้ดูแลระบบรักษาความปลอดภัย (คุณสามารถอ่านรายละเอียดเพิ่มเติมได้ที่หน้า&nbsp;<a href=\"https://www.cmart.co.th/payment-method\">&ldquo;ช่องทางการชำระเงิน&rdquo;</a>)<br>หากคุณมีรหัสคูปองส่วนลด คุณสามารถนำรหัสส่วนลดระบุในช่อง&nbsp;<strong>&ldquo;ใส่รหัสส่วนลด ถ้ามี&rdquo;</strong> และคลิก&nbsp;<strong>&ldquo;ใช้ส่วนลด&rdquo;<br></strong>และเมื่อคุณพร้อมทำการชำระเงินและสั่งซื้อสินค้า ให้คลิกที่ปุ่ม&nbsp;<strong>&ldquo;ซื้อสินค้า&rdquo;</strong></p><p>&nbsp;</p><h3>6. ยืนยันคำสั่งซื้อสินค้าทางอีเมล</h3><p>เมื่อคุณได้ทำรายการสั่งซื้อสินค้าเรียบร้อยแล้ว<br>คุณจะได้รับอีเมลเพื่อยืนยันคำสั่งซื้อสินค้าของคุณ วิธีการชำระเงินแบบ เรียกเก็บเงินปลายทาง ชำระเงินที่จุดรับสินค้า (Cash on Pick up Point)<br>กรุณาคลิกที่ &ldquo;ลิงค์ยืนยันคำสั่งซื้อ&rdquo; ตามลิงค์ที่แนบมาในอีเมลดังกล่าว<br>ภายใน 24 ชม. หากคุณไม่ดำเนินการ ภายในเวลาที่กำหนด<br>คำสั่งซื้อของคุณ จะถูกยกเลิกโดยอัตโนมัติ&nbsp;</p>');
INSERT INTO `core_options` VALUES ('logo', 'Logo', 'https://storage.dconhub.com/images/dconhub.png');
INSERT INTO `core_options` VALUES ('logo_text', 'Logo Text', 'https://storage.dconhub.com/images/logo_bg.JPG');
INSERT INTO `core_options` VALUES ('order_text_start', ' รหัสตัวหนังสือของใบเสนอราคา', 'QT');
INSERT INTO `core_options` VALUES ('order_txt', 'Order Text', 'BS');
INSERT INTO `core_options` VALUES ('page_about', 'About', '<p>เกี่ยวกับเรา นกน้อยทำรังแต่พอตัว</p><table style=\"width: 100%;\"><tbody><tr><td style=\"width: 50.0000%;\"><div style=\"text-align: center;\"><img src=\"https://storage.dconhub.com/images/5c2f5300dfbbe.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\" data-id=\"5c2f5300dfbbe.jpg\"></div></td><td style=\"width: 50.0000%;\"><span class=\"fr-video fr-fvc fr-dvb fr-draggable\" contenteditable=\"false\" draggable=\"true\"><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/-vqdW4IMTnE\" frameborder=\"0\" allowfullscreen=\"\" class=\"fr-draggable\"></iframe></span></td></tr></tbody></table><p>เราขาย <a href=\"http://www.shera.com/\" rel=\"noopener noreferrer\" target=\"_blank\">เฌอร่า</a> และ</p><p><br></p><p><span class=\"fr-emoticon fr-deletable fr-emoticon-img\" style=\"background: url(https://cdnjs.cloudflare.com/ajax/libs/emojione/2.0.1/assets/svg/1f623.svg);\">&nbsp;</span>&nbsp;</p><p><img src=\"https://storage.dconhub.com/images/5c2f54745480c.gif\" style=\"width: 300px;\" class=\"fr-fic fr-fil fr-rounded fr-dii\" data-id=\"5c2f54745480c.gif\">refd</p><p>sdsadsadsadsadsadsadsad</p><p>sadsadsadsadsadsadsadsadsa</p><p>sadsadsadsadsasdsadsadasdasd</p><p>refd</p><p>sdsadsadsadsadsadsadsad</p><p>sadsadsadsadsadsadsadsadsa</p><p>sadsadsadsadsasdsadsadasdasd</p><p>refd</p><p>sdsadsadsadsadsadsadsad</p><p>sadsadsadsadsadsadsadsadsa</p><p>sadsadsadsadsasdsadsadasdasd</p><p>refd</p><p>sdsadsadsadsadsadsadsad</p><p>sadsadsadsadsadsadsadsadsa</p><p>sadsadsadsadsasdsadsadasdasd</p><p><span class=\"fr-video fr-fvc fr-dvb fr-draggable\" contenteditable=\"false\" draggable=\"true\"><iframe width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/-vqdW4IMTnE?wmode=opaque\" frameborder=\"0\" allowfullscreen=\"\" class=\"fr-draggable\"></iframe></span>&nbsp;</p>');
INSERT INTO `core_options` VALUES ('page_contact', 'Contact', '<p>ติดต่อเรา เราคือใครเอ๋ย ให้ทาย</p><h3><span class=\"fr-video fr-fvc fr-dvb fr-draggable\" contenteditable=\"false\" draggable=\"true\">\r\n');

-- ----------------------------
-- Table structure for file_storage_item
-- ----------------------------
DROP TABLE IF EXISTS `file_storage_item`;
CREATE TABLE `file_storage_item`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `base_url` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `upload_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 119 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of file_storage_item
-- ----------------------------
INSERT INTO `file_storage_item` VALUES (106, 'fileStorage', 'http://shop.local/source', '1/HfSgZ0jHjBR0T5af6q5XkXKWyeyEuz7O.png', 'image/png', 3556, 'HfSgZ0jHjBR0T5af6q5XkXKWyeyEuz7O', '::1', 1535699641);
INSERT INTO `file_storage_item` VALUES (107, 'fileStorage', 'http://storage.shop.local/source', '1/OuRcwvxrOLzLzvWR5QBNn6No1vd-2yf5.png', 'image/png', 4679, 'OuRcwvxrOLzLzvWR5QBNn6No1vd-2yf5', '::1', 1535700807);
INSERT INTO `file_storage_item` VALUES (110, 'fileStorage', 'http://storage.exomethai.local/source', '1/FxbtooSVWmIcxSAvrkcYtZACnNSDvlk1.jpg', 'image/jpeg', 210392, 'FxbtooSVWmIcxSAvrkcYtZACnNSDvlk1', '::1', 1562218782);
INSERT INTO `file_storage_item` VALUES (112, 'fileStorage', 'http://storage.exomethai.local/source', '1/8lHe0DJg_oKoIiMUdS06fwasOkLe2lGx.jpg', 'image/jpeg', 223823, '8lHe0DJg_oKoIiMUdS06fwasOkLe2lGx', '::1', 1562230810);
INSERT INTO `file_storage_item` VALUES (113, 'fileStorage', 'http://storage.exomethai.local/source', '1/uCfEs_a84t96Ot6OqYGKGGhHo-ZQAixe.jpg', 'image/jpeg', 176544, 'uCfEs_a84t96Ot6OqYGKGGhHo-ZQAixe', '::1', 1563730622);
INSERT INTO `file_storage_item` VALUES (116, 'fileStorage', 'http://storage.exom.local/source', '1/H3dJrb4HKUeW0QiLrQovDNVg5mRaaUxs.jpg', 'image/jpeg', 63433, 'H3dJrb4HKUeW0QiLrQovDNVg5mRaaUxs', '::1', 1563779072);
INSERT INTO `file_storage_item` VALUES (117, 'fileStorage', 'http://storage.chanpan.local/source', '1/Uc6lM4KiyieX8JGp47yVSxAfHJREKiUV.jpg', 'image/jpeg', 45379, 'Uc6lM4KiyieX8JGp47yVSxAfHJREKiUV', '::1', 1563779324);
INSERT INTO `file_storage_item` VALUES (118, 'fileStorage', 'http://storage.chanpan.local/source', '1/eCRV6n9Zp7QpNFouPoO1zG_SjS6i4got.jpg', 'image/jpeg', 45379, 'eCRV6n9Zp7QpNFouPoO1zG_SjS6i4got', '::1', 1564327746);

-- ----------------------------
-- Table structure for files
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` bigint(20) DEFAULT NULL COMMENT 'รหัสบิล',
  `filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ชื่อไฟล์',
  `filepath` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ที่อยู่ไฟล์',
  `create_at` bigint(20) DEFAULT NULL COMMENT 'สร้างโดย',
  `create_date` datetime(0) DEFAULT NULL COMMENT 'สร้างเมื่อ',
  `update_at` bigint(20) DEFAULT NULL COMMENT 'แก้ไขโดย',
  `update_date` datetime(0) DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  `rstat` int(1) DEFAULT NULL COMMENT 'สถานะ',
  `billtype` int(255) DEFAULT NULL COMMENT 'ประเภทบิล',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of files
-- ----------------------------
INSERT INTO `files` VALUES (30, 3, '1562064045006001700.jpg', 'C:\\wamp64\\www\\bill/storage/web/uploads/', 1, '2019-07-02 17:40:45', NULL, NULL, 1, 9);
INSERT INTO `files` VALUES (31, 3, '1562064090065764800.jpg', 'C:\\wamp64\\www\\bill/storage/web/uploads/', 1, '2019-07-02 17:41:30', NULL, NULL, 1, 9);
INSERT INTO `files` VALUES (32, 1562325569075325000, '1562325589012626200.jpg', 'C:\\wamp64\\www\\bill/storage/web/uploads/', 1, '2019-07-05 18:19:49', NULL, NULL, 1, 10);
INSERT INTO `files` VALUES (33, 1562325569075325000, '1562325599091847200.jpg', 'C:\\wamp64\\www\\bill/storage/web/uploads/', 1, '2019-07-05 18:19:59', NULL, NULL, 1, 8);
INSERT INTO `files` VALUES (34, 1562325708099295800, '1562326179010657300.jpg', 'C:\\wamp64\\www\\bill/storage/web/uploads/', 1, '2019-07-05 18:29:39', NULL, NULL, 1, 10);
INSERT INTO `files` VALUES (35, 1562326264048651000, '1562326285087874100.jpg', 'C:\\wamp64\\www\\bill/storage/web/uploads/', 1, '2019-07-05 18:31:25', NULL, NULL, 1, 10);
INSERT INTO `files` VALUES (36, 1562326327073355000, '1562326350023825800.jpg', 'C:\\wamp64\\www\\bill/storage/web/uploads/', 1, '2019-07-05 18:32:30', NULL, NULL, 1, 5);
INSERT INTO `files` VALUES (37, 1562326631089417700, '1562326656027411800.jpg', 'C:\\wamp64\\www\\bill/storage/web/uploads/', 1, '2019-07-05 18:37:36', NULL, NULL, 1, 5);
INSERT INTO `files` VALUES (38, 1562326928048361300, '1562326948015404100.jpg', 'C:\\wamp64\\www\\bill/storage/web/uploads/', 1, '2019-07-05 18:42:28', NULL, NULL, 1, 10);
INSERT INTO `files` VALUES (39, 1562326928048361300, '1562327001028665700.jpg', 'C:\\wamp64\\www\\bill/storage/web/uploads/', 1, '2019-07-05 18:43:21', NULL, NULL, 1, 9);
INSERT INTO `files` VALUES (40, 1562833781078806000, '1562833800045204600.jpg', 'C:\\wamp64\\www\\bill_core/storage/web/uploads/', 1, '2019-07-11 15:30:00', NULL, NULL, 1, 10);
INSERT INTO `files` VALUES (41, 1562326928048361300, '1564330426082766500.jpg', 'C:\\wamp64\\www\\project\\chanpan_master/storage/web/uploads/', 1, '2019-07-28 23:13:46', NULL, NULL, 1, 9);
INSERT INTO `files` VALUES (42, 1562326928048361300, '1564330438085171700.jpg', 'C:\\wamp64\\www\\project\\chanpan_master/storage/web/uploads/', 1, '2019-07-28 23:13:58', NULL, NULL, 1, 9);

-- ----------------------------
-- Table structure for informations
-- ----------------------------
DROP TABLE IF EXISTS `informations`;
CREATE TABLE `informations`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ไตเติ้ล',
  `detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'รายละเอียด',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'รูปขนาดย่อย',
  `rstat` int(1) DEFAULT NULL COMMENT 'สถานะ',
  `create_by` bigint(20) DEFAULT NULL COMMENT 'สร้างโดย',
  `create_date` datetime(0) DEFAULT NULL COMMENT 'สร้างเมื่อ',
  `update_by` bigint(20) DEFAULT NULL COMMENT 'แก้ไขโดย',
  `update_date` datetime(0) DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `parent`(`parent`) USING BTREE,
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration`  (
  `version` varchar(180) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', 1535696053);
INSERT INTO `migration` VALUES ('m140209_132017_init', 1535696058);
INSERT INTO `migration` VALUES ('m140403_174025_create_account_table', 1535696059);
INSERT INTO `migration` VALUES ('m140504_113157_update_tables', 1535696063);
INSERT INTO `migration` VALUES ('m140504_130429_create_token_table', 1535696064);
INSERT INTO `migration` VALUES ('m140830_171933_fix_ip_field', 1535696065);
INSERT INTO `migration` VALUES ('m140830_172703_change_account_table_name', 1535696065);
INSERT INTO `migration` VALUES ('m141222_110026_update_ip_field', 1535696065);
INSERT INTO `migration` VALUES ('m141222_135246_alter_username_length', 1535696066);
INSERT INTO `migration` VALUES ('m150614_103145_update_social_account_table', 1535696068);
INSERT INTO `migration` VALUES ('m150623_212711_fix_username_notnull', 1535696068);
INSERT INTO `migration` VALUES ('m151218_234654_add_timezone_to_profile', 1535696069);
INSERT INTO `migration` VALUES ('m160929_103127_add_last_login_at_to_user_table', 1535696069);
INSERT INTO `migration` VALUES ('m140602_111327_create_menu_table', 1535696117);
INSERT INTO `migration` VALUES ('m160312_050000_create_user', 1535696117);
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', 1535696133);
INSERT INTO `migration` VALUES ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1535696133);

-- ----------------------------
-- Table structure for options
-- ----------------------------
DROP TABLE IF EXISTS `options`;
CREATE TABLE `options`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Label',
  `value` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Value',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of options
-- ----------------------------
INSERT INTO `options` VALUES (1, 'about', '<p>ใส่ข้อมูลเกี่ยวกับเราที่นี่</p><p><img src=\"http://storage.chanpan.local/images/5d356b73d425c.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\" data-id=\"5d356b73d425c.jpg\"></p><p><img src=\"http://storage.chanpan.local/images/5d35751a6cfff.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\" data-id=\"5d35751a6cfff.jpg\"></p>');
INSERT INTO `options` VALUES (2, 'contact', '<p>ใส่ข้อมูลติดต่อเราที่นี่</p>');
INSERT INTO `options` VALUES (3, 'initial_name_app', 'BILL\r\n');
INSERT INTO `options` VALUES (4, 'name_app', 'Billing Manager\r\n');
INSERT INTO `options` VALUES (5, 'storageUrl', 'http://storage.chanpan.local/');
INSERT INTO `options` VALUES (6, 'home', '<p>ใส่ข้อมูลเกี่ยวกับหน้าหลักที่นี่</p><p><br></p>');
INSERT INTO `options` VALUES (7, 'footer', 'Footer');
INSERT INTO `options` VALUES (9, 'skin', 'skin-red-light');

-- ----------------------------
-- Table structure for profile
-- ----------------------------
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile`  (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `timezone` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_base_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sitecode` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE,
  CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of profile
-- ----------------------------
INSERT INTO `profile` VALUES (1, 'nuttaphon chanpan', 'chanpan.nuttaphon1993@gmail.com', 'chanpan.nuttaphon1993@gmail.com', 'd70f6226ff8caba303baede9f0892c0e', '', '', '07/08/1993', NULL, 'nuttaphon', 'chanpan', '0650859480', '1/eCRV6n9Zp7QpNFouPoO1zG_SjS6i4got.jpg', 'http://storage.chanpan.local/source', NULL);
INSERT INTO `profile` VALUES (2, NULL, 'user@gmail.com', 'user@gmail.com', 'cba1f2d695a5ca39ee6f343297a761a4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `profile` VALUES (3, 'user2 user2', 'user2@gmail.com', 'user2@gmail.com', 'fa7c3fcb670a58aa3e90a391ea533c99', NULL, NULL, '', NULL, 'user2', 'user2', ' ', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for sell_bill
-- ----------------------------
DROP TABLE IF EXISTS `sell_bill`;
CREATE TABLE `sell_bill`  (
  `docno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `docdate` date DEFAULT NULL,
  `doctime` time(0) DEFAULT NULL,
  `refdate` date DEFAULT NULL,
  `customerno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `customername` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `totalprice` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `netprice` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`docno`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sell_bill
-- ----------------------------
INSERT INTO `sell_bill` VALUES ('CR1904-00541', '2019-04-30', '08:10:00', '2019-04-30', 'AR8-0336', 'นายเจริญ (ฟาร์มควาย)', '3960', '3960');
INSERT INTO `sell_bill` VALUES ('CR1904-00549', '2019-04-30', '09:32:00', '2019-04-30', 'AR8-0091', 'แอ๊ท บ้านแก่งโกสุม ม.8', '3498', '3498');

-- ----------------------------
-- Table structure for sell_items
-- ----------------------------
DROP TABLE IF EXISTS `sell_items`;
CREATE TABLE `sell_items`  (
  `docno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `itemcode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `itemname` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `treasury` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `storage` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `unit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `unitprice` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `unitdiscount` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `totaldiscount` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `netprice` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `taxtype` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`docno`, `itemcode`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sell_items
-- ----------------------------
INSERT INTO `sell_items` VALUES ('CR1904-00541', '050-101002060100', 'หน้าต่างทึบแข็ง  60*100*4\"', '001', '001', '030~บาน', '4', '990', '', '0', '3960', 'V');
INSERT INTO `sell_items` VALUES ('CR1904-00549', '010-80128303030', 'ตะแกรงเหล็ก@ 30*30ซม.3.00*50ม.2.8มม. พ่นฟ้า', '001', '004', '047~ม้วน', '1', '1800', '', '0', '1800', 'V\r');
INSERT INTO `sell_items` VALUES ('CR1904-00549', '110-003085012', 'ท่อ PVC   (ชั้น8.5)  #1/2\"  ตรานกอินทรีย์', '001', '002', '011~เส้น', '5', '32', '', '0', '160', 'V\r');
INSERT INTO `sell_items` VALUES ('CR1904-00549', '110-003085200', 'ท่อ PVC  (ชั้น8.5)  #2\"  ตรานกอินทรีย์ บานหัว', '001', '001', '011~เส้น', '1', '140', '', '0', '140', 'V\r');
INSERT INTO `sell_items` VALUES ('CR1904-00549', '110-003085400', 'ท่อ PVC  (ชั้น8.5)  #4\"  ตรานกอินทรีย์ บานหัว', '001', '002', '011~เส้น', '1', '540', '', '0', '540', 'V\r');
INSERT INTO `sell_items` VALUES ('CR1904-00549', '110-105010012', 'ข้องอ90 PVC  # 1/2\"', '001', '001', '003~ตัว', '10', '5', '', '0', '50', 'V\r');
INSERT INTO `sell_items` VALUES ('CR1904-00549', '110-105010200', 'ข้องอ90 PVC  #2\"(หนา)', '001', '001', '003~ตัว', '2', '25', '', '0', '50', 'V\r');
INSERT INTO `sell_items` VALUES ('CR1904-00549', '110-105010400', 'ข้องอ90 PVC  #4\"(หนา)', '001', '001', '003~ตัว', '2', '220', '', '0', '440', 'V\r');
INSERT INTO `sell_items` VALUES ('CR1904-00549', '110-108010012', 'เกลียวใน PVC  # 1/2\"', '001', '001', '003~ตัว', '8', '6', '', '0', '48', 'V\r');
INSERT INTO `sell_items` VALUES ('CR1904-00549', '110-110010012', 'เกลียวนอก  PVC  # 1/2\"', '001', '001', '003~ตัว', '5', '6', '', '0', '30', 'V\r');
INSERT INTO `sell_items` VALUES ('CR1904-00549', '110-111010012', 'สามทาง PVC  #1/2\" (หนา)', '001', '001', '003~ตัว', '10', '8', '', '0', '80', 'V\r');
INSERT INTO `sell_items` VALUES ('CR1904-00549', '110-501250001', 'น้ำยาทาท่อ PVC # 250g ตราช้าง', '001', '001', '024~กระป๋อง', '1', '160', '', '0', '160', 'V');

-- ----------------------------
-- Table structure for sell_shipping
-- ----------------------------
DROP TABLE IF EXISTS `sell_shipping`;
CREATE TABLE `sell_shipping`  (
  `groupcond` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `groupname` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `percent` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`groupcond`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sell_shipping
-- ----------------------------
INSERT INTO `sell_shipping` VALUES ('010-%', 'เหล็ก', '0.05');
INSERT INTO `sell_shipping` VALUES ('040-%', 'ไม้ฝาเฌอร่า', '0.01');
INSERT INTO `sell_shipping` VALUES ('050-%', 'ประตู หน้าต่าง', '0.01');
INSERT INTO `sell_shipping` VALUES ('110-%', 'ท่อพีวีซี', '0.02');

-- ----------------------------
-- Table structure for skin
-- ----------------------------
DROP TABLE IF EXISTS `skin`;
CREATE TABLE `skin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `default` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of skin
-- ----------------------------
INSERT INTO `skin` VALUES (1, 'Blue', 'skin-blue', NULL);
INSERT INTO `skin` VALUES (2, 'Black', 'skin-black', NULL);
INSERT INTO `skin` VALUES (3, 'Purple', 'skin-purple', NULL);
INSERT INTO `skin` VALUES (4, 'Green', 'skin-green', NULL);
INSERT INTO `skin` VALUES (5, 'Red', 'skin-red', NULL);
INSERT INTO `skin` VALUES (6, 'Yellow', 'skin-yellow', NULL);
INSERT INTO `skin` VALUES (7, 'Blue Light', 'skin-blue-light', NULL);
INSERT INTO `skin` VALUES (8, 'Black Light', 'skin-black-light', NULL);
INSERT INTO `skin` VALUES (9, 'Purple Light', 'skin-purple-light', NULL);
INSERT INTO `skin` VALUES (10, 'Green Light', 'skin-green-light', NULL);
INSERT INTO `skin` VALUES (11, 'Red Light', 'skin-red-light', 1);
INSERT INTO `skin` VALUES (12, 'Yellow Light', 'skin-yellow-light', NULL);

-- ----------------------------
-- Table structure for social_account
-- ----------------------------
DROP TABLE IF EXISTS `social_account`;
CREATE TABLE `social_account`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `account_unique`(`provider`, `client_id`) USING BTREE,
  UNIQUE INDEX `account_unique_code`(`code`) USING BTREE,
  INDEX `fk_user_account`(`user_id`) USING BTREE,
  CONSTRAINT `social_account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for token
-- ----------------------------
DROP TABLE IF EXISTS `token`;
CREATE TABLE `token`  (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE INDEX `token_unique`(`user_id`, `code`, `type`) USING BTREE,
  CONSTRAINT `token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT 0,
  `last_login_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_unique_username`(`username`) USING BTREE,
  UNIQUE INDEX `user_unique_email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', 'chanpan.nuttaphon1993@gmail.com', '$2y$12$obnECeQ6R8r.lamu.Kdmo.S2OTh1Dh9TvsvfSpGQfpBChgFs3Tz6K', 'KSwmb0yFT6Jf14f82pSAnAedCN44uzAQ', 1535696234, NULL, NULL, '::1', 1535696234, 1535696234, 0, 1564330784);
INSERT INTO `user` VALUES (2, 'user', 'user@gmail.com', '$2y$12$XQqiA43J1Z9/yIfWc4N9lexmEpDatvryHr15PQ1f1udsM8ipsdldi', 'SIMHVxx-zsO9MyC9gN_ZxsolYakw9_5G', 1562226672, NULL, NULL, '::1', 1562226673, 1562226673, 0, 1562227547);
INSERT INTO `user` VALUES (3, 'user2', 'user2@gmail.com', '$2y$12$DTf.7SbmW8wmbdDBfB70deB6jIFRZrdU094K/VDUOF0d8Td2C0lRe', '_-aO2DARP_wh1gyK_XsE-DASfU5KkWDn', 1562228852, NULL, NULL, '::1', 1562228852, 1562228852, 0, NULL);

-- ----------------------------
-- Table structure for user_percent
-- ----------------------------
DROP TABLE IF EXISTS `user_percent`;
CREATE TABLE `user_percent`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` bigint(20) NOT NULL,
  `driver` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'คนขับ',
  `customer` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ลูกน้อง',
  `default` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_percent
-- ----------------------------
INSERT INTO `user_percent` VALUES (1, 1562326928048361300, '', '30', 1);
INSERT INTO `user_percent` VALUES (2, 1562833781078806000, '20', '30', 1);

-- ----------------------------
-- Table structure for user_sippings
-- ----------------------------
DROP TABLE IF EXISTS `user_sippings`;
CREATE TABLE `user_sippings`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL COMMENT 'ผู้ใช้',
  `parent_id` int(11) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `rstat` int(1) DEFAULT NULL,
  `create_by` bigint(20) DEFAULT NULL,
  `create_date` datetime(0) DEFAULT NULL,
  `upddate_by` bigint(20) DEFAULT NULL,
  `update_date` datetime(0) DEFAULT NULL,
  `percent` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_sippings
-- ----------------------------
INSERT INTO `user_sippings` VALUES (21, 1562326928048361300, 1, NULL, 1, 1, 1, '2019-07-12 18:56:38', NULL, NULL, '0.30');
INSERT INTO `user_sippings` VALUES (22, 1562326928048361300, 2, 21, 2, 1, 1, '2019-07-12 18:56:43', NULL, NULL, '0.30');
INSERT INTO `user_sippings` VALUES (23, 1562833781078806000, 1, NULL, 1, 1, 1, '2019-07-12 19:03:46', NULL, NULL, '0.30');
INSERT INTO `user_sippings` VALUES (24, 1562833781078806000, 3, 23, 2, 3, 1, '2019-07-12 19:04:04', NULL, NULL, '0.30');
INSERT INTO `user_sippings` VALUES (25, 1562833781078806000, 1, NULL, 1, 3, 1, '2019-07-12 19:54:47', NULL, NULL, '0.30');
INSERT INTO `user_sippings` VALUES (26, 1562833781078806000, 2, 23, 2, 3, 1, '2019-07-12 19:54:59', NULL, NULL, '0.30');
INSERT INTO `user_sippings` VALUES (27, 1562833781078806000, 3, 23, 2, 1, 1, '2019-07-12 19:55:04', NULL, NULL, '0.30');
INSERT INTO `user_sippings` VALUES (28, 1562833781078806000, 2, 23, 2, 1, 1, '2019-07-12 19:55:54', NULL, NULL, '0.30');
INSERT INTO `user_sippings` VALUES (29, 1562326928048361300, 3, 21, 2, 1, 1, '2019-07-12 20:01:30', NULL, NULL, '0.30');

SET FOREIGN_KEY_CHECKS = 1;

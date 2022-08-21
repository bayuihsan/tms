/*
SQLyog Ultimate v12.5.1 (32 bit)
MySQL - 10.5.16-MariaDB-cll-lve : Database - u8824069_tms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`u8824069_tms` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `u8824069_tms`;

/*Table structure for table `par_user_role` */

DROP TABLE IF EXISTS `par_user_role`;

CREATE TABLE `par_user_role` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(100) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `par_user_role` */

insert  into `par_user_role`(`id_role`,`nama_role`,`is_active`) values 
(1,'Admin',1),
(2,'Member',1),
(3,'Consultant',1);

/*Table structure for table `project_list` */

DROP TABLE IF EXISTS `project_list`;

CREATE TABLE `project_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `manager_id` int(30) NOT NULL,
  `user_ids` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `project_list` */

insert  into `project_list`(`id`,`name`,`description`,`status`,`start_date`,`end_date`,`manager_id`,`user_ids`,`date_created`) values 
(1,'Sample Project','														&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. In elementum, metus vitae malesuada mollis, urna nisi luctus ligula, vitae volutpat massa eros eu ligula. Nunc dui metus, iaculis id dolor non, luctus tristique libero. Aenean et sagittis sem. Nulla facilisi. Mauris at placerat augue. Nullam porttitor felis turpis, ac varius eros placerat et. Nunc ut enim scelerisque, porta lacus vitae, viverra justo. Nam mollis turpis nec dolor feugiat, sed bibendum velit placerat. Etiam in hendrerit leo. Nullam mollis lorem massa, sit amet tincidunt dolor lacinia at.&lt;/span&gt;												',5,'2020-11-03','2021-01-20',2,'4,5','2020-12-03 09:56:56'),
(2,'Sample Project 102','																		Sample Only															',0,'2022-08-17','2020-12-31',2,'4,5','2020-12-03 13:51:54'),
(3,'data.txt','d											',0,'2022-08-19','2022-08-19',10,'5','2022-08-19 18:05:13'),
(4,'dd','						dss',3,'2022-08-19','2022-08-19',10,'11','2022-08-19 18:05:50');

/*Table structure for table `schedule_list` */

DROP TABLE IF EXISTS `schedule_list`;

CREATE TABLE `schedule_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `id_user` varchar(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

/*Data for the table `schedule_list` */

insert  into `schedule_list`(`id`,`title`,`description`,`start_datetime`,`end_datetime`,`id_user`,`status`) values 
(29,'modul dashboard','page dashboard','2022-08-18 06:34:00','2022-08-19 22:34:00','1','3'),
(30,'modul project','add new project, list project','2022-08-13 09:12:00','2022-08-14 22:36:00','1','3'),
(31,'modul task list','add new task, edit task list','2022-08-14 09:38:00','2022-08-15 22:38:00','1','1'),
(32,'modul user','CRUD','2022-08-16 08:39:00','2022-08-17 22:39:00','1','3'),
(33,'modul calendar','CRUD','2022-08-17 22:40:00','2022-08-19 22:40:00','1','3'),
(34,'modul role','CRUD','2022-08-16 09:40:00','2022-08-17 22:41:00','1','3'),
(35,'modul manage account','update','2022-08-17 08:50:00','2022-08-18 22:51:00','1','3'),
(36,'tes','datass','2022-08-20 17:28:00','2022-08-23 17:28:00','1','3');

/*Table structure for table `system_settings` */

DROP TABLE IF EXISTS `system_settings`;

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `system_settings` */

insert  into `system_settings`(`id`,`name`,`email`,`contact`,`address`,`cover_img`) values 
(1,'Task Management System','info@sample.comm','+6948 8542 623','2102  Caldwell Road, Rochester, New York, 14608','');

/*Table structure for table `tabel_menu` */

DROP TABLE IF EXISTS `tabel_menu`;

CREATE TABLE `tabel_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `page` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `have_child` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tabel_menu` */

insert  into `tabel_menu`(`id_menu`,`nama_menu`,`url`,`page`,`icon`,`parent`,`have_child`,`is_active`) values 
(1,'Dashboard',NULL,NULL,'nav-icon fas fa fa-th-large',0,0,0),
(2,'Projects','./index.php?page=project_list',NULL,'nav-icon fas fa-layer-group',0,0,1),
(3,'Add New','./index.php?page=new_project','new_project','fas fa-angle-right nav-icon',2,0,0),
(4,'List','./index.php?page=project_list','project_list','fas fa-angle-right nav-icon',2,0,0),
(5,'Task','./index.php?page=task_list','task_list','fa fa-file nav-icon',0,0,1),
(6,'Users','./index.php?page=user_list',NULL,'nav-icon fas fa-users',0,0,1),
(7,'Add New','./index.php?page=new_user','new_user','fas fa-angle-right nav-icon',6,0,0),
(8,'List','./index.php?page=user_list','user_list','fas fa-angle-right nav-icon',6,0,0),
(17,'Calender','./index.php?page=calender','calendar','fa fa-calendar nav-icon',0,0,1),
(18,'Role','./index.php?page=role','role','nav-icon fas fa-user',0,0,1);

/*Table structure for table `tabel_role` */

DROP TABLE IF EXISTS `tabel_role`;

CREATE TABLE `tabel_role` (
  `id_menu` int(11) NOT NULL,
  `id_tabel_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tabel_role` */

insert  into `tabel_role`(`id_menu`,`id_tabel_role`) values 
(1,1),
(2,1),
(5,1),
(6,1),
(7,1),
(8,1),
(13,1),
(17,1),
(18,1),
(17,3),
(1,2),
(1,3),
(2,2),
(3,2),
(4,2),
(5,2),
(17,2),
(2,3),
(4,3),
(5,3);

/*Table structure for table `task_list` */

DROP TABLE IF EXISTS `task_list`;

CREATE TABLE `task_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `project_id` int(30) NOT NULL,
  `task` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

/*Data for the table `task_list` */

insert  into `task_list`(`id`,`project_id`,`task`,`description`,`status`,`date_created`) values 
(1,1,'Sample Task 1','				coba task 1',3,'2020-12-03 11:08:58'),
(2,1,'Sample Task 2','								Sample Task 2													',3,'2020-12-03 13:50:15'),
(3,2,'Task Test','				Sample			',2,'2020-12-03 13:52:25'),
(5,3,'dddd','				dd			',3,'2022-08-19 18:06:24'),
(6,4,'ddd','dd',2,'2022-08-19 18:25:46'),
(7,3,'add menu','								menu calendar						',3,'2022-08-19 18:42:46'),
(23,1,'ee','fe',2,'2022-08-20 17:07:38'),
(24,2,'e','				e						',2,'2022-08-20 17:07:50'),
(25,3,'tes add task','								oke						',3,'2022-08-21 15:03:18');

/*Table structure for table `user_productivity` */

DROP TABLE IF EXISTS `user_productivity`;

CREATE TABLE `user_productivity` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `project_id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `subject` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `user_id` int(30) NOT NULL,
  `time_rendered` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_productivity` */

insert  into `user_productivity`(`id`,`project_id`,`task_id`,`comment`,`subject`,`date`,`start_time`,`end_time`,`user_id`,`time_rendered`,`date_created`) values 
(1,1,1,'tes','Sample Progress','2020-12-03','08:00:00','10:00:00',1,2,'2020-12-03 12:13:28'),
(2,1,1,'							Sample Progress						','Sample Progress 2','2020-12-03','13:00:00','14:00:00',1,1,'2020-12-03 13:48:28'),
(3,1,2,'							Sample						','Test','2020-12-03','08:00:00','09:00:00',5,1,'2020-12-03 13:57:22'),
(4,1,2,'asdasdasd','Sample Progress','2020-12-02','08:00:00','10:00:00',2,2,'2020-12-03 14:36:30'),
(5,2,3,'check progress','add productivity','2022-08-17','11:19:00','17:25:00',1,6.1,'2022-08-17 11:19:18'),
(6,3,5,'													','v','2022-08-19','18:11:00','20:11:00',10,2,'2022-08-19 18:11:54'),
(7,3,5,'k																										','v','2022-08-20','22:25:00','22:30:00',1,0.0833333,'2022-08-19 22:25:04'),
(9,3,25,'menambahkan calendar','add pembina task','2022-08-21','01:48:00','23:48:00',5,22,'2022-08-21 15:49:22'),
(10,2,24,'add project','add project','2022-08-21','05:11:00','23:11:00',2,18,'2022-08-21 20:11:31');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = admin, 2 = staff',
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `colorSchema` varchar(100) DEFAULT NULL,
  `background` varchar(100) DEFAULT NULL,
  `sidebar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`id`,`firstname`,`lastname`,`email`,`password`,`type`,`avatar`,`date_created`,`colorSchema`,`background`,`sidebar`) values 
(1,'Administrator','','admin@admin.com','0192023a7bbd73250516f069df18b500',1,'1660628520_Acer_Wallpaper_01_5000x2814.jpg','2020-11-26 10:57:04','#b80000','#FFFFFF','#FFFFFF'),
(2,'John','Smith','jsmith@sample.com','e10adc3949ba59abbe56e057f20f883e',2,'1606978560_avatar.jpg','2020-12-03 09:26:03',NULL,NULL,NULL),
(4,'Pembina','s','pembina1@sample.com','e10adc3949ba59abbe56e057f20f883e',3,'1606963560_avatar.jpg','2020-12-03 10:46:41',NULL,'',NULL),
(5,'Pembina','User 2','pembina2@sample.com','e10adc3949ba59abbe56e057f20f883e',3,'1606963620_47446233-clean-noir-et-gradient-sombre-image-de-fond-abstrait-.jpg','2020-12-03 10:47:06','#719664','#FFFFFF','#FFFFFF'),
(10,'Direktur','User','direktur@sample.com','e10adc3949ba59abbe56e057f20f883e',2,'1660705380_moonton.jpg','2022-08-17 10:03:02',NULL,NULL,NULL),
(11,'tes','tesss','tes123@gmail.com','e10adc3949ba59abbe56e057f20f883e',3,'1660904460_avatar.jpg','2022-08-19 17:21:42',NULL,NULL,NULL),
(12,'Elang','y','elang@admin.com','0192023a7bbd73250516f069df18b500',3,'no-image-available.png','2022-08-21 20:26:19',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- DATABASE: dolphin_crm
DROP DATABASE IF EXISTS dolphin_crm;
CREATE DATABASE dolphin_crm;
USE dolphin_crm;

-- TABLES - create
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INTEGER(11) AUTO_INCREMENT,
  `firstname` VARCHAR(255),
  `lastname` VARCHAR(255),
  `password` VARCHAR(255),
  `email` VARCHAR(255),
  `role` VARCHAR(255),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` INTEGER(11) AUTO_INCREMENT,
  `title` VARCHAR(255),
  `firstname` VARCHAR(255),
  `lastname` VARCHAR(255),
  `email` VARCHAR(255),
  `telephone` VARCHAR(255),
  `company` VARCHAR(255),
  `type` VARCHAR(255), -- whether Sales Lead or Support
  `assigned_to` INTEGER(11), -- store appriate user_id
  `created_by` INTEGER(11), -- store appriate user_id
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`assigned_to`) REFERENCES `users`(`id`),
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`)
);

DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` INTEGER(11) AUTO_INCREMENT,
  `contact_id` INTEGER(11),
  `comment` TEXT,
  `created_by` INTEGER(11), -- store appriate user_id
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`contact_id`) REFERENCES `contacts`(`id`),
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`)
);


-- TABLES - insert
-- INSERT INTO `users` (`firstname`, `lastname`, `password`, `email`, `role`) 
-- VALUES ('Admin', 'Admin', 'password123', 'admin@project2.com', 'admin');
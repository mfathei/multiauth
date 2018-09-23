CREATE SCHEMA `multiauth` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;


/*
-- Query: SELECT * FROM multiauth.admins
LIMIT 0, 50000

-- Date: 2018-09-23 21:23
*/
INSERT INTO `admins` (`id`,`name`,`job_title`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'mahdy','manager','oracle.dev10g@gmail.com',NULL,'$2y$10$c5qJG1vVbUN28voGrM6RDOCYOhn7E5ne0beBBCdjSf/0QWracmuOS','8p6RrYy04aMrPblsJDXlbl2SQSBPQRijQqTbWfeUmKS21mW54gYku0UiKyrc','2018-09-23 12:11:45','2018-09-23 19:18:17');


UPDATE `multiauth`.`admins` SET `email` = 'oracle.dev10g@gmail.com' WHERE (`id` = '1');



CREATE TABLE IF NOT EXISTS `iscwiki`.`main_pages` (
	`page_id` INT NOT NULL ,
	`course_name` VARCHAR(50) NOT NULL,
	`course_code` VARCHAR(10) NULL,
	PRIMARY KEY(`page_id`)
);

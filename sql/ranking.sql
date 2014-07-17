SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- user作成
--grant all privileges ON f1.* TO f1@localhost identified by 'f120140715';
--grant all privileges ON f1.* TO f1@d2cmac019.ac.d2c.co.jp identified by 'f120140715';


CREATE SCHEMA IF NOT EXISTS `f1` DEFAULT CHARACTER SET utf8 ;
USE `f1` ;

create table d_contents (
    `id`                int(11)       NOT NULL,
    `contents_id`       varchar(255)  NOT NULL,
    `site_name`         varchar(255)  NOT NULL,
    `created_at`        timestamp     default 0,
    `summary`           varchar(255),
    `content`           text,
    `detail_url`        varchar(255),
    `source`            varchar(255),
    `user_id`           varchar(255),
    `user_name`         varchar(255),
    `user_screen_name`  varchar(255),
    `user_created_at`   timestamp,
    `insert_date` timestamp default CURRENT_TIMESTAMP,
    `update_date` timestamp,
    `delete_flg`  tinyint(1)   default 0,
    primary key (`id`),
    UNIQUE(`contents_id`, `site_name`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;


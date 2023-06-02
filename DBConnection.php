<?php
if(!is_dir(__DIR__.'./db'))
    mkdir(__DIR__.'./db');
if(!defined('db_file')) define('db_file',__DIR__.'./db/employment_db.db');
function my_udf_md5($string) {
    return md5($string);
}

Class DBConnection extends SQLite3{
    protected $db;
    function __construct(){
        $this->open(db_file);
        $this->createFunction('md5', 'my_udf_md5');
        $this->exec("PRAGMA foreign_keys = ON;");

        $this->exec("CREATE TABLE IF NOT EXISTS `user_list` (
            `user_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `fullname` INTEGER NOT NULL,
            `username` TEXT NOT NULL,
            `password` TEXT NOT NULL,
            `type` INTEGER NOT NULL Default 1,
            `status` INTEGER NOT NULL Default 1,
            `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"); 

        //User Comment
        // Type = [ 1 = Administrator, 2 = Cashier]
        // Status = [ 1 = Active, 2 = Inactive]

        $this->exec("CREATE TABLE IF NOT EXISTS `department_list` (
            `department_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `name` TEXT NOT NULL,
            `description` TEXT NOT NULL 
        ) ");
        $this->exec("CREATE TABLE IF NOT EXISTS `designation_list` (
            `designation_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `department_id` INTEGER NOT NULL,
            `name` TEXT NOT NULL,
            `description` TEXT NOT NULL,
            FOREIGN KEY(`department_id`) REFERENCES `department_list`(`department_id`) ON DELETE CASCADE
        ) ");

        $this->exec("CREATE TABLE IF NOT EXISTS `vacancy_list` (
            `vacancy_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `designation_id` INTEGER NOT NULL,
            `title` TEXT NOT NULL,
            `slots` INTEGER NOT NULL Default 0,
            `status` INTEGER NOT NULL Default 1,
            `description` TEXT NOT NULL,
            `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(`designation_id`) REFERENCES `designation_list`(`designation_id`) ON DELETE CASCADE
        ) ");

        $this->exec("CREATE TABLE IF NOT EXISTS `applicant_list` (
            `applicant_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `vacancy_id` TEXT NOT NULL,
            `name` INTEGER NOT NULL,
            `gender` TEXT NOT NULL,
            `address` TEXT NOT NULL,
            `contact` TEXT NOT NULL,
            `email` TEXT NOT NULL,
            `dob` DATE NOT NULL,
            `summary` TEXT NOT NULL,
            `message` TEXT NOT NULL,
            `status` INTEGER NOT NULL Default 1,
            `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(`vacancy_id`) REFERENCES `vacancy_list`(`vacancy_id`) ON DELETE CASCADE
        ) ");

        $this->exec("CREATE TABLE IF NOT EXISTS `employment` (
            `applicant_id` INTEGER NOT NULL,
            `company_name` TEXT NOT NULL,
            `from` TEXT NOT NULL,
            `to` TEXT NULL,
            `position` TEXT NOT NULL,
            `brief_info` TEXT NOT NULL,
            `still_active` INTEGER NOT NULL Default 0,
            FOREIGN KEY(`applicant_id`) REFERENCES `applicant_list`(`applicant_id`) ON DELETE CASCADE
        ) ");
        $this->exec("CREATE TABLE IF NOT EXISTS `educational` (
            `applicant_id` INTEGER NOT NULL,
            `school_name` TEXT NOT NULL,
            `school_address` TEXT NOT NULL,
            `level` TEXT NOT NULL,
            `from` TEXT NOT NULL,
            `to` TEXT NOT NULL,
            FOREIGN KEY(`applicant_id`) REFERENCES `applicant_list`(`applicant_id`) ON DELETE CASCADE
        ) ");
        $this->exec("CREATE TABLE IF NOT EXISTS `skills` (
            `applicant_id` INTEGER NOT NULL,
            `skill` TEXT NOT NULL,
            FOREIGN KEY(`applicant_id`) REFERENCES `applicant_list`(`applicant_id`) ON DELETE CASCADE
        ) ");
        $this->exec("INSERT or IGNORE INTO `user_list` VALUES (1,'Administrator','admin',md5('admin123'),1,1, CURRENT_TIMESTAMP)");

    }
    function __destruct(){
         $this->close();
    }
}

$conn = new DBConnection();
<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
include("includes/config.php");

//connect to DB
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if ($db->connect_errno > 0) {
    die("Database connection failed." . $db->connect_error);
}

// SQL querys - news 
$sql = "DROP TABLE IF EXISTS project_news;";
$sql .= "
CREATE TABLE project_news(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(128) NOT NULL,
    date timestamp NOT NULL DEFAULT current_timestamp(),
    image_name VARCHAR(128),
    alttext VARCHAR(128),
    content TEXT NOT NULL
);
";

// SQL querys - users 
$sql .= "DROP TABLE IF EXISTS project_users;";
$sql .= "
CREATE TABLE project_users(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    password VARCHAR(256) NOT NULL,
    email VARCHAR(128) UNIQUE NOT NULL,
    fname VARCHAR(128) NOT NULL,
    lname VARCHAR(128) NOT NULL
);
";

// SQL querys - projects 
$sql .= "DROP TABLE IF EXISTS project_projects;";
$sql .= "
CREATE TABLE project_projects(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(128) NOT NULL,
    date timestamp NOT NULL DEFAULT current_timestamp(),
    website VARCHAR(128) NOT NULL,
    intro VARCHAR(256) NOT NULL,
    image_name VARCHAR(128),
    alttext VARCHAR(128),
    pdf_name VARCHAR(128),
    content TEXT NOT NULL
);
";

// SQL querys - skills 
$sql .= "DROP TABLE IF EXISTS project_skills;";
$sql .= "
CREATE TABLE project_skills(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    skill VARCHAR (128) NOT NULL,
    skill_level INT NOT NULL,
    description TEXT NOT NULL
);
";

// SQL querys - work 
$sql .= "DROP TABLE IF EXISTS project_work;";
$sql .= "
CREATE TABLE project_work(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    jobtitle VARCHAR(128) NOT NULL,
    date VARCHAR(64) NOT NULL,
    employer VARCHAR(128) NOT NULL,
    content TEXT NOT NULL
);
";

// SQL querys - education 
$sql .= "DROP TABLE IF EXISTS project_education;";
$sql .= "
CREATE TABLE project_education(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    course VARCHAR(128) NOT NULL,
    date VARCHAR(64) NOT NULL,
    school VARCHAR(128) NOT NULL,
    content TEXT NOT NULL
);
";

// SQL querys - pages 
$sql .= "DROP TABLE IF EXISTS project_pages;";
$sql .= "
CREATE TABLE project_pages(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(128) NOT NULL,
    date timestamp NOT NULL DEFAULT current_timestamp(),
    content TEXT NOT NULL
);
";


echo "<pre> $sql </pre>";

//send SQL to server 
if ($db->multi_query($sql)) {
    echo "Tables installed.";
} else {
    echo "Could not create tables in datebase";
}

// add admin account to users table
$user = new Users();
$user->registerUser("jess@jessofnorth.com", "password123", "Jessica", "Admin");

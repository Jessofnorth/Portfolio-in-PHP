<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
// true = activates error messages, false = deactivates
$devmode = false;
if ($devmode) {
    error_reporting(-1);
    ini_set("display_errors", 1);

    //database settings - For LOCALHOST
    define("DBHOST", "localhost");
    define("DBUSER", "admin");
    define("DBPASS", "password");
    define("DBDATABASE", "PHP_project");
} else {
    //database settngs - for MIUN
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "jeej2100");
    define("DBPASS", "ETbCrUvJBv");
    define("DBDATABASE", "jeej2100");
}
// site title/pagetitle
$site_title = "Jess of North Web developer";
$divider = " | ";

// load classes
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.class.php';
});

//session start
session_start();

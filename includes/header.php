<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
include("includes/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- faviconer -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" type="images/png" href="image/favicon.png">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <!-- ckeditor script -->
    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
    <!-- custom css -->
    <link rel="stylesheet" href="css/styles.css">
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/b16d647ed6.js" crossorigin="anonymous"></script>
    <title><?= $site_title . $divider . $page_title; ?></title>
</head>

<body>
    <div class="wrapper">
        <!-- header with nav/mobile nav -->
        <header>
            <?php
            include("includes/main_navigation.php");
            ?>
            <div class="middle">
                <?php
                if (isset($_SESSION['email'])) {
                    include("includes/admin_navigation.php");
                }
                ?>
                <!-- main content -->
                <main id="main">
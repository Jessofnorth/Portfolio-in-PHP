<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/

$pages = new Pages;
$page_nav = $pages->getPages();
?>
<nav>
    <!-- nav hamburger button -->
    <button name="meny" class="hamburger" aria-label="hamburger-menu"><span class="bar"></span></button>
    <a class="logo" href="index.php"><img src="images/logo_white.svg" alt="Logo"></a>
    <div class="menu">
        <!-- desktop menu -->
        <a class="navlink" href="index.php">Home</a>
        <a class="navlink" href="portfolio.php">Portfolio</a>
        <a class="navlink" href="skills.php">Experience</a>
        <a class="navlink" href="allnews.php">News</a>
        <a class="navlink" href="contact.php">Contact</a>
        <!-- foldout button -->
        <button class="btn navbtn" aria-expanded="false">More <span class="arrow fa-solid fa-chevron-down"></span></button>
        <div class="expandmore">
            <ul>
            <?php
            // loops thru CMS created pages and adds under more button
            foreach ($page_nav as $p) {
            ?>
               <li><a class="navlink" href="more.php?id=<?= $p['id'] ?>"><?= $p['title'] ?></a></li> 

            <?php } ?>
            </ul>
        </div>
    </div>
</nav>
</header>
<!-- mobile nav hidden/showing on click -->
<nav class="mobile-nav">
    <a class="navlink" href="index.php">Home</a>
    <a class="navlink" href="portfolio.php">Portfolio</a>
    <a class="navlink" href="skills.php">Experience</a>
    <a class="navlink" href="allnews.php">News</a>
    <a class="navlink" href="contact.php">Contact</a>
    <button class="btn navbtn" aria-expanded="false">More <span class="arrow fa-solid fa-chevron-down"></span></button>
    <div class="expandmore">
        <?php
        foreach ($page_nav as $p) {
        ?>
            <a class="navlink" href="more.php?id=<?= $p['id'] ?>"><?= $p['title'] ?></a>

        <?php } ?>
    </div>
</nav>
<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
//admin menu added if logged in 
// logout user if clicked
$user = new Users();
if (isset($_GET['logout'])) {
    $user->logoutUser();
}
?>

<div class="adminmenu">
    <!-- admin menu -->
    <h2>Admin menu:</h2>
    <a class="link" href="admin.php">Admin start</a>
    <?php if ($_SESSION['email'] == "jess@jessofnorth.com") {
        echo "<a class='link' href='register.php'>Manage accounts</a>";
    }
    ?>
    <a class="link" href="news.php">Manage news</a>
    <a class="link" href="projects.php">Manage portfolio</a>
    <a class="link" href="experience.php">Manage experience</a>
    <a class="link" href="pages.php">Manage pages</a>
    <a href="index.php?logout" class="logout">Logout<span class="fa-solid fa-arrow-right-to-bracket"></span></a>
</div>
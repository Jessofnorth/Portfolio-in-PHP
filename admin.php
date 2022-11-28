
<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Admin";
include("includes/header.php");
// check for login, if no send to loginpage
if (!isset($_SESSION['email'])) {
    header("Location: login.php?message=You%20need%20to%20login%20to%20access%20this%20page.");
}

// print error message if user tried to access register as not Admin
if (isset($_GET['message'])) {
    echo "<p class='error'>" . $_GET['message'] . "</p>";
}
?>
<section>
    <article>
    <h1 class="indexhead">Admin page</h1>
        <p class="center"><strong>Logged in as: <?= $_SESSION['email'] ?></strong></p>
        <p class="center">Welcome to the admin page!</p>
        <p class="center">Use the admin menu above to get to the section you want to work with.</p>
        <p class="center">Update content, create new content or delete some.</p>
        <p class="center">Only main admin can manage accounts.</p>
    </article>

</section>
<!-- includes footer -->
<?php
include("includes/footer.php");
?>
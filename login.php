<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Login - admin";
include("includes/header.php");
// check for login, if any send to admin page
if (isset($_SESSION['email'])) {
    header("Location: admin.php");
}
// create object
$user = new Users();
$errormsg = "";
$email = "";
$password = "";

// check if form is posted
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->loginUser($email, $password)) {
        header("Location: admin.php");
    } else {
        $errormsg  = "<p class='error'>Wrong email and/or password!</p> <br>";
    }
}
?>
<section>
    <h1 class="indexhead">Administration login</h1>
    <p class="center">Use your email and password to access the admin section.</p><p class="center">By logging in you accept the use of cookies.</p>
    <?php
    // print error message if user tried to access admin without login
    if (isset($_GET['message'])) {
        echo "<p class='error center'>" . $_GET['message'] . "</p>";
    }
    ?>
    <!-- form -->
    <form method="POST" action="login.php">
        <div class="forms">
            <?= $errormsg ?>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <input type="submit" value="Login">
        </div>
    </form>
</section>
<!-- includes footer -->
<?php
include("includes/footer.php");
?>
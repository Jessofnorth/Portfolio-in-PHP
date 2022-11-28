<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Manage accounts";
include("includes/header.php");

// check for login, if no send to loginpage
if ($_SESSION['email'] != "jess@jessofnorth.com") {
    header("Location: admin.php?message=You%20need%20to%20be%20admin%20to%20access%20this%20page.");
}
// create objekt
$user = new Users();
// set default values
$errormsg = "";
$errormsgdelete = "";
$registerd = "";
$email = "";
$password = "";
$fname = "";
$lname = "";

// check if form is posted
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $success = true;
    // check for unique email
    if ($user->userAvailability($email)) {
        $errormsg  = "<p class='error'>The email is taken, choose a different one!</p> <br>";
    } else {
        // check the inputs
        if (!$user->setEmail($email)) {
            $success = false;
            $errormsg  = "<p class='error'>You must enter a valid email!</p> <br>";
        }
        if (!$user->setPassword($password)) {
            $success = false;
            $errormsg  .= "<p class='error'>Password must be atleast 8 characters!</p><br>";
        }
        if (!$user->setFname($fname)) {
            $success = false;
            $errormsg  .= "<p class='error'>Your first name must be filled in!</p><br>";
        }
        if (!$user->setLname($lname)) {
            $success = false;
            $errormsg  .= "<p class='error'>Your surname must be filled in!</p><br>";
        }
        // if all inputs correct, send to class for registration
        if ($success) {

            if ($user->registerUser($email,  $password,  $fname,  $lname)) {
                $registerd = "<p class='published'>Registration was successfull!</p>";
                $email = "";
                $password = "";
                $fname = "";
                $lname = "";
            } else {
                $errormsg  = "<p class='error'>Something went wrong..</p>";
            }
        }
    }
}

// check if a user should be deleted
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    if ($user->deleteUser($delete)) {
        $errormsgdelete = "<p class='error'>The user with ID: $delete has been deleted.</p> <br>";
    } else {
        $errormsgdelete = "<p class='error'>The user could not be deleted!</p> <br>";
    }
}
?>
<section>
    <h1 class="indexhead">Manage accounts</h1>
    <p class="center">Add accounts and manage existing ones.</p>
    <?= $registerd ?>
    <article>
        <!-- print to screen -->
        <h2 class="mainheading">Accounts<span class="fa-solid fa-turn-down"></span></h2>
        <?= $errormsgdelete ?>
        <button class="btn" aria-expanded="false">Show list <span class="arrow fa-solid fa-chevron-down"></span></button>
        <div class="expand">
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>First name</th>
                        <th>Surname</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_list = $user->getUsers();
                    foreach ($user_list as $u) {
                    ?>
                        <tr>
                            <td><?= $u['email'] ?></td>
                            <td><?= $u['fname'] ?></td>
                            <td><?= $u['lname'] ?></td>
                            <td><a href='register.php?delete=<?= $u['id'] ?>'>Delete</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </article>
    <article>
        <h2 class="mainheading">Add account<span class="fa-solid fa-turn-down"></span></h2>
        <p class="center">Register another co-admin account. Passwords must be atleast 8 charachters long! Fields can not be left empty.</p><br>
        <?php
        // print error message if user tried to access admin without login
        if (isset($_GET['message'])) {
            echo "<p class='error'>" . $_GET['message'] . "</p>";
        }
        ?>
        <!-- form for adding account -->
        <form method="POST" action="register.php">
            <div class="forms">
                <?= $errormsg ?>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= $email ?>">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" value="<?= $password ?>">
                <label for="fname">First name:</label>
                <input type="text" name="fname" id="fname" value="<?= $fname ?>">
                <label for="lname">Surname:</label>
                <input type="text" name="lname" id="lname" value="<?= $lname ?>">
                <div class="GDPR">
                    <input type="checkbox" name="gdpr" id="gdpr">
                    <label for="gdpr"> By registering a user I agree that the above information is stored for login purposes.</label>
                </div>
                <input type="submit" value="Register" id="submit" disabled>
            </div>
        </form>
    </article>
</section>
<!-- includes footer -->
<?php
include("includes/footer.php");
?>
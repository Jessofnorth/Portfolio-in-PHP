<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Contact";
include("includes/header.php");

// create object
$mail = new Mail;

$errormsg = "";
$email = "";
$subject = "";
$message = "";

// check if form is posted
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $success = true;
    // check the inputs
    if (!$mail->setEmail($email)) {
        $success = false;
        $errormsg  .= "<p class='error'>You must add your email!</p> <br>";
    }
    if (!$mail->setSubject($subject)) {
        $success = false;
        $errormsg  .= "<p class='error'>You must add a subject!</p><br>";
    }
    if (!$mail->setMessage($message)) {
        $success = false;
        $errormsg  .= "<p class='error'>You must add a message!</p><br>";
    }

    if ($success) {
        // send email
        if ($mail->sendMail($email, $subject, $message)) {
            header("Location: contact.php?success");
        } else {
            $errormsg  = "<p class='error'>Email not sent!</p>";
        }
    } else {
        $errormsg  .= "<p class='error'>Email could not be sent, check inputs!</p>";
    }
}
?>
<section>
    <h1 class="indexhead">Email me!</h1>
    <p class="center">Write me a message in the form below and I will get back to you usually within 48h.</p>
    <p class="center"><strong>Don't forget your email so I can reply to you!</strong></p>
    <p class="center">All fields must be filled.</p>
    <form method="POST" action="contact.php">
        <!-- form -->   
        <div class="forms">
            <?= $errormsg ?>
            <?php
            // print success message if published
            if (isset($_GET['success'])) {
                echo "<p class='published'>The email was sent!</p>";
            }
            ?>
            <label for="email">Your email:</label>
            <input type="email" name="email" id="email" value="<?= $email ?>">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" value="<?= $subject ?>">
            <label for="message">Message:</label>
            <textarea name="message" id="message" cols="30" rows="10"><?= $message ?></textarea>
            <div class="GDPR">
                <input type="checkbox" name="gdpr" id="gdpr">
                <label for="gdpr"> I consent to having this website store above submitted information so that they can respond to my inquiry.</label>
            </div>
            <input type="submit" value="Send email" id="submit" disabled>
        </div>
    </form>
</section>
<!-- include footer -->
<?php
include("includes/footer.php");
?>
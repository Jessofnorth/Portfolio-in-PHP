<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Edit work";
include("includes/header.php");
// check for login, if no send to loginpage
if (!isset($_SESSION['email'])) {
    header("Location: login.php?message=You%20need%20to%20login%20to%20access%20this%20page.");
}
// create object 

$work = new Work;

// set default values
$errormsg = "";
$postpublished = "";
// check if id ist sent
if (isset($_GET['editwork'])) {
    $id = intval($_GET['editwork']);
    // check if form is posted
    if (isset($_POST['work_title'])) {
        $work_title = $_POST['work_title'];
        $date_work = $_POST['date_work'];
        $employer = $_POST['employer'];
        $work_description = $_POST['editor'];
        $success = true;
        // check the inputs
        if (!$work->setWorktitle($work_title)) {
            $success = false;
            $errormsgwork  .= "<p class='error'>You must add a title to the work!</p> <br>";
        }
        if (!$work->setEmployer($employer)) {
            $success = false;
            $errormsgwork  .= "<p class='error'>You must add an employer to the work!</p><br>";
        }
        if (!$work->setWorkDate($date_work)) {
            $success = false;
            $errormsgwork  .= "<p class='error'>You must add an start date of the work!</p><br>";
        }

        if (!$work->setWorkDescription($work_description)) {
            $success = false;
            $errormsgwork  .= "<p class='error'>You must add an description of the work!</p><br>";
        }

        if ($success) {
            // if post is published send back to news.php for cleaning th einputs and write message
            if ($work->updateWork($id, $work_title, $date_work, $employer, $work_description)) {
                $postpublished = "<p class='published'>The post is edited!</p>";
            } else {
                $errormsgwork  = "<p class='error'>Something went wrong, work not saved!</p>";
            }
        } else {
            $errormsgwork  .= "<p class='error'>The work could not be saved, check your inputs!</p>";
        }
    }

    $details = $work->getWorkByID($id);
} else



?>
<section>
    <h1 class="indexhead">Edit work:</h1>
    <h2 class="mainheading">"<?= $details['jobtitle'] ?>"</h2>
    <p class="center">Edit your work in the editor below. All fields must be filled to publish.</p>
    <?= $errormsg ?>
    <?= $postpublished ?>
<!-- form -->
    <form method="POST" action="editwork.php?editwork=<?= $id ?>">
        <div class="postforms">

            <label for="work_title">Position:</label>
            <input type="text" name="work_title" id="work_title" value="<?= $details['jobtitle'] ?>">
            <label for="employer">Employer:</label>
            <input type="text" name="employer" id="employer" value="<?= $details['employer'] ?>">
            <label for="date_work">Date (ex 2020-02-23 - Current):</label>
            <input type="text" id="date_work" name="date_work" value="<?= $details['date'] ?>">
            <label for="editor">Description of employment:</label>
            <textarea name="editor" id="editor" cols="60" rows="20"><?= $details['content'] ?></textarea>
            <input type="submit" value="Save">
        </div>
    </form>
</section>
<!-- ckeditor script -->
<script>
    CKEDITOR.replace('editor');
</script>
<!-- include footer -->
<?php
include("includes/footer.php");
?>
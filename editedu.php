<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Edit education";
include("includes/header.php");
// check for login, if no send to loginpage
if (!isset($_SESSION['email'])) {
    header("Location: login.php?message=You%20need%20to%20login%20to%20access%20this%20page.");
}
// create object 
$education = new Education;

// set default values
$errormsg = "";
$postpublished = "";
// check if id ist sent
if (isset($_GET['editedu'])) {
    $id = intval($_GET['editedu']);
    // check if form is posted
    if (isset($_POST['education_title'])) {
        $education_title = $_POST['education_title'];
        $education_school = $_POST['education_school'];
        $date_edu = $_POST['date_edu'];
        $edu_description = $_POST['editor'];
        $success = true;
        // check the inputs
        if (!$education->setEducationtitle($education_title)) {
            $success = false;
            $errormsgedu  .= "<p class='error'>You must add a title to the education!</p> <br>";
        }
        if (!$education->setSchool($education_school)) {
            $success = false;
            $errormsgedu  .= "<p class='error'>You must add an Institution to the education!</p><br>";
        }
        if (!$education->setEducationDate($date_edu)) {
            $success = false;
            $errormsgedu  .= "<p class='error'>You must add an start date of the education!</p><br>";
        }
        if (!$education->setDescription($edu_description)) {
            $success = false;
            $errormsgedu  .= "<p class='error'>You must add an description of the education!</p><br>";
        }

        if ($success) {
            // if post is published send back to news.php for cleaning th einputs and write message
            if ($education->updateEducation($id, $education_title, $education_school, $date_edu, $edu_description)) {
                $postpublished = "<p class='published'>The post is edited!</p>";
            } else {
                $errormsgedu  = "<p class='error'>Something went wrong, education not saved!</p>";
            }
        } else {
            $errormsgedu  .= "<p class='error'>The education could not be saved, check your inputs!</p>";
        }
    }

    $details = $education->getEducationByID($id);
} else

?>
<section>
    <h1 class="indexhead">Edit education:</h1>
    <h2 class="mainheading">"<?= $details['course'] ?>"</h2>
    <p class="center">Edit your education in the editor below. All fields must be filled to publish.</p>
    <?= $errormsg ?>
    <?= $postpublished ?>
    <!-- form -->
    <form method="POST" action="editedu.php?editedu=<?= $id ?>">
        <div class="postforms">

            <label for="education_title">Title:</label>
            <input type="text" name="education_title" id="education_title" value="<?= $details['course'] ?>">
            <label for="education_school">Institution:</label>
            <input type="text" name="education_school" id="education_school" value="<?= $details['school'] ?>">
            <label for="date_edu">Date (ex 2020-02-23 - Current):</label>
            <input type="text" id="date_edu" name="date_edu" value="<?= $details['date'] ?>">
            <label for="editor">Description of education:</label>
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
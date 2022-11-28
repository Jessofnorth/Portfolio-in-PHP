<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Edit skill";
include("includes/header.php");
// check for login, if no send to loginpage
if (!isset($_SESSION['email'])) {
    header("Location: login.php?message=You%20need%20to%20login%20to%20access%20this%20page.");
}
// create object 

$skill = new Skill;

// set default values
$errormsg = "";
$postpublished = "";
// check if id ist sent
if (isset($_GET['editskill'])) {
    $id = intval($_GET['editskill']);
    // check if form is posted
    if (isset($_POST['skill_type'])) {
        $skill_type = $_POST['skill_type'];
        $skill_level = $_POST['skill_level'];
        $skill_description = $_POST['editor'];
        $success = true;
        // check the inputs
        if (!$skill->setSkilltype($skill_type)) {
            $success = false;
            $errormsg  .= "<p class='error'>You must add a skill to the post!</p> <br>";
        }
        if (!$skill->setSkilllevel($skill_level)) {
            $success = false;
            $errormsg  .= "<p class='error'>You must add a skill level between 0-100 to the post!</p><br>";
        }
        if (!$skill->setSkilldescription($skill_description)) {
            $success = false;
            $errormsg  .= "<p class='error'>You must add an desvription of the skill!</p><br>";
        }

        if ($success) {
            // if post is published send back to news.php for cleaning th einputs and write message
            if ($skill->updateSkill($id, $skill_type, $skill_level, $skill_description)) {
                $postpublished = "<p class='published'>The post is edited!</p>";
            } else {
                $errormsg  = "<p class='error'>Something went wrong, skill not saved!</p>";
            }
        } else {
            $errormsg  .= "<p class='error'>The skull could not be saved, check your inputs!</p>";
        }
    }

    $details = $skill->getSkillByID($id);
} else 

?>
<section>
    <h1 class="indexhead">Edit skill:</h1>
    <h2 class="mainheading">"<?= $details['skill'] ?>"</h2>
            <p class="center">Edit your skill in the editor below. All fields must be filled to publish.</p>
            <?= $errormsg ?>
            <?= $postpublished ?>
<!-- form -->
            <form method="POST" action="editskill.php?editskill=<?= $id ?>">
                <div class="postforms">
                   <!-- form -->
                    <label for="skill_type">Skill:</label>
                    <input type="text" name="skill_type" id="skill_type" value="<?= $details['skill'] ?>">
                    <label for="skill_level">Skill level (0-100):</label>
                    <input type="number" id="skill_level" name="skill_level" min="0" max="100" value="<?= $details['skill_level'] ?>">
                    <label for="editor">Description of skill:</label>
                    <textarea name="editor" id="editor" cols="60" rows="20"><?= $details['description'] ?></textarea>
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
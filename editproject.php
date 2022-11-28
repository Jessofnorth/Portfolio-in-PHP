<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Edit project";
include("includes/header.php");
// check for login, if no send to loginpage
if (!isset($_SESSION['email'])) {
    header("Location: login.php?message=You%20need%20to%20login%20to%20access%20this%20page.");
}
// create object 
$project = new Projects();
// set default values
$errormsg = "";
$postpublished = "";
$title = "";
$weblink = "";
$intro = "";
$content = "";
// check if id ist sent
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    // check if form is posted
    if (isset($_POST['title'])) {
        $title = $_POST['title'];
        $content = $_POST['editor'];
        $weblink = $_POST['weblink'];
        $intro = $_POST['intro'];
        $success = true;
        // check the inputs
        if (!$project->setTitle($title)) {
            $success = false;
            $errormsg  .= "<p class='error'>You must add an title to the project!</p> <br>";
        }
        if (!$project->setContent($content)) {
            $success = false;
            $errormsg  .= "<p class='error'>You must add some content to the project!</p><br>";
        }
        if (!$project->setWeblink($weblink)) {
            $success = false;
            $errormsg  .= "<p class='error'>You must add an website link!</p><br>";
        }
        if (!$project->setIntro($intro)) {
            $success = false;
            $errormsg  .= "<p class='error'>You must add an intro to the project!</p><br>";
        }
        // send to method/class
        if ($success) {
            if ($project->updateProject($id, $title, $content, $intro, $weblink)) {
                $postpublished = "<p class='published'>The post is edited!</p>";
            } else {
                $errormsg  = "<p class='error'>Something went wrong..</p>";
            }
        } else {
            $errormsg  .= "<p class='error'>The post could not be edited, check your inputs!</p>";
        }
    }
    $details = $project->getProjectByID($id);
}

?>
<section>
    <h1 class="indexhead">Edit project: </h1>
    <h2 class="mainheading">"<?= $details['title'] ?>"</h2>
            <p class="center">Edit the project post in the editor below. All fields must be filled to publish. Images can not be changed after publishing.</p>
            <p class="center">Max size for imgaes is 2MB and the file must be in JPEG format.</p>
            <form method="POST" action="editproject.php?edit=<?= $id ?>" enctype="multipart/form-data">
                <div class="postforms">
                    <?= $postpublished ?>
                    <?= $errormsg ?>
                    <?php
                    // print success message if published
                    if (isset($_GET['success'])) {
                        echo "<p class='published'>The project is published!</p>";
                    }
                    ?>
                    <!-- form -->
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" value="<?= $details['title'] ?>">
                    <label for="weblink">Web link:</label>
                    <input type="text" name="weblink" id="weblink" value="<?= $details['website'] ?>">
                    <label for="intro">Short introduction to project, max 256 charachters:</label>
                    <input type="text" name="intro" id="intro" value="<?= $details['intro'] ?>">
                    <p class="error" id="maxchar"></p>
                    <label for="editor">Content:</label>
                    <textarea name="editor" id="editor" cols="60" rows="20"><?= $details['content'] ?></textarea>
                    <input type="submit" value="Publish">
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
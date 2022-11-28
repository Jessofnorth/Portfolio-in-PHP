<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Edit page";
include("includes/header.php");
// check for login, if no send to loginpage
if (!isset($_SESSION['email'])) {
    header("Location: login.php?message=You%20need%20to%20login%20to%20access%20this%20page.");
}
// create object 
$pages = new Pages();
// set default values
$errormsg = "";
$postpublished = "";
// check if id ist sent
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    // check if form is posted
    if (isset($_POST['title'])) {
        $title = $_POST['title'];
        $content = $_POST['editor'];
        $success = true;
        // check the inputs
        if (!$pages->setTitle($title)) {
            $success = false;
            $errormsg  .= "<p class='error'>You must add an title to the post!</p> <br>";
        }
        if (!$pages->setContent($content)) {
            $success = false;
            $errormsg  .= "<p class='error'>You must add some content to the post!</p><br>";
        }
        if ($success) {
            if ($pages->updatePage($id, $title, $content)) {
                $postpublished = "<p class='published'>The post is edited!</p>";
            } else {
                $errormsg  = "<p class='error'>Something went wrong..</p>";
            }
        } else {
            $errormsg  .= "<p class='error'>The post could not be edited, check your inputs!</p>";
        }
    }
    $details = $pages->getPagesByID($id);
}
?>
<section>
    <article>
        <h1 class="indexhead">Edit news:</h1>
        <h2 class="mainheading">"<?= $details['title'] ?>"</h2>
                <p class="center">Edit your page in the editor below. Title and content must be filled to publish.</p>
                <?= $errormsg ?>
                <?= $postpublished ?>
                <form method="POST" action="editpage.php?edit=<?= $id ?>">
                <!-- form -->
                    <div class="postforms">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" value="<?= $details['title'] ?>">
                        <label for="editor">Content:</label>
                        <textarea name="editor" id="editor" cols="60" rows="20"><?= $details['content'] ?></textarea>
                        <input type="submit" value="Save edits">
                    </div>
                </form>
    </article>
</section>
<!-- ckeditor script -->
<script>
    CKEDITOR.replace('editor');
</script>
<!-- include footer -->
<?php
include("includes/footer.php");
?>
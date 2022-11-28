<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Manage Portfolio";
include("includes/header.php");
// check for login, if no send to loginpage
if (!isset($_SESSION['email'])) {
    header("Location: login.php?message=You%20need%20to%20login%20to%20access%20this%20page.");
}
// create object
$project = new Projects();

// set default values
$errormsg = "";
$title = "";
$weblink = "";
$intro = "";
$content = "";
$image_name = "";
$alttext = "";
$pdf_name = "";


// check if form is posted
if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $content = $_POST['editor'];
    $weblink = $_POST['weblink'];
    $intro = $_POST['intro'];
    $image_name = $_FILES['image'];
    $alttext = $_POST['alttext'];
    $pdf_name = $_FILES['pdf'];
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
    if (!$project->setAlttext($alttext)) {
        $success = false;
        $errormsg  .= "<p class='error'>Alternative text could not be stored!</p><br>";
    }
    if (!$project->setWeblink($weblink)) {
        $success = false;
        $errormsg  .= "<p class='error'>You must add an website link!</p><br>";
    }
    if (!$project->setIntro($intro)) {
        $success = false;
        $errormsg  .= "<p class='error'>You must add an intro to the project!</p><br>";
    }

    if ($success) {
        // if post is published send back to news.php for cleaning th einputs and write message
        if ($project->addProject($title, $content, $image_name, $alttext, $intro, $weblink, $pdf_name)) {
            header("Location: projects.php?success");
        } else {
            $errormsg  = "<p class='error'>Something went wrong, project not published!</p>";
        }
    } else {
        $errormsg  .= "<p class='error'>The project could not be published, check your inputs!</p>";
    }
}

// delete news
$postdeleted = "";
// check if a post should be deleted
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    if ($project->deleteProject($delete)) {
        $postdeleted = "<p class='error'>The project with ID: $delete has been deleted.</p> <br>";
    } else {
        $postdeleted = "<p class='error'>The project could not be deleted!</p> <br>";
    }
}
?>


<section>
    <h1 class="indexhead">Manage Portfolio</h1>
    <p class="center">Create new project posts or manage existing projects in the list below.</p>
    <?= $postdeleted ?>
    <article>
        <h2 class="mainheading">Create project<span class="fa-solid fa-turn-down"></span></h2>
        <p class="center">Create a project post in the editor below. Title, content, introduction and weblink must be filled to publish. A standard image will be used if no image is uploaded.</p>
        <p class="center">Max size for files is 2MB and the file must be in JPEG or PDF format. Files can not be changed after publishing.</p>
        <!-- form -->
        <form method="POST" action="projects.php" enctype="multipart/form-data">
            <div class="postforms">
                <?= $errormsg ?>
                <?php
                // print success message if published
                if (isset($_GET['success'])) {
                    echo "<p class='published'>The project is published!</p>";
                }
                ?>
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?= $title ?>">
                <label for="weblink">Web link:</label>
                <input type="text" name="weblink" id="weblink" value="<?= $weblink ?>">
                <label for="image">Image:</label>
                <input type="file" name="image" id="image">
                <label for="alttext">Alternative text if image wont load. (Discription of image):</label>
                <input type="text" name="alttext" id="alttext" value="<?= $alttext ?>">
                <label for="pdf">PDF:</label>
                <input type="file" name="pdf" id="pdf">
                <label for="intro">Short introduction to project, max 256 charachters:</label>
                <input type="text" name="intro" id="intro" value="<?= $intro ?>">
                <p class="error" id="maxchar"></p>
                <label for="editor">Content:</label>
                <textarea name="editor" id="editor" cols="60" rows="20"><?= $content ?></textarea>
                <input type="submit" value="Publish" id="submit">
            </div>
        </form>
    </article>
    <article>
        <!-- foldout button -->
        <h2 class="mainheading">Project list<span class="fa-solid fa-turn-down"></span></h2>
        <button class="btn" aria-expanded="false">Show list <span class="arrow fa-solid fa-chevron-down"></span></button>
        <div class="expand">

            <!-- print to screen -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Published</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $project_list = $project->getProject();
                    foreach ($project_list as $p) {
                    ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td><a href='portfolio.php'><?= $p['title'] ?></a></td>
                            <td><?= $p['date'] ?></td>
                            <td><a href='projects.php?delete=<?= $p['id'] ?>'>Delete</a></td>
                            <td><a href='editproject.php?edit=<?= $p['id'] ?>'>Edit</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
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
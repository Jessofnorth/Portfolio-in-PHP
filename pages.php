<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Manage Pages";
include("includes/header.php");
// check for login, if no send to loginpage
if (!isset($_SESSION['email'])) {
    header("Location: login.php?message=You%20need%20to%20login%20to%20access%20this%20page.");
}
// create object
$pages = new Pages();

// set default values
$errormsg = "";
$title = "";
$content = "";

// check if form is posted
if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $content = $_POST['editor'];
    $success = true;
    // check the inputs
    if (!$pages->setTitle($title)) {
        $success = false;
        $errormsg  .= "<p class='error'>You must add an title to the page!</p> <br>";
    }
    if (!$pages->setContent($content)) {
        $success = false;
        $errormsg  .= "<p class='error'>You must add some content to the page!</p><br>";
    }

    if ($success) {
        // if post is published send back to news.php for cleaning th einputs and write message
        if ($pages->addPage($title, $content)) {
            header("Location: pages.php?success");
        } else {
            $errormsg  = "<p class='error'>Something went wrong, page not published!</p>";
        }
    } else {
        $errormsg  .= "<p class='error'>The page could not be published, check your inputs!</p>";
    }
}

// delete news
$postdeleted = "";
// check if a post should be deleted
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    if ($pages->deletePage($delete)) {
        $postdeleted = "<p class='error'>The page with ID: $delete has been deleted.</p> <br>";
    } else {
        $postdeleted = "<p class='error'>The page could not be deleted!</p> <br>";
    }
}
?>


<section>
    <h1 class="indexhead">Manage Pages</h1>
    <p class="center">Create new page or manage existing pages in the list below.</p>
    <article>
        <h2 class="mainheading">Create new page<span class="fa-solid fa-turn-down"></span></h2>
        <?= $postdeleted ?>
        <p class="center">Create a news page in the editor below. Title and content must be filled to publish.
        <form method="POST" action="pages.php">
            <div class="postforms">
                <?= $errormsg ?>
                <?php
                // print success message if published
                if (isset($_GET['success'])) {
                    echo "<p class='published'>The page is published!</p>";
                }
                ?>
                <!-- form -->
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?= $title ?>">
                <label for="editor">Content:</label>
                <textarea name="editor" id="editor" cols="60" rows="20"><?= $content ?></textarea>
                <input type="submit" value="Publish">
            </div>
        </form>
    </article>
    <article>
        <!-- foldout button -->
        <h2 class="mainheading">Page list<span class="fa-solid fa-turn-down"></span></h2>
        <button class="btn" aria-expanded="false">Show list <span class="arrow fa-solid fa-chevron-down"></span></button>
        <div class="expand">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // print to screen
                    $page_list = $pages->getPages();
                    foreach ($page_list as $p) {
                    ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td><a href='more.php?id=<?= $p['id'] ?>'><?= $p['title'] ?></a></td>
                            <td><a href='pages.php?delete=<?= $p['id'] ?>'>Delete</a></td>
                            <td><a href='editpage.php?edit=<?= $p['id'] ?>'>Edit</a></td>
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
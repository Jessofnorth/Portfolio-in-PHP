<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Manage News";
include("includes/header.php");
// check for login, if no send to loginpage
if (!isset($_SESSION['email'])) {
    header("Location: login.php?message=You%20need%20to%20login%20to%20access%20this%20page.");
}
// create object 
$news = new News();

// set default values
$errormsg = "";
$title = "";
$content = "";
$image_name = "";
$alttext = "";
// check if form is posted
if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $content = $_POST['editor'];
    $image_name = $_FILES['image'];
    $alttext = $_POST['alttext'];
    $success = true;
    // check the inputs
    if (!$news->setTitle($title)) {
        $success = false;
        $errormsg  .= "<p class='error'>You must add an title to the post!</p> <br>";
    }
    if (!$news->setContent($content)) {
        $success = false;
        $errormsg  .= "<p class='error'>You must add some content to the post!</p><br>";
    }
    if (!$news->setAlttext($alttext)) {
        $success = false;
        $errormsg  .= "<p class='error'>Alternative text could not be stored!</p><br>";
    }

    if ($success) {
        // if post is published send back to news.php for cleaning th einputs and write message
        if ($news->addNews($title, $content, $image_name, $alttext)) {
            header("Location: news.php?success");
        } else {
            $errormsg  = "<p class='error'>Something went wrong, post not published!</p>";
        }
    } else {
        $errormsg  .= "<p class='error'>The post could not be published, check your inputs!</p>";
    }
}

// delete news
$postdeleted = "";
// check if a post should be deleted
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    if ($news->deleteNews($delete)) {
        $postdeleted = "<p class='error'>The post with ID: $delete has been deleted.</p> <br>";
    } else {
        $postdeleted = "<p class='error'>The post could not be deleted!</p> <br>";
    }
}
?>


<section>
    <h1 class="indexhead">Manage News</h1>
    <p class="center">Create new post or manage existing news in the list below.</p>
    <article>
        <h2 class="mainheading">Create news post<span class="fa-solid fa-turn-down"></span></h2>
        <p class="center">Create a news post in the editor below. Title and content must be filled to publish. A standard image will be used if no image is uploaded.</p>
        <p class="center">Max size for imgaes is 2MB and the file must be in JPEG format. Images can not be changed after publishing.</p>
        <!-- form -->
        <form method="POST" action="news.php" enctype="multipart/form-data">
            <div class="postforms">
                <?= $errormsg ?>
                <?php
                // print success message if published
                if (isset($_GET['success'])) {
                    echo "<p class='published'>The post is published!</p>";
                }
                ?>
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?= $title ?>">
                <label for="image">Image:</label>
                <input type="file" name="image" id="image">
                <label for="alttext">Alternative text if image wont load. (Discription of image):</label>
                <input type="text" name="alttext" id="alttext" value="<?= $alttext ?>">
                <label for="editor">Content:</label>
                <textarea name="editor" id="editor" cols="60" rows="20"><?= $content ?></textarea>
                <input type="submit" value="Publish">
            </div>
        </form>
    </article>
    <article>
        <h2 class="mainheading">News list<span class="fa-solid fa-turn-down"></span></h2>
        <!-- foldout button -->
        <button class="btn" aria-expanded="false">Show list <span class="arrow fa-solid fa-chevron-down"></span></button>
        <div class="expand">
            <!-- print to screen -->
            <p class="center">Click the title to se the article in its entirety.</p>
            <?= $postdeleted ?>
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
                    $news_list = $news->getNews();
                    foreach ($news_list as $n) {
                    ?>
                        <tr>
                            <td><?= $n['id'] ?></td>
                            <td><a href='singlenews.php?id=<?= $n['id'] ?>'><?= $n['title'] ?></a></td>
                            <td><?= $n['date'] ?></td>
                            <td><a href='news.php?delete=<?= $n['id'] ?>'>Delete</a></td>
                            <td><a href='editnews.php?edit=<?= $n['id'] ?>'>Edit</a></td>
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
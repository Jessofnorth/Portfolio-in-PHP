<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "News";
include("includes/header.php");
// create object
$news = new News();
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $news = $news->getNewsByID($id);
    if (empty($news)) {
        header("Location: index.php");
    }
}
?>
<article>
    <!-- print to screen -->
    <h1 class="indexhead"><?= $news['title'] ?></h1>
    <picture>
        <source type="image/webp" srcset="images/<?= $news['image_name'] ?>.webp">
        <img src="images/<?= $news['image_name'] ?>.jpg" alt="<?= $news['alttext'] ?>">
    </picture>
    <p class="datecenter">Published: <?= $news['date'] ?></p>
    <div class="contentsingle"><?= $news['content'] ?></div>
</article>


<!-- includes footer -->
<?php
include("includes/footer.php");
?>
<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Project";
include("includes/header.php");
// create object
$project = new Projects();
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $project = $project->getProjectByID($id);
    if (empty($project)) {
        header("Location: index.php");
    }
}

?>
<article>
    <h1 class="indexhead"><?= $project['title'] ?></h1>
    <p class="center">Website:<a href="<?= $project['website'] ?>" target="_blank"><?= $project['website'] ?></a></p>
    <p class="center"> <strong> <?= $project['intro'] ?></strong></p>
    <?php
    if ($project['pdf_name'] != "null") {
    ?>
        <p class="center">PDF with more designfiles: <a href="pdf/<?= $project['pdf_name'] ?>" target="_blank">PDF <span class="fa-solid fa-up-right-from-square"></span></a></p>
    <?php } ?>
    <picture>
        <source type="image/webp" srcset="images/<?= $project['image_name'] ?>.webp">
        <img src="images/<?= $project['image_name'] ?>.jpg" alt="<?= $project['alttext'] ?>">
    </picture>
    <div class="contentsingle"><?= $project['content'] ?></div>
</article>


<!-- includes footer -->
<?php
include("includes/footer.php");
?>
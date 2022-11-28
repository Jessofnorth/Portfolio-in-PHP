<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "More";
include("includes/header.php");
// create object
$pages = new Pages();

// check for id, if none - index.php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $page = $pages->getPagesByID($id);
    if (empty($page)) {
        header("Location: index.php");
    }
}
?>
<section>
    <h1 class="indexhead"><?= $page['title'] ?></h1>
    <div class="contentsingle"><?= $page['content'] ?></div>
</section>
<!-- includes footer -->
<?php
include("includes/footer.php");
?>
<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Portfolio";
include("includes/header.php");
// create object
$project = new Projects();
?>
<section>
    <h1 class="indexhead">Portfolio</h1>
<!-- print to screen -->
    <?php
    $project_list = $project->getProject();
    foreach ($project_list as $p) {
    ?>
        <article class="newsshorts newsgrid">
            <picture class="newsgridleft thumb">
                <source type="image/webp" srcset="images/thumb_<?= $p['image_name'] ?>.webp">
                <img src="images/thumb_<?= $p['image_name'] ?>.jpg" alt="<?= $p['alttext'] ?>">
            </picture>
            <div class="newsgridright">
                <h2 class="title"><?= $p['title'] ?></h2>
                <p>Website:<a href="<?= $p['website'] ?>" target="_blank"><?= $p['website'] ?></a></p>
                <strong> <?= $p['intro'] ?></strong>
                <?php
                if ($p['pdf_name'] != "null") {
                ?>
                    <p>PDF with more designfiles: <a href="pdf/<?= $p['pdf_name'] ?>" target="_blank">PDF <span class="fa-solid fa-up-right-from-square"></span></a></p>
                <?php } ?>
                <p class="readmore"> <a href='singleproject.php?id=<?= $p['id'] ?>'>Read more <span class="fa-solid fa-caret-right"></span></a></p>
            </div>
        </article>
    <?php
    }
    
    ?>
</section>
<!-- includes footer -->
<?php
include("includes/footer.php");
?>
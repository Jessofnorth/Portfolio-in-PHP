<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "News";
include("includes/header.php");
// create object
$news = new News();
?>
<section>
    <h1 class="indexhead">All news</h1>

    <?php
    // get news list
    $news_list = $news->getNews();
    foreach ($news_list as $n) {
    ?>
        <article class="newsshorts newsgrid">
            <picture class="newsgridleft thumb">
                <source type="image/webp" srcset="images/<?= $n['image_name'] ?>.webp">
                <img src="images/<?= $n['image_name'] ?>.jpg" alt="<?= $n['alttext'] ?>">
            </picture>
            <div class="newsgridright">
                <h2 class="title"><?= $n['title'] ?></h2>
                <p class="date">Published: <?= $n['date'] ?></p>
                <?= substr($n['content'], 0, 500) ?>
                <p class="readmore"> <a href='singlenews.php?id=<?= $n['id'] ?>'>Keep reading <span class="fa-solid fa-caret-right"></span></a></p>
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
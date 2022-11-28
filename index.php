<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Home";
include("includes/header.php");

// create object
$news = new News();
?>
<section>
    <article>
        <h1 class="indexhead">Hi! I'm Jess</h1>
        <p class="center"><strong >A web developer in training just finishing up the first year at Mid Sweden Univesrity.</strong></p>
        <p class="center">Explore the site and see news, portfolio and experience. Send me an email if you want to work together or just have a chat!</p>
    </article>
    <section>
        <h2 class="mainheading">Latest news<span class="fa-solid fa-turn-down"></span> </h2>
        <?php
        // get news
        $news_list = $news->getLatestNews();
        foreach ($news_list as $n) {
        ?>
<!-- print to screen -->
            <article class="newsshorts newsgrid">
                <picture class="newsgridleft thumb">
                    <source type="image/webp" srcset="images/thumb_<?= $n['image_name'] ?>.webp">
                    <img src="images/thumb_<?= $n['image_name'] ?>.jpg" alt="<?= $n['alttext'] ?>">
                </picture>
                <div class="newsgridright">
                    <h3 class="title"><?= $n['title'] ?></h3>
                    <p class="date">Published: <?= $n['date'] ?></p>
                    <div class="content"><?= substr($n['content'], 0, 500) ?></div>
                    <p class="readmore"><a href='singlenews.php?id=<?= $n['id'] ?>'>Keep reading <span class="fa-solid fa-caret-right"></span></a></p>
                </div>
            </article>
        <?php
        }
        ?>
    </section>
</section>
<!-- includes footer -->
<?php
include("includes/footer.php");
?>
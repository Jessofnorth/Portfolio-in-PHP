<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/
$page_title = "Experience";
include("includes/header.php");

// create objects
$skill = new Skill();
$education = new Education();
$work = new Work;
?>
<section>
    <h1 class="indexhead">Experience </h1>
    <!-- print skills -->
    <article>
        <h2 class="mainheading">Skills<span class="fa-solid fa-turn-down"></span></h2>
        <div class="skillsgrid">
            <?php
            // print to screen
            $skill_list = $skill->getSkills();
            foreach ($skill_list as $s) {
            ?>
                <section>
                    <div class="skillscontain">
                        <div class="skills" style="width: <?= $s['skill_level'] ?>%;"><?= $s['skill'] ?><span class="arrow skillarrow fa-solid fa-chevron-down"></span></div>
                        
                    </div>
                    <div class="skillexpand">
                        <?= $s['description'] ?>
                    </div>
                </section>
            <?php
            }
            ?>

        </div>
    </article>
    <!-- print education -->
    <article>
        <h2 class="mainheading">Education<span class="fa-solid fa-turn-down"></span></h2>
        <div class="skillsgrid">
            <?php
            // print to screen
            $edu_list = $education->getEducation();
            foreach ($edu_list as $e) {
            ?>
                <section class="contentsingle">
                   <h3 class="title"><?= $e['course'] ?> - <?= $e['school'] ?></h3>
                   <p class="date">When: <?= $e['date'] ?></p>
                   <?= $e['content'] ?>
                </section>
            <?php
            }
            ?>

        </div>
    </article>
      <!-- print work -->
      <article>
        <h2 class="mainheading">Work Experience<span class="fa-solid fa-turn-down"></span></h2>
        <div class="skillsgrid">
            <?php
            // print to screen
            $work_list = $work->getWork();
            foreach ($work_list as $w) {
            ?>
                <section class="contentsingle">
                   <h3 class="title"><?= $w['jobtitle'] ?> - <?= $w['employer'] ?></h3>
                   <p class="date">When: <?= $e['date'] ?></p>
                   <?= $w['content'] ?>
                </section>
            <?php
            }
            ?>

        </div>
    </article>
</section>
<!-- includes footer -->
<?php
include("includes/footer.php");
?>
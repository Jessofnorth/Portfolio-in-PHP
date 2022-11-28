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
$skill = new Skill;
$education = new Education;
$work = new Work;


// set default values
$errormsgskill = "";
$errormsgwork = "";
$errormsgedu = "";
// skill
$skill_type = "";
$skill_level = 0;
$skill_description = "";
// education
$education_title = "";
$education_school = "";
$date_edu = "";
$edu_description = "";
// work
$work_title = "";
$date_work = "";
$employer = "";
$work_description = "";
// check if form is posted - skill
if (isset($_POST['skill_type'])) {
    $skill_type = $_POST['skill_type'];
    $skill_level = $_POST['skill_level'];
    $skill_description = $_POST['skill_description'];
    $success = true;
    // check the inputs
    if (!$skill->setSkilltype($skill_type)) {
        $success = false;
        $errormsgskill  .= "<p class='error'>You must add a skill to the post!</p> <br>";
    }
    if (!$skill->setSkilllevel($skill_level)) {
        $success = false;
        $errormsgskill  .= "<p class='error'>You must add a skill level between 1-100 to the post!</p><br>";
    }
    if (!$skill->setSkilldescription($skill_description)) {
        $success = false;
        $errormsgskill  .= "<p class='error'>You must add an description of the skill!</p><br>";
    }
    // send to method/class
    if ($success) {
        // if post is published send back to news.php for cleaning th einputs and write message
        if ($skill->addSkill($skill_type, $skill_level, $skill_description)) {
            header("Location: experience.php?success");
        } else {
            $errormsgskill  = "<p class='error'>Something went wrong, skill not saved!</p>";
        }
    } else {
        $errormsgskill  .= "<p class='error'>The skill could not be saved, check your inputs!</p>";
    }
}
// check if form is posted - education
if (isset($_POST['education_title'])) {
    $education_title = $_POST['education_title'];
    $education_school = $_POST['education_school'];
    $date_edu = $_POST['date_edu'];
    $edu_description = $_POST['edu_description'];
    $success = true;
    // check the inputs
    if (!$education->setEducationtitle($education_title)) {
        $success = false;
        $errormsgedu  .= "<p class='error'>You must add a title to the education!</p> <br>";
    }
    if (!$education->setSchool($education_school)) {
        $success = false;
        $errormsgedu  .= "<p class='error'>You must add an Institution to the education!</p><br>";
    }
    if (!$education->setEducationDate($date_edu)) {
        $success = false;
        $errormsgedu  .= "<p class='error'>You must add an start date of the education!</p><br>";
    }
    if (!$education->setDescription($edu_description)) {
        $success = false;
        $errormsgedu  .= "<p class='error'>You must add an description of the education!</p><br>";
    }

    if ($success) {
        // if post is published send back to news.php for cleaning th einputs and write message
        if ($education->addEducation($education_title, $education_school, $date_edu, $edu_description)) {
            header("Location: experience.php?success");
        } else {
            $errormsgedu  = "<p class='error'>Something went wrong, education not saved!</p>";
        }
    } else {
        $errormsgedu  .= "<p class='error'>The education could not be saved, check your inputs!</p>";
    }
}
// check if form is posted - work
if (isset($_POST['work_title'])) {
    $work_title = $_POST['work_title'];
    $date_work = $_POST['date_work'];
    $employer = $_POST['employer'];
    $work_description = $_POST['work_description'];
    $success = true;
    // check the inputs
    if (!$work->setWorktitle($work_title)) {
        $success = false;
        $errormsgwork  .= "<p class='error'>You must add a title to the work!</p> <br>";
    }
    if (!$work->setEmployer($employer)) {
        $success = false;
        $errormsgwork  .= "<p class='error'>You must add an employer to the work!</p><br>";
    }
    if (!$work->setWorkDate($date_work)) {
        $success = false;
        $errormsgwork  .= "<p class='error'>You must add an start date of the work!</p><br>";
    }

    if (!$work->setWorkDescription($work_description)) {
        $success = false;
        $errormsgwork  .= "<p class='error'>You must add an description of the work!</p><br>";
    }

    if ($success) {
        // if post is published send back to news.php for cleaning th einputs and write message
        if ($work->addWork($work_title, $date_work, $employer, $work_description)) {
            header("Location: experience.php?success");
        } else {
            $errormsgwork  = "<p class='error'>Something went wrong, work not saved!</p>";
        }
    } else {
        $errormsgwork  .= "<p class='error'>The work could not be saved, check your inputs!</p>";
    }
}
// delete 
$postdeletedskill = "";
$postdeletededu = "";
$postdeletedwork = "";

// check if a post should be deleted
if (isset($_GET['deleteskill'])) {
    $delete = $_GET['deleteskill'];
    if ($skill->deleteSkill($delete)) {
        $postdeletedskill = "<p class='error'>The skill with ID: $delete has been deleted.</p> <br>";
    } else {
        $postdeletedskill = "<p class='error'>The skill could not be deleted!</p> <br>";
    }
}
// check if a post should be deleted
if (isset($_GET['deleteedu'])) {
    $delete = $_GET['deleteedu'];
    if ($education->deleteEducation($delete)) {
        $postdeletededu = "<p class='error'>The education with ID: $delete has been deleted.</p> <br>";
    } else {
        $postdeletededu = "<p class='error'>The education could not be deleted!</p> <br>";
    }
}
// check if a post should be deleted
if (isset($_GET['deletework'])) {
    $delete = $_GET['deletework'];
    if ($work->deleteWork($delete)) {
        $postdeletedwork = "<p class='error'>The work with ID: $delete has been deleted.</p> <br>";
    } else {
        $postdeletedwork = "<p class='error'>The work could not be deleted!</p> <br>";
    }
}
?>


<section>
    <h1 class="indexhead">Manage Experience</h1>
    <p class="center">Create and manage new skills, education and woork experience below.</p>
    <?= $postdeletedwork ?>
    <?= $postdeletedskill ?>
    <?= $postdeletededu ?>
    <?php
    // print success message if published
    if (isset($_GET['success'])) {
        echo "<p class='published center'>The experience is saved!</p>";
    }
    ?>
    <!-- skills -->
    <article>
        <h2 class="mainheading">Add skill<span class="fa-solid fa-turn-down"></span></h2>
        <?= $errormsgskill ?>

        <p class="center">Add skills and set skill level from 1-100, nothing to expert.</p>
        <form method="POST" action="experience.php">
            <div class="postforms">
                <!-- form -->
                <label for="skill_type">Skill:</label>
                <input type="text" name="skill_type" id="skill_type" value="<?= $skill_type ?>">
                <label for="skill_level">Skill level (0-100):</label>
                <input type="number" id="skill_level" name="skill_level" min="0" max="100" value="<?= $skill_level ?>">
                <label for="editor1">Description of skill:</label>
                <textarea name="skill_description" id="editor1" cols="60" rows="20"><?= $skill_description ?></textarea>
                <input type="submit" value="Save">
            </div>
        </form>

    </article>
    <article>
        <h2 class="mainheading">Skills list<span class="fa-solid fa-turn-down"></span></h2>
        <!-- foldout button -->
        <button class="btn" aria-expanded="false">Show list <span class="arrow fa-solid fa-chevron-down"></span></button>
        <div class="expand">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Skill</th>
                        <th>Level</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $skill_list = $skill->getSkills();
                    foreach ($skill_list as $s) {
                    ?>
                        <tr>
                            <td><?= $s['id'] ?></td>
                            <td><a href='skills.php'><?= $s['skill'] ?></a></td>
                            <td><?= $s['skill_level'] ?></td>
                            <td><a href='experience.php?deleteskill=<?= $s['id'] ?>'>Delete</a></td>
                            <td><a href='editskill.php?editskill=<?= $s['id'] ?>'>Edit</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </article>
    <!-- education -->
    <article>
        <h2 class="mainheading">Add education<span class="fa-solid fa-turn-down"></span></h2>
        <?= $errormsgedu ?>
        <p class="center">Add education information below.</p>
        <form method="POST" action="experience.php">
            <div class="postforms">
                <!-- form -->
                <label for="education_title">Title:</label>
                <input type="text" name="education_title" id="education_title" value="<?= $education_title ?>">
                <label for="education_school">Institution:</label>
                <input type="text" name="education_school" id="education_school" value="<?= $education_school ?>">
                <label for="date_edu">Date (ex 2020-02-23 - Current):</label>
                <input type="text" id="date_edu" name="date_edu" value="<?= $date_edu ?>">
                <label for="editor2">Description of education:</label>
                <textarea name="edu_description" id="editor2" cols="60" rows="20"><?= $edu_description ?></textarea>
                <input type="submit" value="Save">
            </div>
        </form>

    </article>
    <article>
        <h2 class="mainheading">Education list<span class="fa-solid fa-turn-down"></span></h2>
        <!-- foldout button -->
        <button class="btn" aria-expanded="false">Show list <span class="arrow fa-solid fa-chevron-down"></span></button>
        <div class="expand">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Institution</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $edu_list = $education->getEducation();
                    foreach ($edu_list as $e) {
                    ?>
                        <tr>
                            <td><?= $e['id'] ?></td>
                            <td><a href='skills.php'><?= $e['course'] ?></a></td>
                            <td><?= $e['school'] ?></td>
                            <td><a href='experience.php?deleteedu=<?= $e['id'] ?>'>Delete</a></td>
                            <td><a href='editedu.php?editedu=<?= $e['id'] ?>'>Edit</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </article>
    <!-- work -->
    <article>
        <h2 class="mainheading">Add work<span class="fa-solid fa-turn-down"></span></h2>
        <?= $errormsgwork ?>
        <p class="center">Add work information below.</p>
        <form method="POST" action="experience.php">
            <div class="postforms">
                <!-- form -->
                <label for="work_title">Position:</label>
                <input type="text" name="work_title" id="work_title" value="<?= $work_title ?>">
                <label for="employer">Employer:</label>
                <input type="text" name="employer" id="employer" value="<?= $employer ?>">
                <label for="date_work">Date (ex 2020-02-23 - Current):</label>
                <input type="text" id="date_work" name="date_work" value="<?= $date_work ?>">
                <label for="editor3">Description of employment:</label>
                <textarea name="work_description" id="editor3" cols="60" rows="20"><?= $work_description ?></textarea>
                <input type="submit" value="Save">
            </div>
        </form>

    </article>

    <article>
        <h2 class="mainheading">Work list<span class="fa-solid fa-turn-down"></span></h2>
        <!-- foldout button -->
        <button class="btn" aria-expanded="false">Show list <span class="arrow fa-solid fa-chevron-down"></span></button>
        <div class="expand">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Position</th>
                        <th>Employer</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $work_list = $work->getWork();
                    foreach ($work_list as $w) {
                    ?>
                        <tr>
                            <td><?= $w['id'] ?></td>
                            <td><a href='skills.php'><?= $w['jobtitle'] ?></a></td>
                            <td><?= $w['employer'] ?></td>
                            <td><a href='experience.php?deletework=<?= $w['id'] ?>'>Delete</a></td>
                            <td><a href='editwork.php?editwork=<?= $w['id'] ?>'>Edit</a></td>
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
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
    CKEDITOR.replace('editor3');
</script>
<!-- include footer -->
<?php
include("includes/footer.php");
?>
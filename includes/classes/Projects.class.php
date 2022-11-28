<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/

class Projects extends Files
{

    // properties

    private $db;
    private $title;
    private $weblink;
    private $intro;
    private $content;
    private $alttext;

    // constructor with db connection and running the image class constructor
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }

        parent::__construct();
    }

    // add news to database 
    public function addProject(string $title, string $content, array $image, string $alttext, string $intro, string $weblink, array $pdf): bool
    {
        // check the set methods
        if (!$this->setTitle($title)) return false;
        if (!$this->setContent($content)) return false;
        if (!$this->setAlttext($alttext)) return false;
        if (!$this->setWeblink($weblink)) return false;
        if (!$this->setIntro($intro)) return false;
        $image_name = $this->saveImage($image);
        if ($image_name === "standard") {
            $this->alttext = "Logo";
        }
        $pdf_name = $this->savePDF($pdf);
        if ($pdf_name === "null") {
            $pdf_name = "null";
        }
        // sql query
        $sql = "INSERT INTO project_projects(title, website, intro, content, image_name, alttext, pdf_name)VALUES('" . $this->title . "', '" . $this->weblink . "', '" . $this->intro . "',  '" . $this->content . "', '" . $image_name . "', '" . $this->alttext . "', '" . $pdf_name . "');";
        return mysqli_query($this->db, $sql);
    }


    // update a news article
    public function updateProject(int $id, string $title, string $content, string $intro, string $weblink): bool
    {
        // check the set methods
        if (!$this->setTitle($title)) return false;
        if (!$this->setContent($content)) return false;
        if (!$this->setIntro($intro)) return false;
        if (!$this->setWeblink($weblink)) return false;

        $sql = "UPDATE project_projects SET title='$title', content='$content', intro='$intro', website='$weblink' WHERE id=$id; ";
        return mysqli_query($this->db, $sql);
    }

    // set-methods - returns true/false
    // title
    public function setTitle(string $title): bool
    {
        $title = $this->db->real_escape_string($title);
        $title = strip_tags($title);
        $title = trim($title);
        if ($title != "") {
            $this->title = $title;
            return true;
        } else {
            return false;
        }
    }

    // content
    public function setContent(string $content): bool
    {
        $content = $this->db->real_escape_string($content);
        $content = trim($content);
        $content = strip_tags($content, [
            'h1', 'h2', 'h3', 'pre', 'em', 'blockquote', 'a', 'p',
            'strong', 'ul', 'ol', 'li', 'tabel', 'tbody', 'tr', 'td'
        ]);
        if ($content != "") {
            $this->content = $content;
            return true;
        } else {
            return false;
        }
    }
    // set alttext for img
    public function setAlttext(string $alttext): bool
    {
        $alttext = $this->db->real_escape_string($alttext);
        $alttext = strip_tags($alttext);
        $alttext = trim($alttext);
        $this->alttext = $alttext;
        return true;
    }

    // weblink
    public function setWeblink(string $weblink): bool
    {
        $weblink = $this->db->real_escape_string($weblink);
        $weblink = strip_tags($weblink);
        $weblink = trim($weblink);
        if ($weblink != "") {
            $this->weblink = $weblink;
            return true;
        } else {
            return false;
        }
    }

    // intro
    public function setIntro(string $intro): bool
    {
        $intro = $this->db->real_escape_string($intro);
        $intro = strip_tags($intro);
        $intro = trim($intro);
        if ($intro != "") {
            $this->intro = $intro;
            return true;
        } else {
            return false;
        }
    }

    // get project from db and save to array
    public function getProject(): array
    {
        $sql = "SELECT * FROM project_projects ORDER BY date DESC;";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // get specific project by ID
    public function getProjectByID(int $id): array
    {
        $id = intval($id);
        $sql = "SELECT * FROM project_projects WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }

     // get specific project PDF name by ID
     public function getPDFByID(int $id): array
     {
         $id = intval($id);
         $sql = "SELECT pdf_name FROM project_projects WHERE id=$id;";
         $result = mysqli_query($this->db, $sql);
         return $result->fetch_assoc();
     }

    // delete project from db and any files from directory
    public function deleteProject(int $id): bool
    {
        $id = intval($id);
        $sql = "SELECT image_name FROM project_projects WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $image_name = $result[0]['image_name'];
        if ($image_name != "standard") {
            $this->deleteImage($image_name);
        }
        $sql = "SELECT pdf_name FROM project_projects WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $pdf_name = $result[0]['pdf_name'];
        if ($pdf_name != "null") {
            $this->deletePDF($pdf_name);
        }

        $sql = "DELETE FROM project_projects WHERE id=$id;";
        return mysqli_query($this->db, $sql);
    }


    // destructor - close db connection
    function __destruct()
    {
        mysqli_close($this->db);
    }
}

<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/

class News extends Files
{

    // properties

    private $db;
    private $title;
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
    public function addNews(string $title, string $content, array $image, string $alttext): bool
    {
        // check the set methods
        if (!$this->setTitle($title)) return false;
        if (!$this->setContent($content)) return false;
        if (!$this->setAlttext($alttext)) return false;
        $image_name = $this->saveImage($image);
        if ($image_name == "standard") {
            $this->alttext = "Logo";
        }

        // sql query
        $sql = "INSERT INTO project_news(title, content, image_name, alttext)VALUES('" . $this->title . "',  '" . $this->content . "', '" . $image_name . "', '" . $this->alttext . "');";
        return mysqli_query($this->db, $sql);
    }


    // update a news article
    public function updateNews(int $id, string $title, string $content): bool
    {
        // check the set methods
        if (!$this->setTitle($title)) return false;
        if (!$this->setContent($content)) return false;

        $sql = "UPDATE project_news SET title='$title', content='$content' WHERE id=$id; ";
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

    // get news from db and save to array
    public function getNews(): array
    {
        $sql = "SELECT * FROM project_news ORDER BY date DESC;";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // get specific news by ID
    public function getNewsByID(int $id): array
    {
        $id = intval($id);
        $sql = "SELECT * FROM project_news WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }

    // get the 2 latest news
    public function getLatestNews(): array
    {
        $sql = "SELECT * FROM project_news ORDER BY date DESC LIMIT 3;";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // delete news from db and images from directory
    public function deleteNews(int $id): bool
    {
        $id = intval($id);
        $sql = "SELECT image_name FROM project_news WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $image_name = $result[0]['image_name'];
        if ($image_name != "standard") {
            $this->deleteImage($image_name);
        }
        $sql = "DELETE FROM project_news WHERE id=$id;";
        return mysqli_query($this->db, $sql);
    }



    // destructor - close db connection
    function __destruct()
    {
        mysqli_close($this->db);
    }
}

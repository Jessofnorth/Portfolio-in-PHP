<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/

class Pages 
{

    // properties

    private $db;
    private $title;
    private $content;
    

    // constructor with db connection
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }

    }
     // add page to database 
     public function addPage(string $title, string $content): bool
     {
         // check the set methods
         if (!$this->setTitle($title)) return false;
         if (!$this->setContent($content)) return false;
 
         // sql query
         $sql = "INSERT INTO project_pages(title, content)VALUES('" . $this->title . "',  '" . $this->content . "');";
         return mysqli_query($this->db, $sql);
     }
 
 
     // update a page
     public function updatePage(int $id, string $title, string $content): bool
     {
         // check the set methods
         if (!$this->setTitle($title)) return false;
         if (!$this->setContent($content)) return false;
 
         $sql = "UPDATE project_pages SET title='$title', content='$content' WHERE id=$id; ";
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
 
     // get pages id and title from db and save to array
     public function getPages(): array
     {
         $sql = "SELECT id, title FROM project_pages ORDER BY title;";
         $result = mysqli_query($this->db, $sql);
         return mysqli_fetch_all($result, MYSQLI_ASSOC);
     }
 
     // get specific page by ID
     public function getPagesByID(int $id): array
     {
         $id = intval($id);
         $sql = "SELECT * FROM project_pages WHERE id=$id;";
         $result = mysqli_query($this->db, $sql);
         $result = $result->fetch_assoc();
         if( $result == null){
             $result = [];
         }
         return $result;
     }
 
     // delete page from db
     public function deletePage(int $id): bool
     {
         $id = intval($id);
         $sql = "DELETE FROM project_pages WHERE id=$id;";
         return mysqli_query($this->db, $sql);
     }
 
 
     // destructor - close db connection
     function __destruct()
     {
         mysqli_close($this->db);
     }
}
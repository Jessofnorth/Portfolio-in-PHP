<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/

class Work
{

    // properties

    private $db;
    private $work_title;
    private $date;
    private $employer;
    private $work_description;

    // constructor with db connection and running the image class constructor
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }
    }

    // save to db
    public function addWork(string $work_title, string $date, string $employer, string $work_description): bool
    {
        // check the set methods
        if (!$this->setWorktitle($work_title)) return false;
        if (!$this->setEmployer($employer)) return false;
        if (!$this->setWorkDate($date)) return false;
        if (!$this->setWorkDescription($work_description)) return false;

        // sql query
        $sql = "INSERT INTO project_work(jobtitle, date, employer, content)VALUES('" . $this->work_title . "', '" . $this->date . "', '" . $this->employer . "', '" . $this->work_description . "');";
        return mysqli_query($this->db, $sql);
    }


    // update work
    public function updateWork(int $id, string $work_title, string $date, string $employer, string $work_description): bool
    {
        // check the set methods
        if (!$this->setWorktitle($work_title)) return false;
        if (!$this->setEmployer($employer)) return false;
        if (!$this->setWorkDate($date)) return false;
        if (!$this->setWorkDescription($work_description)) return false;

        $sql = "UPDATE project_work SET jobtitle='$work_title', date='$date', employer='$employer', content='$work_description' WHERE id=$id; ";
        return mysqli_query($this->db, $sql);
    }


    // set properties
    public function setWorktitle(string $work_title): bool
    {
        $work_title = $this->db->real_escape_string($work_title);
        $work_title = strip_tags($work_title);
        $work_title = trim($work_title);
        if ($work_title != "") {
            $this->work_title = $work_title;
            return true;
        } else {
            return false;
        }
    }

    public function setEmployer(string $employer): bool
    {
        $employer = $this->db->real_escape_string($employer);
        $employer = strip_tags($employer);
        $employer = trim($employer);
        if ($employer != "") {
            $this->employer = $employer;
            return true;
        } else {
            return false;
        }
    }

    public function setWorkDate(string $date): bool
    {
        $date = $this->db->real_escape_string($date);
        $date = strip_tags($date);
        $date = trim($date);
        if ($date != "") {
            $this->date = $date;
            return true;
        } else {
            return false;
        }
    }

    public function setWorkDescription(string $work_description): bool
    {
        $work_description = $this->db->real_escape_string($work_description);
        $work_description = trim($work_description);
        $work_description = strip_tags($work_description, [
            'h1', 'h2', 'h3', 'pre', 'em', 'blockquote', 'a', 'p',
            'strong', 'ul', 'ol', 'li', 'tabel', 'tbody', 'tr', 'td'
        ]);
        if ($work_description != "") {
            $this->work_description = $work_description;
            return true;
        } else {
            return false;
        }
    }

    // get work from db and save to array
    public function getWork(): array
    {
        $sql = "SELECT * FROM project_work;";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

      // get specific work by ID
      public function getWorkByID(int $id): array
      {
          $id = intval($id);
          $sql = "SELECT * FROM project_work WHERE id=$id;";
          $result = mysqli_query($this->db, $sql);
          return $result->fetch_assoc();
      }

    // delete work from db
    public function deleteWork(int $id): bool
    {
        $id = intval($id);
        $sql = "DELETE FROM project_work WHERE id=$id;";
        return mysqli_query($this->db, $sql);
    }

    // destructor - close db connection
    function __destruct()
    {
        mysqli_close($this->db);
    }
}

<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/

class Education
{

    // properties

    private $db;
    private $education_title;
    private $education_school;
    private $date;
    private $edu_description;

    // constructor with db connection and running the image class constructor
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }
    }

    // save to db
    public function addEducation(string $education_title, string $education_school, string $date, string $edu_description): bool
    {
        // check the set methods
        if (!$this->setEducationtitle($education_title)) return false;
        if (!$this->setSchool($education_school)) return false;
        if (!$this->setEducationDate($date)) return false;
        if (!$this->setDescription($edu_description)) return false;

        // sql query
        $sql = "INSERT INTO project_education(course, date, school, content)VALUES('" . $this->education_title . "', '" . $this->date . "', '" . $this->education_school . "', '" . $this->edu_description . "');";
        return mysqli_query($this->db, $sql);
    }


    // update education
    public function updateEducation(int $id, string $education_title, string $education_school, string $date, string $edu_description): bool
    {
        // check the set methods
        if (!$this->setEducationtitle($education_title)) return false;
        if (!$this->setSchool($education_school)) return false;
        if (!$this->setEducationDate($date)) return false;
        if (!$this->setDescription($edu_description)) return false;

        $sql = "UPDATE project_education SET course='$education_title', date='$date', school='$education_school', content='$edu_description' WHERE id=$id; ";
        return mysqli_query($this->db, $sql);
    }


    // set properties
    public function setEducationtitle(string $education_title): bool
    {
        $education_title = $this->db->real_escape_string($education_title);
        $education_title = strip_tags($education_title);
        $education_title = trim($education_title);
        if ($education_title != "") {
            $this->education_title = $education_title;
            return true;
        } else {
            return false;
        }
    }

    public function setSchool(string $education_school): bool
    {
        $education_school = $this->db->real_escape_string($education_school);
        $education_school = strip_tags($education_school);
        $education_school = trim($education_school);
        if ($education_school != "") {
            $this->education_school = $education_school;
            return true;
        } else {
            return false;
        }
    }

    public function setEducationDate(string $date): bool
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

    public function setDescription(string $edu_description): bool
    {
        $edu_description = $this->db->real_escape_string($edu_description);
        $edu_description = trim($edu_description);
        $edu_description = strip_tags($edu_description, [
            'h1', 'h2', 'h3', 'pre', 'em', 'blockquote', 'a', 'p',
            'strong', 'ul', 'ol', 'li', 'tabel', 'tbody', 'tr', 'td'
        ]);
        if ($edu_description != "") {
            $this->edu_description = $edu_description;
            return true;
        } else {
            return false;
        }
    }

    // get education from db and save to array
    public function getEducation(): array
    {
        $sql = "SELECT * FROM project_education;";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

     // get specific education by ID
     public function getEducationByID(int $id): array
     {
         $id = intval($id);
         $sql = "SELECT * FROM project_education WHERE id=$id;";
         $result = mysqli_query($this->db, $sql);
         return $result->fetch_assoc();
     }
 

    // delete education from db
    public function deleteEducation(int $id): bool
    {
        $id = intval($id);
        $sql = "DELETE FROM project_education WHERE id=$id;";
        return mysqli_query($this->db, $sql);
    }

      // destructor - close db connection
      function __destruct()
      {
          mysqli_close($this->db);
      }
}

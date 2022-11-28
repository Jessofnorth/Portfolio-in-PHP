<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/

class Skill
{

    // properties

    private $db;
    private $skill_type;
    private $skill_level;
    private $skill_description;

    // constructor with db connection and running the image class constructor
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }
    }

    // save to db
    public function addSkill(string $skill_type, int $skill_level, string $skill_description): bool
    {
        // check the set methods
        if (!$this->setSkilltype($skill_type)) return false;
        if (!$this->setSkilllevel($skill_level)) return false;
        if (!$this->setSkilldescription($skill_description)) return false;

        // sql query
        $sql = "INSERT INTO project_skills(skill, skill_level, description)VALUES('" . $this->skill_type . "', '" . $this->skill_level . "', '" . $this->skill_description . "');";
        return mysqli_query($this->db, $sql);
    }


    // update skill
    public function updateSkill(int $id, string $skill_type, int $skill_level, string $skill_description): bool
    {
        // check the set methods
        if (!$this->setSkilltype($skill_type)) return false;
        if (!$this->setSkilllevel($skill_level)) return false;
        if (!$this->setSkilldescription($skill_description)) return false;

        $sql = "UPDATE project_skills SET skill='$skill_type', skill_level='$skill_level', description='$skill_description' WHERE id=$id; ";
        return mysqli_query($this->db, $sql);
    }


    // set properties
    public function setSkilltype(string $skill_type): bool
    {
        $skill_type = $this->db->real_escape_string($skill_type);
        $skill_type = strip_tags($skill_type);
        $skill_type = trim($skill_type);
        if ($skill_type != "") {
            $this->skill_type = $skill_type;
            return true;
        } else {
            return false;
        }
    }

    public function setSkilllevel(int $skill_level): bool
    {
        intval($skill_level);
        $skill_level = $this->db->real_escape_string($skill_level);
        $skill_level = strip_tags($skill_level);
        $skill_level = trim($skill_level);
        if ($skill_level > 0) {
            $this->skill_level = $skill_level;
            return true;
        } else {
            return false;
        }
    }

    public function setSkilldescription(string $skill_description): bool
    {
        $skill_description = $this->db->real_escape_string($skill_description);
        $skill_description = trim($skill_description);
        $skill_description = strip_tags($skill_description, [
            'h1', 'h2', 'h3', 'pre', 'em', 'blockquote', 'a', 'p',
            'strong', 'ul', 'ol', 'li', 'tabel', 'tbody', 'tr', 'td'
        ]);
        if ($skill_description != "") {
            $this->skill_description = $skill_description;
            return true;
        } else {
            return false;
        }
    }

    // get skill from db and save to array
    public function getSkills(): array
    {
        $sql = "SELECT * FROM project_skills;";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

      // get specific skill by ID
      public function getSkillByID(int $id): array
      {
          $id = intval($id);
          $sql = "SELECT * FROM project_skills WHERE id=$id;";
          $result = mysqli_query($this->db, $sql);
          return $result->fetch_assoc();
      }
  

    // delete skill from db
    public function deleteSkill(int $id): bool
    {
        $id = intval($id);
        $sql = "DELETE FROM project_skills WHERE id=$id;";
        return mysqli_query($this->db, $sql);
    }

     // destructor - close db connection
     function __destruct()
     {
         mysqli_close($this->db);
     }
}

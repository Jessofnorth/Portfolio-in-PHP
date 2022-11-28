<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/

use LDAP\Result;

class Users
{

    // properties

    private $db;
    private $email;
    private $password;
    private $fname;
    private $lname;


    // constructor with db connection
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }
    }

    // register new user 
    public function registerUser(string $email, string $password, string $fname, string $lname): bool
    {
        if (!$this->setEmail($email)) return false;
        if (!$this->setPassword($password)) return false;
        if (!$this->setFname($fname)) return false;
        if (!$this->setLname($lname)) return false;
        // hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO project_users(password, email, fname, lname)VALUES('$hashed_password', '$email', '$fname', '$lname' );";
        return mysqli_query($this->db, $sql);
    }
    // login existing user 
    public function loginUser(string $email, string $password): bool
    {
        if (!$this->setEmail($email)) return false;
        if (!$this->setPassword($password)) return false;

        $sql = "SELECT * FROM project_users WHERE email='$email';";
        $result = $this->db->query($sql);
        // check stored hashed pass against hashed entered pass
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_pass = $row['password'];

            if (password_verify($password, $stored_pass)) {

                $_SESSION['email'] = $email;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    // check if usernamne is available - if email exist send error
    public function userAvailability($email): bool
    {
        $email = $this->db->real_escape_string($email);
        $sql = "SELECT email FROM project_users WHERE email='$email';";
        $result = mysqli_query($this->db, $sql);
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            return true;
        } else {
            return false;
        }
    }

    // set email
    public function setEmail(string $email): bool
    {
        // checkinput - security
        $email = $this->db->real_escape_string($email);
        $email = strip_tags($email);
        $email = trim($email);
        filter_var($email, FILTER_VALIDATE_EMAIL);
        if (strlen($email)  > 4) {
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }
    // set password
    public function setPassword(string $password): bool
    {
        // checkinput - security
        $password = $this->db->real_escape_string($password);
        $password = strip_tags($password);
        $password = trim($password);
        if (strlen($password) > 7) {
            $this->password = $password;
            return true;
        } else {
            return false;
        }
    }
    // set first name 
    public function setFname(string $fname): bool
    {
        // checkinput - security
        $fname = $this->db->real_escape_string($fname);
        $fname = strip_tags($fname);
        $fname = trim($fname);
        if (strlen($fname)  > 0) {
            $this->fname = $fname;
            return true;
        } else {
            return false;
        }
    }
    // set last name
    public function setLname(string $lname): bool
    {
        // checkinput - security
        $lname = $this->db->real_escape_string($lname);
        $lname = strip_tags($lname);
        $lname = trim($lname);
        if (strlen($lname)  > 0) {
            $this->lname = $lname;
            return true;
        } else {
            return false;
        }
    }

    // get list of users - except ID 1 thats ADMIN to prevent deleting admin
    public function getUsers(): array
    {
        $sql = "SELECT * FROM project_users WHERE id != 1;";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // delete user from db
    public function deleteUser(int $id): bool
    {
        $id = intval($id);
        $sql = "DELETE FROM project_users WHERE id=$id;";
        return mysqli_query($this->db, $sql);
    }

    // logout user by destroying session
    public function logoutUser()
    {
        session_destroy();
        header("Location: index.php");
        exit;
    }

    // destructor - close db connection
    function __destruct()
    {
        mysqli_close($this->db);
    }
}

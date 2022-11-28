<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University*/


class Mail
{
    // propertys
    private $db;
    private $email;
    private $subject;
    private $message;

    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connection:" . $this->db->connect_error);
        }
    }

    // send email
    public function sendMail(string $email, string $subject, string $message) : bool
    {
        // set propertys
        $to = "jeej2100@student.miun.se";
        if (!$this->setEmail($email)) return false;
        if (!$this->setSubject($subject)) return false;
        if (!$this->setMessage($message)) return false;
        // add header to know who to respond
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ' . $this->email . "\r\n" .
            'Reply-To: ' . $this->email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        // send email, return tru if sent, false if not 
        if (mail($to, $this->subject, $this->message, $headers)) {
            return true;
        } else {
            return false;
        }
    }

    // set email, subject and message and check these inputs
    public function setEmail(string $email): bool
    {
        $email = $this->db->real_escape_string($email);
        $email = strip_tags($email);
        $email = trim($email);
        filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($email != "") {
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }

    public function setSubject(string $subject): bool
    {
        $subject = $this->db->real_escape_string($subject);
        $subject = strip_tags($subject);
        $subject = trim($subject);
        if ($subject != "") {
            $this->subject = $subject;
            return true;
        } else {
            return false;
        }
    }

    public function setMessage(string $message): bool
    {
        $message = $this->db->real_escape_string($message);
        $message = strip_tags($message);
        $message = trim($message);
        if ($message != "") {
            $this->message = $message;
            return true;
        } else {
            return false;
        }
    }

     // destructor - close db connection
     function __destruct()
     {
         mysqli_close($this->db);
     }
}

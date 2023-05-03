<?php

class User
{
    public $userID;
    public $username;
    public $password;

    public function __construct($userID, $username = null, $password = null)
    {
        $this->userID = $userID;
        $this->username = $username;
        $this->password = $password;
    }

    public static function logInUser($user, mysqli $conn)
    {
        $query = "SELECT userID, username FROM user WHERE username='$user->username' and password='$user->password'";
        
        return $conn->query($query)->fetch_assoc();
    }
}

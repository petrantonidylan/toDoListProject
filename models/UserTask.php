<?php

class UserTask
{

    private $table="UserTask";
    private $connection;

    private $user_id;
    private $user_login;
    private $user_password;

    public function __construct($connection)
    {
        $this -> connection = $connection;
    }

    //SETTER

    public function setUserId($id)
    {
        $this -> user_id = $id;
    }

    public function setUserLogin($login)
    {
        $this -> user_login = $login;
    }

    public function setUtilisateurPass($password)
    {
        $this -> user_password = password_hash($password, PASSWORD_DEFAULT);
    }

    //---------

    public function authenticate($p_user_login, $p_user_password) {
        $query = "SELECT * FROM " . $this -> table . " WHERE user_login = :user_login";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':user_login', $p_user_login);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($p_user_password, $user['user_password'])) {
            return true;
        } else {
            return false;
        }
    }

    public function insert(){
        try{
            $query = $this->connection->prepare("INSERT INTO " . $this -> table . " (user_login, user_password) VALUES (:login, :password)");
            $query->bindParam(':login', $this->user_login);
            $query->bindParam(':password', $this -> user_password);
            $query->execute();
            $this -> connection = null;
            return true;
        }catch(Exception $e)
        {
            return false;
        }
    }
}
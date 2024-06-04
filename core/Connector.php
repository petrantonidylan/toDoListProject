<?php
    class Connector
    {
        private $driver;
        private $host, $user, $pass, $database, $charset;

        public function __construct()
        {
            $db_cfg = require_once 'config/database.php';
            $this -> driver = DB_DRIVER;
            $this -> host = DB_HOST;
            $this -> user = DB_USER;
            $this -> pass = DB_PASS;
            $this -> database = DB_DATABASE;
            $this -> charset = DB_CHARSET;
        }

        public function connection()
        {
            try{
                $connection = new PDO("sqlsrv:Server=DYLAN\\SQLEXPRESS;Database=".$this->database, $this->user, $this->pass);
                $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $connection;

            }catch(PDOException $e)
            {
                echo $e;
                throw new Exception('Problème de connexion à la base de donnée. Merci de prévenir l\'administrateur');
            }
        }
    }

?>
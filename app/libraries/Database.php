<?php
/*
 * PDO Database Class
 * Connect to Database
 * create prepared statements
 * Bind values
 * Return rows and results
 */
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh; // database holder
    private $stmt;
    private $error;

    public function __construct() {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create PDO Instance
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass);
        }catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
    // Prepare statements with query
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    } 

    // Bind values
    public function bind($param, $value, $type) {
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                $type = pdo::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement (we will use it in the functions below)
    public function execute() {
        return $this->stmt->execute();
    }

    // Get results set as array of objects
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function rowCount(){
        $this->execute();
        return $this->stmt->rowCount();
    }
}
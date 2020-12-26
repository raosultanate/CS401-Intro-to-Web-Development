<?php
require_once 'KLogger.php';

class Dao {

  private $host = "localhost:8889";
  private $db = "danny_apparel";
  private $user = "danny";
  private $pass = "Linkinpark1!";
  private $logger;

  public function __construct () {
    $this->logger = new KLogger ("log.txt" , KLogger::DEBUG);
  }


  public function getConnection () {
    $this->logger->LogDebug("getting a connection");
    try {
      $conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
      return $conn;
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("Ooops the database crapped its pants: " . print_r($e, 1));
      exit;
    }
  }
  //check if user email is in the database
  public function checkUserExist($userEmail){
    $this->logger->LogInfo("Checking if user Exist");  
    $conn = $this->getConnection();
    $sth = $conn->prepare("SELECT signUp.userEmail from signUp where signUp.userEmail like :email");
    $sth->bindParam(":email", $userEmail);
    $sth->execute();
    $result = $sth->fetchAll();
    return $result;

}
  //to confirm data for logging in.
  public function checkUser($userEmail, $userPass){
    $this->logger->LogInfo("Checking if user email and password match to the one present in the database.");  
    $conn = $this->getConnection();
    $sth = $conn->prepare("SELECT * from signUp where signUp.userEmail  like :email and signUp.userPassword like :pass");
    $sth->bindParam(":email", $userEmail);
    $sth->bindParam(":pass", $userPass);
    $sth->execute();
    $result = $sth->fetchAll();
    return $result;

}
  // to add data of the user to the database.
  public function addSignupUser($userEmail, $userPass) {
    $this->logger->LogInfo("Creating user Account!");
    $conn = $this->getConnection();
    $saveQuery = "insert into signUp (userEmail, userPassword) values (:userID, :userPass)";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":userID", $userEmail);
    $q->bindParam(":userPass", $userPass);
    $q->execute();
  }

}

//Test Cases:
// $dao = new Dao();
//$dao->addSignupUser("danielrao@boisestate.edu", "12345678");
// $arr = $dao->checkUser("danielrao@gmail.com","12345678");
// $arr = $dao->checkUserExist("abc@gmail.com");
// print_r($arr);
<?php
require_once "Dao.php";
session_start();
$_SESSION['signupErr'] = array();
$_SESSION['credentials'] = array();

  $postUserEmail = $_POST["email"];
  $postUserPassword = $_POST["psw"];
  $postUserRePassword = $_POST["psw-repeat"];
    //    Test Case:
    //    $postUserEmail = "alu123@gmail.com";
    //    $postUserPassword = "12345678";
    //    $postUserRePassword = "12345678";

    $emailPattern = '/^([a-zA-Z0-9_\-\.%]+)@([a-zA-Z0-9_\-\.]+)\.(com|gov|org|net)$/';
    $passPattern = '/^([a-zA-Z0-9!@#$%^&*-=_+|?.,`~()]{8,})$/';
    $dao = new Dao(); //helps to establish database connection.  
    $emailPatternMatch = preg_match($emailPattern , $postUserEmail); //returns a 1 if found 0 if not.
    $passPatternMatch = preg_match($passPattern, $postUserPassword);
    $passwordCmp = strcasecmp($postUserPassword, $postUserRePassword); //returns 0 if string is same else some other number.
    $passwordLength = strlen($postUserPassword);
    $salt = "236%#%$&$%*$5p['124[]*+_-=+421\4";

    if ($emailPatternMatch==1) {
        
        if($passPatternMatch == 1){

            if($passwordLength>=8) {

                if($passwordCmp==0) {
                    //checks if the user exist
                    $exit = $dao->checkUserExist($postUserEmail);
                    if(count($exit) == 0){
                        //setting the cookie to login the user automatically once the user logs in.
                        $cookie_name = "Authorized";
                        $cookie_value = "true";
                        setcookie($cookie_name,$cookie_value); 
    
                        //hashing the password
                        $hashPass = hash("sha256", $postUserPassword . $salt, $binary = FALSE);
                        // adds to the database.
                        $addSignupUser =  $dao->addSignupUser($postUserEmail, $hashPass); 
                        header("location: index.php");
                        exit();
                    }
                    else {
                        $_SESSION['credentials'][] = $postUserEmail;
                        $_SESSION['signupErr'][] = "Email already exits, try a different One?";
                        header("location: signUp.php");
                        exit();
                    }    
                    
                }
                
            }
    
            elseif($passwordCmp == 0 && $passwordLength<8){
                $_SESSION['credentials'][] = $postUserEmail;
                $_SESSION['signupErr'][] = "password must be atleast 8 characters";
                header("location: signUp.php");
                exit();
            }
    
            elseif($passwordCmp != 0 && $passwordLength<8){
                $_SESSION['credentials'][] = $postUserEmail;
                $_SESSION['signupErr'][] = "password does not match";
                $_SESSION['signupErr'][]= "password must be atleast 8 characters";
                header("location: signUp.php");
                exit();
            }

        }

        else {
            $_SESSION['credentials'][] = $postUserEmail;
            $_SESSION['signupErr'][]= "Password requirements does not comply with our policies";
            header("location: signUp.php");
            exit();
        }
        
    }

    elseif($emailPatternMatch == 0){

        if($passPatternMatch ==1) {

            if($passwordCmp == 0 && $passwordLength<8){

                $_SESSION['credentials'][] = $postUserEmail;
                $_SESSION['signupErr'][] = "Invalid Email";
                $_SESSION['signupErr'][] = "password must be atleast 8 characters";
                header("location: signUp.php");
                exit();
            }
    
            elseif($passwordCmp != 0 && $passwordLength<8){

                $_SESSION['credentials'][] = $postUserEmail;
                $_SESSION['signupErr'][] = "Invalid Email";
                $_SESSION['signupErr'][] = "password does not match";
                $_SESSION['signupErr'][]= "password must be atleast 8 characters";
                header("location: signUp.php");
                exit();
            }
            elseif($passwordCmp != 0) {

                $_SESSION['credentials'][] = $postUserEmail;
                $_SESSION['signupErr'][] = "Invalid Email";
                $_SESSION['signupErr'][] = "password does not match";
                header("location: signUp.php");
                exit();
    
            }
    
            else {

                $_SESSION['credentials'][] = $postUserEmail;
                $_SESSION['signupErr'][] = "Invalid Email";
                header("location: signUp.php");
                exit();
            }

        }

        else {

            $_SESSION['credentials'][] = $postUserEmail;
            $_SESSION['signupErr'][] = "Invalid Email";
            $_SESSION['signupErr'][]= "Password requirements does not comply with our policies";
            header("location: signUp.php");
            exit();

        }   

    }

    else {
        $_SESSION['credentials'][] = $postUserEmail;
        $_SESSION['signupErr'][] = "Fatal Error";
        exit();
    } 
 
?>
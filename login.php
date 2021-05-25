<?php

session_start();
 

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit();
}



    $email = isset($_POST['email']) ? $_POST["email"]: "";
    $password = isset($_POST['password']) ? $_POST["password"]: "";

    require_once 'database-connect.php';

    $sql = "SELECT id, firstname, lastname, email, password, admin FROM User WHERE email='{$email}'";
    $result = $conn->query($sql);
    
    $user;
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $user = $row;
      }
    } else {
      echo "0 results";
    }

    if(password_verify($password, $user['password'])){
        $_SESSION["id"] = $user['id'];
        $_SESSION["firstname"] = $user['firstname'];
        $_SESSION["lastname"] = $user['lastname'];
        $_SESSION["email"] = $user['email'];
        $_SESSION["admin"] = $user['admin'] ? true : false;
        $_SESSION["loggedin"] = true;

        header("location: index.php");
        exit();
    }
    
    $conn->close();

?>
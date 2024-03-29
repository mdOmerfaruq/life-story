<?php
session_start();
include "Db_conn.php";

if (isset($_POST['name']) && isset($_POST['email'])&& isset($_POST['password'])&& isset($_POST['re_password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);
    $name = validate($_POST['name']);
    $re_pass = validate($_POST['re_password']);
    $user_data = 'email='. $email. '&name='. $name;


    if (empty($email)) {
        header("Location: Signup.php?error=Email is required&$user_data");
        exit();
    } else if (empty($pass)) {
        header("Location: Signup.php?error=Password is required&$user_data");
        exit();
    }
    else if (empty($name)) {
        header("Location: Signup.php?error=name is required&$user_data");
        exit();
    }
    else if ($pass!==$re_pass) {
        header("Location: Signup.php?error=password not match is required&$user_data");
        exit();
    }else {
        $pass = md5($pass);

        $sql = "SELECT * FROM users WHERE user_name='$email' ";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            header("Location: signup.php?error=The username is taken try another&$user_data");
            exit();
        }else {
            $sql2 = "INSERT INTO users(user_name, password, name) VALUES('$email', '$pass', '$name')";
            $result2 = mysqli_query($conn, $sql2);
            if ($result2) {
                header("Location: signup.php?success=Your account has been created successfully");
                exit();
            }else {
                header("Location: signup.php?error=unknown error occurred&$user_data");
                exit();
            }
        }
    }


}
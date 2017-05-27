<?php
require_once 'session-handler.php';
session_name("2Org-Cows");
session_start();
$math = hash_hmac('sha256', 'update_user_password', $_SESSION["set_password_token"]);
if (hash_equals($_POST["set_password_token"], $math)) {
    unset($_SESSION["group_token"]);
    unset($_SESSION["user_token"]);
    unset($_SESSION["delete_token"]);
    unset($_SESSION["grant_token"]);
    unset($_SESSION["set_password_token"]);
    $date = date("U");
    $_SESSION["expire"] = $date + (60*60*24);
    if (!empty($_POST["set_user_password"]) && !empty($_POST["confirm_set_user_password"])) {
        $new_password = $_POST["set_user_password"];
        $password_verify = $_POST["confirm_set_user_password"];
        if (strcmp($new_password, $password_verify) == 0) {
            include_once 'auth_connect.php';
            $user_id = intval($_POST["update_user_password"]);
            $password = password_hash($new_password, PASSWORD_DEFAULT, ['cost' => 12]);
            $sql1 = "UPDATE auth SET `password_hash` = '$password' WHERE `ID_User` = ?";
            $stmt1 = $auth->prepare($sql1);
            $stmt1->bind_param('i', $user_id);
            $stmt1->execute();
            $val3 = "Password successfully updated";
            $auth->close();
            header("Location:../admin?val3=$val3");
            exit();
        } else {
            $auth->close();
            $agri_star_001->close();
            $var1 = "Passwords do not match";
            header("Location:../admin?val1=$var1");
            exit();
    }
    } else {
        $var2 = "Please fill in all required fields";
        header("Location:../admin?val2=$var2");
        exit();
        }
    } else {
            $string4 = "Session terminated due to security concerns. Please check your internet connection";
            session_destroy();
            header("Location:..?val1=$string4");
            exit();
            }


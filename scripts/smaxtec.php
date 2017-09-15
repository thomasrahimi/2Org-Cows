<?php
require_once 'session-handler.php';
session_name("2Org-Cows");
session_start();
$calc = hash_hmac("sha256", "smaxtec_connect", $_SESSION["smaxtec_token"]);
if (hash_equals($calc, $_POST["smaxtec_token"])){
    if (!empty($_POST["smaxtec_email"]) && !empty($_POST["smaxtec_password"])){
        include_once "credentials_connect.php";
        $email = $credentials->real_escape_string($_POST["smaxtec_email"]);
        $password = $credentials->real_escape_string($_POST["smaxtec_password"]);
        $id_group = $_SESSION["group"];
        $service = "smaxtec";
        $sql = "INSERT INTO credentials (`ID_Group`, `service`, `username`, `password`) VALUES (?, ?, ?, ?)";
        $stmt1 = $credentials->prepare($sql);
        $stmt1->bind_param("iss", $id_group, $service, $email, $password);
        $stmt1->execute();
        $var2 = "Synchronization will start soon";
        header("Location:../upload?val2=$var2");
        exit();
    } else {
        $var1 = "Please fill in all required fields";
        header("Location:../upload?val1=$var1");
        exit();
    }
} else {
    session_destroy();
    $var4 = "Session terminated for security concerns. Please check your internet connection";
    header("Location:..?val4=$var4");
    exit();
}
?>
<?php
require_once 'session-handler.php';
session_name("2Org-Cows");
session_start();
$calc = hash_hmac('sha256','upload_file',$_SESSION["upload_token"]);
if(hash_equals($calc, $_POST["upload_token"])) {
	unset($_SESSION["upload_token"]);
	if (isset($_FILES["data_files"]) && $_FILES["data_files"]["size"] > 0) { # http://www.php-mysql-tutorial.com/wikis/mysql-tutorials/uploading-files-to-mysql-database.aspx, https://bytes.com/topic/php/insights/740327-uploading-files-into-mysql-database-using-php
            if ($_FILES["data_files"]["error"] == 0) {
                include_once "agri_star_001_connect.php";
                $file = $agri_star_001->real_escape_string(file_get_contents($_FILES["data_files"]["tmp_name"]));
                $filetype = $agri_star_001->real_escape_string($_FILES["data_files"]["type"]);
                $allowed_types = ["text/x-adasrc","text/comma-separated-values","text/plain"];
                if (in_array($filetype, $allowed_types) == false) {
                    $var1 = "File not matching conditions";
                    $agri_star_001->close();
                    header("Location:../upload?val1=$var1");
                    exit();
                } else {
                $measurement_method = intval($_POST["choose-measurement"]);
                $user_id = intval($_SESSION["userid"]);
                $date = date("U");
                $sql1 = "INSERT INTO files (`filetype`, 
                                            `ID_User`, 
                                            `ID_Gage`, 
                                            `time`, 
                                            `file`) VALUES 
                                            (?, 
                                            ?, 
                                            ?, 
                                            ?, 
                                            ?)";
                $stmt1 = $agri_star_001->prepare($sql1);
                $stmt1->bind_param("siiib", $filetype, $user_id, $measurement_method, $date, $file);
                $stmt1->send_long_data(4, file_get_contents($_FILES["data_files"]["tmp_name"]));
                $stmt1->execute();
                $error = $agri_star_001->error;
                $var2 = "File successfully uploaded";
                $agri_star_001->close();
                header("Location:../upload?val2=$var2");
                exit();
            }
            }
	} else {
	    $var3 = "Upload error";
	    header("Location:../upload?val3=$var3");
	    exit();
	}	
} else {
    session_destroy();
    $var4 = "Session terminated for security concerns. Please check your internet connection";
    header("Location:..?val4=$var4");
    exit();
}

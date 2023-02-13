<?php
include_once("../database/config.php");
session_start();

$username = $_SESSION['adminname'];

    $language = strtolower($_POST['language']);
    $code = $_POST['code'];
    $file_id=$_GET['file_id'];

    $sql = "SELECT * FROM admin_files WHERE `file_id`='$file_id'";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
            
    $filename = $row['filename'];
    $filetype = $row['filetype'];

    $filePath = $username."/".$filename.".".$filetype;
    $programFile = fopen($filePath, "w");
    fwrite($programFile, $code);
    fclose($programFile);



    if($language == "php") {
        $output = shell_exec("C:\php-8.1.8\php.exe C:/xampp/htdocs/project/livecode/ide/$filePath 2>&1");
        echo $output;
    }
    if($language == "python") {
        $output = shell_exec("C:\Python310\python.exe C:/xampp/htdocs/project/livecode/ide/$filePath 2>&1");
        echo $output;
    }
    if($language == "node") {
        rename($filePath, $filePath.".js");
        $output = shell_exec("C:/nodejs/node.exe C:/xampp/htdocs/project/livecode/ide/$filePath.js 2>&1");
        echo $output;
    }

    

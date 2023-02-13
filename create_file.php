<?php
include_once("./database/config.php");

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
}

$user_id = $_SESSION['user_id'];
$image = $_SESSION['image'];
$username = $_SESSION['username'];

echo $filename= strtolower($_POST['name']);
echo $filetype= $_POST['lang'];

date_default_timezone_set('Asia/Dhaka');
$created = date('y-m-d h:i:s');

$sql = "SELECT * FROM user_files WHERE user_id='$user_id' AND `filename`='$filename' AND `filetype`='$filetype'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    echo"<script>
    alert('File Alrteady Exists');
    window.location.href='user_files.php';
    </script>";

    echo $created;

}
else{

    $sql = "INSERT INTO user_files(`user_id`,`filename`, filetype, created ) VALUES ('$user_id','$filename','$filetype', '$created')";
    $result = mysqli_query($conn, $sql);
    
    if($result){
        $file_path = "ide"."/".$username;

        $sql = "SELECT `file_id` FROM user_files WHERE user_id='$user_id' AND `filename`='$filename' AND `filetype`='$filetype'";
        $result = mysqli_query($conn, $sql);
        $row=mysqli_fetch_assoc($result);
        
        $file_id = $row['file_id'];
            
       $repo = fopen($file_path."/".$filename.".".$filetype, "a") or die("Unable to open file!");
        
        if($filetype == "python"){
    
            $txt ="#Start Writing your Code";
            fwrite($repo, $txt);
            fclose($repo);
            header("Location: compiler.php?file_id=$file_id");
        }
        elseif($filetype == "php"){
            
            $txt = "<?php
//Start Writing your Code
    
                
?>";
            fwrite($repo, $txt);
            fclose($repo);
            header("Location: compiler.php?file_id=$file_id");
        }
        elseif($filetype == "node.js"){
            $txt = "//Start Writing your Code";
            fwrite($repo, $txt);
            fclose($repo);
            header("Location: compiler.php?file_id=$file_id");

        }
    }
}

?>
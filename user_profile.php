<?php
include_once("./database/config.php");

session_start();
$username = $_SESSION['username'];

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
}
$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$img=$row['user_img'];

$_SESSION['image'] = $img;
$_SESSION['user_id'] = $row['user_id'];
$_SESSION['username'] = $row['username'];

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);
$img=$row['user_img'];

$image = $row['user_img'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$about_me=$row['about_me'];
$gender=$row['gender'];
$birthday=$row['birthday'];
$contact=$row['contact'];
$email=$row['email'];
$address=$row['address'];
$city=$row['city'];
$zip=$row['zip'];

if (isset($_POST['submit_img'])) {

    $error = "";
    $cls="";
 
    $name = $_FILES['file']['name'];
    $target_dir = "images/users/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){

        // Upload file
        if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){

            // Convert to base64 
            $image_base64 = base64_encode(file_get_contents('images/users/'.$name));
            $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

            // Update Record
            $query2 = "UPDATE users SET `user_img`='$name' WHERE username='$username'";
            $query_run2 = mysqli_query($conn, $query2);

            $query3 = "UPDATE `recent` SET `image`='$name' WHERE `name`='$username'";
            $query_run3 = mysqli_query($conn, $query3);

            if ($query_run2 && $query_run3) {
                echo "<script> alert('Profile Image Successfully Updated.');
                window.location.href='dashboard.php';</script>";
            } 
            else {
                $cls="danger";
                $error = "Cannot Update Profile Image";
            }

        }else{
            $cls="danger";
            $error = 'Unknown Error Occurred.';
        }
    }else{
        $cls="danger";
        $error = 'Invalid File Type';
    }   
}

if (isset($_POST['submit'])) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender=$_POST['gender'];
    $birthday=$_POST['birthday'];
    $contact=$_POST['contact'];
    $email=$_POST['email'];
    $about_me=$_POST['about_me'];
    $address=$_POST['address'];
    $city=$_POST['city'];
    $zip=$_POST['zip'];

    $error = "";
    $cls="";

        // Update Record
        $query2 = "UPDATE users SET firstname='$firstname',lastname='$lastname',
        birthday='$birthday', email='$email', gender='$gender', contact='$contact',about_me='$about_me',
        `address`='$address', city='$city', zip='$zip' WHERE username='$username'";
        $query_run2 = mysqli_query($conn, $query2);
        
        if ($query_run2) {
            $cls="success";
            $error = "Profile Successfully Updated.";
        } 
        else {
            $cls="danger";
            $error = "Cannot Update Profile";
        }

}
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">

    <title>Livecode - Online Code Compiler</title>

    <!-- # Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- # CSS Plugins -->
    <link rel="stylesheet" href="plugins/slick/slick.css">
    <link rel="stylesheet" href="plugins/font-awesome/fontawesome.min.css">
    <link rel="stylesheet" href="plugins/font-awesome/brands.css">
    <link rel="stylesheet" href="plugins/font-awesome/solid.css">
</head>
<!-- # Main Style Sheet -->
<link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- navigation -->
    <?php include_once("./templates/user_header.php");?>
    <!-- /navigation -->

    <section class="banner bg-tertiary position-relative overflow-hidden" id="home">
    <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-10 col-xl-8">
            <h2 class="h3 mb-4 page-title">My Profile</h2>
            <div class="my-4">
              <form action="" method="POST" enctype='multipart/form-data'>
                <div class="row mt-5 align-items-center">
                  <div class="col-md-3 text-center mb-5">
                    <div class="avatar avatar-xl">
                      <img src="images/users/<?php echo $image?>" alt="..." class="avatar-img rounded-circle">
                      <input type="file" name="file" id="file" style="padding-left:5px;padding-top:30px;padding-bottom:20px;">

                      <button type="submit" name="submit_img" class="btn btn-primary">Save Change</button>

                    </div>
                  </div>
                  <div class="col">
                    <div class="row align-items-center" style="padding-left:30px;">
                      <div class="col-md-7">
                        <h3 class="mb-1"><?php echo $firstname." ".$lastname?></h3>
                        <p class="small mb-3"><span class="badge badge-dark"><?php echo $city;?>, Bangladesh</span></p>
                      </div>
                    </div>
                    <div class="row mb-4" style="padding-left:30px;">
                      <div class="col-md-7">
                        <p class="text-muted"><?php echo $about_me;?></p>
                      </div>
                      <div class="col">
                        <p class="small mb-0 text-muted"><?php echo $address?></p>
                        <p class="small mb-0 text-muted"><?php echo $city?> - <?php echo $zip;?></p>
                        <p class="small mb-0 text-muted"><?php echo $contact?></p>
                      </div>
                    </div>
                  </div>

                </div>
              </form>
              <hr class="my-4">
              <form action="" method="POST" enctype='multipart/form-data'>
                <div class="row">
                  <div class=" col-md-12">
                    <div class="alert alert-<?php echo $cls;?>">
                      <?php 
                        if (isset($_POST['submit']) || isset($_POST['submit_img'])){
                        echo $error;
                      }?>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="firstname">Firstname</label>
                    <input type="text" name="firstname" class="form-control" placeholder="Enter Firstname"
                      value="<?php echo $firstname?>" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="lastname">Lastname</label>
                    <input type="text" name="lastname" class="form-control" placeholder="Enter Lastname"
                      value="<?php echo $lastname?>" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="lastname">About Me</label><br>
                    <textarea name="about_me" cols="105.5" rows="3" class="form-control"
                      placeholder="Write something about yourself..."><?php echo $about_me?></textarea>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control" required>
                      <option value="<?php echo $gender?>">Select Gender</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                      <option value="others">Others</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="lastname">Birthday</label>
                    <input type="date" name="birthday" class="form-control" placeholder=""
                      value="<?php echo $birthday?>" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email"
                      value="<?php echo $email?>" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="contact">Contact</label>
                    <input type="text" name="contact" class="form-control" placeholder="Enter Contact Number"
                      value="<?php echo $contact?>" required>
                  </div>
                </div>


                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" name="address" placeholder="Enter Address"
                    value="<?php echo $address?>" required>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="city">City</label>
                    <input type="text" class="form-control" name="city" placeholder="Enter City"
                      value="<?php echo $city?>" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="zip">Zip</label>
                    <input type="text" class="form-control" name="zip" placeholder="Enter Zip" value="<?php echo $zip?>"
                      required>
                  </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Save Change</button>
              </form>
            </div> <!-- /.card-body -->
          </div> <!-- /.col-12 -->
        </div> <!-- .row -->
      </div> 
    </section>

    <?php include_once("./templates/footer.php");?>

    <!-- # JS Plugins -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/bootstrap.min.js"></script>
    <script src="plugins/slick/slick.min.js"></script>
    <script src="plugins/scrollmenu/scrollmenu.min.js"></script>

    <!-- Main Script -->
    <script src="js/script.js"></script>

</body>

</html>
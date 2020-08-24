<?php

require_once "config.php";
session_start();


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


if(isset($_POST['goBack'])){
    header("location: panel.php");
}


$newPass_err = '';
$NewPassConfirm_err = '';
// echo $newPass;

// if($_SERVER["REQUEST_METHOD"] == "POST"){
if(isset($_POST['changePW'])){

    $newPass = $_POST['newPass'];
    $newPassConfirm = $_POST['newPassConfirm'];

    if(empty(trim($_POST["newPass"]))){
        $newPass_err = "Please enter new password.";
        } else{
        $newPass = trim($newPass);
    }

    if(empty(trim($_POST["newPassConfirm"]))){
        $newPassConfirm_err = "Please confirm your password.";
    } else{
        $newPassConfirm = trim($newPassConfirm);
    }

    // echo $newPass_err;
    // echo $newPassConfirm_err;
    // echo $newPass;
    echo '<br>';
    // echo $newPassConfirm;
 

    if( (empty($newPass_err) && empty($newPassConfirm_err)) && ($newPass == $newPassConfirm) ){
        // echo 'inside the block';
        $newPassHash = password_hash($newPass, PASSWORD_DEFAULT);
        // echo $newPass;
        // echo $newPassHash;

        $query = "UPDATE users SET password=? WHERE username=?";
        $stmt = mysqli_prepare($link, $query);
        $username = 'hradmin';
        mysqli_stmt_bind_param($stmt, "ss", $newPassHash,$username);

        // echo $query;
        // $stmt = $link->prepare($query);
        // echo '<br>';
        // print_r($stmt);
        
        // $stmt->bind_param("ss",$newPassHash,"hradmin" );
        // echo '<br>';
        // print_r($stmt);

        if( $stmt->execute() ){
            // echo "prepared update statement was successful";
            header("location: panel.php");
            echo "<script type='text/javascript'>alert('Your password was changed successfully);</script>";

        } else {
            // echo "pprepared update statement was not successful";
        }


    }


} 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHX6 Career Development Center</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel='stylesheet' href='../css/main.css'>
</head>
<body>

<div class="wrapper">
<section class="mb-5 text-center">

  <p>Set a new password</p>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">

    <div class="form-group <?php echo (!empty($newPass_err)) ? 'has-error' : ''; ?>">
    <!-- <label>New Password</label> -->
      <input type="password" name="newPass" class="form-control">
      <span class="help-block"><?php echo $newPass_err; ?></span>

      <!-- <label data-error="wrong" data-success="right" for="newPass">New password</label> -->


    </div>

    <div class="form-group <?php echo (!empty($newPassConfirm_err)) ? 'has-error' : ''; ?>">
    <!-- <label>New Password</label>   -->
    <input type="password" name="newPassConfirm" class="form-control">
    <span class="help-block"><?php echo $newPassConfirm_err; ?></span>

      <!-- <label data-error="wrong" data-success="right" for="newPassConfirm">Confirm password</label> -->
    </div>
    
    <div class="form-group">
        <button type="submit" onclick="return confirm('If your password is successfully changed you will be taken back to the admin panel')" name='changePW' class="btn btn-primary mb-4">Change password</button>    
        <button type="submit" name = 'goBack' class="btn btn-primary mb-4">Go Back</button>
    </div>  


  </form>





  </section>
    
</body>
</html>
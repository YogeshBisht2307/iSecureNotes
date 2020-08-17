<?php
  // declaring Global Variable
  $showError = false;
  $showAlert = false;
  //for checking that wether singup form method is post or not;
  if($_SERVER["REQUEST_METHOD"]=="POST"){
      require 'partials/database_connect.php';

      //Now taking value from the signup form;
      $email = $_POST["email"];
      $username = $_POST["username"];
      $password = $_POST["password"];
      $repassword = $_POST["repassword"];
      //Query for taking the all the username same as taken from form.
      $check = "Select * from users where username = '$username'";
      $check_result = mysqli_query($connection , $check);
      // getting the no of row which is having the same username;
      $checkRow = mysqli_num_rows($check_result);

      //for checking existence of the entered username;
      if($checkRow > 0){
        $showError = "Username already Exist";
      }
      else{
        if($password == $repassword){
          //for security of password using hashing of pasword;
          $hash = password_hash($password , PASSWORD_DEFAULT);
          //now query for inserting user data into database table.
          $insert = "INSERT INTO `users` (`email`, `username`, `password`, `date`) VALUES ('$email', '$username', '$hash', CURRENT_TIMESTAMP);";
          //command to insert;
          $insert_result = mysqli_query($connection, $insert);
          if($insert_result){
            $showAlert = true;
          }
        }
        else{
          $showError = "Password do not match !";
        }
      }

  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous">

    <title>Signup</title>
  </head>
  <body>
    
    <?php require 'partials/navbar.php' ?>
    <?php 
      if($showAlert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Hey ".$username."</strong> Your Account has created Successfully login now !.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
      }
      if($showError){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error! </strong>".$showError."
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
      }
    ?>
    <div class="container mt-4 ">
    <h2 class="text-center mb-4">Signup to My Website !</h2>
    <form action="/iSecureNotes/signup.php" method="POST">
      <div class="form-group">
        <label for="Email">EMAIL ADDRESS</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="username">USERNAME</label>
        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="password">PASSWORD</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <div class="form-group">
        <label for="repassword">RE-PASSWORD</label>
        <input type="password" class="form-control" id="repassword" name="repassword">
        <small id="passwordHelp" class="form-text text-muted">Password must be same!</small>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
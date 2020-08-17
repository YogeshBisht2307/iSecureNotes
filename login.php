<?php
  // declaring Global Variable
  $showError = false;
  $login = false;
  //for checking that wether singup form method is post or not;
  if($_SERVER["REQUEST_METHOD"]=="POST"){
    
      require 'partials/database_connect.php';

      //Now taking value from the login form;
      $username = $_POST["username"];
      $password = $_POST["password"];
      //Query for taking the all the username same as taken from login form.
      $check = "Select * from users where username = '$username'";
      $check_result = mysqli_query($connection , $check);
      // getting the no of row which is having the same username;
      $checkRow = mysqli_num_rows($check_result);

      //for checking existence of the entered username;
      if($checkRow == 1){
        //to get all those row from check_result
        while($row = mysqli_fetch_assoc($check_result)){
            if(password_verify($password , $row['password'])){
              $login = true;
              session_start();
              $_SESSION['loggedin']=true;
              $_SESSION['username']=$username;
              header("location: notes.php");
            }
            else{
              $showError = true;
            }
        }
      }
      else{
          $showError = true;
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

    <title>login</title>
  </head>
  <body>
    
    <?php require 'partials/navbar.php' ?>
    <?php 
      if($login){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Hey ".$username."</strong>You are logged in now.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
      }
      if($showError){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!</strong> Invalid creditianl,username and password do not match.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
      }
    ?>
    <div class="container mt-5 ">
    <h2 class="text-center mb-2">Login to Your Account !</h2>
    <p class="text-center mb-4">BEFORE LOGIN, MAKE SURE YOU HAVE SIGNUP !</p>
    <form action="/iSecureNotes/login.php" method="POST">
      
      <div class="form-group">
        <label for="username">USERNAME</label>
        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="password">PASSWORD</label>
        <input type="password" class="form-control" id="password" name="password">
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
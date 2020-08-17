<?php 
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header ("location: login.php");
  exit();
}
?>
<?php 
  $insert=false;
  if($_SERVER["REQUEST_METHOD"]=="POST"){
    require 'partials/database_connect.php';
    //taking notes from notes form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $insertion= "INSERT INTO `notes` ( `title`, `description`) VALUES ('$title', '$description')";
    $insertion_result = mysqli_query($connection,$insertion);

    if($insertion_result){
      $insert=true;
    }
  else{
      echo "Record is not Inserted successfully because of this error-----> :- ".mysqli_error($conn);
    }
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>iSecureNotes - <?php echo $_SESSION['username'];?></title>
    
  </head>
  <body>
     <?php require 'partials/navbar.php' ?>
     <?php
      if($insert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success ! </strong> Your notes has been saved successfully, You can check out it at admin page. !
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
      }
     ?>
      <div class="container mt-5">
        <div class="alert alert-success" role="alert">
          <h4 class="alert-heading">Welcome <?php echo $_SESSION['username'];?></h4>
          <p>Aww Yeah, You successfully log in to iSecureNotes, Now Secure your notes under our high secure eyes, Security of your data is our prime spot !</p>
          <hr>
          <p class="mb-0">Whenever You need to , be sure logout <a href="/iSecureNotes/logout.php">Using this link.</a></p>
      </div>

      <div class="container mt-5">
        <h2 class="text-center mb-2">Add a Note to Remember !</h2>
        <p class="text-center mb-4">PRIMARY KEY TO REMEMBER EVERYTHING !</p>
        <form action="/iSecureNotes/notes.php" method="POST">
          
          <div class="form-group">
            <label for="title">NOTE TITLE</label>
            <input type="text" class="form-control" id="title" name="title">
          </div>
          <div class="form-group">
            <label for="description">NOTE DESCRIPTION</label>
            <textarea class="form-control" id="description" name ="description" rows="4"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
      </div>
  </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
</body>
</html>
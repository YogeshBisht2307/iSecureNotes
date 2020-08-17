<?php
  $loggedin = false;
  if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    $loggedin = true;
  }
  echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">iSecureNotes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse text-center navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/iSecureNotes/notes.php">Home<span class="sr-only">(current)</span></a>
      </li>';
      if($loggedin){
        echo '<li class="nav-item">
        <a class="nav-link" href="/iSecureNotes/login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/iSecureNotes/signup.php">Singup</a>
      </li>';
      }
      
      echo '<li class="nav-item">
      <a class="nav-link" href="#">Contacts</a>
    </li>';
    if(!$loggedin){
      echo '<li class="nav-item">
      <a class="nav-link" href="/iSecureNotes/admin.php">Admin Pannel</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/iSecureNotes/logout.php">Logout</a>
    </li>';
}
  echo '</ul>
</div>
</nav>';
    
?>
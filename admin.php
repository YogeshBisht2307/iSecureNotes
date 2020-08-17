<?php 
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header ("location: login.php");
  exit();
}
?>
<?php
    $update= false;
    $delete = false;
    require 'partials/database_connect.php';
    //for deleting notes
    if(isset($_GET['delete']))
    {
    $sno=$_GET['delete'];
    $delete = "DELETE FROM `notes` WHERE `notes`.`S_no` = $sno";
    $deleted_result = mysqli_query($connection,$delete);
    if($deleted_result){
        $delete = true;
    }
    else{
        $err = mysqli_error($conn);
        echo "deletion not possible due to this error:-  $err";
    }
    
    }
    //for updating notes 
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['snoEdit'])){
          //update query.
          $S_no = $_POST['snoEdit'];
          $title= $_POST['titleEdit'];
          $description = $_POST['descEdit'];
          $update= "UPDATE `notes` SET `title` = '$title' , `description`='$description' WHERE `notes`.`s_no` = $S_no";
          $update_result = mysqli_query($connection,$update);
          if($update_result){
            $update=true;
            }
          else{
              echo "Record is not Inserted successfully because of this error-----> :- ".mysqli_error($connection);
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel ="stylesheet" href= "//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

    <title>Admin Pannel</title>
  </head>
  <body>
  <?php require 'partials/navbar.php' ?>
  <?php
        if($delete){
          echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> Your notes has been deleted successfully.
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
        }
        if($update){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> Your notes has been updated successfully.
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
        }
      ?>
  <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit this Node</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="/iSecureNotes/admin.php" method="post">
              <input type="hidden" name="snoEdit" id="snoEdit">
                <div class="form-group">
                  <label for="title">Note Title</label>
                  <input type="text" class="form-control" id="titleEdit" name="titleEdit">
                </div>
                <div class="form-group">
                    <label for="textarea">Note Description</label>
                    <textarea class="form-control" id="descEdit" name="descEdit" rows="4"></textarea>
                  </div>
                <button type="submit" class="btn btn-primary">Update Note</button>
              </form>
          </div>
        </div>
      </div>
      </div>
    <div class="container mt-5">
        <h2 class="text-center mb-3">Here is your list of all notes !</h2>
        <p class="text-center mb-5">WE SERVE YOU TO EDIT AND DELETE FUNCTION TO MANIPULATE YOUR NOTES </p>
        <table class="table" id="notesTable">
        <thead>
              <tr>
                <th scope="col">S.No</th>
                <th scope="col">Ttile</th>
                <th scope="col">Descritpion</th>
                <th scope="col">Actions</th>
              </tr>
        </thead>
        <tbody>
                <?php
                  $sql= "SELECT * FROM `notes`";
                  $result = mysqli_query($connection,$sql);
                  //find the number of records retured
                  $num= mysqli_num_rows($result);
                  $s_no=0;
                  //Display the reows returned by the sql query
                  if($num>0){
                      while($row = mysqli_fetch_assoc($result)){
                        $s_no++;
                        echo "<tr>
                        <th scope='row'>". $s_no."</th>
                        <td>".$row['title']."</td>
                        <td>".$row['description']."</td>
                        <td><button class='btn btn-sm btn-primary Edit' id=".$row['s_no'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['s_no'].">Delete</button>
                      </tr>";
                      }
                    }
              ?>

            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready( function () {
        $('#notesTable').DataTable();
        } );
    </script>
    <script>
      edits = document.getElementsByClassName('Edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          console.log("Edit",e.target.parentNode.parentNode);
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title, description);
          titleEdit.value= title;
          descEdit.value=description;
          snoEdit.value= e.target.id;
          console.log(e.target.id);
          $('#EditModal').modal('toggle');

        })
      })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          sno= e.target.id.substr(1,);
          if(confirm("Are you sure you want to delete it  !"))
            {
              console.log('yes');
              window.location=`/iSecureNotes/admin.php?delete=${sno}`;
            }
          else{
            console.log('no');
          }
        })
      })
    </script>
  </body>
</html>
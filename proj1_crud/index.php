<!-- CRUD - Create Read Update Delete-->


<?php
$insert = false;
$update = false;
$delete = false;
//Connect to the database
//INSERT INTO `notes` (`sno`, `title`, `description`, `datetime`) VALUES (NULL, 'Buy Books', 'Please buy books from store.', current_timestamp());
$servername = "localhost";
$username = "root";
$password = "";
$database = "proj_crud_inotes";

//create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
//die if connection fails
if (!$conn) {
  die("Connection failed!!!");
}


if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
  $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['snoEdit'])) {
    //update a record
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];

    //sql query
    $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno;";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      //echo "Records updated successfully!";
      $update = true;
    } else {
      echo "Record updation unsucessful!";
    }
  } else {
    //insert a record
    $title = $_POST['title'];
    $description = $_POST['description'];

    //sql query
    $sql = "INSERT INTO `notes` (`sno`, `title`, `description`, `datetime`) VALUES (NULL, '$title', '$description', current_timestamp())";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      //echo "Records updated successfully!";
      $insert = true;
    } else {
      echo "Record insertion unsucessful!";
    }
  }
}


?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="post-it.png" rel="icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListner("click", (e) => {
        console.log("edit ", e);

      })

    });
  </script>

  <title>eNotes</title>
</head>

<body>

  <!-- Edit modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Modal
</button> -->

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/proj1_crud/index.php" method="POST">
          <div class="modal-body">

            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="titleEdit" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">

            </div>

            <div class="mb-3">
              <label for="descriptionEdit" class="form-label">Note Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div>


          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img src="ENotes_logo.png" height="50px" alt="logo"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-brand" text-align="centre">
        <h3>Notes taking made easy</h3>
      </div>
    </div>
  </nav>

  <?php
  if ($insert) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your note has been inserted successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  ?>
  <?php
  if ($update) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your note has been updated successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  ?>
  <?php
  if ($delete) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your note has been deleted successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  ?>

  <div class="container my-5">
    <h2>Add a Note</h2>
    <form action="/proj1_crud/index.php" method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">

      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>
  <div class="container my-4">


    <table class="table table-hover" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sr.No.</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $srno = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
                <th scope='row'>$srno</th>
                <td>" . $row['title'] . "</td>
                <td>" . $row['description'] . "</td>
                <td><button class='edit btn btn-sm btn-primary' id=" . $row['sno'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=d" . $row['sno'] . ">Delete</button></td>
                </tr>";
          $srno = $srno + 1;
        }

        ?>


      </tbody>
    </table>

  </div>
  <hr>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    
    -->
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ", );
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');



      })

    });

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("delete ", );
        sno = e.target.id.substr(1, ); //considers all characters except first
        if (confirm("Are you sure you want to delete this note?")) {
          console.log("yes");
          window.location = `/proj1_crud/index.php?delete=${sno}`; //window.location will rederict you to that particular URL
          //if we consider this application for local use it's fine
          //but our application has some security issues
          //if order to avoid securitiy issues, we can Create a form and use POST request to submit that form
          //TODO : Create a form and use POST request to submit that form

        } else {
          console.log("no");
        }
      })
    });
  </script>

</body>

</html>
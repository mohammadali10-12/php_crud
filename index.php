<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "php_sql";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("connection error " . mysqli_connect_error($conn));
}
$insert = false;
$update = false;
$delete = false;

//delete data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = true;
    $sql = "delete from note where id='$id'";
    $result = mysqli_query($conn, $sql);
}

//update data and insert data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['idedit'])) {
        $id = $_POST['idedit'];
        $title = $_POST['titleedit'];
        $description = $_POST['descriptionedit'];

        $sql = "UPDATE `note` SET `tittle` = '$title',`description`='$description' WHERE `note`.`id` = $id";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            echo "data not updated " . mysqli_error($conn);
        }
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $sql = "insert into note (tittle,description) values (' $title','$description')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $insert = true;
        } else {
            echo "data not inserted " . mysqli_error($conn);
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iNotes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

</head>

<body>

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="editModal">

    </button> -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/learnphp/crud_php/index.php" method="post">
                    <input type="hidden" name="idedit" id="idedit">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Note </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Note Tittle</label>
                            <input type="text" id="titleedit" name="titleedit" class="form-control">
                            <div id="emailHelp" class="form-text"></div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1" class="form-label">Note Description</label>
                            <textarea class="form-control" id="descriptionedit" name="descriptionedit" row="3"></textarea>
                            <label for=""></label>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Note</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">iNotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="/learnphp/crud_php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link ">Contact</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>success</strong> note has been inserted successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    ?>
    <?php
    if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>success</strong> note has been update successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    ?>
    <?php
    if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>success</strong> note has been delete successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    ?>
    <!-- form -->

    <div class="container my-5">

        <form action="/learnphp/crud_php/index.php" method="post">
            <h2>Add Note</h2>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Note Tittle</label>
                <input type="text" id="title" name="title" class="form-control">
                <div id="emailHelp" class="form-text"></div>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label">Note Description</label>
                <textarea class="form-control" id="Description" name="description" row="3"></textarea>
                <label for=""></label>
            </div>

            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>


        <!-- table -->
        <div class="container my-5">
            <table class="table " id="myTable">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select * from note";
                    $result = mysqli_query($conn, $sql);
                    $id = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $id + 1;
                        echo " <tr>
                    <th scope='row'>" . $id . "</th>
                    <td>" . $row['tittle'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td><button class='edit btn btn-sm btn-primary' id=" . $row['id'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=" . $row['id'] . ">Delete</button></td>
                </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        edit = document.getElementsByClassName('edit');
        Array.from(edit).forEach((element) => {
            element.addEventListener("click", (e) => {

                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;

                titleedit.value = title;
                descriptionedit.value = description;
                id = idedit.value = e.target.id;
                $('#editModal').modal('toggle');
            })
        });
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                id = e.target.id.substr(1, );

                if (confirm('Are you sure delete for this note!')) {
                    console.log("yes");
                    window.location = `/learnphp/crud_php/index.php?delete=${id}`;
                } else {
                    console.log("no");
                }
            })
        });
    </script>
</body>

</html>
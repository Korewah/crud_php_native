<?php 

    session_start();
    
    include_once '../koneksi.php';

    $currPage = "anggota";

    include_once 'cekLogin.php';


    $sql = "SELECT * FROM anggota ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($query);

    if(isset($_POST['submit'])) {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $birthdate = $_POST['birthdate'];

        $sql = "UPDATE anggota SET name = ?, birthdate = ? WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $name, $birthdate, $id);
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        
        $sql = "INSERT INTO activity (action, created_at) VALUES (?, ?)";

        $data = [
          'title' => 'Edit Anggota',
          'name' => $name,
          'birthdate' => $birthdate,
        ];

        $data = json_encode($data);

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $data, date('Y-m-d H:i:s'));
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);

        header("Location: anggota.php");

    }
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Data anggota</title>

    <meta name="theme-color" content="#7952b3">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }


    </style>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">CRUD NATIVE</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="logout.php">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <?php include_once 'sidebar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data anggota</h1>
      </div>  

      <div class="card">
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-hover table-striped table-sm">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Tanggal Lahir</th>
                  <th scope="col">Umur Tahun Ini</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=1;if($data): ?>
                    <?php do { ?>
                    <tr>
                        <th scope="row"><?= $i++ ?></th>
                        <td><?= $data['name']; ?></td>
                        <td><?= $data['birthdate']; ?></td>
                        <td><?= date('Y') - date('Y', strtotime($data['birthdate'])) ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $data['id'] ?>" data-name="<?= $data['name'] ?>" data-birthdate="<?= $data['birthdate'] ?>">
                                Edit
                            </button>
                            <a href="delete_anggota?id=<?= $data['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php } while($data = mysqli_fetch_assoc($query)); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No data</td>
                    </tr>
                <?php endif ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>


    </main>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="mb-3 form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="name" class="form-label">Birth Date</label>
                            <input type="date" class="form-control mt-2" name="birthdate" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

      var myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
      
      $('#exampleModal').on('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var name = button.getAttribute('data-name')
        var birthdate = button.getAttribute('data-birthdate')
        var modal = $(this)
        modal.find('.modal-body input[name="id"]').val(id)
        modal.find('.modal-body input[name="name"]').val(name)
        modal.find('.modal-body input[name="birthdate"]').val(birthdate)
      })

    </script>
  </body>
</html>

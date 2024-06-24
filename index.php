<?php
    session_start();
    include 'koneksi.php';

    $sql = "SELECT anggota.*, fraksi.name AS fraksi FROM anggota INNER JOIN fraksi ON anggota.fraksi_id = fraksi.id ORDER BY anggota.id DESC";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($query);

    $sql = "SELECT * FROM fraksi ORDER BY id DESC";
    $query2 = mysqli_query($conn, $sql);
    $data_fraksi = mysqli_fetch_assoc($query2);
?>


<?php
    if (isset($_POST['submit'])) {

        $fraksi = $_POST['fraksi'];
        $name = $_POST['name'];
        $birthdate = $_POST['birthdate'];
        $sql = "INSERT INTO anggota (fraksi_id, name, birthdate) VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $fraksi,$name, $birthdate);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        
        $sql = "INSERT INTO activity (action, created_at) VALUES (?, ?)";

        $data = [
          'title' => 'New Anggota',
          'name' => $name,
          'birthdate' => $birthdate,
        ];

        $data = json_encode($data);

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $data, date('Y-m-d H:i:s'));
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);

        header("Location: index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
    <style>
        body, html {
            margin: 0;
            height: 100%;
        }

        .hero-image {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("assets/img/1104327.jpg");
            height: 50%;
            background-position: top;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }

        .hero-text {
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
        }
    </style>

    <?php include_once 'navbar.php'; ?>


    <div class="hero-image">
        <div class="hero-text">
            <h1>Selamat Datang di Pencatatan Anggota </h1>
            <p>Silahkan klik tombol di bawah untuk mendaftar</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Daftar
            </button>
        </div>
    </div>

    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Pendaftaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 form-group">
                            <label for="name" class="form-label">Fraksi</label>
                            <select name="fraksi" id="" class="form-control">
                            <?php $i=1;if($data_fraksi): ?>
                                <?php do { ?>
                                    <option value="<?= $data_fraksi['id']; ?>"><?= $data_fraksi['name']; ?></option>
                                <?php } while($data_fraksi = mysqli_fetch_assoc($query2)); ?>
                            <?php else: ?>
                                <option value="">No data</option>
                            <?php endif ?>
                            </select>
                            <!-- <input type="text" class="form-control" name="name" required> -->
                        </div>
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
                        <button type="submit" name="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="container mt-3">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Pendaftar</h1>
            </div>
            <div class="col-12 mt-2">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Vote</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;if($data): ?>
                            <?php do { ?>
                            <tr>
                                <th scope="row"><?= $i++ ?></th>
                                <td><?= $data['name']; ?></td>
                                <td>
                                    <?php if(isset($_SESSION['vote'])):?>
                                        <?php if($_SESSION['vote'] == $data['id']):?>
                                            <a disabled class="btn btn-primary disabled">Didukung</a>
                                        <?php else:?>
                                            <a disabled class="btn btn-primary disabled">Vote</a>
                                        <?php endif?>
                                    <?php else:?>
                                        <a href="vote?id=<?= $data['id'] ?>" class="btn btn-primary">Vote</a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php } while($data = mysqli_fetch_assoc($query)); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No data</td>
                            </tr>
                        <?php endif ?>
                        <tr>
                            <td colspan="3" class="text-center">Total Pendaftar : <?= $i-1 ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    
</body>
</html>
<?php 

    session_start();

    $currPage = "dashboard";

    include_once 'cekLogin.php';
    include_once '../koneksi.php';

    
    $sql = "SELECT anggota.*, fraksi.name AS fraksi, COUNT(vote.id) AS vote_all FROM vote INNER JOIN anggota ON vote.id_anggota = anggota.id INNER JOIN fraksi ON anggota.fraksi_id = fraksi.id GROUP BY id_anggota ORDER BY vote_all DESC";
    $C_anggota = mysqli_query($conn, $sql)->fetch_all(MYSQLI_ASSOC);
    
    $sql = "SELECT COUNT(vote.id) AS vote_all FROM vote";
    $C_total_vote = mysqli_query($conn, $sql)->fetch_assoc();
    $C_total_vote = $C_total_vote['vote_all'];

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Dashboard</title>

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
        <h1 class="h2">Dashboard</h1>
      </div>
      <h2>Selamat Datang <?= $_SESSION['name'] ?>!</h2>
      <div class="row">
        <?php foreach ($C_anggota as $anggota):?>
          <div class="col-lg-4">
            <div class="card bg-dark text-white">
              <div class="card-body">
                <h5 class="card-title"><?= ucwords(strtolower($anggota['name'])) ?></h5>
                <p class="card-text">Fraksi : <?= $anggota['fraksi'] ?>
                  <br>
                  Vote : <?= $anggota['vote_all'] ?>
                  <br>
                  Persentase vote: <?= (($C_total_vote / $anggota['vote_all']) * 100) . '%'  ?>
                </p>
              </div>
            </div>
          </div>
        <?php endforeach ?>
      </div>


    </main>
  </body>
</html>

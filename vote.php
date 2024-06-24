<?php
    include 'koneksi.php';

    session_start();
    
    $id = $_GET['id'];

    $sql = "INSERT INTO vote (id_anggota) VALUES (?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    $sql = "INSERT INTO activity (action, created_at) VALUES (?, ?)";

        $data = [
          'title' => 'Vote Anggota',
          'id' => $id,
        ];

        $data = json_encode($data);

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $data, date('Y-m-d H:i:s'));
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);

    $_SESSION['vote'] = $id;

    header("Location: index.php");

    die();
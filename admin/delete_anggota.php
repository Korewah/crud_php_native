<?php
    include '../koneksi.php';
    session_start();

    include_once 'cekLogin.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $id = $_GET['id'];
        $sql = "DELETE FROM anggota WHERE id = ?";
    
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt); 

        mysqli_stmt_close($stmt);
        
        $sql = "INSERT INTO activity (action, created_at) VALUES (?, ?)";

        $data = [
          'title' => 'Delete Anggota',
          'id' => $id,
        ];

        $data = json_encode($data);

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $data, date('Y-m-d H:i:s'));
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
    }

    header("Location: anggota");


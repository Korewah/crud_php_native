<?php
    include '../koneksi.php';
    session_start();

    include_once 'cekLogin.php';

    if(isset($_POST['submit'])) {


        $id = $_POST['name'];
        $sql = "INSERT INTO fraksi (name) VALUES (?)";
    
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt); 

        mysqli_stmt_close($stmt);
        
        $sql = "INSERT INTO activity (action, created_at) VALUES (?, ?)";

        $data = [
          'title' => 'Delete fraksi',
          'id' => $id,
        ];

        $data = json_encode($data);

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $data, date('Y-m-d H:i:s'));
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
    }

    header("Location: fraksi");


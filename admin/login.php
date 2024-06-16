<?php

session_start();

if(isset($_SESSION['login'])) {
    header("location: dashboard.php");
}


if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    include '../koneksi.php';

    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $cek = mysqli_num_rows($result);

    mysqli_close($conn);

    if($cek > 0) {
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['username'] = $username;
            $_SESSION['login'] = true;
            header("location: dashboard.php");
        }
    } else {
        $_SESSION['errorMSG'] = "Username / Password Salah";
    }
}

?>


<html>
    <head>
        <title>Halaman Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container" style="
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);">
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header">
                            <h5 class="card-title">Login</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <p class="text-danger"><?php if(isset($_SESSION['errorMSG'])) { echo $_SESSION['errorMSG']; } unset($_SESSION['errorMSG']); ?></p>
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username"><br>
                    
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" name="password" id="password"><br>
                    
                                <button name="submit" class="btn btn-primary" type="submit">Login</button>
                            </form>
                            <p class="mt-3">
                                usename : admin <br>
                                password : 12345
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </body>
</html>
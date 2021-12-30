<?php
$pesan="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        include "config/database.php";

        $username = input($_POST["username"]);
        $password = input($_POST["password"]);

        $cek_pengguna = "select * from pengguna where username='".$username."' and password='".$password."' limit 1";
        $hasil_cek = mysqli_query ($kon,$cek_pengguna);
        $jumlah = mysqli_num_rows($hasil_cek);
        $row = mysqli_fetch_assoc($hasil_cek);

        if ($jumlah>0){
            if ($row["status"]==1){
                $_SESSION["id_pengguna"]=$row["id_pengguna"];
                $_SESSION["kode_pengguna"]=$row["kode_pengguna"];
                $_SESSION["nama_pengguna"]=$row["nama_pengguna"];
                $_SESSION["username"]=$row["username"];

                //Redirect ke halaman admin
                header("Location:admin/index.php?halaman=kategori");

            }else {
                    $pesan="<div class='alert alert-warning'><strong>Gagal!</strong> Status pengguna tidak aktif.</div>";
                }

        }else {
            $pesan="<div class='alert alert-danger'><strong>Error!</strong> Username dan password salah.</div>";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>

        <div class="card mb-4">
        <div class="card-header">Halaman Login</div>
            <div class="card-body">
            <?php 	if ($_SERVER["REQUEST_METHOD"] == "POST") echo $pesan; ?>
            <?php 	if(isset($_GET['pesan'])){ if ($_GET["pesan"] == "login_dulu") echo "<div class='alert alert-danger'>Anda harus login dulu</div>"; }?>
                <div class="row">
                    <div class="col-sm-5">
                        <form action="index.php?halaman=login" method="post">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" placeholder="Masukan username">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukan password">
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>

<?php
session_start();
$userid = $_SESSION['a_global']->user_id;
include 'koneksi.php';
if($_SESSION['status_login'] != true){
  echo '<script>alert("Belum login! silahkan login")</script>';
          echo '<script>window.location="login.php"</script>';

}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>web galeri foto</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01" >
      <a class="navbar-brand" href="dashboard.php" style="font-size: 25px;">Hidden brand</a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item" style="margin-left: 15px; font-size: 20px;">
          <a class="nav-link" href="album.php">Album</a>
        </li>

        <li class="nav-item" style="font-size:20px;">
          <a class="nav-link" href="foto.php">Foto</a>
        </li>
      </ul>
      <form class="d-flex">
        <button class="btn btn-outline-danger" type="submit" ><a href="keluar.php" style="color:red;">keluar</a></button>
      </form>
    </div>
  </div>
</nav>

   

    <div class="container mt-3">
     
            <div class="row">
              <?php
              if(isset($_GET['album_id'])){
                $album_id = $_GET['album_id'];
                $query = mysqli_query($conn, "SELECT * FROM foto WHERE user_id='$userid' AND album_id='$album_id'");
                while($data = mysqli_fetch_array($query)) {?>
                  <div class="col-md-3 mt-2">
                    <div class="card">
                        <img style="height: 12rem;" src="assets/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top" title="<?php echo $data['judul_foto'] ?>">
                        <div class="card-footer text-center">
                            <?php
                            $foto_id = $data['foto_id'];
                            $ceksuka = mysqli_query($conn, "SELECT * FROM likefoto WHERE foto_id='$foto_id' AND user_id='$user_id'");
                            if(mysqli_num_rows($ceksuka) == 1){ ?>
                              <a href="proses_like.php?foto_id=<?php echo $data['foto_id'] ?>" type="submit" name="batalsuka"><i class="fa fa-heart"></i></a>
                            <?php }else{  ?>
                              <a href="proses_like.php?foto_id=<?php echo $data['foto_id'] ?>" type="submit" name="suka"><i class="fa-regular fa-heart"></i></a>
                            <?php }
                            // vid ke 6 menit ke 15:41 
                            $like = mysqli_query($conn, "SELECT * FROM likefoto WHERE foto_id='$foto_id'");
                            echo mysqli_num_rows($like). ' Suka';
                            ?>
                            <a href=""><i class="fa-regular fa-comment"></i></a> 3 Komentar
                        </div>
                    </div>
                </div>
              <?php }} else {
               $query = mysqli_query($conn, "SELECT * FROM foto WHERE user_id='$userid'");
                while($data = mysqli_fetch_array($query)) {
              ?>
                <div class="col-md-3 mt-2">
                    <div class="card">
                        <img style="height: 12rem;" src="assets/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top" title="<?php echo $data['judul_foto'] ?>">
                        <div class="card-footer text-center">
                            <?php
                            $foto_id = $data['foto_id'];
                            $ceksuka = mysqli_query($conn, "SELECT * FROM likefoto WHERE foto_id='$foto_id' AND user_id='$userid'");
                            if(mysqli_num_rows($ceksuka) == 1){ ?>
                              <a href="proses_like.php?foto_id=<?php echo $data['foto_id'] ?>" type="submit" name="batalsuka"><i class="fa fa-heart"></i></a>
                            <?php }else{  ?>
                              <a href="proses_like.php?foto_id=<?php echo $data['foto_id'] ?>" type="submit" name="suka"><i class="fa-regular fa-heart"></i></a>
                            <?php }
                            // vid ke 6 menit ke 15:41 
                            $like = mysqli_query($conn, "SELECT * FROM likefoto WHERE foto_id='$foto_id'");
                            echo mysqli_num_rows($like). ' Suka';
                            ?>
                            <a href=""><i class="fa-regular fa-comment"></i></a> 3 Komentar
                        </div>
                    </div>
                </div>
            <?php }} ?>
        </div>
    </div>


<!-- footer -->
<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
  <div class="container">
    <small>copyright : UKK RPL 2024 || azza auliyaul fitri</small>
  </div>
</footer>

<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
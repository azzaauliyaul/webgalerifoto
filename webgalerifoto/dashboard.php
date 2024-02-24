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
            $query = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.user_id=user.user_id INNER JOIN album ON foto.album_id=album.album_id");
            while ($data = mysqli_fetch_array($query)) {
            ?>
            <div class="col-md-3">
                <a type="button"  data-bs-toggle="modal" data-bs-target="#Komentar<?php echo $data['foto_id'] ?>">

                    <div class="card mb-2">
                        <img src="assets/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top"
                            title="<?php echo $data['judul_foto'] ?>" style="height: 12rem;">
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
                            <a href=""><i class="fa-regular fa-comment"></i></a> 
                            <?php
                            $jumlahkomen = mysqli_query($conn, "SELECT * FROM komentar WHERE foto_id='$foto_id'");
                            echo mysqli_num_rows ($jumlahkomen).'komentar';
                            ?>
                        </div>
                        </div>
                </a>

                <!-- Modal -->
              <div class="modal fade" id="Komentar<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-body">
                     <div class="row">
                       <div class="col-md-8">
                         <img src="assets/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top"
                            title="<?php echo $data['judul_foto'] ?>" >
                       </div>
                       <div class="col-md-4">
                         <div class="m-2">
                           <div class="ovelflow-auto">
                             <div class="sticky-top">
                               <strong><?php echo $data['judul_foto']?></strong>
                               <span class="badge bg-secondary"><?php echo $data['nama_lengkap']?></span>
                               <span class="badge bg-secondary"><?php echo $data['tanggal_unggah']?></span>
                               <span class="badge bg-secondary"><?php echo $data['nama_album']?></span>
                             </div>

                             <hr>
                             <p align="left"><?php echo $data['deskripsi_foto']?></p>
                             <hr>

                             <hr>
                             <?php
                             $foto_id = $data['foto_id'];
                             $komentar = mysqli_query($conn, "SELECT * FROM komentar INNER JOIN user ON komentar.user_id=user.user_id WHERE komentar.foto_id='$foto_id'");
                             while($row = mysqli_fetch_array($komentar)){ 
                             ?>
                             <p align="left">
                              <strong><?php echo $row['nama_lengkap']?></strong>
                             <?php echo $row['isi_komentar']?>
                             </p>
                             <?php }
                             ?>
                             <hr>
                             <div class="sticky-bottom">
                               <form action="" method="post">
                                 <div class="input-group">
                                   <input type="hidden" name="foto_id" value="<?php echo $data['foto_id']?>">
                                   <input type="text" name="isi_komentar" class="form-control" placeholder="tambah Komentar">
                                   <div class="input-group-prepend">
                                     <button type="submit" name="kirimkomentar" class="btn btn-outline-primary">Kirim</button>
                                   </div>
                                 </div>
                               </form>
                             </div>

                           </div>
                         </div>
                       </div>
                     </div>
                    </div>
                  </div>
                </div>
              </div>

                    </div>
            <?php } ?>
                </div>

                    </div>
            </div>


        </div>
    </div>

    <?php
    if (isset($_POST['kirimkomentar'])) {

      $foto_id = $_POST['foto_id'];
      $user_id = $_SESSION['a_global']->user_id;
      $isi_komentar = $_POST['isi_komentar'];
      $tanggal_komentar = date('y-m-d');

      $query = mysqli_query($conn, "INSERT INTO komentar values(
        '',
        '$foto_id',
        '$user_id',
        '$isi_komentar',
        '$tanggal_komentar'
    )");
          echo '<script>window.location="dashboard.php"</script>';

    }
    ?>

<!-- footer -->
<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
	<div class="container">
		<small>copyright : UKK RPL 2024 || azza auliyaul fitri</small>
	</div>
</footer>

<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
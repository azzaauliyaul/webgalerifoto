<?php
session_start();
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

<!-- konten -->
<div class="container">
	<div class="row"  style="margin-top: 30px;">

		<div class="col-md-4">
			<div class="card mt-2">
				<div class="card-header">Tambah Album</div>
				<div class="card-body">
					<form action="" method="post">
						<input type="text" name="nama_album" class="form-control" placeholder="Nama Album" style="margin-bottom: 20px; height: 45px; " required>
						<textarea class="form-control" name="deskripsi" placeholder="Deskripsi" style="margin-bottom: 20px; " required></textarea>
						<button type="submit" class="btn btn-primary mt-2" name="tambah">Tambah</button>
					</form>
				</div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="card mt-2">
				<div class="card-header">Data Album</div>
				<div class="card-body">
					<table border="1" cellspacing="0" class="table">
						<thead>
							<tr>
								<th >No</th>
								<th >Nama Album</th>
								<th>Deskripsi</th>
								<th>Tanggal</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php

							$batas = 10;
							 $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
							 $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0; 
							 
							 $previous = $halaman - 1;
							 $next = $halaman + 1;
							 
							 $data = mysqli_query($conn,"select * from album");
							 $jumlah_data = mysqli_num_rows($data);
							 $total_halaman = ceil($jumlah_data / $batas);
							 
							 $nomor = $halaman_awal+1;

					$user = $_SESSION['a_global']->user_id;
					$album = mysqli_query($conn, "SELECT * FROM album WHERE user_id = '$user' limit $halaman_awal, $batas");
						while($row = mysqli_fetch_array($album)){


					?>
					<tr>
						<td><?php echo $nomor++?></td>
						<td><?php echo $row['nama_album']?></td>
						<td><?php echo $row['deskripsi']?></td>
						<td><?php echo $row['tanggal_dibuat']?></td>
						<td>
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php $row['album_id']?>" style="border-radius: 20px;">Edit
						</button>
							<a href="hapus-album.php?hapus=<?php echo $row['album_id']?>" onclick="return confirm ('yakin ingin hapus')" title="" class="btn btn-danger" style="border-radius: 20px; ">Hapus</a>

				<!-- Modal -->
						<div class="modal fade" id="edit<?php $row['album_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
						      </div>
						      <div class="modal-body">
						      	<div class="modal-body">
                                                <form action="" method="post">
                                                    <input type="hidden" name="album_id" value="<?php echo $row['album_id'] ?>" >
                                                    <input type="text" name="nama_album" value="<?php echo $row['nama_album'] ?>" class="form-control" required>
                                                    <textarea name="deskripsi" class="form-control"><?php echo $row['deskripsi']; ?></textarea>
                                                    
                                                
                                            </div>
                                            <div class="modal-footer">
                                            <button class="btn btn-primary mt-2" name="edit" type="submit" >Simpan Data</button>
                                            </form>
						      </div>
						    </div>
						  </div>
						</div>

						</td>
					</tr><?php }
                     ?>
						</tbody>
					</table>
									<nav>
				 <ul class="pagination ">
				 <li class="page-item">
				 <a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$Previous'"; } ?>>Previous</a>
				 </li>
				 <?php 
				 for($x=1;$x<=$total_halaman;$x++){
				 ?> 
				 <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
				 <?php
				 }
				 ?> 
				 <li class="page-item">
				 <a  class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
				 </li>
				 </ul>
				 </nav>
				</div>
			</div>
		</div>

	</div>
</div>

<?php
if (isset($_POST['tambah'])) {
	$nama_album = $_POST['nama_album'];
	$deskripsi = $_POST['deskripsi'];
	$tanggal_dibuat = date('y-m-d');
	$user_id = $_SESSION['a_global']->user_id;

	$insert = mysqli_query($conn, "INSERT INTO album VALUES(
					null,
					'".$nama_album."',
					'".$deskripsi."',
					'".$tanggal_dibuat."',
					'".$user_id."'
			)");
					echo '<script>alert("berhasil dibuat")</script>';
					echo '<script>window.location="album.php"</script>';

}

if (isset($_POST['edit'])) {
	$album_id = $_POST['album_id'];
	$nama_album = $_POST['nama_album'];
	$deskripsi = $_POST['deskripsi'];
	$tanggal_dibuat = date('y-m-d');
	$user_id = $_SESSION['a_global']->user_id;

	$insert = mysqli_query($conn, "UPDATE album SET
					nama_album = '$nama_album',
					deskripsi = '$deskripsi',
					tanggal_dibuat = '$tanggal_dibuat' 
					WHERE album_id = '$album_id' ");
					echo '<script>alert("data berhasil diperbarui");location.href="album.php"</script>';

}


    if(isset($_POST['hapus'])){
        $albumid = $_POST['albumid'];
        
        $sql = mysqli_query($koneksi,"DELETE FROM album WHERE albumid='$albumid'");

        echo "<script>alert('data berhasil dihapus');
        location.href='../admin/album.php';</script>";
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
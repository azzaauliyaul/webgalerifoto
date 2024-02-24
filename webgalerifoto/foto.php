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
                <button class="btn btn-outline-danger" type="submit"  onclick="return confirm ('yakin ingin hapus')"><a href="keluar.php" style="color: red;">keluar</a></button>

      </form>
    </div>
  </div>
</nav>

<!-- konten -->
<div class="container">
	<div class="row" style="margin-top:30px;">

		<div class="col-md-4">
			<div class="card mt-2">
				<div class="card-header">Tambah Foto</div>
				<div class="card-body">
					<form action="" method="post" enctype="multipart/form-data">
						<input type="text" name="judul_foto" class="form-control" placeholder="Judul Foto" style="margin-bottom: 20px; height: 45px; " required>
						<textarea class="form-control" name="deskripsi_foto" placeholder="deskripsi foto" style="margin-bottom: 20px; " required></textarea>
						<select class="form-control" name="album_id"style="margin-bottom: 20px; height: 45px; ">
							<?php
							$album = mysqli_query($conn, "SELECT * FROM album ");
						while($data = mysqli_fetch_array($album)){ ?>
							<option value="<?php echo $data['album_id']?>"><?php echo $data['nama_album']?></option>
						<?php } ?>
						</select>
						<input type="file" name="lokasi_file" class="form-control" placeholder="File"style="margin-bottom: 20px;  " required>
						<button type="submit" class="btn btn-primary mt-2" name="tambah">Tambah</button>
					</form>
				</div>
			</div>
		</div>

		<div class="col-md-8">


			<div class="card mt-2">
				<div class="card-header">
					<h3>Data Foto</h3>
					<form action="" method="get">
 <div class="form-group">
 <input type="text" name="cari">
 <button type="submit" name="search" value="Cari">cari</button>
</div>
</form>
 


					
				</div>
				<div class="card-body">

<?php 
if(isset($_POST['search'])){
 $cari = $_POST['cari'];
 echo "<b>Hasil pencarian : ".$cari."</b>";
}
?>

					<table border="1" cellspacing="0" class="table">
						<thead>
							<tr>
								<th>No</th>
								<th width="100px">Foto</th>
								<th>Judul Foto</th>
								<th>Deskripsi</th>
								<th>Tanggal</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							 $user_id = $_SESSION['a_global']->user_id;
							$batas = 5;
							 $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
							 $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0; 
							 
							 $previous = $halaman - 1;
							 $next = $halaman + 1;
							 
							 $data_pagination = mysqli_query($conn,"select * from foto");
							 $jumlah_data = mysqli_num_rows($data_pagination);
							 $total_halaman = ceil($jumlah_data / $batas);

							 $nomor = $halaman_awal+1;


							 	if(isset($_POST['search'])){
				 $cari = $_POST['cari'];
				 $foto = mysql_query($conn, "select * from foto where judul_foto like '%".$cari."%'"); 
				 }else{
				  $foto = mysqli_query($conn, "SELECT * FROM foto WHERE user_id = '$user_id' limit $halaman_awal, $batas ");
 
			 }
					
						while($row = mysqli_fetch_array($foto)){
					
					?> 
					
					<tr>
						<td><?php echo $nomor++?></td>
						<td ><img src="assets/img/<?php echo $row['lokasi_file']?>" width="100px"></td>
						<td><?php echo $row['judul_foto']?></td>
						<td><?php echo $row['deskripsi_foto']?></td>
						<td><?php echo $row['tanggal_unggah']?></td>
						<td>

	  <!-- Button edit-->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $row['foto_id'] ?>">
                                        Edit
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="edit<?php echo $row['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST" enctype="multipart/form-data" >
                                                    <input type="hidden" name="foto_id" value="<?php echo $row['foto_id'] ?>" >
                                                    <input type="text" name="judul_foto" value="<?php echo $row['judul_foto'] ?>" class="form-control">
                                                    <textarea name="deskripsi_foto" class="form-control"><?php echo $row['deskripsi_foto']; ?></textarea>
                                                    <select name="album_id" class="form-control">
                                                        <?php
                                                            $sql_album = mysqli_query($conn, "SELECT * FROM album WHERE user_id='$user_id'");
                                                            while($data_album = mysqli_fetch_array($sql_album)){ ?>
                                                                <option <?php if($data_album['album_id'] == $row['album_id'] ) {
                                                                    ?> selected= "selected" <?php
                                                                } ?> value="<?php echo $data_album['album_id'] ?>"><?php echo $data_album['nama_album'] ?></option>
                                                            <?php }  
                                                        ?>
                                                    </select>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="assets/img/<?php echo $row['lokasi_file'] ?>" width="100" >
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label for="" class="form-label">Ganti File</label>
                                                            <input type="file" name="lokasi_file" class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                
                                            </div>
                                            <div class="modal-footer">
                                            <button class="btn btn-primary mt-2" name="edit" type="submit" >Simpan Data</button>
                                            </form>
                                            </div>
                                            </div>
                                        </div>
                                        </div>

							<!-- Button hapus -->
									<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $row['foto_id'] ?>">
  hapus
</button>


					<!-- Modal -->
					<div class="modal fade" id="hapus<?php echo $row['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
					        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					      </div>
					      <div class="modal-body">
					      <form action="" method="post">
                       <input type="hidden" name="foto_id" value="<?php echo $row['foto_id'] ?>" > 
                       Apakah anda yakin ingin menghapus data   
                       <strong><?php echo $row['judul_foto'] ?></strong> ?    
                                                                                            
               </div>
               <div class="modal-footer">
               <button class="btn btn-danger mt-2" name="hapus" type="submit" >Hapus Data</button>
               </form>
					      </div>
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
	$judul_foto = $_POST['judul_foto'];
	$deskripsi_foto = $_POST['deskripsi_foto'];
	$tanggal_unggah = date('y-m-d');
	$album_id = $_POST['album_id'];
	$user_id = $_SESSION['a_global']->user_id;

	$filename = $_FILES['lokasi_file']['name'];
	$tmp_name = $_FILES['lokasi_file']['tmp_name'];


    $type1 = explode('.', $filename);
    $type2 = $type1[1];

	$lokasi = 'assets/img/';
	$namafoto = rand().'-'.$filename;

                    $tipe_diizinkan = array('jpg','jpeg','png','gif');

                    if(!in_array($type2, $tipe_diizinkan)){
                        echo '<script>alert("Format foto tidak diizinkan")</script>';
                    }else{
  move_uploaded_file($tmp_name, $lokasi.$namafoto);

	$insert = mysqli_query($conn, "INSERT INTO foto VALUES(
					null,
					'".$judul_foto."',
					'".$deskripsi_foto."',
					'".$tanggal_unggah."',
					'".$namafoto."',
					'".$album_id."',
					'".$user_id."'
			)");
					echo '<script>alert("berhasil dibuat")</script>';
					echo '<script>window.location="foto.php"</script>';

}
}

// edit
if(isset($_POST['edit'])){
        $foto_id = $_POST['foto_id'];
        $judul_foto = $_POST['judul_foto'];
        $deskripsi_foto = $_POST['deskripsi_foto'];
        $tanggal_unggah = date('Y-m-d');
        $album_id = $_POST['album_id'];
        $user_id = $_SESSION['a_global']->user_id;

        $filename = $_FILES['lokasi_file']['name'];
				$tmp_name = $_FILES['lokasi_file']['tmp_name'];


                    $type1 = explode('.', $filename);
                    $type2 = $type1[1];

				$lokasi = 'assets/img/';
				$namafoto = rand().'-'.$filename;

        if($filename == null){

        $sql = mysqli_query($conn,"UPDATE foto SET
            judul_foto = '$judul_foto',
            deskripsi_foto = '$deskripsi_foto',
            tanggal_unggah = '$tanggal_unggah',
            album_id = '$album_id'
            WHERE foto_id = '$foto_id'
        ");
        }else{
            $query = mysqli_query($conn,"SELECT * FROM foto WHERE foto_id='$foto_id'");
            $data = mysqli_fetch_array($query);
            if(is_file('assets/img/'.$data['lokasi_file'])){
                unlink('assets/img/'.$data['lokasi_file']);
            }
             move_uploaded_file($tmp_name, $lokasi.$namafoto);

            $sql = mysqli_query($conn,"UPDATE foto SET
                judul_foto = '$judul_foto',
                deskripsi_foto = '$deskripsi_foto',
                tanggal_unggah = '$tanggal_unggah',
                lokasi_file = '$namafoto',
                album_id = '$album_id'
                WHERE foto_id = '$foto_id'
            ");
        }
       

        echo "<script>alert('data berhasil diubah');
        location.href='foto.php';</script>";
    }


// Hapus
    if(isset($_POST['hapus'])){
        $foto_id = $_POST['foto_id'];
        
        $sql = mysqli_query($conn,"DELETE FROM foto WHERE foto_id='$foto_id'");

        echo "<script>alert('data berhasil dihapus');
        location.href='foto.php';</script>";
    }

?>

<!-- footer -->
<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
	<div class="container" class="text-center">
		<small >copyright : UKK RPL 2024 || azza auliyaul fitri</small>
	</div>
</footer>

<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
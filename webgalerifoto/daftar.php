<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>web galeri foto</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-login">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01" >
      <a class="navbar-brand" href="index.php" style="font-size: 25px;">Hidden brand</a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>
      <form class="d-flex" style="">
        <button class="btn btn-outline-primary" type="submit" style="margin-right: 20px; border-radius:15px;"><a href="daftar.php" style="color:blue; ">daftar</a></button>
        <button class="btn btn-outline-success" type="submit" style="border-radius:15px;"><a href="login.php" style="color:green;">login</a></button>
      </form>
    </div>
  </div>
</nav>

	<!-- konten -->
	<div class="container" style="margin-top: 70px; " > 
	<div class="row justify-content-center align-item-center vh-100">
		<div class="col-5">
			<div class="card" style="width: 350px; box-shadow: black; background-color: ; border-radius: 15px;">
			<div class="card-body" >
		<h3 class="text-center" style="margin-bottom:30px;">Daftar</h3>
		<div class="box">
			<form action="" method="post">
				<input type="text" name="username" placeholder="username" class="form-control"style="margin-bottom: 20px; height: 45px; " required>
				<input type="text" name="password" placeholder="password" class="form-control"style="margin-bottom: 20px; height: 45px; " required>
				<input type="text" name="email" placeholder="email" class="form-control"style="margin-bottom: 20px; height: 45px; " required>
				<input type="text" name="nama_lengkap" placeholder="nama_lengkap" class="form-control"style="margin-bottom: 20px; height: 45px; " required>
				<textarea type="text" name="alamat" placeholder="alamat" class="form-control"style="margin-bottom: 20px; " required></textarea>
				<input type="submit" name="submit" value="submit" class="btn btn-primary mt-2" style="border-radius: 20px;">
			</form>

			<?php
			if(isset($_POST['submit'])){
				$username = ucwords($_POST['username']);
				$password = $_POST['password'];
				$email = $_POST['email'];
				$nama_lengkap = $_POST['nama_lengkap'];
				$alamat = ucwords($_POST['alamat']);

				$insert = mysqli_query($conn, "INSERT INTO user VALUES(
					null,
					'".$username."',
					'".$password."',
					'".$email."',
					'".$nama_lengkap."',
					'".$alamat."'
			)");
				if($insert){
					echo '<script>alert("Daftar Berhasil, silahkan login")</script>';
					echo '<script>window.location="login.php"</script>';
				}else{
					echo 'gagal' .mysql_error($conn);
				}

			}
			?>
			<br>
		<p>sudah punya akun ? klik  <a href="daftar.php" style="color: blue;"> Login</a></p>
		</div>
	</div>
	</div>
	</div>
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
<?php
session_start();
include 'koneksi.php';
$foto_id = $_GET['foto_id'];
$user_id = $_SESSION['a_global']->user_id;

 $ceksuka = mysqli_query($conn, "SELECT * FROM likefoto WHERE foto_id='$foto_id' AND user_id='$user_id'");
    if($row = mysqli_num_rows($ceksuka) == 1){
        while($row = mysqli_fetch_array($ceksuka)){
            $like_id = $row["like_id"];
            $query = mysqli_query($conn,"DELETE FROM likefoto WHERE like_id='$like_id'");
            echo "<script>location.href='dashboard.php'</script>";
        }
    }else{
        $tanggallike = date('Y-m-d');
        $query = mysqli_query($conn,"INSERT INTO likefoto VALUES(
        '',
        '$foto_id',
        '$user_id',
        '$tanggal_like'
        )");
        echo "<script>location.href='dashboard.php'</script>";
    }
?>
<!-- home menit ke 13.44  -->
<!-- home menit ke 21.47  -->
<!-- index/dasboard menit ke 28.57 -->
<!-- home menit ke 29.33 trus lanjut -->
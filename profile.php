<?php 

session_start();
if (isset($_POST['submit'])){
    // var_dump($_FILES['image']);die;
    $namaGambar = $_FILES['image']['name'];
    $tmpname = $_FILES['image']['tmp_name']; //penyimpanan sementara 
    // var_dump($namaGambar);die;
    $eror = $_FILES['image']['error'];
    $size = $_FILES['image']['size']; 

 // cek apakah eror atau gak 

 if ($eror === 4){ // 4 artinya gambar tidak di upload, atau boleh tulis !$eror
  echo "<script> 
   alert ('Please upload a photo');
   document.location.href = 'profile.php';
   </script>";
  return False ;
 }

 // cek ekstensi 

 $ekstensigambarValid = ['jpg','jpeg','png']; // ini ekstensi yang diperbolehkan 
 $ekstensifilegambar = explode('.', $namaGambar);
 $ekstensigambar = strtolower((end($ekstensifilegambar)));

 if (!in_array($ekstensigambar, $ekstensigambarValid)){

  echo "<script> 
   alert ('Invalid input');
   document.location.href = profile.php'; 
   </script>";
  return False ;

 }
 //  cek size foto 

 if ($size > 2000000){
  echo "<script> 
   alert ('Size too big!');
   document.location.href = 'profile.php';
   </script>";
  return False ;
 }

 // jika lolos pengecekan, upload file
 // genetate nama gambar baru 

//  $namaGambarBaru  = uniqid();
//  $namaGambarBaru .- ".";
//  $namaGambarBaru .= $ekstensigambar;

 move_uploaded_file($tmpname, 'images/' . $namaGambar);

 include 'connection.php';
$conn = new mysqli($server, $username, $password,$dbname);// this create connection
$sql = "SELECT * from users where username='".$_SESSION['Name']."'";
$result=$conn->query($sql);
                // var_dump($result);die;
$row = $result->fetch_assoc();

$pass = $row['password'];
$id = $row['Id'] ;  
$image= $row['image'];
            // var_dump($image);die;
$sql = "DELETE FROM ".$dbname.".`users` WHERE id='".$id."'";
$conn->query($sql);
$sql = "INSERT INTO ".$dbname.".`users`(`id`, `username`, `password`, `image`) VALUES ('".$id."', '".$_SESSION['Name']."', '". $pass."', '". $namaGambar."')";
$conn->query($sql);
//  return $namaGambarBaru;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">    
    <title>Profile</title>
    <link rel="apple-touch-icon" sizes="57x57" href="images/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="images/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="images/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="images/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="images/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="images/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="images/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="images/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="images/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="images/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/stylesheet.css" rel="stylesheet">

</head>
<body style="background:url(images/bgpageonline.png);">

<nav class="navbar navbar-default">
  <div class="container-fluid"> 

  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
  <a href="online.php" > <button class="btn btn-default"> Back </button></a>

	<a class="navbar-brand"><img style="width: 65px; height: auto; margin-left: 25px; margin-top: 5px;"
          class="img-fluid" src="images/logo.png" alt="TOETICTAC"></a>

	<a><img style="width: 50px; height: auto; margin-top: 10px;" src="images/toetictac.svg"</a>

  <!-- <a href="online.php" class="btn btn-menu">Back</a>

  <a class="navbar-brand"><img style="width: 65px; height: auto; margin-left: 25px; margin-top: 5px;"
          class="img-fluid" src="images/logo.png" alt="TOETICTAC"></a>

	<a><img style="width: 50px; height: auto; margin-top: 20px;" src="images/toetictac.svg"</a> -->
      
</div></nav>

    <div class="container">

    
    <div class="card">
      <br>
    <h6 style="background-color: transparent;">
      <?php 
      echo $_SESSION['Name'];
      if(substr($_SESSION['Name'], -1)=='s'){
      echo "' PROFILE";  
      } else{
        echo "'S PROFILE";
      }
      ?>
    
    </h6>
    <?php
    include 'connection.php';
    $conn = new mysqli($server, $username, $password,$dbname);// this create connection
    $sql = "SELECT * from users where username='".$_SESSION['Name']."'";
            $result=$conn->query($sql);
                // var_dump($result);die;
			$row = $result->fetch_assoc();
				
		        
            $image= $row['image'];
            // var_dump($image);die;
    
    ?>
  <div>  
  <img src="images/<?= $image;?>" style="width:30vh; border-radius:50%;" class="img-top" alt="Foto <?=$_SESSION['Name']?>" >
  </div>

  <div class="stats">
  <!-- <div class="row row-no-gutters">
  <div class="col-lg-6"> -->
  <p>Total Match: 
  <?php 
    include 'connection.php';
    $conn = new mysqli($server, $username, $password,$dbname);
    // var_dump($_SESSION['Id']); die;
    $sql="SELECT COUNT(menang) AS total1 FROM menang WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalmenang=($result['total1']);
    
    $sql="SELECT COUNT(kalah) AS total2 FROM kalah WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalkalah=($result['total2']);

    $sql="SELECT COUNT(seri) AS total3 FROM seri WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalseri=($result['total3']);

    $jumlahmain=($totalmenang+$totalkalah+$totalseri);
    echo "$jumlahmain";
    
  ?>
  </p>

  <p>Win: 
  <?php 
    include 'connection.php';
    $conn = new mysqli($server, $username, $password,$dbname);
    // var_dump($_SESSION['Id']); die;
    $sql="SELECT COUNT(menang) AS total FROM menang WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalmenang=($result['total']);
    echo "$totalmenang";
  ?>
  </p>

  <p>Lose: 
  <?php 
    include 'connection.php';
    $conn = new mysqli($server, $username, $password,$dbname);
    // var_dump($_SESSION['Id']); die;
    $sql="SELECT COUNT(kalah) AS total FROM kalah WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalkalah=($result['total']);
    echo "$totalkalah";
  ?>
  </p>
  <p>Draw: 
  <?php 
    include 'connection.php';
    $conn = new mysqli($server, $username, $password,$dbname);
    // var_dump($_SESSION['Id']); die;
    $sql="SELECT COUNT(seri) AS total FROM seri WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalseri=($result['total']);
    echo "$totalseri";
  ?>
  </p>
  
  <!-- <div class="row-lg-6"> -->
  <p>Ratio (W:L:D): 
  <?php 
    include 'connection.php';
    $conn = new mysqli($server, $username, $password,$dbname);
    // var_dump($_SESSION['Id']); die;
    $sql="SELECT COUNT(menang) AS total1 FROM menang WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalmenang=($result['total1']);
    
    $sql="SELECT COUNT(kalah) AS total2 FROM kalah WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalkalah=($result['total2']);

    $sql="SELECT COUNT(seri) AS total3 FROM seri WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalseri=($result['total3']);

    
    $jumlahmain=($totalmenang+$totalkalah+$totalseri);
    if(!$jumlahmain==0){
      $ratamenang=($totalmenang/$jumlahmain*100);
      echo "$totalmenang : $totalkalah : $totalseri";
    } else {
      echo "0 : 0 : 0";
    }
    
  ?>
  </p>
  <p>Average Win: 
  <?php 
    include 'connection.php';
    $conn = new mysqli($server, $username, $password,$dbname);
    // var_dump($_SESSION['Id']); die;
    $sql="SELECT COUNT(menang) AS total1 FROM menang WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalmenang=($result['total1']);
    
    $sql="SELECT COUNT(kalah) AS total2 FROM kalah WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalkalah=($result['total2']);

    $sql="SELECT COUNT(seri) AS total3 FROM seri WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalseri=($result['total3']);

    $jumlahmain=($totalmenang+$totalkalah+$totalseri);
    if(!$jumlahmain==0){
      $ratamenang=round($totalmenang/$jumlahmain*100);
      echo "$ratamenang%";
    } else{
      echo "0%";
    }
    
  ?>
  </p>
  <p>Average Lose: 
  <?php 
   include 'connection.php';
   $conn = new mysqli($server, $username, $password,$dbname);
   // var_dump($_SESSION['Id']); die;
   $sql="SELECT COUNT(menang) AS total1 FROM menang WHERE Id='".$_SESSION['Id']."'";
   $query=mysqli_query($conn,$sql);
   $result=mysqli_fetch_assoc($query);
   $totalmenang=($result['total1']);
   
   $sql="SELECT COUNT(kalah) AS total2 FROM kalah WHERE Id='".$_SESSION['Id']."'";
   $query=mysqli_query($conn,$sql);
   $result=mysqli_fetch_assoc($query);
   $totalkalah=($result['total2']);

   $sql="SELECT COUNT(seri) AS total3 FROM seri WHERE Id='".$_SESSION['Id']."'";
   $query=mysqli_query($conn,$sql);
   $result=mysqli_fetch_assoc($query);
   $totalseri=($result['total3']);

    $jumlahmain=($totalmenang+$totalkalah+$totalseri);
    if(!$jumlahmain==0){
      $ratakalah=round($totalkalah/$jumlahmain*100);
      echo "$ratakalah%";
    }else{
      echo "0%";
    }
    
  ?>
  </p>
  <p>Average Draw: 
  <?php 
    include 'connection.php';
    $conn = new mysqli($server, $username, $password,$dbname);
    // var_dump($_SESSION['Id']); die;
    $sql="SELECT COUNT(menang) AS total1 FROM menang WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalmenang=($result['total1']);
    
    $sql="SELECT COUNT(kalah) AS total2 FROM kalah WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalkalah=($result['total2']);
 
    $sql="SELECT COUNT(seri) AS total3 FROM seri WHERE Id='".$_SESSION['Id']."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_assoc($query);
    $totalseri=($result['total3']);
 
     $jumlahmain=($totalmenang+$totalkalah+$totalseri);
     if(!$jumlahmain==0){
       $rataseri=round($totalseri/$jumlahmain*100);
       echo "$rataseri%";
     }else{
      echo "0%";
     }
     

  ?>
  </p>
  </div>
  <!-- </div>
  </div> -->
  
    <!-- Button trigger modal -->
  <div class="container">
  <div class="row justify-content-center card-body">
     </div>
     <!-- <p class="card-text" style="margin-left: 16px">Nama: <?= $_SESSION['Name']?></p> -->
  <div class="row2 justify-content-center card-body"> 

  <div class="container-fluid"> 
  <button type="button" class="col-12 btn-menu" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="width:150px; padding:5px;">  Change Image </button>
  <a style= "color: black" href="editProfile.php"> <button type="button" style="width:150px" class="col-12 btn btn-menu"> Change Password </button> </a>
  </div>
  </div>
  </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Change Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method= "post" enctype="multipart/form-data">
    <label class="form-label">Change Image</label>
    <input name="image" type="file" class="form-control" >
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</body>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
-->
</html>










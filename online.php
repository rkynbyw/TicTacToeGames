<?php 
session_start();
if(!(isset($_SESSION['Name']))){
	header("Location: index.php"); /* this redirect user to index page if user is not logged in */
exit();
}
include 'connection.php'; // this file contains $server,$username,$password
// PHP script on challenge
if(isset($_POST['plrid'])){
$id = $_POST['plrid']; // get id of challenged player
$name ="";
$conn = new mysqli($server, $username, $password);
$sql = "SELECT * FROM ".$dbname.".`users` WHERE Id =".$id;
$result = $conn->query($sql);
if($result->num_rows>0){
	while($row = $result->fetch_assoc()){
		$name = $row['username']; // get the name of challenged player
	}
}
$sql = "select * from $dbname.requests";// select requests 
$result = $conn->query($sql);
$i = 0;
if($result->num_rows>0){
	while($row = $result->fetch_assoc()){// check if the request is already sended.
	      if($row['senderid'] == $_SESSION["Id"] && $row['recieverid'] == $id){
			 $i=1;
			 break; 
		  }
	}
}
if($i == 0){// insert request in request table
$sql = "INSERT INTO ".$dbname.".`requests`(`senderid`, `sendername`, `recieverid`, `recievername`, `status`)  VALUES (".$_SESSION['Id'].",'".$_SESSION['Name']."',".$id.",'".$name."',false)";
$conn->query($sql) ;
}
	$sql = "SELECT requestid FROM ".$dbname.".`requests` WHERE senderid=".$_SESSION['Id']." and recieverid=$id";// get the id of request send
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
	   $_SESSION['requestid'] = $row['requestid']; // set a session for request id
	   header("Location: challenge.php"); /* Redirect to challenge page */
exit();
}
}

$error = "";
   
// Create connection

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $_SESSION['Name'];?> - TicTacToe</title>
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
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/stylesheet.css" rel="stylesheet">
</head>
<body style="background:url(images/bgpageonline.png); color:white;">



<nav class="navbar navbar-default">
  <div class="container-fluid"> 

    <!-- Brand and toggle get grouped for better mobile display -->
  <a href="Logout.php" > <button class="btn btn-default"> <span class="glyphicon glyphicon-log-out"> </span> Log Out</button></a>
  <a href="profile.php" > <button class="btn btn-default"> Profile </button></a>

	<a class="navbar-brand"><img style="width: 65px; height: auto; margin-left: 25px; margin-top: 5px;"
          class="img-fluid" src="images/logo.png" alt="TOETICTAC"></a>

	<a><img style="width: 50px; height: auto; margin-top: 20px;" src="images/toetictac.svg"</a>

      
</div></nav>

<div class="container text-center" style="text-align:center;">

<div class="row justify-content-center">
<h1 style ="border-radius:10px;">ONLINE PLAYERS</h1> </div>

<div style="width:80%; margin-left:10%; text-align:center">
<div style="width:80%; margin-left:10%; text-align:left;"> 

<span id="onlinepl"> </span>

    <br>
    <br>
    <br>
  
  <p> <?php echo $error // display error ?></p>
   </div>
  </div></div>
  


  <div class="container text-center" style="text-align:center;">
  <div class="row justify-content-center">

  <h1 style="width:750px align:center; border-radius:10px;">REQUESTS</h1>
  <div class="text-center" style=" margin-left:25%;width:50%; background:none; color:black;" >
  <span id="req"> </span>
  </div>
  
  <script>
  function loadreq(){
	  
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("req").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","requests.php?r=1",true);
        xmlhttp.send();
	  
  }
  function loadonlinepl(){
	  
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("onlinepl").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","loadonlinepl.php?r=1",true);
        xmlhttp.send();
	  
  }
  loadreq();
 setInterval("loadreq();",500);
 loadonlinepl();
 setInterval("loadonlinepl();",500
 );
  </script>
  
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.2.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>
</body>
</html>
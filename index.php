<?php 

session_start();// session started



    if(isset($_SESSION['Name'])){
      /*this check if user is log in  by checking $_SESSION['Name'] variable  */	
		header("Location: online.php"); 
exit();
		}
	
	

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<title>Home</title>

<?php 
$error1 = "";// this will be use for displaying error (Username or password is incorrect)
$error = "";// this will be use for displaying sql connect errors

    if(isset($_POST['username'])){ /* this if checks is form is submitted by checking that $_POST['username'] is set or exists */

   include 'connection.php'; /* this file contains variables used for connecting to database ($server,$username,$password,$dbname)*/

$conn = new mysqli($server, $username, $password);// this create connection

if ($conn->connect_error) { //  this checks if there error connecting to server
	$error = die("Connection failed: " . $conn->connect_error); // saves error  in $error
    
} 

$username =  trim(htmlspecialchars($_POST['username']));/* this will trim(remove extra spaces) and remove html tags from username*/
$password= trim(htmlspecialchars($_POST['password']));/* this will trim(remove extra spaces) and remove html tags from password*/

$sql = 'SELECT * FROM '.$dbname.'.users '; //query for selecting data from studentlogin table
$result = $conn->query($sql); // 

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if($row['username'] == $username && $row['password'] == $password){
			
		    $_SESSION['Name'] =  $row['username'];
			$_SESSION['Id'] = $row['Id'];
			$sql = "DELETE FROM ".$dbname.".`online` WHERE plrid=".$_SESSION["Id"];
			$conn->query($sql);
			$sql = "INSERT INTO ".$dbname.".`online`(`plrid`, `plrname`) VALUES (".$_SESSION['Id'].",'".$_SESSION['Name']."')";
			$conn->query($sql);
			
			
			header("Location: online.php"); /* Redirect browser */
exit();
		}
		else 
		{
			$error1 = "Username or Password Is Incorrect!";
			
		}
		
        
    }
} 
$conn->close();
	}
	
	 


   
?>
<link href="css/bootstrap.css" rel="stylesheet">

<link href="css/bootstrap.min.css" rel="stylesheet">

<link href="css/stylesheet.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<div class="container-fluid">

<body style="background:url(images/bglandingpage.png); max-width:100%; height:auto; background-size:cover; background-repeat:repeat-y;">

<nav class="navbar navbar-default">
    <!-- Brand and toggle get grouped for better mobile display -->

    <a href="signup.php">
    <button class="btn btn-default">Sign Up</button></a>
      
</div></nav>


<div class="container text-center login">

<div class="row justify-content-center my-4">
<div class="col-3 align-self-right pr-0"> <img style="width: 76px; height: auto; margin-top: 5px" class="img-fluid" src="images/logo.png" alt="TOETICTAC"> </div>
<div class="col-2 align-self-left pl-0"> <a><img style="width: 50px; height: auto; margin-top: 10px;" src="images/toetictac.svg"></a> </div> </div>
    
<div class= "logininfo">    
<form action="index.php" method="post" >
    <div class="form-group text-left center-block text-center" style=" width:50%; color:white;" >
      <label for="usr">Username</label>
      <input placeholder="Enter your Username..." type="text" class="form-control" name="username"required> 
    </div>
    <div class="form-group text-left center-block text-center" style=" width:50%; color:white;" >
      <label for="pwd">Password</label>
      <input placeholder="Enter your Password..." type="password" class="form-control" name="password" required> <?php echo '<p style="color:red">'.$error. $error1. "</p>"?>
      
    </div>
    <h4><input id="submit"  type="submit" class="btn btn-login" value="Log In"/> 
    <button class="btn btn-login" type="reset" > Clear </button></h4>
  </form>
</div>
  
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.2.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>
</div>
</body>
</html>

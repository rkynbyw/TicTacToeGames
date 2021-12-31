<?php 
session_start();// session started

		if(isset($_SESSION['Name'])){ /*
 this check if user is log in  by checking $_SESSION['Name'] variable  */	
		header("Location:online.php"); 
		}
	
	

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SignUp - Online Test</title>

<?php 
$user ="";
$pass = "";
$rpass="";
$error1 = "";// this will be use for displaying error (Username or password is incorrect)
$error = "";// this will be use for displaying sql connect errors

    if(isset($_POST['username'])){ /* this if checks is form is submitted by checking that $_POST['username'] is set or exists */
	$pass = $_POST['password'];
	$rpass = $_POST['rpassword'];
	$user = $_POST['username'];
	if($pass == $rpass){

   include 'connection.php'; /* this file contains variables used for connecting to database ($server,$username,$password,$dbname)*/
$conn = new mysqli($server, $username, $password,$dbname);// this create connection
if ($conn->connect_error) { //  this checks if there error connecting to server
	$error = die("Connection failed: " . $conn->connect_error); // saves error  in $error
} 
$user =  trim(htmlspecialchars($_POST['username']));/* this will trim(remove extra spaces) and remove html tags from username*/
$pass = trim(htmlspecialchars($_POST['password']));/* this will trim(remove extra spaces) and remove html tags from password*/
$sql = "SELECT * FROM `users` WHERE username='".$user."'";
$result= $conn->query($sql);
if($result->num_rows>0){
	$error = "Username Already Exists!";
}
else {
	
	$sql = "INSERT INTO `users`(`username`, `password`) VALUES ('".$user."','".$pass."')";
if($conn->query($sql)== true){
		   
			$sql = "select * from users where username='".$user."'";
			$result=$conn->query($sql);
			while($row = $result->fetch_assoc()){
				
		    $_SESSION['Name'] =  $row['username'];
			$_SESSION['Id'] = $row['Id'];
			$sql = "DELETE FROM ".$dbname.".`online` WHERE plrid=".$_SESSION["Id"];
			$conn->query($sql);
			$sql = "INSERT INTO ".$dbname.".`online`(`plrid`, `plrname`) VALUES (".$_SESSION['Id'].",'".$_SESSION['Name']."')";
			$conn->query($sql);
			
			
			header("Location:online.php"); /* Redirect browser */
exit();
			}		
			
}	
}
	}
	else {
		$error = "Passwords not matched!";
		}
	
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
<body style="background:url(images/bglandingpage.png); max-width:100%; height:auto; background-size:cover; background-repeat:repeat-y;">
<nav class="navbar navbar-default">
    <!-- Brand and toggle get grouped for better mobile display -->

    <a href="index.php">
    <button class="btn btn-default">Log In </button></a>
      
</div></nav>

<div class="container text-center signup">
   
<div class="row justify-content-center my-4">
<div class="col-3 align-self-right pr-0"> <img style="width: 76px; height: auto; margin-top: 5px; margin-bottom: 5px;" class="img-fluid" src="images/logo.png" alt="TOETICTAC"> </div>
<div class="col-2 align-self-left pl-0"> <a><img style="width: 50px; height: auto; margin-top: 10px;" src="images/toetictac.svg"</a> </div> </div>
    
    <form action="signup.php" method="post" >
    <div class="form-group text-left center-block text-center" style=" width:50%; color:white;" >
      <label for="usr">Username</label>
      <input placeholder="Enter your Username..." type="text" class="form-control" name="username"required value="<?php echo $user?>"> 
    </div>
    <div class="form-group text-left center-block text-center" style=" width:50%; color:white; " >
      <label for="pwd">Password</label>
      <input placeholder="Enter your Password..." type="password" class="form-control" name="password" required value="<?php echo $pass?>"> 
    </div>
    <div class="form-group text-left center-block text-center" style=" width:50%; color:white;" >
      <label for="pwd">Retype Password</label>
      <input placeholder="Retype Password..." type="password" class="form-control" name="rpassword" required value="<?php echo $rpass?>"> 
    </div>
    <?php echo '<p style="color:red">'.$error. "</p>"?>
	<h4><input id="submit"  type="submit" class="btn btn-login" value="Sign Up"/>
	 <button class="btn btn-login" type="reset" > Clear </button></h4>
  </form>
  
</html>

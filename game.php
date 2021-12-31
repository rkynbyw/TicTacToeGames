<?php 
session_start();
if(!(isset($_SESSION['Name']))){
	header("Location: index.php"); /* Redirect browser */
exit();
}
if(!isset($_SESSION['pid'])){
	header("Location: online.php"); /* Redirect browser */
exit();
}

include 'connection.php';
$conn = new MySQLi($server,$username,$password);
$sql = "select * from ".$dbname.".gamesessions where sessionid=".$_SESSION['gamesessionid'] ;
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	
	$pl1id= $row['pl1id'];
	$pl2id= $row['pl2id'];
}
$sql = "select * from ".$dbname.".users where Id=".$pl1id;
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	
	$pl1name= $row['username'];
}
$sql = "select * from ".$dbname.".users where Id=".$pl2id;
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	
	$pl2name= $row['username'];
}
$pltype =$_SESSION['pltype'];
if($pltype == 'rec'){
$pname = $pl1name;
$oppname = $pl2name;	
}
else if($pltype == 'sender'){
$pname = $pl2name;
$oppname = $pl1name;	
}

?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $_SESSION['Name'];?> - Tic Tac Toe</title>
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
<link href="css/bootstrap-3.3.4.css" rel="stylesheet" type="text/css">
<link href="css/stylesheet.css" rel="stylesheet" type="text/css">
<script src="jQueryAssets/jquery-1.11.1.min.js" type="text/javascript"></script>
<script> 
var checkedboxes = new Array(0,0,0,0,0,0,0,0,0);
var z =0;
var turn = 0;
function sendmove(box){
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				    
					
            }
        };
		xmlhttp.open("GET","sendmove.php?b="+box,true);
        xmlhttp.send();	
}
function recievemove(){
	 if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				// $("#myModal").css("display","none");
				<?php echo  "var plrtype = '".$_SESSION['pltype']."';";?>
			   z = this.responseText;
			   if(z == "pl1"){
				  
				//    
				//    $sql = "INSERT INTO ".$dbname.".menang(Id, menang) VALUES ('".$pl1id."',1)";
				//    $conn->query($sql);
				//    $sql = "INSERT INTO ".$dbname.".kalah(Id, kalah) VALUES ('".$pl2id."',1)";
				// 	$conn->query($sql);
				//    
				// $Win = "UPDATE users SET Win=((select Win from users where Id=".$pl1id.")+1) where Id = ".$pl1id;
				// mysqli_query($dbconn,$Win);
				// $Lose = "UPDATE users SET Lose=((select Lose from users where Id=".$pl2id.")+1) where Id = ".$pl2id;
				// mysqli_query($dbconn,$Lose);

				  document.getElementById("plwin").innerHTML="<?php if($pltype == 'rec' ){ 
					   echo 'You ';
					
				} else {
					echo $pl1name;
				// 	$sql = "INSERT INTO ".$dbname.".menang(Id, menang) VALUES ('".$pl1id."',1)";
				//    $conn->query($sql);
				} 
				?> Won!";
				$("#myModal").css("display","block");
			}
			else if(z== "pl2"){
				document.getElementById("plwin").innerHTML="<?php if($pltype == 'rec' ){ 
					echo $pl2name;
				} else {
					echo 'You ';
				} ?> Won!";
				$("#myModal").css("display","block");
			}
			else if(z == "draw"){
				document.getElementById("plwin").innerHTML="Draw !";
				$("#myModal").css("display","block");
			}
			else {
			   if(checkedboxes[z-1] == 0){ 
			   if(plrtype == 'rec'){
			  $(".div"+z).css("background-image", "url(images/cross1.png)");
			  turn=0;
			   }
			   else if(plrtype == 'sender'){
				   $(".div"+z).css("background-image", "url(images/tic1.png)");
				   turn =1;
				   
			   }
			   if(turn == <?php if($_SESSION['pltype'] == 'rec'){
				echo 0;
			}
			else if($_SESSION['pltype'] == 'sender'){
				echo 1;
			} ?>){
				document.getElementById("turntxt").innerHTML = "Your Turn!";
		document.getElementById("pl1").checked = true;
	}
	else {
		document.getElementById("turntxt").innerHTML = "Enemy Turn!";
		document.getElementById("pl2").checked = true;
	}	
			   checkedboxes[z-1] =1;
			   }
			   
    	
            }
			}
        };
        xmlhttp.open("GET","recievedata.php?r=1",true);
        xmlhttp.send();
	
}
recievemove();
setInterval("recievemove();",500);
$(document).ready(function(){
	var i =0;
	function radbtn(){
	
	if(turn == <?php if($_SESSION['pltype'] == 'rec'){
				echo 0;
			}
			else if($_SESSION['pltype'] == 'sender'){
				echo 1;
			} ?>){
				document.getElementById("turntxt").innerHTML = "Your Turn!";
		document.getElementById("pl1").checked = true;
	}
	else {
		document.getElementById("turntxt").innerHTML = "Enemy Turn!";
		document.getElementById("pl2").checked = true;
	}	
}
radbtn();
	    function onbuttonclick(box){
			
			if(turn == <?php if($_SESSION['pltype'] == 'rec'){
				echo 0;
			}
			else if($_SESSION['pltype'] == 'sender'){
				echo 1;
			} ?>){
				
			if(checkedboxes[box-1] == 0){ 
			if(i==0){
				<?php echo  "var plrtype = '".$_SESSION['pltype']."';";?>
			if(plrtype == 'rec'){
				
				
        $(".div"+box).css("background-image", "url(images/tic1.png)");
		turn = 1;
		}
		else {
			 $(".div"+box).css("background-image", "url(images/cross1.png)");
			 turn = 0;
		}
		radbtn();
		sendmove(box);
			}
			checkedboxes[box-1] = 1;
			}
			
		}}
		$(".div1").click(function(){
		onbuttonclick(1);
    });
	$(".div2").click(function(){
		onbuttonclick(2);
    });
	$(".div3").click(function(){
		onbuttonclick(3);
    });
	$(".div4").click(function(){
		onbuttonclick(4);
    });
	$(".div5").click(function(){
		onbuttonclick(5);
    });
	$(".div6").click(function(){
		onbuttonclick(6);
    });
	$(".div7").click(function(){
		onbuttonclick(7);
    });
	$(".div8").click(function(){
		onbuttonclick(8);
    });
	$(".div9").click(function(){
		onbuttonclick(9);
    });
	});
</script>
</head>
<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    
	<a class="navbar-brand"><img style="width: 65px; height: auto; margin-left: 25px; margin-top: 5px;"
          class="img-fluid" src="images/logo.png" alt="TOETICTAC"></a>

	<a><img style="width: 50px; height: auto; margin-top: 20px;" src="images/toetictac.svg"></a>
	<a href="Logout.php" > <button class="btn btn-default"> <span class="glyphicon glyphicon-log-out"> </span> Log Out</button></a>
	<a href="online.php" > <button class="btn btn-default"><span class="glyphicon glyphicon-backward"> </span> Back</button></a>
</div></nav>


<body style="background:url(images/bgpageonline.png);">
<div class="container">
<center>
<h1 id="txt"></h1>
<form action="#" method="post">

<div  id="divback" style="background:url(images/bisaatw.jpg); background-repeat:no-repeat; background-size:auto; background-position:center; height:400px; width:360px;">
<div id="tictac-div" class="div1" style="margin-top:18px; margin-left:10px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div2" style="margin-top:18px; margin-left:25px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div3" style="margin-top:18px; margin-left:25px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div4" style="margin-top:0px; margin-left:10px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div5" style=" margin-top:-2px; margin-left:25px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div6" style=" margin-top:0px; margin-left:24px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div7" style=" margin-top:-5px; margin-left:9px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div8" style=" margin-top:-5px; margin-left:22px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>
<div id="tictac-div" class="div9" style=" margin-top:-5px; margin-left:30px; background:url(); background-repeat:no-repeat; background-size:contain; background-position:center;" > </div>

 </div>
 <br>
 <span style="font-size:20px;">
 <p id="turntxt" style="color:white;"></p> 


 <div class="container">
	 <div class="row justify-content-center">
 <div class="col-6 player"><input class="player" type="radio" id="pl1" name="player" value="1" disabled/> <?php echo $pname; ?>&nbsp; </div>
 <div class="col-6 player"><input class="player" type="radio" id="pl2" name="player" value="2" disabled/> <?php echo $oppname; ?><br></div> 
</div>
</div>
</span>
</form>
</div></center>
<!-- The Modal -->
<div id="myModal" style="background:rgba(255,255,255,1); border:2px solid black; padding:20px; color:black; width:300px; height:30vh; margin-left:auto; margin-right:auto; margin-top:auto; margin-bottom:auto;" class="modal">

  <!-- Modal content --> 
      <h1 id="plwin"> </h1><br>
	  <div class="col-xs-6" >
  <center><form action="online.php">  <button type="submit" class="btn" style="background-color:#ED55A9" autofocus> Done!</button></form></center>
  </div>
  <div class="col-xs-6">
  <center><form action="playagain2.php">  <button type="submit" class="btn" style="background-color:#ED55A9" autofocus> Play again!</button></form></center>
		</div>
</div>
</body>
</html>
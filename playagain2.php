<?php
session_start();
include 'connection.php';
$conn = new MySQLi($server,$username,$password);
$sql = "UPDATE ".$dbname.".`gamesessions` SET box1 = 0, box2=0, box3=0, box4=0, box5=0, box6=0, box7=0, box8=0, box9=0, count=0  WHERE sessionid=".$_SESSION['gamesessionid'];
$conn ->query($sql);
// // unset($_SESSION['gamesessionid']);
header("location:game.php");


?>
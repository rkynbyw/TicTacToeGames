<?php 
session_start();
if(isset($_GET['r'])){
	// Create connection
	include "connection.php";
$conn = new mysqli($server, $username, $password);
$sql = "select * from ".$dbname.".requests";
$result = $conn->query($sql);
echo '<table  class="table  table-hover table-responsive" style="font-size:20px; text-align:center; background-color:#49C8E5; color:black; width:100%; border-radius:20px;  border:none;  border-top:0px; "> <tr> <tr > <th style="text-align:center;"> Id </th><th style="text-align:center"> Player Name</th><th style="text-align:center"></th>';
if($result->num_rows>0){
while ($row = $result->fetch_assoc()){
	if($_SESSION['Id'] == $row['recieverid']){
		echo "<tr>";
		echo "<td>".$row['senderid']."</td>";
		echo "<td>".$row['sendername']."</td>";
		echo "<td>".'<form action="recieve.php" method="post"><input type="hidden" name="requestid" value="'.$row['requestid'].'"> <input type="submit" class="btn btn-info btn-sm" style="font-size:15px; background-color:#ED55A9;color:black; border-radius:34px " value="Accept"></form>'."</td>";
		// echo "<td>".'<form action="recieve.php" method="post"><input type="hidden" name="requestid" value=""> <input type="submit" class="btn btn-info btn-sm" style="font-size:15px; background-color:#ED55A9;color:black; border-radius:34px " value="Decline"></form>'."</td>";
		echo "</tr>";	
	}
}
}
echo "</table>";
// this loads online users on page load
	
}
?>
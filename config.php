<?php
$con	=	mysql_connect("localhost","root","");
if($con){
	mysql_select_db("test") or die(mysql_error());
}else{
	die('Error in connection' . mysql_error());
}
?>
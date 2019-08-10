<?php 
//pn 6/8/2019
// Load configuration as an array. Use the actual location of your configuration file
$config = include('config.php'); 
/*
echo $config['user']; // 'localhost
echo "<br>";
echo $config['pass']; // 'localhost'
echo "<br>";
echo $config['dbname']; // 'localhost'
echo "<br>";
*/
// Try and connect to the database
$mysqli = new mysqli('127.0.0.1',$config['user'],$config['pass'],$config['dbname']);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


$value_ID = "";
//echo $value_ID;
//$value_Date =  $_GET["Date"];

$value_Date = new DateTime();
date_timezone_set($value_Date, timezone_open('America/Mexico_City'));
$value_Date =  $value_Date->format('Y-m-d H:i:s');


echo $value_Date;

$value_MAC = "";
//$value_MAC = $_GET["MAC_char"];
$value_CO = "";
$value_maxCO = "";
//$value_maxCO = $_GET["MCO"];
$value_Temp = "";
$value_Hum = "";
$value_Latitude = "";
$value_Longitude = "";

 if (isset($_GET["MAC_char"])) 
 {
  $value_MAC = $_GET["MAC_char"];  
 }
 if (isset($_GET["ID"])) 
 {
  $value_ID = $_GET["ID"];  
 }
  if (isset($_GET["CO"])) 
 {
  $value_CO = $_GET["CO"];  
 }
  if (isset($_GET["MCO"])) 
 {
  $value_maxCO = $_GET["MCO"];  
 }
  if (isset($_GET["t"])) 
 {
  $value_Temp = $_GET["t"];  
 }
  if (isset($_GET["h"])) 
 {
  $value_Hum = $_GET["h"];  
 }
  if (isset($_GET["La"])) 
 {
  $value_Latitude = $_GET["La"];  
 }
  if (isset($_GET["Lo"])) 
 {
  $value_Longitude= $_GET["Lo"];  
 }
 
  $paramValides=false;
 //vérifier que chaque variable possède une valeur
 //sinon l'insertion est annulée
 if( 
($value_ID!="")&&($value_MAC!="")&&($value_CO!="")&&($value_maxCO!="")&&($value_Temp!="")&&($value_Hum!="")&&($value_Latitude!="")&&($value_Longitude!="") 
)
 {
   $paramValides=true;  
 }
 //validation contre injection sql
 //vérifier chaque variable selon son type de donnée
 if ((!is_numeric($value_ID))&&(!is_numeric($value_CO)))
 {
     $paramValides=false; 
 }
 
 /*pn UPDATE QRY
Here's a quick summary:
(UN)SIGNED TINYINT: I
(UN)SIGNED SMALLINT: I
(UN)SIGNED MEDIUMINT: I
SIGNED INT: I
UNSIGNED INT: S
(UN)SIGNED BIGINT: S
(VAR)CHAR, (TINY/SMALL/MEDIUM/BIG)TEXT/BLOB should all have S.
FLOAT/REAL/DOUBLE (PRECISION) should all be D.

db

	1	MAC_char	char(18)	    S
	2	ID	varchar(50)         	S	
	3	Date	datetime			S
	4	CO	smallint(5)		        I	
	5	MCO	smallint(6)		        I
	6	t	float		            D	
	7	h	float		            D	
	8	La	double(13,8)	    	D
	9	Lo	double(13,8)		    D
 
 php

    $value_ID = "";                 s
    $value_Date = new DateTime();   s
    $value_MAC = "";                s   
    $value_CO = "";                 s
    $value_maxCO = "";              s
    $value_Temp = "";               s
    $value_Hum = "";                s   
    $value_Latitude = "";           s
    $value_Longitude = "";          s
    
*/
 
 
if ($paramValides==true)
{
  $stmt = mysqli_prepare($mysqli, "INSERT INTO CCE VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, 'sssssssss', $value_MAC, $value_ID, $value_Date, $value_CO, $value_maxCO, $value_Temp, $value_Hum, $value_Latitude, $value_Longitude);

  /* execute prepared statement */
  mysqli_stmt_execute($stmt);

  printf("%d Row inserted.\n", mysqli_stmt_affected_rows($stmt));

  /* close statement and connection */
  mysqli_stmt_close($stmt);
    

}
else {
        echo "Error: opration annulee , donnees non valides.<br>"; 
    }
?>

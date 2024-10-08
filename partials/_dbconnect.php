<?php

 $server = "localhost";
 $username = "root";
 $password = "";
 $database = "test";

 $con = mysqli_connect($server, $username, $password, $database);

 if (!$con) {
     die("Connectivity of database is failed due to ". mysqli_connect_error());
}

?>
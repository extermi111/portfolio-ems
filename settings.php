<?php

$dbcon = mysqli_connect("localhost", "root", "", "ems");

if(!$dbcon) echo "nope";

@mysqli_set_charset($dbcon, "utf8");

$poziomy['kadet'] = 1; // Tylko wyświetlanie
$poziomy['medyk'] = 3; // Dodanie nowych osób, edycja osób, dodawanie kartotek
$poziomy['lekarz'] = 7; // Stwierdzanie zgonu u danej osoby
$poziomy['ordynator'] = 10; // Zarządzanie ludźmi

if(isset($_SESSION['Name'])){}
  else {
    if($_SERVER["QUERY_STRING"] != '')
      header('location: index.php');
  }

 ?>

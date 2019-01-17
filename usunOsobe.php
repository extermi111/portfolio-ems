<?php

SESSION_START();

include("settings.php");

if ($_SESSION['Admin'] < $poziomy['ordynator']) {
    header('location: index.php');
}

// print_r($_GET);

$query = sprintf(
    "DELETE FROM `ludzie` WHERE `LP` = %d",
mysqli_real_escape_string($dbcon, $_GET['ID'])
);

// echo $query;

mysqli_query($dbcon, $query);

$_SESSION['komunikat'] = "Poprawnie usunięto osobę z bazy.";

header('location: index.php');

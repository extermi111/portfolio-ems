<?php

SESSION_START();

include("settings.php");

if ($_SESSION['Admin'] < $poziomy['lekarz']) {
    header('location: index.php');
}

print_r($_GET);

$query = sprintf(
    "DELETE FROM `kartoteki` WHERE `LP` = %d",
mysqli_real_escape_string($dbcon, $_GET['rekord'])
);

// echo $query;

mysqli_query($dbcon, $query);

$_SESSION['komunikat'] = "Poprawnie usunięto z bazy wpis #{$_GET['rekord']}";

header('location: index.php?szukaj='.mysqli_real_escape_string($dbcon, $_GET['ID']).'&rekord=0');

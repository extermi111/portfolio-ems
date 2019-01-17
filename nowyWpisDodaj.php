<?php

SESSION_START();

include("settings.php");

if ($_SESSION['Admin'] < $poziomy['medyk']) {
    header('location: index.php');
}

  foreach ($_POST as $l => $d) {
      $_POST[$l] = mysqli_real_escape_string($dbcon, $d);
  }

  // print_r($_POST);

  $query = "INSERT INTO `kartoteki` (`Pacjent`, `Medyk`, `Date`, `Miejsce_zdarzenia`, `Okolicznosci`, `Rozpoznanie`, `Leczenie`, `Uwagi`) VALUES ('{$_POST['Pacjent']}', '{$_POST['Medyk']}', '{$_POST['Date']}', '{$_POST['Okolicznosci']}', '{$_POST['Rozpoznanie']}', '{$_POST['Leczenie']}', '{$_POST['Uwagi']}', '{$_POST['']}')";

  // echo $query;

  if (mysqli_query($dbcon, $query)) {
      $_SESSION['komunikat'] = "Dodano kartotekę do bazy.";
      header('location: index.php?szukaj='.$_POST['Pacjent']);
  } else {
      $_SESSION['komunikat'] = "Wystąpił problem z dodaniem kartoteki do bazy.";
      header('location: index.php');
  }

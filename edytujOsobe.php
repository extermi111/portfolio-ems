<?php

SESSION_START();

include("settings.php");

if ($_SESSION['Admin'] < $poziomy['medyk']) {
    header('location: index.php');
}

foreach ($_POST as $l => $d) {
    $_POST[$l] = mysqli_real_escape_string($dbcon, $d);
}

print_r($_POST);


$query = "SELECT * FROM `ludzie` WHERE `LP` = {$_POST['LP']}";

$result = mysqli_query($dbcon, $query);

$dane = mysqli_fetch_assoc($result);

print_r($dane);

$wynik = [];

foreach ($dane as $l => $d) {
    if (isset($_POST[$l])) {
        if ($d != $_POST[$l]) {
            $wynik[] = "`".$l."` = '".$_POST[$l]."'";
        }
    }
}

$wynik = implode($wynik, ', ');

if ($wynik == '') {
    $_SESSION['komunikat'] = 'Nic nie uległo zmianie';
    header('location: index.php?szukaj='.$_POST['LP']);
} else {
    $query = "UPDATE `ludzie` SET $wynik WHERE `LP` = {$_POST['LP']}";

    $wynik = mysqli_query($dbcon, $query);

    if ($wynik) {
        $_SESSION['komunikat'] = "Poprawnie edytowano osobę #{$_POST['LP']}";

        header('location: index.php?szukaj='.$_POST['LP']);
    } else {
        $_SESSION['komunikat'] = "Nie udało się zedytować osoby #{$_POST['LP']}";

        header('location: index.php?szukaj='.$_POST['LP']);
    }
}

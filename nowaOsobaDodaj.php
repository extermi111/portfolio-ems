<?php

SESSION_START();

include("settings.php");

if ($_SESSION['Admin'] < $poziomy['medyk']) {
    header('location: index.php');
}

foreach ($_POST as $l => $d) {
    $_POST[$l] = mysqli_real_escape_string($dbcon, $d);
}

$query = "INSERT INTO `ludzie` (`Name`, `Birthday`, `Sex`) VALUES ('{$_POST['name']}', '{$_POST['date']}', '{$_POST['sex']}')".PHP_EOL;

// echo $query;

if (mysqli_query($dbcon, $query)) {
    $query = "SELECT `LP` FROM `ludzie` WHERE `Name` LIKE '{$_POST['name']}' AND `Birthday` LIKE '{$_POST['date']}'";

    // echo $query;

    if ($result = mysqli_query($dbcon, $query)) {
        $dane = mysqli_fetch_assoc($result);

        $_SESSION['komunikat'] = "Dodano {$_POST['name']} do bazy, numer w bazie: {$dane['LP']}";

        header('location: index.php?szukaj='.$dane['LP']);
    } else {
        $_SESSION['komunikat'] = "Dodano {$_POST['name']} do bazy";

        header('location: index.php');
        // echo "Brak przekierowania dodanie udane";
    }
} else {
    $_SESSION['komunikat'] = "Wystąpił problem i nie udało się dodać osoby do bazy.";
    echo 'Brak przekierowania dodanie nieudane';
}

<?php

SESSION_START();

include("settings.php");

foreach ($_POST as $l => $d) {
    $_POST[$l] = mysqli_real_escape_string($dbcon, $d);
}

if (isset($_POST['moje'])) {
    if ($_POST['ID'] != $_SESSION['ID']) {
        echo "Wykryto niezgodność!";
        exit();
    }
} else {
    if ($_SESSION['Admin'] < $poziomy['ordynator']) {
        header('location: index.php');
    }
}

$query = "UPDATE `ludzie` SET `password` = PASSWORD('{$_POST['password']}') WHERE `LP` = {$_POST['ID']}";

$result = mysqli_query($dbcon, $query);

if ($result) {
    echo "Poprawnie zmieniono hasło.";
} else {
    echo "Coś poszło nie tak i nie udało się zmienić hasła.";
}

// echo $query;

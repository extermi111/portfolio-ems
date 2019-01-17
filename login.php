<?php

if (@$maybeStart != true) {
    header('location: index.php');
}
?>
<link rel="stylesheet" href="login.css">
<?php
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Błędny login i/lub hasło albo brak dostępu do systemu. Skontaktuj się z Ordynatorem";
    } else {
        // Define $username and $password
        $username=$_POST['username'];
        $password=$_POST['password'];
        // To protect MySQL injection for Security purpose
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysqli_real_escape_string($dbcon, $username);
        $password = mysqli_real_escape_string($dbcon, $password);
        // Selecting Database
        // SQL query to fetch information of registerd users and finds user match.
        $query = mysqli_query($dbcon, "select * from Ludzie where Password=PASSWORD('$password') AND Name='$username'");
        $rows = mysqli_num_rows($query);
        $wynik = mysqli_fetch_assoc($query);
          if ($wynik['Admin'] != 0){
        if ($rows == 1) {
            $_SESSION['Name']=$username; // Initializing Session
            $_SESSION['Admin']=$wynik['Admin'];
            $_SESSION['ID'] = $wynik['LP'];
header("location: index.php"); // Redirecting To Other Page

}} else {
            $error = "Błędny login i/lub hasło albo brak dostępu do systemu. Skontaktuj się z Ordynatorem";
        }
        mysqli_close($dbcon); // Closing Connection
    }
}

?>
<body class="text-center">
<form action="" method="POST" class="form-signin">
<label>Imie i nazwisko</label>
<input id="name" name="username" placeholder="Imie i nazwisko" type="text" class="form-control">
<label>Hasło</label>
<input id="password" name="password" type="password" value="admin" class="form-control">
<input name="submit" type="submit" value="Login" class="btn btn-lg btn-primary btn-block">
<span><?php echo $error; ?></span>
</form>
</body>

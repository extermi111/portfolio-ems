<?php

if (@$maybeStart != true) {
    header('location: index.php');
}

?>
<body>

  <div class="container">

<nav class="navbar navbar-light bg-light">
    <a href="<?php echo $_SERVER["PHP_SELF"] ?>" class="btn btn-primary">
      System medyczny V1
    </a>
      <?php echo "Witaj ".$_SESSION['Name']." [". $_SESSION['ID'] ."]"; ?>
      <span>
        <?php if ($_SESSION['Admin'] >= $poziomy['ordynator']) {
    ?>
  <a href="?adminPanel"class="btn btn-outline-danger">Panel ordynatora</a> <?php
} ?>
<a href="#" onclick="changePasswordMy(<?php echo $_SESSION['ID']; ?>)" class="btn btn-outline-danger"  data-toggle="tooltip" data-placement="bottom" title="Kliknij tutaj, aby zmienić swoje hasło.">🔐</a>
  <a href="logout.php"class="btn btn-outline-danger">Wyloguj</a>
</span>
</nav><br/><br/>

<?php if (isset($_SESSION['komunikat'])) {
        ?>
  <div class="alert alert-info text-center d-block" role="alert"><?php echo $_SESSION['komunikat']; ?></div>
<?php
unset($_SESSION['komunikat']);
    } ?>

<div class="card-deck">
<div class="card border-primary mb-3 float-left" style="max-width: 18rem;">
  <div class="card-header">Wyszukaj osobę</div>
  <div class="card-body text-primary">
<form>
  <div class="input-group mb-3">
<input class="form-control" type="search" placeholder="ID lub imie i nazwisko" aria-label="Search" name="szukaj">
<div class="input-group-append">
    <span class="input-group-text" id="basic-addon2"><a href="#szukaj" data-toggle="tooltip" data-placement="bottom" title="Aby wyszukać daną osobę, wpisz całe jej imie i nazwisko, fragment lub numer ID w bazie. Jeżeli będzie więcej osób o podanym ciągu znaków, zostanie wyświetlona lista z wyborem. W przypadku pozostawienia pola pustego uzyskasz dostęp do swojej kartoteki.">❔</a></span>
  </div>
</div>
<button class="btn btn-info btn-sm btn-block" type="submit">Szukaj</button>
</form>
</div>
</div>

<div class="card border-info mb-3" style="">
  <div class="card-header">Dodaj nową osobę</div>
  <div class="card-body text-info">
    <form method="POST" action="nowaOsobaDodaj.php">

        <?php if ($_SESSION['Admin'] >= $poziomy['medyk']) {
        ?>
      <div class="form-row">
        <div class="form-group col-md-5">
          <label for="name">Imie i nazwisko</label>
          <input name="name" required type="text" class="form-control form-control-sm" id="name" style="margin-top: 0px;">
        </div>
        <div class="form-group col-md-2">
          <label for="sex">Płeć</label>
          <select name="sex" id="sex" class="form-control form-control-sm">
            <option selected value="0">Mężczyzna</option>
            <option value="1">Kobieta</option>
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="date">Data urodzenia</label>
          <input name="date" required type="date" class="form-control form-control-sm" id="date">
        </div>
        <button type="submit" class="btn btn-primary">Dodaj osobę</button>
        </div>
      <?php
    } else {
        echo '<div class="alert alert-danger text-center d-block" role="alert">BRAK DOSTĘPU DO MODUŁU!</div>';
    }?>

    </form>
  </div>
</div>
</div>
<?php

  if (isset($_GET['szukaj'])) {
      include("szukaj.php");
  } elseif (isset($_GET['edytuj'])) {
      include("edytuj.php");
  } elseif (isset($_GET['adminPanel'])) {
      include("adminPanel.php");
  } else {
      include("statystyki.php");
  }

?>
</div>
<footer class="footer text-muted text-right">
    Strona stworzona przez Extermi111<br/>All rights reserved
</footer>

  </body>
  </html>

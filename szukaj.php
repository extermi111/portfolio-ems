<?php

if (@$maybeStart != true) {
    header('location: index.php');
}

$scrollTo = 'scrollSzukaj';

$wyszukaj = mysqli_real_escape_string($dbcon, $_GET['szukaj']);

if ($wyszukaj=='' or $wyszukaj == 0) {
    $wyszukaj = $_SESSION['ID'];
}

  if (is_numeric($wyszukaj)) {
      $query = sprintf("SELECT * FROM `ludzie` WHERE `LP` LIKE '%d' LIMIT 10", $wyszukaj);
  } else {
      $wyszukaj = '%'.$wyszukaj.'%';

      $query = sprintf("SELECT * FROM `ludzie` WHERE `Name` LIKE '%s' LIMIT 10", $wyszukaj);
  }

    $result = mysqli_query($dbcon, $query);

    if (mysqli_num_rows($result) == 1) {
        ?>
      <div class="card-deck" id="scrollSzukaj">
<div class="card border-dark mb-3" style="max-width: 24rem;">
  <div class="card-header">Dane osobowe</div>
  <div class="card-body text-dark">

    <?php

      $wynik = mysqli_fetch_array($result);

        $liczbaKartotek = sprintf("SELECT `LP` FROM `kartoteki` WHERE `Pacjent` Like %d", $wynik['LP']);

        $liczbaKartotek = mysqli_query($dbcon, $liczbaKartotek);

        $liczbaKartotek = mysqli_num_rows($liczbaKartotek);

        $IDPacjenta = $wynik['LP'];

        if ($wynik['Sex'] == 0) {
            $plec = "Mężczyzna";
        } else {
            $plec = "Kobieta";
        }


        if ($wynik['Dead'] == 0) {
            $zgon = "Nie";
        } else {
            $zgon = "Tak";
        }

        if ($_SESSION['Admin'] >= $poziomy['ordynator']) {
            $poziomAdmina = '<li class="list-group-item"><b>Poziom: </b>'. $wynik['Admin'] .'</li>';
        } else {
            $poziomAdmina = "";
        }

        $pacjent = sprintf(
          '<ul class="list-group">
                            <li class="list-group-item"><b>ID w bazie: </b>%d</li>
                            <li class="list-group-item"><b>Imie i nazwisko: </b>%s</li>
                            <li class="list-group-item"><b>Data urodzenia: </b>%s</li>
                            <li class="list-group-item"><b>Płeć: </b>%s</li>
                            <li class="list-group-item"><b>Zgon: </b>%s</li>
                            <li class="list-group-item"><b>Kartotek: </b>%s</li>
                            %s
                          </ul>',
                          $wynik['LP'],
                          $wynik['Name'],
                          $wynik['Birthday'],
                          $plec,
                          $zgon,
                          $liczbaKartotek,
                          $poziomAdmina
      );

        echo $pacjent;
        if ($_SESSION['Admin'] >= $poziomy['medyk']) {
            echo "<br/><form>
        <button type='submit' name='edytuj' value='{$wynik['LP']}' class='btn btn-primary btn-sm btn-block'>Edytuj osobę</button>
      </form><br/>";
        }

        if ($_SESSION['Admin'] >= $poziomy['ordynator']) {
            ?>
    <div class="text-right">
      <a href="usunOsobe.php?<?php echo "ID=".$IDPacjenta ?>" onclick="return confirm ('Czy na pewno chcesz usunąć osobę #<?php echo $wynik['LP'] ?>?');" class="btn btn-primary btn-sm">Usuń osobę 🗑️</a>
    </div> <?php
        }

        echo "</div></div>"; ?>

      <div class="card border-dark mb-3">
        <div class="card-header">Dodaj nowy wpis</div>
        <div class="card-body text-dark">
          <?php if ($_SESSION['Admin'] >= $poziomy['medyk']) {
            ?>
          <form method="POST" action="nowyWpisDodaj.php">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputEmail4">ID Pacjenta</label>
                <input class="form-control" name="Pacjent" type="text" value="<?php echo $wynik['LP']; ?>" readonly>
              </div>
              <div class="form-group col-md-4">
                <label for="inputEmail4">Ratownik</label>
                <select name="Medyk" class="form-control">
                  <?php
                    $query = "SELECT `LP`, `Name` FROM `Ludzie` WHERE `Admin` > 0";
            $result = mysqli_query($dbcon, $query);

            while ($dane = mysqli_fetch_assoc($result)) {
                echo "<option ";
                if ($dane['LP'] == $_SESSION['ID']) {
                    echo " selected ";
                }
                echo " value='{$dane['LP']}'>
                      {$dane['Name']}
                        </option>";
            } ?>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="inputEmail4">Data</label>
                <input name="Date" class="form-control" type="date" value="<?php echo date("Y-m-d"); ?>">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label name="Miejsce_zdarzenia" for="inputEmail4">Miejsce zdarzenia</label>
                <input class="form-control" type="text">
              </div>
              <div class="form-group col-md-4">
                <label for="inputEmail4">Okoliczności</label>
                <input name="Okolicznosci" class="form-control" type="text">
              </div>
              <div class="form-group col-md-4">
                <label for="inputEmail4">Rozpoznanie</label>
                <input name="Rozpoznanie" class="form-control" type="text">
              </div>
            </div>

            <div class="form-group">
              <label>Leczenie</label>
              <textarea name="Leczenie" class="form-control" rows="2"></textarea>
            </div>

            <div class="form-group">
              <label>Uwagi</label>
              <textarea name="Uwagi" class="form-control" rows="2"></textarea>
            </div>

            <button type='submit' class='btn btn-primary btn-sm btn-block'>Dodaj wpis</button>

          </form>
          <?php
        } else {
            echo '<div class="alert alert-danger text-center d-block" role="alert">BRAK DOSTĘPU DO MODUŁU!</div>';
        } ?>
      </div>
      </div></div>

      <?php include("kartoteki.php"); ?>

      <?php
    } elseif (mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger text-center d-block" role="alert">Przykro mi, nikogo nie znalazłem :(</div></div>';
    } else {
        ?>
      <div class="card border-dark mb-3" style="max-width: 24rem;">
        <div class="card-header">Wybierz osobę</div>
        <div class="card-body text-dark">
          <div class="list-group">

<?php

      while ($wynik = mysqli_fetch_array($result)) {
          ?>
          <form>
          <button type="submit" name="szukaj" value="<?php echo $wynik['LP'] ?>" class="list-group-item list-group-item-action"><?php echo $wynik['Name']." - ".$wynik['Birthday']; ?></button>
        </form>
        <?php
      } ?> </div></div></div>
      </div> <?php
    }
    ?>

<?php

if (@$maybeStart != true) {
    header('location: index.php');
}

?>
<div class="card border-dark mb-3">
  <div class="card-header">Lista wpisów</div>
  <div class="card-body text-dark">
    <div class="accordion" id="Kartoteki">
      <?php

      $kartoteka = 1;

        if (isset($_GET['rekord'])) {
            $scrollTo = 'scrollKartoteki';
            $kartotekiWiecej = $_GET['rekord'];
            if (!is_numeric($kartotekiWiecej) or $kartotekiWiecej<=0) {
                $kartotekiWiecej = 0;
            }
        } else {
            $kartotekiWiecej = 0;
        }

        $kartotekiWiecej = mysqli_real_escape_string($dbcon, $kartotekiWiecej);

        $ileWiecej = 10;

        $query = "SELECT `kartoteki`.*, `ludzie`.`Name` FROM `kartoteki` INNER JOIN `ludzie` ON `kartoteki`.`Medyk` = `ludzie`.`LP` WHERE `kartoteki`.`Pacjent` = {$IDPacjenta} ORDER BY `kartoteki`.`Date` DESC, `LP` DESC LIMIT {$kartotekiWiecej}, $ileWiecej";

        $result = mysqli_query($dbcon, $query);

        if (mysqli_num_rows($result) != 0) {
            while ($dane = mysqli_fetch_assoc($result)) {
                ?>
      <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#Kartoteka<?php echo $kartoteka; ?>" aria-expanded="false" aria-controls="Kartoteka<?php echo $kartoteka; ?>" style="cursor: pointer;">
          <div class="row">
                  <div class="col-1">#<?php echo $dane['LP']; ?></div>
                  <div class="col-2"><?php echo $dane['Date']; ?></div>
                  <div class="col-3"><?php echo $dane['Name']; ?></div>
                  <div class="col-3"><?php echo $dane['Miejsce_zdarzenia']; ?></div>
                  <div class="col-3"><?php echo $dane['Okolicznosci']; ?></div>
          </div>
        </div>
        <div id="Kartoteka<?php echo $kartoteka++; ?>" class="collapse" data-parent="#Kartoteki">
          <div class="card-body">
            <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10%" scope="row">Rozpoznanie</th>
                  <td><pre style='margin: 0;'><?php echo $dane['Rozpoznanie']; ?></pre></td>
                </tr>
                <tr>
                  <th scope="row">Leczenie</th>
                  <td><pre style='margin: 0;'><?php echo $dane['Leczenie']; ?></pre></td>
                </tr>
                <tr>
                  <th scope="row">Uwagi</th>
                  <td><pre style='margin: 0;'><?php echo $dane['Uwagi']; ?></pre></td>
                </tr>
              </tbody>
            </table><?php if ($_SESSION['Admin'] >= $poziomy['medyk']) {
                    ?>
            <div class="text-right">
              <a href="usunWpis.php?rekord=<?php echo $dane['LP']."&ID=".$IDPacjenta ?>" onclick="return confirm ('Czy na pewno chcesz usunąć wpis #<?php echo $dane['LP'] ?>?');" class="btn btn-primary">Usuń wpis 🗑️</a>
            </div> <?php
                } ?>
          </div>
        </div>
      </div>

    <?php
            }
        } else {
            echo '<div class="alert alert-danger text-center d-block" role="alert">Brak kartotek do wyświetlenia.</div>';
        }
  ?>

    <nav aria-label="Page navigation example" id="scrollKartoteki">
      <ul class="pagination justify-content-center mt-3">
        <li class="page-item <?php if ($kartotekiWiecej <= 0) {
      echo 'disabled';
  } ?>">
          <a class="page-link" href="?szukaj=<?php echo $IDPacjenta; ?>&rekord=<?php echo($kartotekiWiecej-$ileWiecej) ?>" tabindex="-1">Previous</a>
        </li>
        <?php
          $query2 = "SELECT * FROM `kartoteki` WHERE `Pacjent` = {$IDPacjenta}";

          $result2 = mysqli_query($dbcon, $query2);

          $kartotekLiczba = mysqli_num_rows($result2);

          $kartotekStron = ceil($kartotekLiczba/$ileWiecej);

          for ($i=0; $i<$kartotekStron; $i++) {
              echo '<li class="page-item"><a class="page-link" href="?szukaj='.$IDPacjenta.'&rekord='.($i*$ileWiecej).'">'.($i+1).'</a></li>';
          }
         ?>
        <li class="page-item <?php if ($kartotekiWiecej+$ileWiecej >= $kartotekLiczba) {
             echo 'disabled';
         } ?> ">
          <a class="page-link" href="?szukaj=<?php echo $IDPacjenta; ?>&rekord=<?php echo($kartotekiWiecej+$ileWiecej) ?>">Next</a>
        </li>
      </ul>
    </nav>

  </div>
</div>
</div>

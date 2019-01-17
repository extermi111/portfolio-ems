<?php

if (@$maybeStart != true or $_SESSION['Admin'] < $poziomy['medyk']) {
    header('location: index.php');
}

$query = mysqli_query($dbcon, sprintf("SELECT * FROM `ludzie` WHERE `LP` LIKE '%d'", $_GET['edytuj']));

$result = mysqli_fetch_assoc($query);

// print_r($result);

?>

<div class="card border-dark mb-3">
  <div class="card-header">Edytuj osobę</div>
  <div class="card-body text-dark">
    <form action="edytujOsobe.php" method="post">
      <div class="form-row">
        <div class="form-group col-md-5">
            <label>Imie i nazwisko</label>
            <input type="text" class="form-control form-control-sm" name="Name" value="<?php echo $result['Name'] ?>" placeholder="Imie i nazwisko">
        </div>
        <div class="form-group col-md-2">
            <label>Płeć</label>
            <select name="Sex" id="Sex" class="form-control form-control-sm">
              <option <?php if ($result['Sex'] == 0) {
    echo 'selected';
} ?> value="0">Mężczyzna</option>
              <option <?php if ($result['Sex'] == 1) {
    echo 'selected';
} ?> value="1">Kobieta</option>
            </select>
        </div>
        <div class="form-group col-md-2">
            <label>Data urodzenia</label>
            <input type="date" class="form-control form-control-sm" name="Birthday" value="<?php echo $result['Birthday'] ?>">
        </div>
        <?php if ($_SESSION['Admin'] >= $poziomy['lekarz']) {
    ?>
          <input type="hidden" name="Dead" value="0">
          <div class="form-group col-md-1 text-center">
              <label>Zgon</label><br/>
              <input type="checkbox" name="Dead" value='1'>
          </div>
        <?php
} ?>
        <?php if ($_SESSION['Admin'] >= $poziomy['ordynator']) {
        ?>
          <div class="form-group col-md-2">
              <label>Poziom dostępu</label>
              <input type="number" min="0" max="10" class="form-control form-control-sm" name="Admin" value="<?php echo $result['Admin'] ?>">
          </div>
        <?php
    } ?>
      </div>

      <input type="hidden" name="LP" value="<?php echo $_GET['edytuj'] ?>">

    <button type='submit' class='btn btn-primary btn-sm btn-block'>Zatwierdź edycję</button>

    </form>
  </div>
</div>

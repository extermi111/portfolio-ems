<?php

if (@$maybeStart != true) {
    header('location: index.php');
}

if ($_SESSION['Admin'] < $poziomy['ordynator']) {
    header('location: index.php');
}

$scrollTo = 'scrollAdminPanel';
 ?>


<div class="card border-dark mb-3" id="scrollAdminPanel">
  <div class="card-header">Ratownicy Medyczni</div>
  <div class="card-body text-dark">
    <div class="row border text-center font-weight-bold">
      <div class="col-1 border">ID</div>
      <div class="col-3 border">Imie i nazwisko</div>
      <div class="col-2 border">Poziom dostępu</div>
      <div class="col-6 border">Hasło</div>
    </div>
    <?php

      $query = "SELECT * FROM `ludzie` WHERE `Admin` between 1 and 99 ORDER BY `Admin` DESC";

      $result = mysqli_query($dbcon, $query);

      while ($dane = mysqli_fetch_assoc($result)) {
          ?>

            <div class="row border text-center">
              <div class="col-1 border"><?php echo $dane['LP']; ?></div>
              <div class="col-3 border"><?php echo $dane['Name']; ?></div>
              <div class="col-2 border"><?php echo $dane['Admin']; ?></div>
              <div class="col-6 border pr-0 pl-0"><input type="text" class="form-control" style="height: 26px;" name="haslo" placeholder="<?php
              if ($dane['Password'] == '') {
                  echo "Brak hasła";
              } else {
                  echo "Hasło już istnieje";
              } ?>" onblur="changePasswordAdmin(this, <?php echo $dane['LP']; ?>)"></div>
            </div>

          <?php
      }

    ?>
  </div>
</div>

<script>

  function changePasswordAdmin(Obj, id){

    $.ajax({
      url: "adminPanelChange.php",
      type: "POST",
      data: 'password='+Obj.value+'&ID='+id,
      success: function(data){
        alert (data);
      },
      error: function(data){
        alert (data);
      },
    });

  }

</script>

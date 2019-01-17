<?php
// Start the session
session_start();

include("settings.php");

$scrollTo = '';
?>

<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <link rel="stylesheet" href="custom.css">

    <title>kartoteki ems</title>
  </head>

<?php

$maybeStart = true;

if (isset($_SESSION['Name'])) {
    include('start.php');
} else {
    include('login.php');
}

?>

	</div>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="custom.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    $('body').scrollTo('#<?php echo $scrollTo; ?>');
    </script>
  </body>
</html>

<?php
    //yhendan sessiooniga
    require("functions.php");

    //kui ei ole sisseloginud, suunan login lehele
    if(!isset($_SESSION["userId"])) {
      header("Location: login.php");
      exit();
    }

    //kas aadressireal on logout
    if (isset($_GET["logout"])) {

      session_destroy();

      header("Location: login.php");
      exit();
    }

    if ( isset($_POST["autor"]) &&
   isset($_POST["esitaja"]) &&
   isset($_POST["pealkiri"]) &&
   isset($_POST["loomise_aasta"]) &&
   isset($_POST["kestvus"]) &&
   isset($_POST["plaat"]) &&
   isset($_POST["zanr"]) &&
   isset($_POST["kommentaar"]) &&
   !empty($_POST["autor"]) &&
   !empty($_POST["esitaja"]) &&
   !empty($_POST["pealkiri"]) &&
   !empty($_POST["loomise_aasta"]) &&
   !empty($_POST["kestvus"]) &&
   !empty($_POST["plaat"]) &&
   !empty($_POST["zanr"]) &&
   !empty($_POST["kommentaar"])

  ) {

  //$color = cleanInput($_POST["color"]);
  //$age = cleanInput($_POST["age"]);

  saveSong($Autor, $Esitaja, $Pealkiri, $Loomise_aasta, $Kestvus, $Plaat, $Zanr, $Kommentaar);

  }

  $songs = getAllSongs();

  echo "<pre>";
  var_dump($songs[5]);
  echo "</pre>";

?>


<h1>Data</h1>

<p>

    Tere tulemast <?=$_SESSION["userEmail"];?>!
    <a href="?logout=1">logi välja</a>

</p>

    <h2>Salvesta oma teos </h2>

    <form method = "POST" >

      <label> Autor </label><br>
      <input name="autor" type="text">

      <br><br>

      <label> Esitaja </label><br>
      <input name="esitaja" type="text">

      <br><br>

      <label> Pealkiri </label><br>
      <input name="pealkiri" type="text">

      <br><br>

      <label> Loomise aasta </label><br>
      <input name="loomise_aasta" type="number">

      <br><br>

      <label> Kestvus </label><br>
      <input name="kestvus" type="time">

      <br><br>

      <label> Plaat </label><br>
      <input name="plaat" type="text">

      <br><br>

      <label> Žanr </label><br>
      <input name="zanr" type="text">

      <br><br>

      <label> Kommentaar </label><br>
      <input name="kommentaar" type="text">

      <br><br

	<input type="submit" value="Salvesta">

</form>

<h2> Arhiiv </h2>

<?php


    $html = "<table>";

      $html .= "<tr>";
        $html .= "<th>ID</th>";
        $html .= "<th>Autor</th>";
        $html .= "<th>Esitaja</th>";
        $html .= "<th>Loomise aasta</th>";
        $html .= "<th>Kestvus</th>";
        $html .= "<th>Plaat</th>";
        $html .= "<th>Žanr</th>";
        $html .= "<th>Kommentaar</th>";
      $html .= "</tr>";

      foreach ($songs as $s)  {

        $html .= "<tr>";
          $html .= "<td>".$s->id."</td>";
          $html .= "<td>".$s->autor."</td>";
          $html .= "<td>".$s->esitaja."</td>";
          $html .= "<td>".$s->pealkiri."</td>";
          $html .= "<td>".$s->loomise_aasta."</td>";
          $html .= "<td>".$s->kestvus."</td>";
          $html .= "<td>".$s->plaat."</td>";
          $html .= "<td>".$s->zanr."</td>";
          $html .= "<td>".$s->kommentaar."</td>";
        $html .= "</tr>";


      }

    $html .= "</table>";

    echo $html;


?>

<h2> Midagi huvitavat </h2>

<?php

  /*  foreach ($people as $p)  {

      $style = "
        background-color:".$p->lightcolor.";
        width: 40px;
        height: 40px;
        border-radius: 20px;
        text-align: center;
        line-height: 39px;
        float: left;
        margin: 20px;

      ";

      echo "<p style ='  ".$style."  '>".$p->age."</p>";


      */
 ?>

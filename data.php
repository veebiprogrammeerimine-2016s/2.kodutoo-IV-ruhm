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

    if ( isset($_POST["age"]) &&
   isset($_POST["color"]) &&
   !empty($_POST["age"]) &&
   !empty($_POST["color"])
  ) {

  $color = cleanInput($_POST["color"]);
  $age = cleanInput($_POST["age"]);

  saveEvent($age, $color);

  }

  $people = getAllPeople();

  echo "<pre>";
  var_dump($people[5]);
  echo "</pre>";

?>


<h1>Data</h1>

<p>

    Tere tulemast <?=$_SESSION["userEmail"];?>!
    <a href="?logout=1">logi välja</a>

</p>

    <h2>Salvesta sündmus </h2>

    <form method = "POST" >

      <label> Vanus </label><br>
      <input name="age" type="number">

      <br><br>

      <label> Värv </label><br>
      <input name="color" type="color">

      <br><br>
	<input type="submit" value="Salvesta">

</form>

<h2> Arhiiv </h2>

<?php


    $html = "<table>";

      $html .= "<tr>";
        $html .= "<th>ID</th>";
        $html .= "<th>Vanus</th>";
        $html .= "<th>Värv</th>";
      $html .= "</tr>";

      foreach ($people as $p)  {

        $html .= "<tr>";
          $html .= "<td>".$p->id."</td>";
          $html .= "<td>".$p->age."</td>";
          $html .= "<td>".$p->lightcolor."</td>";
        $html .= "</tr>";


      }

    $html .= "</table>";

    echo $html;


?>

<h2> Midagi huvitavat </h2>

<?php

    foreach ($people as $p)  {

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

    }

 ?>

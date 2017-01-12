<?php
require("functions.php");
if(!isset($_SESSION["userID"])){
    header("Location: index.php");
}
//kas aadressireal on logout
if(isset($_GET["logout"])) {
  session_destroy();
  header("Location: index.php");
}
if ( isset($_SESSION["userID"]) && isset($_POST["text"]) &&
   !empty($_POST["text"])
){
  saveText($_POST["text"]);
}
if(isset($_GET["done"])&& !empty($_GET["done"])) {
  textDone($_GET["done"]);
}
$texts = getTexts();
?>
<h1>To Do</h1>
<p>Oled sisse loginud kui <b><?=$_SESSION["userName"];?></b> <a href="?logout=1">logi valja </a></p>
<br>
<h2>To Do lisamine</h2>
<form method="POST" >
	<label>Tekst</label><br>
	<input name="text" type="text">
	<input type="submit" value="Salvesta">
</form>
<br>
<h2>To Do List</h2>
<?php
 $html = "";
  $html .= "<table border='1px'>";

  $html .= "<tr>";
    $html .= "<th>ID</th>";
    $html .= "<th>Tekst</th>";
    $html .= "<th>Lisatud</th>";
    $html .= "<th></th>";
  $html .= "</tr>";

  foreach ($texts as $text) {
    $html .= "<tr>";
      $html .= "<td>".$text->id."</td>";
      $html .= "<td>".$text->text."</td>";
      $html .= "<td>".$text->created."</td>";
      $html .= "<td><a href='?done=".$text->id."'><input type='button' value='Tehtud'></a></td>";
    $html .= "</tr>";

  }
  $html .= "</table>";
  echo $html;
?>
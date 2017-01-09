<?php
    //edit.php
    require("../functions.php");

    require("../class/Helper.class.php");
    $Helper = new Helper();

    require("../class/Event.class.php");
    $Event = new Event($mysqli);

    if(isset($_GET["delete"])){
        $Event->deleteExercise($_GET["id"]);
        header("Location: data.php");
        exit();
    }


    //kas kasutaja uuendab andmeid
    if(isset($_POST["update"])){

        if(!empty($_POST["date"]) &&
            !empty($_POST["exercise"]) &&
            !empty($_POST["sets"]) &&
            !empty($_POST["reps"]) &&
            !empty($_POST["weight"])) {

                    $Event->updateExercise($_POST["date"], $Helper->cleanInput($_POST["exercise"]), $Helper->cleanInput($_POST["sets"]), $Helper->cleanInput($_POST["reps"]), $Helper->cleanInput($_POST["weight"]), $Helper->cleanInput($_POST["id"]));
             } else {

            echo "mingi väli on tühi";
            }

    }


?>
<?php require("../header.php"); ?>
    <br><br>
    <a href="data.php"> Back </a>

    <h2>Edit exercise</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
        <input type="hidden" name="id" value="<?=$_GET["id"];?>" >
        <input type="date" name="date" >Date</input><br><br>
        <input type="text" name="exercise" >Exercise</label><br><br>
        <input type="text" name="sets" >Sets</input><br><br>
        <input type="text" name="reps" >Reps</label><br><br>
        <input type="text" name="weight" >Weight</label><br><br>

        <input type="submit" name="update" value="Update">
    </form>


    <a href="?id=<?=$_GET["id"];?>&delete=true">Delete</a>


<?php require("../footer.php"); ?>
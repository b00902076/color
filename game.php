<!-- <?//php session_start();$_SESSION["via_button"]="unset"?> -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="ui/bootstrap.css" rel="stylesheet">
    <link href="game.css" rel="stylesheet" type="text/css">
    <link href="ui/jquery-confirm.css" rel="stylesheet">
    <script src="jquery-3.2.1.js" type="text/javascript"></script>
    <script src="ui/jquery-confirm.js" type="text/javascript"></script>
    <script src="ui/bootstrap.js" type="text/javascript"></script>
</head>
<body>
    <div class="information">
        <p class="lv">Level </p>
        <p>
            <button class="help_btn btn btn-info">ヘルプ</button>
            <button class="kichiku_btn btn btn-info">鬼畜モード</button>
            <button class="reset btn btn-info">リセット</button>
        </p>
    </div>

    <div class="mycontainer">
        <div class="row">
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
        </div>
        <div class="row">
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
        </div>
        <div class="row">
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
        </div>
        <div class="row">
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
            <div class="grid_outer"><div class="grid"></div></div>
        </div>

    </div>
    
<!--     <div class="fixed"> -->
<!--         <p class="highScore">High Score: </p> -->
<!--     </div> -->
    


    <?php
        echo "<table class=\"board page\">";
        echo "<tr class=\"board_top\">"."<td colspan=2>ランキング</td>";
        echo "</tr>";
        echo "<tr class=\"board_ctop\">";
        echo "<td>Name</td><td>Score</td>";
        echo "</tr>";
        $servername = "localhost";
        $username = "root";
        $password = "ppp";
        $dbname = "huang";
        //echo "Get name: ".$name."<br>Get score: ".$score."<br>";


        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }//echo "Connected successfully<br>";

        if( ($_POST["name"] != "" && $_POST["score"] != "") //&&
            //($_SESSION["via_button"] == $_POST["via_button"]) &&
            //($_SESSION["via_button"] == "unset")){
            ){
            $sql = "select max(uid) as maxuid from score_ranking";
            $result = $conn->query($sql)->fetch_assoc();
            //echo "maxuid= ".$result['maxuid']+1;
            if($name == "") $name = "NoName";
            $sql = "insert into score_ranking (uid, name, score) value ('".($result['maxuid']+1)."','".$_POST['name']."','".$_POST['score']."')";
            $conn->query($sql);
            $conn->close();
            header('Location: http://127.0.0.1:8888/WebGame/game.php');
            //$_POST = [];
            //$_SESSION["via_button"]="submitted";
        }

        $sql = "select * from score_ranking order by score desc, uid asc limit 20";
        //$result = $conn->query($sql);
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_array()) {
                echo "<tr>";
                echo "<td>{$row[1]}</td><td>{$row[2]}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td>0 results</tr></td>";
        }
        $conn->close();
        echo "</table>";
    ?>
    <?php 
        //echo "\$_SESSION[\"via_button\"]= ".$_SESSION["via_button"]."<br>";
        //echo "\$_POST[\"via_button\"]= ".$_POST["via_button"]."<br>";
    ?>
    <form name="myform" action="game.php" method="post">
        <input type="hidden" name="name">
        <input type="hidden" name="score">
        <input type="hidden" name="valid">
        <!--  <input type="hidden" name="via_button" value="<?php //echo $_SESSION['via_button']; ?>"> -->
        <?php 
            //echo "\$_SESSION[\"via_button\"]= ".$_SESSION["via_button"]."<br>";
            //echo "\$_POST[\"via_button\"]= ".$_POST["via_button"]."<br><br><br>";
        ?>
    </form>
    <script src="game_jQuery.js" type="text/javascript"></script>
</body>
</html>
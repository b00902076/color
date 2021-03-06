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

    <?php
        echo "<table class=\"board page\">";
        echo "<tr class=\"board_top\">"."<td colspan=2>ランキング</td>";
        echo "</tr>";
        echo "<tr class=\"board_ctop\">";
        echo "<td>Name</td><td>Score</td>";
        echo "</tr>";

        include_once "config/db_connect.php";

        if($_POST["name"] != "" && $_POST["score"] != ""){
            $sql = "select max(uid) as maxuid from score_ranking";
            $result = $conn->query($sql)->fetch_assoc();
            if($name == "") $name = "NoName";
            $sql = "insert into score_ranking (uid, name, score) value ('".($result['maxuid']+1)."','".$_POST['name']."','".$_POST['score']."')";
            $rtn =  $conn->query($sql);
            $conn->close();
            header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        }

        $sql = "select * from score_ranking order by score desc, uid asc limit 20";
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
    <form name="myform" action="game.php" method="post">
        <input type="hidden" name="name">
        <input type="hidden" name="score">
        <input type="hidden" name="valid">
    </form>
    <script src="game.js" type="text/javascript"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/ilc.svg" type="image/x-icon">
    <title>ILC SCORE</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
    * {
        box-sizing:border-box;
        margin:0;
        padding:0;
        font-family: 'Press Start 2P', Stencil Std, sans-serif, cursive;
    }
    html {
        height:100%;
    }
    body {
        background-color:#f1f1f1;
        height:100vh;
    }
    #notificationS, #notificationF, #notificationM  {
      height:100vh;
      width:100%;
      text-align:center;
      color:white;
      line-height:30px;
      font-family:bold;
      border:1px solid white;
      position:absolute;
      top:0;
      left:0;
      z-index: 1000000000000;
      display:flex;
      align-items:center;
      justify-content:center;
    }
    #notificationS {
      background-color: lime;
    }
    #notificationF {
      background-color: red;
    }
    #notificationM {
      background-color: orange;
    }
</style>
</head>

<body>

<?php
   
    $servername = "localhost";
    $database = "leaderboard";
    $username = "root";
    $password = "";
    // Create connection
    $baglanti = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if ($baglanti->connect_error) { 
        die("DB Connection failed: " . $baglanti->connect_error);
    } else { 
        $nickname= $_POST["nickname"];
        $address= $_POST["address"];
        $ilcscore= $_POST["ilcscore"]; 
        $sql_u = "SELECT * FROM leaderboard WHERE nickname='$nickname'";
        $res_u = mysqli_query($baglanti, $sql_u);


        if (!empty($nickname) && !empty($address) && $ilcscore < 1000)  {
            if (mysqli_num_rows($res_u) > 0) {
                $updt = "UPDATE leaderboard SET score = '$ilcscore' WHERE nickname = '$nickname' AND score < '$ilcscore'";
                $updted = mysqli_query($baglanti,$updt); 
                if ($updted) { ?>
                    <div id="notificationS">
                        Your old score updated, higher one is valid, you will be forwarded to game.
                    </div>
                    <script>
                    setTimeout(function(){
                        document.getElementById("notificationS").style.display="none";
                        location.href="index.php";
                    }, 3000);
                </script>
                <?php    
                }     
            } else {
                $add = "insert into leaderboard (nickname,address,score) values ('$nickname','$address','$ilcscore')";
                $added = mysqli_query($baglanti,$add);
                if ($added) { ?>
                    <div id="notificationS">
                        Score submitted successfully, you will be forwarded to to game.
                    </div>
                    <script>
                    setTimeout(function(){
                        document.getElementById("notificationS").style.display="none";
                        location.href="index.php";
                    }, 3000);
                </script>
                <?php    
                } else { ?>
                    <div id="notificationF">
                        Score submission failed, play again.
                    </div>
                    <script>
                    setTimeout(function(){
                        document.getElementById("notificationF").style.display="none";
                        location.href="index.php";
                    }, 3000);
                </script>
                <?php }
            }
        } else { ?>
            <div id="notificationM">
                Please fill out the nickname and/or ILC address field, or you are SCAMMER
            </div>
            <script>
                setTimeout(function(){
                    document.getElementById("notificationM").style.display="none";
                    location.href="index.php";
                }, 3000);
            </script>
        <?php } 

        
        


        
       
        }
        ?>


</body>
</html>


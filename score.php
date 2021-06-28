<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/ilc.svg" type="image/x-icon">
    <title>SCOREBOARD</title>
    <!-- CSS -->
    <link href='css/jquery-ui.min.css' rel='stylesheet' type='text/css'>

   
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
        .wrapper {
            height:100vh;
            overflow-y:auto;
            padding-top:90px;
        }
        .wrapper h1 {
            text-align: center;
            position: absolute;
            width: 100%;
            top: 0;
            font-size: 30px;
            background: white;
            height: 60px;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .wrapper .date {
            position: absolute;
            width: 100%;
            top: 60px;
            left:0;
            font-size: 30px;
            background-color: #1f1f21;
            height: 30px;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .wrapper .date input[type="text"] {
            width:90px;
            margin-right:10px;
            text-align:center;
            font-size:16px;
            height: 24px;
            line-height: 24px;
        }
        
        .wrapper .date label {
            color:white;
            font-size:12px;
            margin-right:10px;
        }
        .wrapper .date input[type="submit"] {
            height:24px;
            width:90px;
            background-color: #fff;
            color:#1f1f21;
            outline:0;
            border:0;
            cursor:pointer;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-left:auto;
            margin-right:auto;
            color:white;
            background-color: #3c3436;
            font-size:14px;
        }
        th, td {
            padding: 0.25rem;
            text-align: left;
            border: 1px solid #ccc;
        }
        table tr:nth-of-type(2){
            background-color:#00ff00;
            color:black;
        }
        table tr:nth-of-type(3){
            background-color:#00c0ff;
            color:black;
        }
        table tr:nth-of-type(4){
            background-color:#ff8d17;
            color:black;
        }
        table #tableerror {
            background-color:#ef002d;
            color:white;
            text-align:center;
        }
        .highlight {
            background: #1f1f21;
        }
        #connectOk, #connectFail {
            height:30px;
            width:100%;
            text-align:center;
            color:white;
            line-height:30px;
            font-family:bold;
            border:1px solid white;
            position:absolute;
            bottom:0;
            left:0;
            z-index: 100;
        }
        #connectOk {
            background-color:green;
        }
        #connectFail {
            background-color:red;
        }
        .date .dateFilter {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }
        @media screen and (max-width:900px) {
            table {
                font-size:12px;
            }
        }
        @media screen and (max-width:700px) {
            table {
                font-size:10px;
            }
            table .hiddencolumn {
                display:none;
            }
            .wrapper h1 {
                font-size: 20px;
            }
            .wrapper .date label {
                display:none;
            }
            #ui-datepicker-div {
                width: 100%!important;
                left:50% !important;
                transform:translateX(-50%)!important;
            }
        }
        @media screen and (max-width:400px) {
            table {
                font-size:7px;
            }
            .wrapper h1 {
                font-size: 12px;

            }
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
        if ($baglanti->connect_error) { ?>
            <div id="connectFail">
            <?php die("DB Connection failed: " . $baglanti->connect_error); ?>
            </div> 
            <script>
                setTimeout(function(){
                    document.getElementById("connectFail").style.display="none";
                }, 3000);
            </script>
            <?php
        } else { }?>


    <div class="wrapper">
        <h1>ILCOIN HODL SCOREBOARD</h1>
        <!-- Search filter -->
        <form class="date" method='post' action='' autocomplete="off">
            <label for="dateFilter1">Start Date</label>
            <input id="dateFilter1" type='text' class='dateFilter' placeholder="start date" name='fromDate' readonly="readonly" value='<?php if(isset($_POST['fromDate'])) echo $_POST['fromDate']; ?>'>
        
            <label for="dateFilter2">End Date</label>
            <input id="dateFilter2" type='text' class='dateFilter' placeholder="end date" name='endDate' readonly="readonly" value='<?php if(isset($_POST['endDate'])) echo $_POST['endDate']; ?>'>

            <input type='submit' name='but_search' value='Search' onclick="cleardate()">
        </form>
        
        <table>
            <tr class="highlight">
                <th>Rank</th>
                <th>Nickname</th>
                <th class="hiddencolumn">Address</th>
                <th>Score</th>
                <th>Date</th>
            </tr>
            <?php 
                $emp_query = "SELECT * FROM leaderboard WHERE 1 ";
         
                // Date filter
                if(isset($_POST['but_search'])){
                   $fromDate = $_POST['fromDate'];
                   $endDate = $_POST['endDate'];
         
                   if(!empty($fromDate) && !empty($endDate)){
                      $emp_query .= " and jointdate 
                                   between '".$fromDate."' and '".$endDate."' ";
                   }
                 }
         
                 // Sort
                 $emp_query .= " ORDER BY score DESC";
                 $employeesRecords = mysqli_query($baglanti,$emp_query);
         
                 // Check records found or not
                 if(mysqli_num_rows($employeesRecords) > 0){
                    $i=1;  
                   while($scoreboard = mysqli_fetch_assoc($employeesRecords)){
                     $nickname = $scoreboard['nickname'];
                     $address = $scoreboard['address'];
                     $score = $scoreboard['score'];
                     $jointdate = $scoreboard['jointdate'];
         
                     echo "<tr>";
                     echo "<td>".$i; $i++."</td>";
                     echo "<td>". $nickname ."</td>";
                     echo '<td class="hiddencolumn">'. $address ."</td>";
                     echo "<td>". $score ."</td>";
                     echo "<td>". $jointdate ."</td>";
                     echo "</tr>";
                   }
                 }else{
                   echo "<tr>";
                   echo '<td id="tableerror" colspan="5">No record found</td>';
                   echo "</tr>";
                 }
                
            ?>
            

        </table>
    </div>

     <!-- Script -->
     <script src='js/jquery.js' type='text/javascript'></script>
    <script src='js/jquery-ui.js' type='text/javascript'></script>
    <script src='js/jquery-ui.min.js' type='text/javascript'></script>
    <script type='text/javascript'>
        $(document).ready(function(){
        $('.dateFilter').datepicker({
            dateFormat: "yy-mm-dd"
        });
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en" translate="no">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate" />
    <link rel="shortcut icon" href="img/ilc.svg" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/7d5dd4076f.js" crossorigin="anonymous"></script> 
    <title>ILCOIN HODL</title>

    <style>
      #scorePopUp form .wrapper + #submitscore:disabled {
        opacity: 0.7;
        color: #666666;
        cursor: not-allowed;
      }
    </style>
  </head>
  <body>
   <div id="brand">
     <img src="img/ilc.svg" class="logo" alt="ilcoin-logo">
     <div class="wrapper">
      <p class = "p1">ILCOIN HODL</p>
      <p class = "p2">How long can you HODL? Press <span>&#11014;&#65039;</span> to up <span>&#11015;&#65039;</span> to down </p>
     </div>
   </div>

   <div id="mobile">
     <p>You can play only mobile version from your smartphone</p>
   </div>

   <div id="container">
      <div id="backdrop">
        <div id="intro">
          <img src="img/ilc.svg" alt="">
          <h2>ILCOIN HODL</h2> 
        </div>
        <button id="play" onclick="play()">PLAY</button>
        <div id="information">
          <h2>How long can you hodl ILCOIN without crashing? Let's play and submit your high score for weekly rewards.</h2>
          <ul>
            <li><span class="emoji">&#9940;</span><span>Don't hit the edges</span></li>
            <li><span class="emoji">&#9940;</span><span>Don't crash to the pipes</span></li>
            <li><span class="emoji">&#127918;</span><span>Let's click "Play" Button</span></li>
            <li><span class="emoji">&#127919;</span><span>Submit your score</span></li>
            <li><span class="emoji">&#127942;</span><span>Earn ILCOIN weekly</span></li>
          </ul>
        </div>
      </div>

      <div id="bird">
        <img id="birdimage" src="img/ilc.svg" alt="">
      </div>
      <div id="pole_1" class="pole"></div>
      <div id="pole_2" class="pole"></div>
      <div id='stars'></div>
      <div id='stars2'></div>
      <div id='stars3'></div>


      <div id="restart_btn">
        <img src="img/ilc.svg" alt="">
        <h2>ILCOIN HODL</h2>
        <button id="restart_btn1">Restart</button>
        <button id="submit_score">Score: <span id="score2">0</span>
          <span class="ilc">ILC</span> <br><br>  <span class="bluetext">Submit Score</span> </button>
      </div>
      
      
     <div id="gameover">
        <h2>GAME OVER</h2>
        <p>Balance: <span id="score1">0</span>
          <span class="ilc">ILC</span>
        </p>
     </div>

     <div class="grand">
        <button id="flapdown"> 
          <i class="far fa-arrow-alt-circle-down"></i>
        </button>

        <div class="rightside">
          <div id="score_div">
            <p>
              <b> Balance: </b>
              <span id="score">0</span>
              <span class="ilc">ILC</span>
            </p>
            <p><b>Speed: </b><span id="speed"></span></p>
         </div> 
        </div>

        <button id="flap"> 
        <i class="far fa-arrow-alt-circle-up"></i>
        </button>
        
     </div>



     <div id="scorePopUp">
        <form action="addscore.php" method="post" id="form1">
          <div class="wrapper">
            <label for="nickname">Nickname</label>
            <input type="text" name="nickname" id="nickname" minlength="3" maxlength="16">
          </div>
          <small>Nickname must be between 3 and 16 characters</small>
          <div class="wrapper">
            <label for="address">ILC Address</label>
            <input type="text" name="address" id="address" >
          </div>
          <small>score must be more than 100 to submit</small>
          <div class="wrapper">
            <label for="ilcscore">Score</label>
            <input type="number" name="ilcscore" id="ilcscore" readonly>
          </div>
          <button id="submitscore" type="submit" name="ScoreSubmission" >Submit Score</button>
          <button id="backbtn">Cancel</button>
        </form>
      </div>

      <button id="sound">
            <i class="fas fa-volume-mute"></i>
      </button>

   </div>
   
   <script src="js/jquery.min.js"></script>
   <script src="js/game.js"></script>

    <script>
      $(document).keydown(function (event) {
          if (event.keyCode == 123) { // Prevent F12
              return false;
          } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
              return false;
          }
      });

      //prevent right click on mouse
      document.addEventListener("contextmenu", function(e){  
          e.preventDefault();
      }, false);

      //reload the page with resize
      jQuery(function($){
        var windowWidth = $(window).width();
        var windowHeight = $(window).height();
      
        $(window).resize(function() {
          if(windowWidth != $(window).width() || windowHeight != $(window).height()) {
            location.reload();
            return;
          }
        });
      });
      

    </script>

    <?php
    function isMobileDevice() {
      return preg_match("/(android|webos|avantgo|iphone|ipad|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
    if(isMobileDevice()){?>
      <script>
      document.getElementById("flap").style.display = "block";
      document.getElementById("flapdown").style.display = "block";
      document.getElementById("mobile").style.display = "none";
      document.getElementById("brand").style.display = "none";

    </script>
    <?php
    }
    else { ?>
      <script>
        document.getElementById("container").style.display = "none";
        document.getElementById("flap").style.display = "none";
        document.getElementById("flapdown").style.display = "none";
        $('.grand .rightside')[0].style.flex="1";
        $('.grand .rightside #score_div')[0].style.alignSelf = "initial";
      </script>
    <?php }
    ?>

  </body>
</html>

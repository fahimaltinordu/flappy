// First we get the viewport height and we multiple it by 1% to get a value for a vh unit
let vh = window.innerHeight * 0.01;
// Then we set the value in the --vh custom property to the root of the document
document.documentElement.style.setProperty('--vh', `${vh}px`);

// audio files
var flapsound = new Audio();
var earnilc = new Audio();
var hitsound = new Audio();
var themeMusic = new Audio();
var gameover = new Audio();

earnilc.src = "audio/earnilc.mp3";
flapsound.src = "audio/flap.mp3";
hitsound.src = "audio/hit.mp3";
themeMusic.src = "audio/themeMusic.mp3";
gameover.src = "audio/over.mp3";

$( document ).ready(function() {
    $('#sound').click(function(){
        var $this = $(this);
        $this.toggleClass('active');
        if ($this.hasClass('active')){
            document.getElementById("sound").innerHTML = `<i class="fas fa-volume-up"></i>`;                
            themeMusic.play();     
        } else {
            document.getElementById("sound").innerHTML = `<i class="fas fa-volume-mute"></i>`;
            themeMusic.pause();
        }
    });
});



function play() {
    document.getElementById("backdrop").style.display="none";

    //saving dom objects to variables
    var container = $('#container');
    var bird = $('#bird');
    var pole = $('.pole');
    var pole_1 = $('#pole_1');
    var pole_2 = $('#pole_2');
    var score = $('#score');
    var score1 = $('#score1');
    var score2 = $('#score2');
    var speed_span = $('#speed');
    var restart_btn = $('#restart_btn');
    var restart_btn1 = $('#restart_btn1');
    var submitScore = $('#submit_score');
    var submitScorData = $('#submitscore');
    var backbutton = $('#backbtn');
    var grand = $('.grand');

    //saving some initial setup
    var container_width = parseInt(container.width());
    var container_height = parseInt(container.height());
    var pole_initial_position = parseInt(pole.css('right'));
    var pole_initial_height = parseInt(pole.css('height'));
    var bird_left = parseInt(bird.css('left'));
    var bird_height = parseInt(bird.height());
    var grand_height = parseInt(grand.height());
    var speed = 4;

    //some other declarations
    var go_up = false;
    var score_updated = false;
    var game_over = false;


    var the_game = setInterval(function () {
        
        if (parseInt(bird.css('top')) <= 0 || parseInt(bird.css('top')) > container_height - bird_height  - grand_height) {
            var element = document.getElementById("container");
            element.classList.add("crash");
            gameover.play();
            setTimeout(function(){
                document.getElementById("container").style.borderColor = "#0b52ff";
            },3000); 
        }
        if (collision(bird, pole_1)) {
            var element = document.getElementById("pole_1");
            element.classList.add("poleCrash");
            gameover.play();

        } else if (collision(bird, pole_2)) {
            var element = document.getElementById("pole_2");
            element.classList.add("poleCrash");
            gameover.play();
        }

        
        if (collision(bird, pole_1) || collision(bird, pole_2) || parseInt(bird.css('top')) <= 0 || parseInt(bird.css('top')) > container_height - bird_height - grand_height ) {

            hitsound.play();
            themeMusic.pause(); 
            
            var kayma = container_height - bird_height - grand_height;
            var coin = document.getElementById("bird");
            coin.style.top = `${kayma}px`;

            coin.style.transform = 'rotate(180deg)';
            coin.style.transition = "top 2s, transform 1s";
            document.getElementById("gameover").style.display = "flex";
            stop_the_game();

        } else {
            var pole_current_position = parseInt(pole.css('right'));
            
            //update the score when the poles have passed the bird successfully
            if (pole_current_position > container_width - bird_left) {
                if (score_updated === false) {
                    if (speed <= 5) {
                        score.text((parseInt(score.text()) + 1));
                        score1.text((parseInt(score1.text()) + 1));
                        score2.text((parseInt(score2.text()) + 1));
                    }
                    if (speed >5 && speed <= 10) {
                        score.text((parseInt(score.text()) + 2));
                        score1.text((parseInt(score1.text()) + 2));
                        score2.text((parseInt(score2.text()) + 2));
                    }
                    if (speed >10 && speed <= 15) {
                        score.text((parseInt(score.text()) + 3));
                        score1.text((parseInt(score1.text()) + 3));
                        score2.text((parseInt(score2.text()) + 3));
                    }
                    if (speed >15 && speed <= 20) {
                        score.text((parseInt(score.text()) + 4));
                        score1.text((parseInt(score1.text()) + 4));
                        score2.text((parseInt(score2.text()) + 4));
                    }
                    if (speed >20 && speed <= 30) {
                        score.text((parseInt(score.text()) + 5));
                        score1.text((parseInt(score1.text()) + 5));
                        score2.text((parseInt(score2.text()) + 5));
                    }
                    if (speed >30 ) {
                        score.text((parseInt(score.text()) + 6));
                        score1.text((parseInt(score1.text()) + 6));
                        score2.text((parseInt(score2.text()) + 6));
                    }
                    score_updated = true;
                    earnilc.play();

                }
            }

            //check whether the poles went out of the container
            if (pole_current_position > container_width) {
                var new_height = parseInt(Math.random() * 130);

                //change the pole's height
                pole_1.css('height', pole_initial_height - new_height);
                pole_2.css('height', pole_initial_height + new_height);

                //increase speed
                speed = speed + 0.5;
                speed_span.text(speed);

                score_updated = false;

                pole_current_position = pole_initial_position;
            }

            //move the poles
            pole.css('right', pole_current_position + speed);

            if (go_up === false) {
                go_down();
            }
        }

    }, 40);

    $(document).on('keydown', function (e) {
        var key = e.keyCode;
        if (key === 38 && go_up === false && game_over === false) {
            go_up = setInterval(up, 50);
        }
    });

    $(document).on('keyup', function (e) {
        var key = e.keyCode;
        if (key === 38) {
            clearInterval(go_up);
            go_up = false;
        }
    });
    
    document.addEventListener("contextmenu", function(e){  //prevent right click on mouse
        e.preventDefault();
    }, false);

    document.getElementById("flap").addEventListener("touchstart", touchHandler, false);
    function touchHandler(e) {    
        if (go_up === false && game_over === false) {
                e.preventDefault();
                go_up = setInterval(up, 50);
            }
        } 
    document.getElementById("flap").addEventListener("touchend", function(e){
        clearInterval(go_up);
        go_up = false;  
        e.preventDefault();
    }, false);
    

    function go_down() {
        document.getElementById("bird").style.transform = 'rotate(45deg)';
        bird.css('top', parseInt(bird.css('top')) + 5);
    }

    function up() {
        document.getElementById("bird").style.transform = 'rotate(0deg)';
        bird.css('top', parseInt(bird.css('top')) - 12);
        flapsound.play();
    }

    function stop_the_game() {
        clearInterval(the_game);
        game_over = true;
        setTimeout(function(){
            document.getElementById("gameover").style.display = "none";
            document.getElementById("restart_btn").style.display = "flex";
            document.getElementById("score_div").style.color = "lightgray";
            restart_btn.slideDown();
            // document.getElementById("flap").style.display = "none";
         },3000); 
    }
    
    restart_btn1.click(function () {
        location.reload();
    });
    

    submitScore.click(function() {
        document.getElementById("restart_btn").style.display="none";
        document.getElementById("scorePopUp").style.display="block";
        $("#ilcscore").val(parseInt(score.text()));

    });

    var useraddress  = localStorage.getItem("useraddress");
    var usernick  = localStorage.getItem("usernick");
    $("#address").val(useraddress);
    $("#nickname").val(usernick);
    submitScorData.click(function() {
        var ilcoinaddress = document.getElementById('address').value;
        var ilcoinnickname = document.getElementById('nickname').value;
        localStorage.setItem("useraddress", ilcoinaddress);
        localStorage.setItem("usernick", ilcoinnickname);

    });

    backbutton.click(function(e) {
        document.getElementById("restart_btn").style.display="flex";
        document.getElementById("scorePopUp").style.display="none";
        e.preventDefault();
    });
    
    

    function collision($div1, $div2) {
        var x1 = $div1.offset().left;
        var y1 = $div1.offset().top;
        var h1 = $div1.outerHeight(true);
        var w1 = $div1.outerWidth(true);
        var b1 = y1 + h1;
        var r1 = x1 + w1;
        var x2 = $div2.offset().left;
        var y2 = $div2.offset().top;
        var h2 = $div2.outerHeight(true);
        var w2 = $div2.outerWidth(true);
        var b2 = y2 + h2;
        var r2 = x2 + w2;

        if (b1 < y2 || y1 > b2 || r1 < x2 || x1 > r2) return false;
        return true;
    }



};

<!doctype html>
<html>
<head>
	<title>do you Daily?</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="application-name" content="Daily" />
		<meta name="author" content="Alfonso Fernández Roca"/>
		<meta name="description" content="" />
		<meta name="keywords" content=""/>
		<meta name="googlebot" content="noarchive"/>
		<meta name="robots" content="index,follow"/> 
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<meta name="MobileOptimized" content="320"/>
		<meta property="og:type" content="website" /> 
		<meta property="og:title" content="Daily" /> 
		<meta property="og:image" content="http://doskalei.com/img/pikuit.png" /> 
		<meta property="og:description" content="" /> 
		<meta property="og:url" content="http://doskalei.com">
		<meta http-equiv="X-UA-Compatible" content="chrome=1" />
		<meta name="msapplication-tooltip" content="" />
		<meta name="msapplication-navbutton-color" content="#FF3300" />
		<meta name="msapplication-window" content="width=1024;height=768" />

	
		<link href='http://fonts.googleapis.com/css?family=Coda' rel='stylesheet' type='text/css'>

		<style type="text/css">
			*{font-family:'Coda', cursive;}
			html,body{display:block;width:100%;height:100%;margin:0;padding:0;}
			body{background-image:url(img/background.png);-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;background-size: cover !important;background-repeat: no-repeat;}

			#menu{
				display: 			block;
				position: 			absolute;
				top:				20px;
				left:				5%;
				width:				50%;
				min-width: 			280px;
				height:				30px;				
			}
			#menu > span{
				display:			inline-block;
				margin:				auto 20px 0 0;
				cursor:  			pointer;
			}
			#menu #status{width:60px;height:60px;-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;}
			#menu #status.down{background: #b7b7b7;}
			#menu #status.up{background: #84d96a;}
			#input{
				display: 			block;
				position: 			absolute;
				top:				50px;
				right:				5%;
				width:				50%;
				min-width: 			280px;
				height:				40px;
				background: 		none;
				border: 			0;
				border-bottom: 		3px solid #474747;
				line-height: 		150%;
				font-size: 			20px;
				text-indent: 		10px;
				color:				rgba(0,0,0,0.6);
			}
			#input:focus, #input:active{border:0;box-shadow: 0;outline: 0;background: rgba(0,0,0,0.7);color:white;}
			#glass{
				display: 			block;
				position: 			absolute;
				top:				100px;
				right:				5%;
				width:				50%;
				min-width: 			280px;
				height:				40%;
				color: 				white;
				background: 		rgba(0,0,0,0.6);
				overflow-x:			hidden;
				overflow-y:			auto;
			}
			#glass h3{
				display:			none;
				position:			relative;
				left:				-800px;
				font-weight: 		normal;
				font-size: 			1em;
				line-height: 		150%;
			}
			#board{
				display: 			block;
				position: 			absolute;
				top:				60%;
				right:				5%;
				width:				50%;
				min-width: 			280px;
				height:				30%;
				padding-top: 		2px;
				color: 				white;
				background: 		rgba(0,0,0,0.6);
				text-indent: 		10px;
				font-size: 			12px;
				line-height: 		150%;
				overflow-x:			hidden;
				overflow-y:			auto;
			}
		</style>
</head>
<body id="interface">

	<section id="menu">
		<span id="status" data-state="down" class="down"></span>
	</section>
	<input id="input" type="text" x-webkit-speech />
	<section id="glass"></section>
	<!--<section id="board"></section>-->
	
	<script src="js/processing-1.4.1.min.js"></script>
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery.nicescroll.min.js"></script>
	<script type="text/javascript">

		// function draw() {
		// 	var canvas = document.getElementById("radians");
		// 	if (canvas.getContext) {
		// 		var ctx = canvas.getContext("2d");

		// 		ctx.beginPath();
		// 		ctx.moveTo(63,63);
		// 		ctx.lineTo(104,92);
		// 		ctx.moveTo(63,63);
		// 		ctx.lineTo(63,12);
		// 		ctx.moveTo(63,63);
		// 		ctx.lineTo(22,92);
		// 		ctx.closePath();
		// 		ctx.stroke();

		// 	}
		// }

		var working, speech;

		function action() {
			if (working) {
				speech.stop(); 
				reset(); 
			} else {
				speech.start(); 
				working = true;  
				$("#status").removeClass("down").addClass("up").attr("data-status","up");
			} 
		}

		function showInfo(info){

			var _idinfo = new Date().getTime();
			$("#glass").append('<h3 id="info_'+ _idinfo +'"">'+info+'</h3>');
			$("#info_"+_idinfo).fadeIn().animate({left:"10px"},180,function(){});

			$("#glass").niceScroll({horizrailenabled:false,cursorborderradius:0,autohidemode:false}).resize();
		}

		$(document).ready(function(){


			$("#glass").niceScroll({horizrailenabled:false,cursorborderradius:0,autohidemode:false}).resize();

			// Check if the user's web browser supports HTML5 Speech Input API
			if(document.createElement('input').webkitSpeech == undefined) {
				showInfo("We are sorry but Dictation requires Google Chrome.");
			}else {
				// Get the default locale of the user's browser (e.g. en-US, or de)
			    var _language = window.navigator.userLanguage || window.navigator.language;
			    $("body").attr("lang", _language).focus();
		  	}
		 
			// This is called when Chrome successfully transcribes the spoken word
			$("body").bind("webkitspeechchange", function (e) {
				var val = $("#input").val();
				daily(val);
				$("#input").val("");			    
			});

			$("#status").on('click',function(){
				action();
				return false;
			});

		});

		function daily(said){
			if(said == "start") {
				showInfo("Daily active");
				return;
			}
		}

		function save() {
		  var d = document.getElementById("input").innerHTML;
		  filepicker.setKey('AeoWySYsRQWugIlof6Gegz');
		  filepicker.store(d, function(a) {
		    filepicker['export'](a, {extension: '.txt', services:['DROPBOX','GOOGLE_DRIVE','COMPUTER','SEND_EMAIL']}, function(a) {
		    });
		  });
		}
		                     
		var working, speech;

		if (typeof(webkitSpeechRecognition) !== 'function') {  
		  document.getElementById("input").innerHTML = "We are sorry but Dictation requires the latest version of Google Chrome on your desktop.";
		  document.getElementById("messages").style.display = "none";
		} else {

		  speech = new webkitSpeechRecognition();
		  speech.continuous = true;
		  speech.maxAlternatives = 5;
		  speech.interimResults = true;

		  speech.lang = window.navigator.userLanguage || window.navigator.language;
		  speech.onend = reset;
		 
		  reset();
		  
		  speech.onerror = function (e) {
		    var msg = e.error + " error"; 
		    if ( e.error === 'no-speech' ) {
		      msg = "No speech was detected. Please try again."; 
		    } else if ( e.error === 'audio-capture' ) {
		      msg = "Please ensure that a microphone is connected to your computer."; 
		    } else if ( e.error === 'not-allowed' ) {
		      msg = "The app cannot access your microphone. Please go to chrome://settings/contentExceptions#media-stream and allow Microphone access to this website."; 
		    } 
		    document.getElementById("warning").innerHTML = "<p>" + msg + "</p>"; 
		    setTimeout(function() {
		      document.getElementById("warning").innerHTML = ""; 
		    }, 5000);
		  };
		  
		  speech.onresult = function (e) {
		    for (var i = e.resultIndex; i < e.results.length; ++i) {
		      if (e.results[i].isFinal) {

		        var words = document.getElementById("input"); 
		        var val = e.results[i][0].transcript; 

		        if (val === "\n\n") {
		          val = ".<br><br>"; 
		        } else if (val === " new sentence") {
		          val = ". ";
		        } else if (val === " stop listening") {
		          val = ". "; action();
		        } 
		        
		        if (words.innerHTML.substr(-2) === ". ") {
		          val = val.substr(1,1).toUpperCase() + val.substr(2);          
		        }        

		        if (words.innerHTML.length === 0) {
		          val = val.substr(0,1).toUpperCase() + val.substr(1);          
		        }        
		        
		        //document.getElementById("notfinal").innerHTML = ""; 
		        words.innerHTML += val;        
		      } else {        
		        //document.getElementById("notfinal").innerHTML = e.results[i][0].transcript;
		        daily(e.results[i][0].transcript);
		      }
		    }
		  };
		  
		  if (typeof(localStorage) !== 'undefined' ) {
		    if ( localStorage.narration === 'undefined' ) {
		      localStorage.narration = ""; 
		    }
		    
		    document.getElementById("input").innerHTML = localStorage.narration;
		  
		    setInterval (function () {
		      var text = document.getElementById("input").innerHTML;  
		      if (text !== localStorage.narration) {
		        localStorage.narration = text;        
		      }
		    }, 5000);       
		  }  
		}
		  
		function clearSlate() { 
		  if (working) {
		    speech.stop();
		  } 
		  document.getElementById("input").innerHTML = "";
		  reset();
		}

		function reset() {
		  working = false; 
		  $("#status").removeClass("up").addClass("down").attr("data-state","down");
		  // document.getElementById("status").style.display="none"; 
		  // document.getElementById("btn").innerHTML = "Start Dictation";  
		}


		function toggleVisibility(selectedTab) {
		     var content = document.getElementsByClassName('info');
		     for(var i=0; i<content.length; i++) {
		          if(content[i].id == selectedTab) {
		                content[i].style.display = 'block';
		          } else {
		                content[i].style.display = 'none';
		          }
		     }
		}



	</script>
</body>
</html>
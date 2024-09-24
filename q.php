<!DOCTYPE html>
<html>
<body>

<audio id="beeper">
  <source src="Beep-09.ogg" type="audio/ogg">
  
Your browser does not support the audio element.
</audio>

<p>Click the buttons to play or pause the audio.</p>

<script>

var n = 0;

//var run = setInterval(playAudio, 5000);

var x = document.getElementById("beeper"); 
playAudio();

function playAudio() { 
  if (n > 5) {
    document.getElementById("beeper").play(); 
  setTimeout(pauseAudio, 3000);// set the timeout to determine how long it
//should run!
}
} 

function pauseAudio() { 
  x.pause();
    n++; 
} 
</script>

<button onclick="playAudio()" type="button">Play Audio</button>
<button onclick="pauseAudio()" type="button">Pause Audio</button> 


</body>
</html>

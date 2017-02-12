<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="{{ asset('js/recorder.js') }}"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style>
		:focus {
			outline: none;
		}

		.progress {
			width: 40px;
			height: 40px;
			text-align: center;
			
		}

		.progress > svg {
			height: 100%;
			/*display: inline-block;*/
		}
	</style>
</head>
<body>

<style>
</style>


<div style="display: inline;">
	<input type="image" id="playSample" src="{{ asset('img/noun_839208_cc.png') }}" onclick="$('#sample')[0].play(); startProgress('progressSample')" alt="Submit" width="40" height="40">
	<div class="progress" style="height: 7px; width: 200px; display: none;">
		<div id="progressSample" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:1%">
		</div>
	</div>
</div>
<div style="display: inline;">
	<input type="image" class="startRecord" src="{{ asset('img/noun_89660.png') }}" onclick="toggleRecord(this); startProgress('progressRecord')" alt="Submit" width="40" height="40">
	<div class="progress" style="height: 7px; width: 40px; display: none;">
		<div id="progressRecord" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:1%">
		</div>
	</div>
</div>
<div style="display: inline;">
	<input type="image" id="playRecord" class="play" style="display: none;" src="{{ asset('img/noun_659654_cc.png') }}" onclick="$('#record')[0].play(); startProgress('progressPlayback')" alt="Submit" width="40" height="40">
	<div class="progress" style="height: 7px; width: 40px; display: none;">
		<div id="progressPlayback" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:1%">
		</div>
	</div>
</div>
<audio id="sample" src="{{ asset('audio/vie-1-1-1-1.mp3') }}"></audio>
<audio id="record"></audio>

<script>
  var audio_context;
  var recorder;

  function toggleRecord(button) {
  	if ($(button).hasClass('startRecord')) {
  		startRecording(button);
  	} else if ($(button).hasClass('stopRecord')) {
  		stopRecording(button);
  	}
  }

  function startUserMedia(stream) {
    var input = audio_context.createMediaStreamSource(stream);

    // Uncomment if you want the audio to feedback directly
    //input.connect(audio_context.destination);
    //__log('Input connected to audio context destination.');
    
    recorder = new Recorder(input);
  }

  function startRecording(button) {
    recorder && recorder.record();
	$(button).removeClass('startRecord');
	$(button).addClass('stopRecord');
	$(button).attr('src', '{{ asset('img/noun_105507_cc.png') }}');

    setTimeout(function() {
    	recorder && recorder.stop();
  		$(button).removeClass('stopRecord');
  		$(button).addClass('startRecord');
  		$(button).attr('src', '{{ asset('img/noun_89660.png') }}');
	    
	    // create WAV download link using audio data blob
	    createMedia();
	    
	    recorder.clear();

	    $('#playRecord').show();
    }, 5000);
  }

  function stopRecording(button) {
    recorder && recorder.stop();

	$('#progressRecord').attr('style', 'width: 0%');
	$('#progressRecord').closest('.progress').hide();

	$(button).removeClass('stopRecord');
	$(button).addClass('startRecord');
	$(button).attr('src', '{{ asset('img/noun_89660.png') }}');
    
    // create WAV download link using audio data blob
    createMedia();
    
    recorder.clear();

    $('#playRecord').show();
  }

  function createMedia() {
    recorder && recorder.exportWAV(function(blob) {
      var url = URL.createObjectURL(blob);
      var auRecord = document.getElementById("record");
      
      auRecord.controls = false;
      auRecord.src = url;
      localStorage.setItem("record", url);
    });
  }

  function startProgress(id) {
	var elem = document.getElementById(id);
	$(elem).closest('.progress').show();

	var interval = 0;
	if (id == 'progressSample') {
		interval = $('#sample')[0].duration *10;
	} else if (id == 'progressRecord') {
		interval = 50;
	} else if (id == 'progressPlayback') {
		interval = $('#record')[0].duration *10;
	}
	var width = 1;
	var duration = setInterval(frame, interval);
	function frame() {
		if (width >= 100) {
			clearInterval(duration);
			setTimeout(function() {
		    	$(elem).attr('style', 'width: 0%');
		    	$(elem).closest('.progress').hide();
		    }, 1000);
		} else {
			width++; 
			elem.style.width = width + '%'; 
		}
	}
  }

  window.onload = function init() {
    try {
      // webkit shim
      window.AudioContext = window.AudioContext || window.webkitAudioContext;
      navigator.mediaDevices.getUserMedia = navigator.mediaDevices.getUserMedia || navigator.webkitGetUserMedia;
      window.URL = window.URL || window.webkitURL;
      
      audio_context = new AudioContext;
      console.log('Audio context set up.');
      console.log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
    } catch (e) {
      alert('No web audio support in this browser!');
    }
    
    navigator.mediaDevices.getUserMedia({audio: true}, startUserMedia, function(e) {
      window.alert('No live audio input: ' + e);
    });
  };
  </script>
</body>
</html>
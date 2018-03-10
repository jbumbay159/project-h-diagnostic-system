@extends('template')

@section('content')

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Take Photo</h3>
            </div>      
        </div>
    </div>
    <div class="panel-body">
    	<div class="app">
    	  	<a href="#" id="start-camera" class="visible">Touch here to start the app.</a>
    	  	<video id="camera-stream"></video>
    	  	<img id="snap">
    	  		<p id="error-message"></p>
    	  	<div class="controls">
    	    	<a href="#" id="delete-photo" title="Delete Photo" class="disabled"><i class="material-icons">Retake</i></a>
    	    	<a href="#" id="take-photo" title="Take Photo"><i class="material-icons">Capture</i></a>
    	    	<a href="#" id="download-photo" title="Save Photo" class="disabled" style="display: none;"><i class="material-icons">file_download</i></a>  
    	  	</div>
    	  	<!-- Hidden canvas element. Used for taking snapshot of video. -->
    	  	<canvas></canvas>
    	</div>
    	
    	<a href="/1" target="__blank" id="new_tab" style="display:none;">New Tab</a>
    	
    	{!! Form::model($info, ['method'=>'patch', 'action' => ['CustomerController@photoUpdate', $info->id] ,'files'=>'true']) !!}
    	 	{!! Form::text('photo',null,['style'=>'display:none;', 'placeholder'=>'Watermark', 'title'=>'Normal Size', 'id'=>'image_file']) !!}
    	 	{!! Form::button('<i class="glyphicon glyphicon-save"></i> SAVE PHOTO', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk', 'style' => 'margin-top:20px;')) !!}
    	 	<a href="#upload" data-toggle="modal" style="margin-top: 20px;" class="btn btn-primary btn-quirk"><i class="fa fa-pencil-square-o"></i> Upload Photo</a>
    	{!! Form::close() !!}
    	
    </div>
</div>

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="upload" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Add Photo</h4>
            </div>
            {!! Form::model($info, ['method'=>'patch', 'action' => ['CustomerController@uploadPhoto', $info->id],'files'=>'true']) !!}
                <div class="modal-body">    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('photo','Photo') !!}
                                {!! Form::file('photo', ['class' => 'form-control image-form']) !!}
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">CLOSE</button>
                                {!! Form::submit('UPDATE ENTRY', ['class'=>'btn btn-lg btn-primary','style'=>'margin-top:0px;']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		// References to all the element we will need.
		var video = document.querySelector('#camera-stream'),
		    image = document.querySelector('#snap'),
		    start_camera = document.querySelector('#start-camera'),
		    controls = document.querySelector('.controls'),
		    take_photo_btn = document.querySelector('#take-photo'),
		    delete_photo_btn = document.querySelector('#delete-photo'),
		    download_photo_btn = document.querySelector('#download-photo'),
		    error_message = document.querySelector('#error-message'),
		    // Added by Jaybee
		    image_file = document.querySelector('#image_file');

		// The getUserMedia interface is used for handling camera input.
		// Some browsers need a prefix so here we're covering all the options
		navigator.getMedia = ( navigator.getUserMedia ||
		                      navigator.webkitGetUserMedia ||
		                      navigator.mozGetUserMedia ||
		                      navigator.msGetUserMedia);

		if(!navigator.getMedia){
		  displayErrorMessage("Your browser doesn't have support for the navigator.getUserMedia interface.");
		}
		else{

		  // Request the camera.
		  	navigator.getMedia(
			    {
			      	video: true
			    },
			    // Success Callback
			    function(stream){

			      	// Create an object URL for the video stream and
			      	// set it as src of our HTLM video element.
			      	video.src = window.URL.createObjectURL(stream);

			      	// Play the video element to start the stream.
			      	video.play();
			      	video.onplay = function() {
			        	showVideo();
			      	};
			    },
			    // Error Callback
			    function(err){
			      	displayErrorMessage("There was an error with accessing the camera stream: " + err.name, err);
			    }
		  	);
		}
		// Mobile browsers cannot play video without user input,
		// so here we're using a button to start it manually.
		start_camera.addEventListener("click", function(e){
		  	e.preventDefault();
		  	// Start video playback manually.
		  	video.play();
		  	showVideo();
		});

		take_photo_btn.addEventListener("click", function(e){
		  	e.preventDefault();
		  	var snap = takeSnapshot();

		  	// Show image. 
		  	image.setAttribute('src', snap);
		  	image.classList.add("visible");

		  	// Enable delete and save buttons
		  	delete_photo_btn.classList.remove("disabled");
		  	download_photo_btn.classList.remove("disabled");

		  	// Set the href attribute of the download button to the snap url.
		  	$('#image_file').val(snap);
		  	download_photo_btn.href = snap;
		  	
		  	
		  	
		  	// Pause video playback of stream.
		  	video.pause();
		});

		delete_photo_btn.addEventListener("click", function(e){
		  	e.preventDefault();

		  	// Hide image.
		  	image.setAttribute('src', "");
		  	image.classList.remove("visible");

		  	// Disable delete and save buttons
		  	delete_photo_btn.classList.add("disabled");
		  	download_photo_btn.classList.add("disabled");

		  	// Resume playback of stream.
		  	video.play();

		});

		function showVideo(){
		  	// Display the video stream and the controls.
		  	hideUI();
		  	video.classList.add("visible");
		  	controls.classList.add("visible");
		}


		function takeSnapshot(){
		  	// Here we're using a trick that involves a hidden canvas element.  

		  	var hidden_canvas = document.querySelector('canvas'),
		    context = hidden_canvas.getContext('2d');

		  	var width = video.videoWidth,
		    height = video.videoHeight;

		  	if (width && height) {

		    	// Setup a canvas with the same dimensions as the video.
		    	hidden_canvas.width = width;
		    	hidden_canvas.height = height;

		    	// Make a copy of the current frame in the video on the canvas.
		    	context.drawImage(video, 0, 0, width, height);

		    	// Turn the canvas image into a dataURL that can be used as a src for our photo.
		    	return hidden_canvas.toDataURL("images/png");
		  	}
		}


		function displayErrorMessage(error_msg, error){
		  	error = error || "";
		  	if(error){
		    	console.log(error);
		  	}

		  	error_message.innerText = error_msg;

		  	hideUI();
		  	error_message.classList.add("visible");
		}


		function hideUI(){
		  	// Helper function for clearing the app UI.

		  	controls.classList.remove("visible");
		  	start_camera.classList.remove("visible");
		  	video.classList.remove("visible");
		  	snap.classList.remove("visible");
		  	error_message.classList.remove("visible");
		}
	});
</script>
@endsection
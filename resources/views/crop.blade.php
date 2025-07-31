<script type="text/javascript" src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tether.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('jcrop/js/jquery.Jcrop.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('jcrop/js/jquery.color.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dropzone/dropzone.js?v=1') }}"></script>
<link rel="stylesheet" href="{{ asset('css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('jcrop/css/jquery.Jcrop.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/dropzone/dropzone.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('js/dropzone/dist/min/basic.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
<script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
	rel="stylesheet">

@php

	if ($data['type'] == 'patient_doc') {

		$acceptedFiles = ".pdf,.doc,.docx,.xls,.xlsx,.txt";
	} else {
		$acceptedFiles = "image/*";

	}

@endphp


<script>
	$(document).ready(function () {

		var accepted = "{{$acceptedFiles}}";

		Dropzone.options.uploadImg = {

			acceptedFiles: "image/*",
			maxFiles: 1,
			maxFilesize: 10,
			//autoProcessQueue:false,
			//alert('nmvghfghf');
			init: function () {

				this.on("maxfilesexceeded", function (file) {
					this.removeAllFiles();
					this.addFile(file);
				});
				this.on('error', function (file, response) {
					//alert(response);
					swal(response, '', 'error');
					this.removeAllFiles();
				});

				this.on("thumbnail", function (file) {
					if (file.width < 10 || file.height < 10) {
						file.rejectDimensions()
					}
					else {
						file.acceptDimensions();
					}
				});
				this.on("removedfile", function (file) {
					this.removeAllFiles();
					// $("#drphide").show();
				});

				this.on('success', function (file, response) {
					$("#preloadviews").show();
					$("#preloadview").show();
					$("#mydataone").hide().html(response);
					setTimeout(function () {
						$("#preloadviews").hide();
						$("#preloadview").hide();
						$("#mydataone").show();

						Dropzone.discover();
					}, 500);
				});
			},
			accept: function (file, done) {
				file.acceptDimensions = done;
				file.rejectDimensions = function () { done("Upload a JPG/GIF/PNG image with minimum dimensions of 10 X 10px (Width/Height)."); };
			}
		};

	});
</script>

<style>
	/* .closecolorbox {
		position: absolute;
		top: 15px;
		right: 20px;
		font-family: lato;
		font-size: 20px;
		color: #3b3e44;
	}
	.dropzoneheader h4 {
		font-size: 1.25rem;
		margin: 0;
		font-family: 'Nunito Sans', sans-serif;
		margin-bottom: 20px;
		font-weight: 800;
    	color: var(--dark);
	}
	#drphide {
		padding: 20px;
	}
	.dropzone.dz-clickable {
		cursor: pointer;
		position: relative;
		font-family: 'Nunito Sans', sans-serif;
		font-size: 14px;
		border-radius: 8px;
    	background: #f0f0f0;
    	border: 1px solid #e4e5e8;
		color: #6c757d;
	}
	
	.dropzone {
		padding: 20px 30px 40px;
	}
	.panel-heading h4 {
		font-size: 21px;
		font-family: lato;
		margin: 0;
		margin: 10px 0 20px;
		color: #3b3e44;
	}
	.btn.btn-primary , .btn.btn-default {
		background-color:#52c4ad !important;
		border: 1px solid #52c4ad !important;
		color: #fff !important;
		box-sizing: border-box;
		border-radius: 8px;
		padding: 7px 15px;
		font-weight: 400;
		font-size: 11px;
		line-height: 16px;
		text-align: center;
		text-transform: uppercase;
		color: #FFFFFF;
		transition: all ease .6s;
		margin-right: 3px;
		position:relative;
		z-index:99;
	}
	.btn.btn-default {
		background: transparent;
		border: 1px solid #26126f;
		color: #26126f;
	}
	.btn.btn-primary:hover{
		background: transparent;
		border: 1px solid #26126f;
		color: #26126f;
	}
	.btn.btn-default:hover {
		background: #26126f;
		color: #fff;
	}
	.dz-default.dz-message {
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		margin: auto;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 !important;
	}
	.close-btn {
    background-color: #fff;
    color: #52c4ad;
    border-radius: 8px;
    padding: .5rem 1.5rem;
    text-transform: uppercase;
    border: 2px solid #52c4ad;
    font-size: 11px;
} */
	div#preloadview {
		position: absolute;
		width: 100%;
		top: 0;
		height: 100%;
		display: flex;
		left: 0;
		align-items: center;
		justify-content: center;
	}

	div#preloadviews {
		position: absolute;
		width: 100%;
		top: 0;
		height: 100%;
		display: flex;
		left: 0;
		align-items: center;
		justify-content: center;
	}

	.help-list {
		margin-top: 20px
	}

	.help-list h6 {
		font-size: 15px;
		margin: 0;
	}

	.help-list ul {
		padding-left: 1.5rem;
	}
</style>


<div id="preloadview" class="prelod" style="display:none;">
	<img src="<?php echo url('public/img/twppre.gif'); ?>" alt="Blackbag">
</div>
<div id="mydataone">
	<!DOCTYPE html>

	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Crop & Upload</title>

	</head>

	<body class="cropwrp">

		<style>
			.prelod {
				background-attachment: scroll;
				background-clip: border-box;
				background-color: rgba(0, 0, 0, 0);

				background-origin: padding-box;
				background-position: 0 0;
				background-repeat: no-repeat;
				background-size: auto auto;
				display: block;
				height: 35px;
				width: 35px;
			}
		</style>

		<script>
			function closeColorBox() {
				parent.$.fn.colorbox.close();
			}


			jQuery(function ($) {
				var jcrop_api;

				$('#target').Jcrop({
					boxWidth: 375,
					aspectRatio: <?php echo $data['imageSizes']["width"];?> / <?php echo $data['imageSizes']["height"];?>,
					minSize: [<?php echo $data['imageSizes']["width"];?>, <?php echo $data['imageSizes']["height"];?>],
					setSelect: [0, 0, <?php echo $data['imageSizes']["width"];?>, <?php echo $data['imageSizes']["height"];?>],
					allowSelect: false,
					onChange: attachCoords,
					onSelect: attachCoords,

				}, function () {
					jcrop_api = this;
				});
			});


			function attachCoords(c) {
				$('#x1').val(c.x);
				$('#y1').val(c.y);
				$('#x2').val(c.x2);
				$('#y2').val(c.y2);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			$(document).ready(function () {
				$("#preloaddiv").html('');
				$("#firstsub").click(function () {
					$("#preloaddiv").html('<div class="preInnr">Please wait while we upload…<span class="prelod cuspreNW"></span></div>');
				});

			});
			function withoutcrops() {
				$('#withoutcrop').val('yes');
				$('#cropcreate').submit();
			}
		</script>
		<div id="preloadviews" class="prelod" style="display:none;">
			<img src="{{ asset('img/loading.gif') }}" alt="Blackbag">
		</div>

		<div class="UPerror">{{ $data['error'] }}</div>

		<div id="drphide">
			@if($data['view'] == 1)
					<div class="dropzoneheader">
						<h4 class="modal-title">Upload an image</h4><a class="closecolorbox btn-close"
							onclick="closeColorBox()"> <i class="fas fa-times"></i></a>
					</div>
					<form method="POST" action="{{ url('crop/' . $data['type'] . '/' . $data['count']) }}"
						class="edit-form dropzone" id="uploadImg" enctype="multipart/form-data" autocomplete="off">
						@csrf
						<div class="fallback">
							<input name="img" type="file" />
						</div>
						<input type="hidden" id="uldoctypeimage" name="doctype" value="" />
						<input type="hidden" name="fileupload" value="1" />
						<input type="hidden" name="imtype" value="{{ $data['type'] }}" />
						<input type="hidden" name="cropview" value="{{ $data['cropview'] }}" />
						<input type="hidden" id="uldoctypeimage" name="doctype" value="" />
					</form>
					<div class="help-list">
						<h6 class="my-3">Logo image requirements</h6>
						<ul>
							@if($data['type'] == 'ad')
								<li>Upload the image in either JPG or PNG format.</li>
								<li>The maximum file size is 10 MB.</li>
								<li>The logo is displayed at exactly 1500 * 340 pixels; therefore, the recommended image size that
									you upload is exactly 1500 * 340 pixels.</li>
							@else
								<li>Upload the logo in either JPG or PNG or JPEG format.</li>
								<li>The minimum file size is {{$data['imageSizes']["width"]}} * {{$data['imageSizes']["height"]}} pixels.</li>	
								<!-- <li>The logo is displayed at exactly {{$data['imageSizes']["width"]}} * {{$data['imageSizes']["height"]}} pixels; therefore, the recommended image size that you upload is exactly {{$data['imageSizes']["width"]}} * {{$data['imageSizes']["height"]}} pixels.</li> -->

							@endif
							<!-- <li>If you upload a smaller or larger image, the image is resized to exactly 320 * 130 pixels. If the aspect ratio does not match, then the image will be distorted. For example, a 132 * 132 pixel image expands to 320 * 130 pixels, causing distortion.</li> -->
						</ul>
					</div>
				</div>



				<?php /* <input type="hidden" name="fileupload" value="1"/>
																																																																													  <input type="hidden" name="imtype" value="{{ $type }}"/>
																																																																													 <div class="fallback">
																																																																														 <input name="myfile" type="file" />
																																																																													 </div>
																																																																													 <input type="hidden" id="uldoctypeimage" name="doctype" value=""/> */ ?>

			@endif


		@if($data['view'] == 2)

			<form method="POST" action="{{ url('crop/' . $data['type'] . '/' . $data['count']) }}" id="cropcreate"
				enctype="multipart/form-data" autocomplete="off">
				@csrf

				<input type="hidden" name="thumbnail" value="1" />
				<input type="hidden" id="x1" name="x1" value="0" />
				<input type="hidden" id="y1" name="y1" value="0" />
				<input type="hidden" id="x2" name="x2" value="0" />
				<input type="hidden" id="y2" name="y2" value="0" />
				<input type="hidden" id="w" name="w" value="0" />
				<input type="hidden" id="h" name="h" value="0" />
				<input type="hidden" name="imagekey" value="{{ $data['imagekey'] }}" />


				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="modal-title">Upload an image and crop</h4>
					</div>

					<div class="panel-body">
						<img src="{{ $data['imageLink'] }}" id="target" alt="Blackbag" />
					</div>

					<left class="upboxbtnwrp" style="padding: 0 15px;">

						@if($data['cropview'] == 1)
							<p class="alert alert-warning tc"></p>
							<div class="btn_alignbox">
								@if($data['type'] != 'ad')
									<button class="btn btn-outline-normal crop-btn" type="button" onClick="withoutcrops()">Skip
										Crop</button>
									<input type="hidden" name="withoutcrop" value="no" id="withoutcrop" />
								@endif
								<button class="btn btn-primary crop-btn" type="submit">Crop</button>
						@else
							<button class="btn btn-primary" type="submit">Upload</button>
						@endif
							<button class="btn btn-outline-primary" type="button" onClick="closeColorBox();">Cancel</button>
						</div>
					</left>

					<br />
				</div>
			</form>
		@endif



		@if($data['view'] == 3)

			@if($data['type'] == 'logo')
				<script>
					parent.logoImage('{{ $data['imagekey'] }}', '{{ $data['imagePath'] }}');
					parent.$.fn.colorbox.close();
				</script>

			@elseif($data['type'] == 'doctor')
				<script>
					parent.doctorImage('{{ $data['imagekey'] }}', '{{ $data['imagePath'] }}');
					parent.$.fn.colorbox.close();
				</script>
			@elseif($data['type'] == 'nurse')
				<script>
					parent.nurseImage('{{ $data['imagekey'] }}', '{{ $data['imagePath'] }}');
					parent.$.fn.colorbox.close();
				</script>
			@elseif($data['type'] == 'clinic_logo')

				<script>
					parent.clinicLogoImage('{{ $data['imagekey'] }}', '{{ $data['imagePath'] }}', '{{$data['imgName']}}');
					parent.$.fn.colorbox.close();
				</script>
			@elseif($data['type'] == 'clinic_banner')
				<script>
					parent.clinicBannerImage('{{ $data['imagekey'] }}', '{{ $data['imagePath'] }}'), '{{$data['imgName']}}';
					parent.$.fn.colorbox.close();
				</script>

			@elseif($data['type'] == 'patient')
				<script>
					parent.patientImage('{{ $data['imagekey'] }}', '{{ $data['imagePath'] }}');
					parent.$.fn.colorbox.close();
				</script>
			@elseif($data['type'] == 'patient_doc')
				<script>
					parent.patientDoc('{{ $data['imagekey'] }}', '{{ $data['imagePath'] }}');
					parent.$.fn.colorbox.close();
				</script>
			@else
				<script>
					parent.profileImage('{{ $data['imagekey'] }}', '{{ $data['imagePath'] }}', '{{$data['filesize']}}');
					parent.$.fn.colorbox.close();
				</script>


			@endif
		@endif

	</body>

	</html>
</div>
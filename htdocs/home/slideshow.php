<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_home_portal.php"); ?>

<ul id="slideshow">
	<?php echo svc_echoSlideshowImages(); ?>
</ul>

<style type="text/css">
#slideshow {
	position: relative;
	height: 300px;
	width: 100%;
	padding: 0px;
	margin: 0px;
	list-style-type: none;
}
.slide {
	position: absolute;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	opacity: 0;
	z-index: 1;
	-webkit-transition: opacity 1s;
	-moz-transition: opacity 1s;
	-o-transition: opacity 1s;
	transition: opacity 1s;
}
.showing {
	opacity: 1;
	z-index: 2;
}
.slideimage {
	height: 300px;
	width: auto;
	max-width: 100%;
}
</style>

<script type="text/javascript">
var slides = document.querySelectorAll('#slideshow .slide');
var currentSlide = 0;
var intervalMS = <?php echo svc_getSetting("SlideshowInterval"); ?> ;
//alert(intervalMS);
var slideInterval = setInterval(nextSlide,intervalMS);

function nextSlide(){
	slides[currentSlide].className = 'slide';
	currentSlide = (currentSlide+1)%slides.length;
	slides[currentSlide].className = 'slide showing';
}
</script>
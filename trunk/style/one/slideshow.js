$(document).ready(function(){
    var currentPosition = 0;
    var slideWidth = 560;
    var slides = $('.slide');
    var numberOfSlides = slides.length;

  // Remove scrollbar in JS
    $('#slidesContainer').css('overflow', 'hidden');

  // Wrap all .slides with #slideInner div
  slides
	.wrapAll('<div id="slideInner"></div>')
  // Float left to display horizontally, readjust .slides width
	.css({
	    'float' : 'left',
	    'width' : slideWidth
	});

  // Set #slideInner width equal to total width of all slides
    $('#slideInner').css('width', slideWidth * numberOfSlides);

  // Insert left and right arrow controls in the DOM
    $('#slideshow')
	.prepend('<span class="control" id="leftControl">Move left</span>')
	.append('<span class="control" id="rightControl">Move right</span>');

  // Hide left arrow control on first load
    manageControls(currentPosition);

  // Create event listeners for .controls clicks
    $('.control')
	.bind('click', function(){
    // Determine new position
	    currentPosition = ($(this).attr('id')=='rightControl')
		? currentPosition+1 : currentPosition-1;

      // Hide / show controls
	    manageControls(currentPosition);
      // Move slideInner using margin-left
	    $('#slideInner').animate({
		'marginLeft' : slideWidth*(-currentPosition)
	    });
	});

    window.setTimeout('autoslide', 5000);

  // manageControls: Hides and shows controls depending on currentPosition
    function manageControls(position){
    // Hide left arrow if position is first slide
	if(position==0){ $('#leftControl').hide() }
	else{ $('#leftControl').show() }
    // Hide right arrow if position is last slide
	if(position==numberOfSlides-1){ $('#rightControl').hide() }
	else{ $('#rightControl').show() }
    }
});

function autoslide {
    // Determine new position
    currentPosition = currentPosition+1;

    if(currentPosition >= numberOfSlides) currentPosition = 0;
    
    // Hide / show controls
    manageControls(currentPosition);
    // Move slideInner using margin-left
    $('#slideInner').animate({
	'marginLeft' : slideWidth*(-currentPosition)
    });
    window.setTimeout('autoslide', 5000);
}

var currentPosition = 0;
var slideWidth = 560;
var slides = $('.slide');
var numberOfSlides = slides.length;

$('#slidesContainer').css('overflow', 'hidden');

slides
    .wrapAll('<div  id="slideInner"></div>')

$('#slideInner').css('width', slideWidth * numberOfSlides);

slides
    .css('overflow', 'hidden')
    .wrapAll('<div  id="slideInner"></div>')
$('#slideshow')
    .prepend('<span class="control" id="leftControl">Moves left</span>')
    .append('<span class="control" id="rightControl">Moves right</span>');
function  manageControls(position){
  // position==0 is first slide
    if(position==0)  { $('#leftControl').hide(); }
    else { $('#leftControl').show(); }
    // numberOfSlides-1 is last slides
    if(position==numberOfSlides-1) {  $('#rightControl').hide(); }
    else { $('#rightControl').show(); }
} 

manageControls(currentPosition);

$('.control').bind('click',  function(){
  // do something when user clicks
});

currentPosition = ($(this).attr('id')=='rightControl')
    ?  currentPosition+1 : currentPosition-1;

manageControls(currentPosition);

$('#slideInner').animate({
    'marginLeft' : slideWidth*(-currentPosition)
});
jQuery(function($) {

    var carouselItems = document.getElementsByClassName("carousel-item");

	$('#radeema-carousel').on('slide.bs.carousel', function(event) {
		var iframe = $(this).find('.carousel-item.active iframe');

		if(iframe.length > 0) {

            //console.log(iframe[0])
            var indexOfIframe = players.findIndex(player => player.h.id === iframe[0].id);
            //console.log(indexOfIframe)
            players[indexOfIframe].pauseVideo();
		}
	});
});


var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var players = []; 

function onYouTubeIframeAPIReady()
{
    var youtubeVIframes = document.getElementById("radeema-carousel").getElementsByTagName('iframe');
    for (currentIFrame of youtubeVIframes)
    {
    	var iframeYTSrc = currentIFrame.attributes.src.value
        currentIFrame.src = iframeYTSrc+"&enablejsapi=1"
    	currentIFrame.id = iframeYTSrc.slice(iframeYTSrc.indexOf('embed/')+6, iframeYTSrc.indexOf('?') );
    	//console.log(currentIFrame)

        players.push(new YT.Player(
            currentIFrame.id, 
            { events: { 'onStateChange': onPlayerStateChange } }
        ));
    }
}
function onPlayerStateChange(event)
{	

    if (event.data == YT.PlayerState.PLAYING || event.data == YT.PlayerState.BUFFERING)
        
        jQuery('#radeema-carousel').carousel('pause');
    else
        jQuery('#radeema-carousel').carousel();
}
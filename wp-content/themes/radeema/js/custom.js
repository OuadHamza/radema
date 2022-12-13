jQuery(function($) {

    $('.dropdown').on('show.bs.dropdown', function(e){
        console.log(this.id)
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
    });

    $('.dropdown').on('hide.bs.dropdown', function(e){
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
    });

    $('.menu-item-has-children.dropdown-item').on('click', function(e){
        e.preventDefault();
        e.stopPropagation()
        console.log(this.id, $(this).find('.dropdown-menu'))
        $(this).find('.dropdown-menu').first().slideToggle(300);
    })

    //console.log($('.menu-item-has-children:has(.active.dropdown-item)'))

    $('.menu-item-has-children:has(.active.dropdown-item)').addClass('has_active_nav_link');

});

//document.getElementById('INDmenuGroup-customcolor').style.display = "none"
let observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (!mutation.addedNodes) return

        for (let i = 0; i < mutation.addedNodes.length; i++) {

            if(document.getElementsByClassName("INDmenuFreeMsg").length > 0){
                
                document.getElementsByClassName("INDmenuFreeMsg")[0].style.display = 'none';
                document.getElementById('INDmenuGroup-customcolor').style.display = 'none';
                
                observer.disconnect();
            }
        }
    })
})

observer.observe(document.body, {
    childList: true
    , subtree: true
    , attributes: false
    , characterData: false
}) 

jQuery(document).ready(function($){
    $(window).scroll(function(){
        if ($(this).scrollTop() < 200) {
            $('#smoothup') .fadeOut();
        } else {
            $('#smoothup') .fadeIn();
        }
    });
    $('#smoothup').on('click', function(){
        $('html, body').animate({scrollTop:0}, 1000);
        return false;
        });
});

const showPopupPrivacy = () => !localStorage.getItem('privacy_accepted');
const privacyAccepted = () => localStorage.setItem('privacy_accepted', 'accepted');

jQuery('document').ready( function ($) {

    $popup = $('#popup-consent')
    //console.log(showPopupPrivacy());
    if ( showPopupPrivacy() )
        $popup.slideDown(1500);

    $('#popup-consent-btn').on( 'click',  function () {
        privacyAccepted();
        $popup.slideUp(1000);
    });
})



function focusOnMainContent(identity){
    var top = ($(identity).position().top);
    $(window).scrollTop(top);
}

$(document).ready(function(){ 
    $('#hero-login-gear').click(function(){ focusOnMainContent('#content iframe'); });
    //apply not for TOC.
    $('a').click(function(){ focusOnMainContent('#content'); });
});
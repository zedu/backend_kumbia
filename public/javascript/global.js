$(function(){
    $('.alert-message .close').click(function(event){
        event.preventDefault();
        $(this).parent().fadeOut(400);
    });
});
$(function(){
    $(':button, :submit, .actions a').addClass('btn');
    $('.alert-message .close').click(function(event){
        event.preventDefault();
        $(this).parent().hide(400);
    });
});
$(function() {
    
    /*ie - img size*/
    $('img').each(function(){
        if($(this).width()>900){
            $(this).width('inherit');
        }else{
            $(this).width('auto');
        }
    });

});

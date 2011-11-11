/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    
    $('.last').live('keypress', function(){
        $(this).removeClass('last').addClass('name');
        var $listItem = $('<li class="last"><input class="name"></input></li>').hide();
        $('#nameList').append($listItem);
        $listItem.animate({
            opacity: 'toggle', 
            height: 'toggle'
        }, 'fast');
    })
    
    $('.name').live('blur', function() {
        if($(this).find('input').val() == '') {
            $(this).animate({
                opacity: 'toggle', 
                height: 'toggle'
            }, 'fast', function(){
                $(this).remove();
            })
        }
    })
})


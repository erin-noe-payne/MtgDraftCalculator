/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    
    /*
     * Event Listeners
     */
    $('.last').live('keypress', function(){
        addLi($(this));
    })
    
    $('.name').live('blur', function() {
        if($(this).find('input').val() == '') {
            removeLi($(this));
        }
    })
    
    $('.deleteButton').live('click', function() {
        var li = $(this).closest('li');
        removeLi(li);
    });
    
    /*
     * Functionality
     */
    function addLi(li){
        $(li).removeClass('last').addClass('name');
        $(li).append($('<button type="button" class="deleteButton">X</button>'))
        
        var $listItem = $('<li class="last"><input class="name"></input></li>').hide();
        $('#nameList').append($listItem);
        $listItem.animate({
            opacity: 'toggle', 
            height: 'toggle'
        }, 'fast');
    }
    
    function removeLi(li) {
        $(li).animate({
            opacity: 'toggle', 
            height: 'toggle'
        }, 'fast', function(){
            $(li).remove();
        })
    }
})


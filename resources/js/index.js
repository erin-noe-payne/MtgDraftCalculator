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
        if($.trim($(this).val()) == '') {
            var li = $(this).closest('li');
            removeLi(li);
        }
    })
    
    $('.deleteButton').live('click', function() {
        var li = $(this).closest('li');
        removeLi(li);
    });
    $('#draftForm').submit(function(){
        var players=[];
        $.each($('.name'), function() {
            if($.trim($(this).val()) != '') {
                players.push($(this).val());
            }
        })
        $('#field_players').val(JSON.stringify(players));
    })
    
    /*
     * Functionality
     */
    function addLi(input){
        var li = input.closest('li');
        $(input).removeClass('last').addClass('name');
        var button = $('<div class="deleteButtonContainer"><div class="deleteButton ui-icon-close ui-icon"></div></div>')
        $(li).append(button);
        
        var $listItem = $('<li><input class="last"></input></li>').hide();
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


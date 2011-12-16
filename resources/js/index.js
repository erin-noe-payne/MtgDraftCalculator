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
    $('#draftForm').submit(function(e){
        if(!validData()) {
            alert('This is going to be a boring draft. Try adding some players!')
            return e.preventDefault();
        }
        var players=[];
        $.each($('.name'), function() {
            if($.trim($(this).val()) != '') {
                players.push($(this).val());
            }
        })
        $('#field_players').val(JSON.stringify(players));
    })
    $('#closeModal').live('click', function(){
        $('#oldDraft').fadeOut('fast'); 
    });
    $('.helpButtonContainer').click(function(){
        $('#help').fadeIn('fast');
    })
    $('#help').click(function() {
        $(this).fadeOut('fast'); 
    });
    /*
     * Functionality
     */
    function addLi(input){
        var li = input.closest('li');
        $(input).removeClass('last').addClass('name');
        var button = $('<div class="deleteButtonContainer"><div class="deleteButton ui-icon-close ui-icon"></div></div>')
        $(li).append(button);
        var nextLi = li.next('li');
        if(nextLi) {
            nextLi.find('input').addClass('last');
            nextLi.fadeIn('fast');
        }
    }
    function removeLi(li) {
        $(li).animate({
            opacity: 'toggle', 
            height: 'toggle'
        }, 'fast', function(){
            $(li).remove();
        });
        var newLi = $('<li class="hidden"><input type="text" class=""></li>');
        if($('.name').length==12) {
            newLi.removeClass('hidden');
            newLi.find('input').addClass('last');
        }
        $(li).closest('ol').append(newLi);
    }
    function validData() {
        if($('.name').length==0 || $.trim($('.name:first').val())=='') {
            return false;
        }
        return true;
    }
})


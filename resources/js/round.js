/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    var data = function(){}
    data.dropped = new Array();
    data.scores = new Array();
    var WINCONDITION = Math.ceil(BESTOF/2);
    
    $('.deleteButton').live('click', function() {
        var index = $('.deleteButton').index($(this));
        var name = PLAYERS[index].name;
        if(confirm('Are you sure you wish to drop player '+name+
            ' from the draft? The player who drops will lose the match. This action cannot be undone.')) {
            dropPlayer($(this), index);
        }
    });
    $('form').submit(function(e){
        if(!dataValid()) {
            e.preventDefault();
            alert('Score totals are not right.')
        }
        else{
            var scores={};
            var rows = $('.dataRow');
            for(var i=0;i<PLAYERS.length; i++) {
                var uid = PLAYERS[i].id;
                var dropped = PLAYERS[i].dropped;
                var fields = rows.eq(Math.floor(i/2)).find('.numberField');
                if(i%2==0) {
                    var wins = getIntFromField(fields.eq(0));
                    var draws = getIntFromField(fields.eq(1));
                    var losses = getIntFromField(fields.eq(2));
                }
                else {
                    var wins = getIntFromField(fields.eq(2));
                    var draws = getIntFromField(fields.eq(1));
                    var losses = getIntFromField(fields.eq(0));   
                }
                scores[uid]=[wins, draws, losses, dropped];
            }
            $('[name="scores"]').val(JSON.stringify(scores));
        }
    })
    $('.helpButton').click(function(){
        $('#help').fadeIn('fast');
    })
    $('#help').click(function() {
       $(this).fadeOut('fast'); 
    });
    
    function dataValid() {
        var validData = true;
        //Iterate over rows
        $.each($('.dataRow'), function() {
            var validRow=true;
            $(this).removeClass('invalidData');

            /*
             * Data validation rules:
             * Total number of games cannot be less than ceil(BESTOF / 2)
             *  UNLESS there is a draw
             * Total number of games cannot be greater than BESTOF
             * Neither win column may have more than ceil(BESTOF / 2)
             * Draw column cannot be greater than 1
             */
            var fields = $(this).find('.numberField');
            var wins1=getIntFromField(fields.eq(0));
            var draws=getIntFromField(fields.eq(1));
            var wins2=getIntFromField(fields.eq(2));
            
            if(draws>1){
                validRow=false;
            }
            if(wins1>WINCONDITION || wins2>WINCONDITION) {
                validRow=false;
            }
            if(wins1<WINCONDITION && wins2<WINCONDITION && draws==0) {
                validRow=false;
            }
            if(wins1+wins2+draws>BESTOF) {
                validRow=false;
            }
            
            if(!validRow) {
                validData=false;
                $(this).addClass('invalidData');
            }
        });
        return validData;
    }
    function dropPlayer(button, index){
        PLAYERS[index].dropped = true;

        button.parent().hide();
        var row = button.closest('tr');
        row.addClass('dropped');
        var fields = row.find('.numberField');
        fields.attr('disabled', 'disabled');

        if(index%2==0) {
            fields.eq(0).val(0);
            fields.eq(1).val(0);
            fields.eq(2).val(WINCONDITION);
        }
        else {
            fields.eq(2).val(0);
            fields.eq(1).val(0);
            fields.eq(0).val(WINCONDITION);
        }
    }
    function getIntFromField(field) {
        var val = parseInt(field.val());
        return isNaN(val)?0:val;
    }
})




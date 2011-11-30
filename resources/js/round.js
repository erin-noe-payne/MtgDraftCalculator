/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    var WINCONDITION = Math.ceil(BESTOF/2);
    
    $('form:not(.backButtonForm)').submit(function(e){
        if(!dataValid()) {
            e.preventDefault();
            alert('Please check the highlighted rows and correct the scores before continuing.')
        }
        else{
            var scores={};
            var rows = $('.dataRow');
            for(var i=0;i<PLAYERS.length; i++) {
                var uid = PLAYERS[i].id;
                var row = rows.eq(Math.floor(i/2))
                var fields = row.find('.numberField');
                var droppedBoxes = row.find('input:checkbox');
                var wins, draws, losses, dropped;
                if(i%2==0) {
                    wins = getIntFromField(fields.eq(0));
                    draws = getIntFromField(fields.eq(1));
                    losses = getIntFromField(fields.eq(2));
                    dropped = droppedBoxes.eq(0).is(':checked');
                }
                else {
                    wins = getIntFromField(fields.eq(2));
                    draws = getIntFromField(fields.eq(1));
                    losses = getIntFromField(fields.eq(0));
                    dropped = droppedBoxes.eq(1).is(':checked');
                }
                scores[uid]=[wins, draws, losses, dropped];
            }
            $('[name="scores"]').val(JSON.stringify(scores));
        }
    })
    $('.helpButtonContainer').click(function(){
        $('#help').fadeIn('fast');
    })
    $('.#help').click(function() {
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
    function getIntFromField(field) {
        var val = parseInt(field.val());
        return isNaN(val)?0:val;
    }
});

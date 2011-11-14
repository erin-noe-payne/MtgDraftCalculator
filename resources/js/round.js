/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    var data = function(){}
    data.dropped = new Array();
    data.scores = new Array();
    var bestOf=3;
    
    $('.deleteButton').live('click', function() {
        if(confirm('Are you sure you wish to drop this player from the draft?')) {
            dropPlayer();
        }
    });
    $('form').submit(function(e){
        if(!dataValid()) {
            e.preventDefault();
            alert('Score totals are not right.')
        }
        else{
            $.each($('.numberField'), function(){
            
                });
            
            $('[name="scores"]').val(JSON.stringify(data));
        }
    })
    
    function dataValid() {
        var validData = true;
        //Iterate over rows
        $.each($('.dataRow'), function() {
            var validRow=true;
            $(this).removeClass('invalidData');

            /*
             * Data validation rules:
             * Total number of games cannot be less than ceil(bestOf / 2)
             *  UNLESS there is a draw
             * Total number of games cannot be greater than bestOf
             * Neither win column may have more than ceil(bestOf / 2)
             * Draw column cannot be greater than 1
             */
            var fields = $(this).find('.numberField');
            var wins1=getInt(fields.eq(0));
            var draws=getInt(fields.eq(1));
            var wins2=getInt(fields.eq(2));
            
            if(draws>1){
                validRow=false;
            }
            if(wins1>Math.ceil(bestOf/2) || wins2>Math.ceil(bestOf/2)) {
                validRow=false;
            }
            if(wins1<Math.ceil(bestOf/2) && wins2<Math.ceil(bestOf/2) && draws==0) {
                validRow=false;
            }
            if(wins1+wins2+draws>bestOf) {
                validRow=false;
            }
            
            if(!validRow) {
                validData=false;
                $(this).addClass('invalidData');
            }
        });
        return validData;
    }
    function dropPlayer(){
        data.dropped.push('a');
        alert('dropped');
    }
    function getInt(field) {
        var val = parseInt(field.val());
        return isNaN(val)?0:val;
    }
})


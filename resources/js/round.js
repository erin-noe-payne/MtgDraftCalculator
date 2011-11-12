/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    var data = function() {
        data.dropped = new Array();
        data.scores = new Array();
    }
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
            var players=[];
            $.each($('.name'), function() {
                data.scores.push($(this).val())
            })
        
            $('[name="scores"]').val(JSON.stringify(data));
        }
    })
    
    function dataValid() {
        var validData = true;
        //Iterate over rows
        $.each($('.dataRow'), function() {
            var sum=0;
            //iterate over fields and sum. The sum should be >= ciel(bestOf / 2)
            $.each($(this).find('.numberField'), function(){
                var val = parseInt($(this).val());
                sum+=(isNaN(val)?0:val);
            });
            if(sum<Math.ceil(bestOf/2)) {
                //TODO: Need to add a drop check, otherwise drops may force validation to fail.
                validData=false;
            }
        });
        return validData;
    }
    function dropPlayer(){
        data.dropped.push();
        alert('dropped');
    }
})


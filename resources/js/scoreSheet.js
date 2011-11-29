/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    
    $('.helpButtonContainer').click(function(){
        //$('#help').fadeIn('fast');
        $('.tbInfo').fadeIn('fast');
    })
    $('.#help').click(function() {
        $(this).fadeOut('fast'); 
    });
    $('#showTiebreakers').click(function(){
        $('.tbInfo').toggle();
    });
    
    
});

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    //Prevents numberFields from taking non-int values
    $('.numberField').live('keypress', function(e){
        var character = String.fromCharCode(e.which);
        if(('0123456789').indexOf(character)==-1){
            e.preventDefault();
        }
    })
    
})

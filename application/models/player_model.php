<?php

class Player_model extends CI_Model 
{
    var $id;
    var $name; //name of player
    
    var $matchPoints; //3 for a win, 1 for a draw, 0 for a loss
    var $matchCount; //the  number of matches a player has played in
    var $gamePoints; //
    var $gameCount; //the number of games a player has played in
    var $byeCount; //the number of byes a player has had (shouldn't really ever be more than 1)
    
    var $dropped; //bool value indicating whether a player has dropped out
    
    var $oponents; //array of players that this player has played against
    
    function __construct($id, $name)
    {
        parent::__construct();
        
        $this->id = $id;
        $this->name = $name;
        
        $this->matchPoints = 0;
        $this->matchCount = 0;
        $this->gamePoints = 0;
        $this->gameCount = 0;
        $this->byeCount = 0;
        
        $this->dropped = false;
       
        $this->oponents = array();
    }
}
?>

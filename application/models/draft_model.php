<?php
include 'player_model.php';
class Player_model extends CI_Model 
{
    var $nextPlayerID;
    
    var $bestOfGames;
    var $players;
    
    function __construct($bestOfGames)
    {
        parent::__construct();
        
        $this->bestOfGames = $bestOfGames;
        
        $this->nextPlayerID = 1;
        
        $this->players = array();
    }
    
    function addPlayer($name)
    {
        array_push($this->players, new Player_model($nextPlayerID, $name));
        $this->nextPlayerID++;
    }
}
?>
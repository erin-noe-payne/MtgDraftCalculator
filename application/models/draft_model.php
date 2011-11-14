<?php
include 'player_model.php';
class Draft_model extends CI_Model 
{
    private $nextPlayerID;
    
    var $bestOfGames;
    var $players;
    var $roundNumber;
    
    function __construct()
    {
        parent::__construct();
        
        $this->bestOfGames = 3;
        
        $this->nextPlayerID = 1;
        
        $this->players = array();
    }
    
    function addPlayer($name)
    {
        array_push($this->players, new Player_model($this->nextPlayerID, $name));
        $this->nextPlayerID++;
    }
}
?>
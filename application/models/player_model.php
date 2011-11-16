<?php

class Player_model extends CI_Model
{

    var $id;
    var $name; //name of player
    var $wins;
    var $draws;
    var $losses;
    var $matchPoints; //3 for a win, 1 for a draw, 0 for a loss
    var $matchCount; //the  number of matches a player has played in
    var $gamePoints; //
    var $gameCount; //the number of games a player has played in
    var $byeCount; //the number of byes a player has had (shouldn't really ever be more than 1)
    var $dropped; //bool value indicating whether a player has dropped out
    var $opponents; //array of players that this player has played against
    


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

        $this->opponents = array();
    }
    
    function updateScore($score)
    {
        $wins = $score[0];
        $draws = $score[1];
        $losses = $score[2];
        $dropping = $score[3];
        
        $this->wins += $wins;
        $this->draws += $draws;
        $this->losses += $losses;
        
        
        if($wins == 2)
        {
            $this->matchPoints += 3;
        }
        else if(($wins == 1 && $losses == 1) || ($wins == 0 && $losses == 0 && $draws == 1))
        {
            $this->matchPoints += 1;
        }
        $this->matchCount++;
        $this->gamePoints += ($wins*3)+($draws*1);
        $this->gameCount += $wins+$losses+$draws;
        
        $this->dropped = $dropping;
        
    }
    
    //returns true if this player is ranked higher than $otherPlayer
    function isHigherThan($otherPlayer)
    {
        if($this->matchPoints > $otherPlayer->matchPoints)
        {
            return true;
        }
        
    }
    
    //returns true if this player has played $otherPlayer
    function hasPlayed($otherPlayer)
    {
        foreach($this->opponents as $opponentID)
        {
            if($otherPlayer->id == $opponentID)
            {
                return true;
            }
        }
        
        return false;
    }

}

?>

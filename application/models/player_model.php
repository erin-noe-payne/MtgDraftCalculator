<?php

class Player_model extends CI_Model
{

    var $id;
    var $name; //name of player
    var $wins;
    var $draws;
    var $losses;
    var $mWins;
    var $mDraws;
    var $mLosses;
    var $opponentMatchWinPerc;
    var $gameWinPerc;
    var $opponentGameWinPerc;
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
        
        /*
         * Data for display at ranking screen
         */
        $this->wins=0;
        $this->draws=0;
        $this->losses=0;
        $this->mWins=0;
        $this->mDraws=0;
        $this->mLosses=0;
        
        /*
         * Tiebreaker data
         */
        $this->matchPoints = 0;
        $this->matchCount = 0;
        $this->gamePoints = 0;
        $this->gameCount = 0;
        $this->byeCount = 0;

        $this->dropped = false;

        $this->opponents = array();
    }
    
    static function updateScore($score, &$player)
    {   
        //TODO: bestOf values are hard coded, need to add reference for bestOf
        $wins = $score[0];
        $draws = $score[1];
        $losses = $score[2];
        $dropping = $score[3];
        
        $player->wins += $wins;
        $player->draws += $draws;
        $player->losses += $losses;
        
        
        if($wins == 2)
        {
            $player->matchPoints += 3;
            $player->mWins++;
        }
        else if($wins == 1 && $draws == 1 && $losses == 0)
        {
            $player->matchPoints += 3;
            $player->mWins++;
        }
        else if(($wins == 1 && $losses == 1) || ($wins == 0 && $losses == 0 && $draws == 1))
        {
            $player->matchPoints += 1;
            $player->mDraws++;
        }
        else 
        {
            $player->mLosses++;
        }
        $player->matchCount++;
        $player->gamePoints += ($wins*3)+($draws*1);
        $player->gameCount += $wins+$losses+$draws;
        
        $player->dropped = $dropping;
        
    }
    
    //returns true if this player is ranked higher than $otherPlayer
    static function isHigherThan($player, $otherPlayer)
    {
        //First measure, match points
        if($player->matchPoints == $otherPlayer->matchPoints)
        {
            //First tiebreaker: opponent win %
            $thisWinPerc = max($player->matchPoints/($player->matchCount*3),0.33);
            $otherWinPerc = max($otherPlayer->matchPoints/($otherPlayer->matchCount*3),0.33);
            if($thisWinPerc == $otherWinPerc) {
                
            }
        }
        else {
            return ($player->matchPoints > $otherPlayer->matchPoints);
        }
        
    }
    
    //returns true if this player has played $otherPlayer
    static function hasPlayed($player, $otherPlayer)
    {
        foreach($player->opponents as $opponentID)
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

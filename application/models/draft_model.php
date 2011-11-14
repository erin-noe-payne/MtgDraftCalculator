<?php

include 'player_model.php';

class Draft_model extends CI_Model
{

    private $nextPlayerID;
    var $bestOfGames;
    var $players;
    var $droppedPlayers;
    var $roundNumber;

    function __construct()
    {
        parent::__construct();

        $this->bestOfGames = 3;

        $this->nextPlayerID = 1;

        $this->players = array();
        $this->droppedPlayers = array();
    }

    function addPlayer($name)
    {
        array_push($this->players, new Player_model($this->nextPlayerID, $name));
        $this->nextPlayerID++;
    }

    function dropPlayer($id)
    {
        foreach($this->players as $index => $player)
        {
            if($player->id == $id)
            {
                //add the player who is being dropped to the dropped players list
                array_push($this->droppedPlayers, $player);
                //remove them from the active players list
                unset($this->players[$index]);
                //reindex the active players list
                $this->players = array_values($this->players);
                break;
            }
        }
    }

    function sortForMatchMaking()
    {
        //is this the first round?
        if($this->roundNumber == 0)
        {
            $this->players = $this->sortForFirstRound($this->players);
        }
        else
        {
            $this->players = $this->sortByRanking($this->players);
        }
    }
    
    function sortForFirstRound($players)
    {
        $toBeChecked = $players;
        $ret = array();
        
        //checking to see if there's an odd number of people
        if(count($toBeChecked)%2==1)
        {
            //pick a number between 0 and one less than the total number of people
            //this numbe is the index of the person who gets the bye
            $rand = rand(0, count($toBeChecked)-1);
            $mrBye = $toBeChecked[$rand];
            unset($toBeChecked[$rand]);
            $toBeChecked = array_values($toBeChecked); //be sure to reindex!
        }
        
        while(count($toBeChecked) > 0)
        {
            //calculate the distatnce to the opponent
            $halfOfArray = count($toBeChecked)/2;
            
            //push the two people on to the return list.
            //By being next to each other that means they are playing
            array_push($ret, $toBeChecked[0]);
            array_push($ret, $toBeChecked[$halfOfArray]);
            
            //remove both of those pople from the first list
            unset($toBeChecked[0]);
            unset($toBeChecked[$halfOfArray]);
            
            //reindex the array
            $toBeChecked = array_values($toBeChecked);
        }
        
        //last but not least, add the guy who got the bye (if there was one)
        if(isset($mrBye))
        {
            array_push($ret, $mrBye);
        }
        
        return $ret;
    }

    function sortByRanking($players)
    {
        $toBeChecked = $players;
        $ret = array();

       
        while(count($toBeChecked) > 0)
        {
            $highestPlayer = $toBeChecked[0];
            $highestIndex = 0;
            $isFirst = true;
            foreach($toBeChecked as $index => $player)
            {
                if($isFirst)
                {
                    $isFirst = false;
                    continue;
                }
                
                if($player->isHigherThan($highestPlayer))
                {
                    $highestPlayer = $player;
                    $highestIndex = $index;
                }
            }
           
            //add the highest ranked player to the back of the return list
            array_push($ret, $highestPlayer);
            //remove the highest ranked player from the list of things that still need to be checked
            unset($toBeChecked[$highestIndex]);
            //reindex the array
            $toBeChecked = array_values($toBeChecked);
        }
        return $ret;
    }

}

?>
<?php

include 'player_model.php';

class Draft_model extends CI_Model
{

    private $nextPlayerID;
    var $bestOfGames;
    var $roundNumber;
    var $players;
    var $droppedPlayers;
    var $maxNumberOfRounds;

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

    function updateScores($score)
    {

        foreach($this->players as $index => $player)
        {
            $player->updateScore($score[$player->id]);
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
            $players = $this->players;
            //order the players by their current ranking in draft
            $players = $this->sortByRanking($players);
            
            //if there's an odd number of people, find out who needs the bye
            if(count($players) % 2 == 1)
            {
                for($i = count($players) - 1; $i >= 0; $i--)
                {
                    if($players[$i]->byeCount == 0)
                    {
                        $mrBye = $players[$i];
                        $mrBye->byeCount++;
                        unset($players[$i]);
                        $players = array_values($players); //be sure to reindex!
                        break;
                    }
                }
            }
            
            //now resort them taking oponents played into consideration
            $pairingOptions = array();
            $this->findPairingOptions($players, array(), $pairingOptions);

            $shortestDistancePairings = $this->findShortest($pairingOptions);
            
            $matchmakingList = array();
            foreach($shortestDistancePairings as $pair)
            {
                array_push($pair->player1->opponents, $pair->player2->id);
                array_push($pair->player2->opponents, $pair->player1->id);
                
                array_push($matchmakingList, $pair->player1);
                array_push($matchmakingList, $pair->player2);
                
            }
            if(isset($mrBye))
            {
                array_push($matchmakingList, $mrBye);
            }
            
            $this->players = $matchmakingList;    
        }
        $this->roundNumber++;
    }
    
    function calculateDistance($pairs)
    {
        
        $sum = 0;
        foreach($pairs as $pair)
        {
            $sum += $pair->distance;
        }
        
        return $sum;
    }

    function findShortest($pairingSets)
    {
        $shortest = $pairingSets[0];
        $shortestDistance = $this->calculateDistance($shortest);
        $isFirst = true;
        foreach($pairingSets as $index => $pairings)
        {
            if($isFirst)
            {
                $isFirst = false;
                continue;
            }
            
            $tempShortest = $this->calculateDistance($pairings);
            if($tempShortest < $shortestDistance)
            {
                $shortestDistance = $tempShortest;
                $shortest = $pairings;
            }
        }
        
        return $shortest;
    }

        function findPairingOptions($toBeChecked, $pairings, &$pairingOptions)
        {
            //check to see if who just got paired together is invalid
            //only do this if there are actually pairings
            if(count($pairings) != 0)
            {
                if(!$pairings[count($pairings) - 1]->isValid())
                {
                    return;
                }
            }

            //Yay! we found a valid combination of pairings
            if(count($toBeChecked) == 0)
            {
                array_push($pairingOptions, $pairings);
            }

            $distance = 1; //the index of the person to try and match up
            while($distance < count($toBeChecked))
            {
                //the pairing to try
                $tempPair = new Pair($toBeChecked[0], $toBeChecked[$distance]);
                $nextToBePairted = $pairings;
                array_push($nextToBePairted, $tempPair);

                //set up the array minus the two we just paired up
                $nextToBeChecked = $toBeChecked;
                unset($nextToBeChecked[0]);
                unset($nextToBeChecked[$distance]);

                //down the rabbit hole we go
                $this->findPairingOptions(array_values($nextToBeChecked), $nextToBePairted, $pairingOptions);

                //keep trying more combinations
                $distance++;
            }
        }

        function sortForRound($players)
        {
            $toBeChecked = $players;
            $ret = array();

            //if there's an odd number, find the lowest ranked person 
            //that has not had a bye and set them as the one to get it
            if(count($toBeChecked) % 2 == 1)
            {
                for($i = count($toBeChecked) - 1; $i >= 0; $i--)
                {
                    if($toBeChecked[$i]->byeCount == 0)
                    {
                        $mrBye = $toBeChecked[$i];
                        unset($toBeChecked[$i]);
                        $toBeChecked = array_values($toBeChecked); //be sure to reindex!
                        break;
                    }
                }
            }

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

                    if(!$highestPlayer->hasPlayed($player))
                    {
                        //update oponents list of the two paired players
                        array_push($highestPlayer->opponents, $player->id);
                        array_push($player->opponents, $highestPlayer->id);

                        array_push($ret, $highestPlayer);
                        array_push($ret, $player);

                        unset($toBeChecked[0]);
                        unset($toBeChecked[$index]);

                        $toBeChecked = array_values($toBeChecked);
                        break;
                    }
                }
            }

            if(isset($mrBye))
            {
                array_push($ret, $mrBye);
            }

            return $ret;
        }

        function sortForFirstRound($players)
        {
            $toBeChecked = $players;
            $ret = array();

            //checking to see if there's an odd number of people
            if(count($toBeChecked) % 2 == 1)
            {
                //pick a number between 0 and one less than the total number of people
                //this numbe is the index of the person who gets the bye
                $rand = rand(0, count($toBeChecked) - 1);
                $mrBye = $toBeChecked[$rand];
                $mrBye->byeCount++;
                unset($toBeChecked[$rand]);
                $toBeChecked = array_values($toBeChecked); //be sure to reindex!
            }

            while(count($toBeChecked) > 0)
            {
                //calculate the distatnce to the opponent
                $halfOfArray = count($toBeChecked) / 2;

                //update opponents list of the two players that are getting paired
                array_push($toBeChecked[0]->opponents, $toBeChecked[$halfOfArray]->id);
                array_push($toBeChecked[$halfOfArray]->opponents, $toBeChecked[0]->id);

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

        //deletes the current draft players and throws these in.
        //the state is the start of round 2
        function generateTestPlayers()
        {
            $players = array();

            $this->addPlayer("Ted");
            $this->addPlayer("Frank");
            $this->addPlayer("Bill");
            $this->addPlayer("Charlie");
            $this->addPlayer("Wilson");

            $this->players[0]->matchPoints = 3;
            $this->players[1]->matchPoints = 0;
            $this->players[2]->matchPoints = 3;
            $this->players[3]->matchPoints = 0;
            $this->players[4]->matchPoints = 3;

            array_push($this->players[0]->opponents, $this->players[1]->id);
            array_push($this->players[1]->opponents, $this->players[0]->id);

            array_push($this->players[2]->opponents, $this->players[3]->id);
            array_push($this->players[3]->opponents, $this->players[2]->id);

            $this->players[4]->byeCount = 1;
        }

    }

    class Pair
    {

        var $player1;
        var $player2;
        var $distance;

        function __construct($player1, $player2)
        {
            $this->player1 = $player1;
            $this->player2 = $player2;
            $this->distance = abs($player1->matchPoints - $player2->matchPoints);
        }

        function isValid()
        {
            return!$this->player1->hasPlayed($this->player2);
        }

    }

?>
<?php

include 'player_model.php';

class Draft_model extends CI_Model {

    private $nextPlayerID;
    var $bestOfGames;
    var $roundNumber;
    var $players;
    var $droppedPlayers;

    function __construct() {
        parent::__construct();

        $this->bestOfGames = 3;
        $this->roundNumber=1;
        $this->nextPlayerID = 1;

        $this->players = array();
        $this->droppedPlayers = array();
    }

    function addPlayer($name) {
        array_push($this->players, new Player_model($this->nextPlayerID, $name));
        $this->nextPlayerID++;
    }

    function dropPlayer($id) {
        foreach ($this->players as $index => $player) {
            if ($player->id == $id) {
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

    function updateScores($score) {

        foreach ($this->players as $index => $player) {
            $player->updateScore($score[$player->id]);
        }
    }

    function sortForMatchMaking() {
        //is this the first round?
        if ($this->roundNumber == 1) {
            $this->players = $this->sortForFirstRound($this->players);
        } else {
            if(count($this->players)%2==1) {
                
            }
        }
        $this->roundNumber++;
    }

    function sortForRound($players) {
        $toBeChecked = $players;
        $ret = array();

        //if there's an odd number, find the lowest ranked person 
        //that has not had a bye and set them as the one to get it
        if (count($toBeChecked) % 2 == 1) {
            for ($i = count($toBeChecked) - 1; $i >= 0; $i--) {
                if ($toBeChecked[$i]->byeCount == 0) {
                    $mrBye = $toBeChecked[$i];
                    unset($toBeChecked[$i]);
                    $toBeChecked = array_values($toBeChecked); //be sure to reindex!
                    break;
                }
            }
        }

        while (count($toBeChecked) > 0) {
            $highestPlayer = $toBeChecked[0];
            $highestIndex = 0;
            $isFirst = true;
            foreach ($toBeChecked as $index => $player) {
                if ($isFirst) {
                    $isFirst = false;
                    continue;
                }

                if (!$highestPlayer->hasPlayed($player)) {
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

        if (isset($mrBye)) {
            array_push($ret, $mrBye);
        }

        return $ret;
    }

    function sortForFirstRound($players) {
        $toBeChecked = $players;
        $ret = array();

        //checking to see if there's an odd number of people
        if (count($toBeChecked) % 2 == 1) {
            //pick a number between 0 and one less than the total number of people
            //this numbe is the index of the person who gets the bye
            $rand = rand(0, count($toBeChecked) - 1);
            $mrBye = $toBeChecked[$rand];
            unset($toBeChecked[$rand]);
            $toBeChecked = array_values($toBeChecked); //be sure to reindex!
        }

        while (count($toBeChecked) > 0) {
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
        if (isset($mrBye)) {
            array_push($ret, $mrBye);
        }

        return $ret;
    }

    function sortByRanking($players) {
        $toBeChecked = $players;
        $ret = array();


        while (count($toBeChecked) > 0) {
            $highestPlayer = $toBeChecked[0];
            $highestIndex = 0;
            $isFirst = true;
            foreach ($toBeChecked as $index => $player) {
                if ($isFirst) {
                    $isFirst = false;
                    continue;
                }

                if ($player->isHigherThan($highestPlayer)) {
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
    function generateTestPlayers() {
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

    function createMatches($unmatchedPlayers, $pairings, &$sets) {
        //complete legal pairings set.
        if (count($unmatchedPlayers) == 0) {
            array_push($sets, $pairings);
            return;
        }
        
        //select first player
        $player = reset($unmatchedPlayers);
        //litst the ID's of illegal opponents, including self
        $illegalOpponents = array_merge($player->opponents, array($player->id));
        
        //array subtraction of unmatched opponents - legal opponents
        $legalOpponets = $unmatchedPlayers;
        foreach ($legalOpponets as $key => $opponent) {
            if (in_array($opponent->id, $illegalOpponents)) {
                unset($legalOpponets[$key]);
            }
        }
        //there are unmatched opponents but no legal pairings remaining; break
        if (count($legalOpponets) == 0) {
            return;
        }
        
        //for each legal opponent, 
        foreach ($legalOpponets as $j => $opponent) {
            $pairing = array(0 => $player->id, 1 => $opponent->id, 'distance' => abs($player->matchPoints - $opponent->matchPoints));
            $nextPairings = $pairings;
            array_push($nextPairings, $pairing);
            $remainingUnmatchedPlayers = $unmatchedPlayers;
            $i1 = array_search($player, $remainingUnmatchedPlayers);
            $i2 = array_search($opponent, $remainingUnmatchedPlayers);
            unset($remainingUnmatchedPlayers[$i1]);
            unset($remainingUnmatchedPlayers[$i2]);
            $this->createMatches($remainingUnmatchedPlayers, $nextPairings, $sets);
        }
    }

}

?>
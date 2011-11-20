<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mtgdc extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function test() {
        session_start();
        $draft = $_SESSION['draft'];

        $draft->test();
    }

    public function index() {
        session_start();

        $previousSession = false;
        if (isset($_SESSION['draft'])) {
            $previousSession = true;
        }
        $data['previousSession'] = $previousSession;

        $this->load->view('header');
        $this->load->view('index', $data);
        $this->load->view('footer');
    }

    public function newDraft() {
        session_start();
        /*
         * POST Data: 
         * bestOf - int data for # of games per match
         * players - stringified json array of player names, i.e. ["Erin", "Chris", "Sean"]
         */

        //check to see if the best of was sent
        if (isset($_POST['bestOf'])) {//it was! 
            $bestOf = json_decode($_POST['bestOf']);
        } else {//it wasn't! Set it to the default of 3.
            $bestOf = 3;
        }

        //check to see if the list of players was sent
        if (isset($_POST['players'])) {//it was! let's add these players to the draft
            $playerNames = json_decode($_POST['players'], true);
        } else {//it wasn't! For now let's just return some test data.  in the future, there should be some kind of error handling
            $playerNames = array('Ted', 'John', 'Steve', 'Bob');
        }

        //create the draft obejct
        $draft = new Draft_model();

        //set the max number of games people will play each match
        $draft->bestOfGames = $bestOf;

        //Go through the list of players and add them to the draft
        foreach ($playerNames as $playerName) {
            $draft->addPlayer($playerName);
        }

        //randomize the order of the players in the draft
        shuffle($draft->players);
        //add the draft object to the session data

        /*
         * This draft object will be created, attached to users' session, and passed to the newDraft view and each round view.
         * You do not need to deal with json or strings at all, the view will deal with the php object.
         */

        //This is how to pass the draft object to the view
        $data['draft'] = $draft;
        //save the draft in the session
        $_SESSION['draft'] = $draft;

        $this->load->view('header');
        $this->load->view('newDraft', $data);
        $this->load->view('footer');
    }

    public function round() {
        //check if GET -- if it is, start round 1 or recover 
        //if draft object in session is higher than round 1
        //check if POST -- if it is, then incremement round 
        //and do matchmaking

        session_start();
        //TODO - check for valid session / data, handle appropriately.
        $draft = $_SESSION['draft'];

        //if rounds was acessed via post.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $roundNumber = $_POST['round'];

            //In the case of a page reload (and form resubmit) nothing will happen
            if ($roundNumber > $draft->roundNumber) {
                $scores = json_decode($_POST['scores'], true);
                $draft->updateScores($scores);
                $draft->sortForMatchmaking();
            }
        } 
        //if it was accessed by get and round number is 1
        else if ($draft->roundNumber == 0) {
            $draft->sortForMatchMaking();
        }

        $data['draft'] = $draft;
        //save the draft in the session
        $_SESSION['draft'] = $draft;

        $this->load->view('header');
        $this->load->view('round', $data);
        $this->load->view('footer');
    }

    public function scoreSheet() {
        session_start();
        $draft = $_SESSION['draft'];
        $scores = json_decode($_POST['scores'], true);
        $draft->updateScores($scores);
        $draft->getRankings();
        $data['draft'] = $draft;

        //unset($_SESSION['draft']);

        $this->load->view('header');
        $this->load->view('scoreSheet', $data);
        $this->load->view('footer');
    }

}
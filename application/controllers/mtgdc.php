<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mtgdc extends CI_Controller
{

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
    public function index()
    {
        $this->load->view('header');
        $this->load->view('index');
        $this->load->view('footer');
    }

    public function newDraft()
    {
        /*
         * POST Data: 
         * bestOf - int data for # of games per match
         * players - stringified json array of player names, i.e. ["Erin", "Chris", "Sean"]
         */
        //load the draft model and create the draft object we'll be passing around
        $this->load->model('Draft_model');

        //check to see if the best of was sent
        if(isset($_POST['bestOf']))
        {//it was! 
            $bestOf = json_decode($_POST['bestOf']);
        } else
        {//it wasn't! Set it to the default of 3.
            $bestOf = 3;
        }

        //check to see if the list of players was sent
        if(isset($_POST['players']))
        {//it was! let's add these players to the draft
            $playerNames = json_decode($_POST['players']);
        } else
        {//it wasn't! For now let's just return some test data.  in the future, there should be some kind of error handling
            $playerNames = array('Ted', 'John', 'Steve', 'Bob');
        }

        //create the draft obejct
        $draft = new Draft_model();

        //set the max number of games people will play each match
        $draft->bestOfGames = $bestOf;

        //Go through the list of players and add them to the draft
        foreach($playerNames as $playerName)
        {
            $draft->addPlayer($playerName);
        }

        //randomize the order of the players in the draft
        shuffle($draft->players);

        /*
         * This draft object will be created, attached to users' session, and passed to the newDraft view and each round view.
         * You do not need to deal with json or strings at all, the view will deal with the php object.
         */

        //This is how to pass the draft object to the view
        $data['draft'] = $draft;

        //Start up the session and save the draft
        //session_start();
        //$_SESSION['draft'] = $draft;
        //load the views and send stuff through the $data variable
        $this->load->view('header');
        $this->load->view('newDraft', $data);
        $this->load->view('footer');
    }

    public function round()
    {
        $this->load->model('Draft_model');

        $data['draft'] = $draft;

        $this->load->view('header');
        $this->load->view('round', $data);
        $this->load->view('footer');
    }

    public function scoreSheet()
    {
        $draft = null;
        $data['draft'] = $draft;
        $this->load->view('scoreSheet', $data);
    }

    private function generateTestDraft()
    {
        $draft = new Draft_model(3);
        $draft->addPlayer('Ted');
        $draft->addPlayer('Bob');
        $draft->addPlayer('Fred');
        $draft->addPlayer('Charlie');
        $draft->addPlayer('Alvin');
        return $draft;
    }

    private function generateTestWins($draft)
    {
        $draft->players[0]->matchPoints = 2;
        $draft->players[1]->matchPoints = 1;
        $draft->players[2]->matchPoints = 4;
        $draft->players[3]->matchPoints = 3;
        $draft->players[4]->matchPoints = 0;
    }

}
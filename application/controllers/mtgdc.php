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
    public function index() {
        $this->load->view('index');
    }

    public function newDraft() {
        /*
         * POST Data: 
         * bestOF - int data for # of games per match
         * players - stringified json array of player names, i.e. ["Erin", "Chris", "Sean"]
         */


        /*
         * This draft object will be created, attached to users' session, and passed to the newDraft view and each round view.
         * You do not need to deal with json or strings at all, the view will deal with the php object.
         */
        $draft = null;

        $this->load->view('newDraft', $draft);
    }

    public function round() {
        $draft = null;

        $this->load->view('round', $draft);
    }

    public function scoreSheet() {
        $draft = null;

        $this->load->view('scoreSheet', $draft);
    }

}
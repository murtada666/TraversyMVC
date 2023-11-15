<?php
// All the controllers are Classes.
  class Pages extends Controller {
    public function __construct(){
    
    }

    public function index(){

      $data = [
        'title' => 'world',
      ];

      $this->view('pages/index', $data);

      // $this->view('pages/index', ['title' => 'world']); (another way to do it)
    }

    public function about(){
      $data = ['title' => 'about us'];
      $this->view('pages/about', $data);
    }
} 
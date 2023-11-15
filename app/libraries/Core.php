<?php

/*
    * App Core Class
    * Creates URL & loads core controllers
    * URL FORMAT - /controller/methods/params
*/

class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        // print_r($this->getUrl());
        // echo '<br>';

        $url = $this->getUrl();
        // print_r($url);

        // Look in controllers for first value (the controller).
        if (!empty($url) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // if exist set as controller 
            $this->currentController = ucwords($url[0]);
            // Unset 0 index
            unset($url[0]);
        }

        // require the controller
        require_once '../app/controllers/' . $this->currentController  . '.php';

        // instantiate controller class
        $this->currentController = new $this->currentController;

        // Check for second part of url
        if (isset($url[1])) {
            // Check to see if method exists in controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // Unset 1 index
                unset($url[1]);
            }
        }

        // Get params (and because we unset the controller and the method thats mean the values remaining in the array are the params only)
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params (notice that this function takes two params and NOT three)
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        
        /* we are basically saying:
      - Here is a class named something 
      - There is a method inside it named something
      - And here is the params of the method
      - Now call it for me. 
      */
    }

    /*
        *rtrim is being used to remove (/) on the right if exist
        *FILTER_SANITIZE_URL: remove all characters except letters
    */
    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }
    }
}

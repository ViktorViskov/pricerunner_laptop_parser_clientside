<?php
// 
// Class for request processing
// 

// Libs
require "./core/mysql.php";
require "./core/render.php";

class Request_Process {
    // variables
    private $url;
    private $db_connection;
    private $nav_links_array = array();
    private $nav_links_dict = array();
    
    // constructor
    function __construct($url) {

        // init variables
        $this->url = $url;
        $this->db_connection = new Db_Connection("10.0.0.2","root","dbnmjr031193");

        // load navigation links
        $this->nav_links_array = $this->db_connection->Request("SELECT * FROM pricerunner.navigation_laptops");

        // from array to dict
        foreach ($this->nav_links_array as $nav_item){
            $this->nav_links_dict[$nav_item['url']] = $nav_item['sql'];
        }

        // process link
        $this->Proccesing();
    }

    // function for request processing
    private function Proccesing() {

        // print page
        if (array_key_exists($this->url, $this->nav_links_dict)){
            new Page_Render($this->db_connection->Request($this->nav_links_dict[$this->url]), $this->nav_links_array);
        }

        // request page not available
        else{
            new Page_Render($this->db_connection->Request($this->nav_links_dict['/']), $this->nav_links_array);
        }
    }
}
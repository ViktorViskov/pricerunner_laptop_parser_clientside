<?php
// 
// Class for create connection with db server
//

class Db_Connection {
    // variables
    private $server_addr;
    private $user_name;
    private $password;
    private $conn;
    
    // constructor
    function __construct($server_addr, $user_name, $password) {

        // properties to connection
        $this->server_addr = $server_addr;
        $this->user_name = $user_name;
        $this->password = $password;

        // init connection
        $this->Init();
    }

    // init connection
    private function Init(){
        $this->conn = new mysqli($this->server_addr, $this->user_name, $this->password);
    }

    // make SQL Request
    public function Request($sql){

        // make request
        $response = $this->conn->query($sql);

        // variable for results
        $result = array();

        // load response
        while ($data = $response->fetch_assoc()){
            // add to result
            array_push($result, $data);
        }

        // return results
        return $result;
    }
}
?>
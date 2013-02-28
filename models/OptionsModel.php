<?php
include "Constants.php";

$tables = array(
    TTIME, 
    TMODIFIER,
    TDAY
);

//Utility function to return rows
function getData($mySqlI, $tableName) {

    $query = "SELECT * FROM ".$tableName." ORDER BY name ASC";
    $result = $mySqlI->query($query);
    //$num = mysqli_num_rows($result);

    while($row = $result->fetch_array(MYSQLI_BOTH)) {
        $rows[] = $row;
    }

    /* free result set */
    $result->free();

    return $rows;

}

class OptionsModel {

    private $mysqli;
    private $timeData;
    private $modifierData;
    private $dataMap;

    public function __construct() {  

        $this->mysqli = new mysqli(CONST_DB_SERVER, CONST_DB_SERVER_USERNAME, CONST_DB_SERVER_PASSWORD, CONST_DB_NAME); 

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        global $tables;

        foreach($tables as $table){
            $this->dataMap[$table] = getData($this->mysqli, $table); 
        }

        //echo 'The class "', __CLASS__, '" was initiated!<br />'; 
    } 

    public function __destruct() { 

        /* close connection */
        $this->mysqli->close();

        //echo 'The class "', __CLASS__, '" was destroyed.<br />';  
    }  

    public function __toString() {  
        echo "Using the toString method: ";  
        return __CLASS__;  
    }  

    public function getResults($tableName) {

        $res = $this->dataMap[$tableName];

        return $res;
    }

}

?>

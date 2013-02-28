<?php
include "../models/OptionsModel.php";
class CompController {

    private $data = array();

    public function __construct() {  

        $optionsModel = new OptionsModel;
        $modelDays = $optionsModel->getResults(TDAY);
        $modelTimes = $optionsModel->getResults(TTIME);
        $modelMods = $optionsModel->getResults(TMODIFIER);
        //$break = "<br />";

        //Loop over the return params from the form post
        foreach ($_POST as $key => $value) {
            //echo $key." = ".$value.$break;

            $tunein = "tunein_";
            $tuneinLen = strlen($tunein);
            $tuneinPos = strpos($key, $tunein);

            if ($key == "templateName") {

                $this->data['templateName'] = $value;

            } else if ($key == "dupeName") {

                $this->data['dupeName'] = $value;

            //if this is a field from a table
            } else if ($tuneinPos >= 0 && $tuneinPos !== false) {

                //remove "tunein_" from field name
                $field = substr($key, $tuneinLen);

                //echo $tuneinPos." --- ".$field.$break;

                //test for the day
                $day = "day";
                $dayPos = strpos($field, $day);

                if ($dayPos >= 0 && $dayPos !== false) {

                    //test if this is the day checkbox or the yes/no for the show time for that day
                    $radio = "Radio";
                    $radioPos = strpos($field, $radio);

                    if (!$radioPos) {
                        //iterate over the rows of the table and match on the value of the fieldname of the checkbox
                        foreach ($modelDays as $modelDay) {
                            if ($field == "day".$modelDay['key']) {
                                //echo "day === ".$field.$break;
                                //echo $modelDay[1].$break; 
                                $map = array(
                                    "day" => $modelDay,
                                    "time" => "no"
                                );
                                $this->data['days'][$modelDay['key']] = $map;
                            }
                        }
                    } else {
                        //iterate over the rows of the table and match on the value of the fieldname of the radio button
                        foreach ($modelDays as $modelDay) {
                            if ($field == "day".$modelDay['key']."Radio") {
                                //echo "dayRadio === ".$field.$break;
                                $this->data['days'][$modelDay['key']]['time'] = $value;
                            }
                        }
                    }

                }
                
                //test for the time
                $time = "time";
                $timePos = strpos($field, $time);

                if ($timePos >= 0 && $timePos !== false) {
                    //echo "time === ".$field.$break;

                    //iterate overf the rows of the table and match on the fieldname of the checkbox
                    foreach ($modelTimes as $modelTime) {
                        if ($field == "time".$modelTime['key']) {
                            $this->data['times'][$modelTime['key']] = $modelTime;
                        }
                    }

                }

                //test for modifier
                $mod = "modifier";
                $modPos = strpos($field, $mod);

                if ($modPos >= 0 && $modPos !== false) {
                    //echo "mod === ".$field." - ".$value.$break;
                    //iterate over the rows of the table and match on the value of the radio button
                    foreach ($modelMods as $modelMod) {
                        if ($field == "modifier".$modelMod['key']) {
                            $this->data['mods'][$modelMod['key']] = $modelMod;
                        }
                    }
                }
            } else if ($key == "channelNumber") {

                //echo "channelNumber === ".$value.$break;

                $this->data['channelNumbers']['no'] = 0;

            } else if ($key == "channelNumbers") {

                $channels = explode(",", $value);

                $this->data['channelNumbers']['yes'] = $channels;
            }
        }
    }
    public function __toString() {
        echo "Using the toString method: ";  
        return __CLASS__;  
    }
    public function __destruct() { 

        $data = $this->data;

        session_start();

        if ($data['templateName'] == '') {
            $_SESSION['message'] = "Template name is required";
            header("Location:../?view=formError");
            exit;
        } else if ($data['dupeName'] == '') {
            $_SESSION['message'] = "Duplicate name is required";
            header("Location:../?view=formError");
            exit;
        } else {
            include __DIR__."/../views/generateXml.php";
        }
    }

    //returns $templateName;
    public function getTemplateName() {
        return $this->data['templateName'];
    }
    //returns $dupeName;
    public function getDupeName() {
        return $this->data['dupeName'];
    }
    //returns $days = array();
    public function getDays() {
        return $this->data['days'];
    }
    //returns $times = array();
    public function getTimes() {
        return $this->data['times'];
    }
    //returns $mods = array();
    public function getMods() {
        return $this->data['mods'];
    }
    //returns $channelNumbers = array();
    public function getChannelNumbers() {
        return $this->data['channelNumbers'];
    }
}

$cont = new CompController;
?>

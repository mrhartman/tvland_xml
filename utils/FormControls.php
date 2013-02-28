<?php
include "models/OptionsModel.php";

class FormControls {

    private $model;

    public function __construct() {  
        $this->model = new OptionsModel;
    }

    public function __toString()  
    {  
        echo "Using the toString method: ";  
        return __CLASS__;  
    }  

    public function createCheckboxes($type, $alt) {

        $rows = $this->model->getResults($type);
        $num = count($rows);

        if ($num > 0) {  
            $i = 0;
            foreach ($rows as $row) {

                $checked = "";
                $disabled = " disabled";
                
                if ($i == 0) {
                    $checked = " checked";
                    $disabled ="";
                }

                $tp .= '<div><label for="'.$type.$row['key'].'"><input name="'.$type.$row['key'].'" id="'.$type.$row['key'].'" type="checkbox"'.$checked.' />'.$row['name'].'</label></div>';
                if ($alt) {
                    $tp .= '<div id="'.$type.'-'.$row['key'].'-info">';
                    $tp .= '<label for="'.$type.'-'.$row['key'].'-yes"><input name="'.$type.$row['key'].'Radio" id="'.$type.'-'.$row['key'].'-yes" value="yes" type="radio"'.$disabled.' /><span>Yes</span></label>';
                    $tp .= '<label for="'.$type.'-'.$row['key'].'-no"><input name="'.$type.$row['key'].'Radio" id="'.$type.'-'.$row['key'].'-no" value="no" type="radio"'.$disabled.' checked /><span>No</span></label>';
                    $tp .= '</div>';
                }

                $i += 1;
            }
        }

        return $tp;
    }

    public function createRadioButtons($type) {

        $rows = $this->model->getResults($type);
        $num = count($rows);

        if ($num > 0) {  
            $checked = '';
            foreach ($rows as $row) {
                if ($row['name'] == 'None') {
                    $checked = ' checked';
                } else {
                    $checked = '';
                }
                $tp .= '<div><label for="'.$type.$row['key'].'-radio"><input name="'.$type.'Radio" id="'.$type.$row['key'].'-radio" type="radio" value="'.$row['key'].'"'.$checked.' />'.$row['name'].'</label></div>';
            }
        }

        return $tp;
    }

}
?>

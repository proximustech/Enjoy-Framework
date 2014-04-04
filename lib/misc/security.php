<?php

class security {

    function filter($valueToFilter, $sqlI = false) {
        
        if (is_array($valueToFilter)) {
    
            foreach ($valueToFilter as $key => $value) {
                if (is_array($value)) {
                    $value=$this->filter($value, $sqlI);
                } else {
                    $value = $this->filterValue($value,$sqlI);
                }
                $valueToFilter[$key] = $value;
            }
        }
        else $valueToFilter=$this->filterValue($valueToFilter,$sqlI);
        
        return $valueToFilter;
    }
    
    function filterValue($value, $sqlI = false) {

        $value = strip_tags($value); //filtering XSS

        if ($sqlI) { //Usually to filter INPUT against SQL Injection
            
            $sqlInjectionWords = array('SELECT', 'UPDATE', 'DELETE','INSERT'); //6 chars len
            
            $valueArray = explode(' ', $value);
            $newValueArray = array();
            foreach ($valueArray as $valueWord) {
                
                $add=true;
                if (strlen($valueWord) >= 6) {
                    $suspectString=strtoupper($valueWord);
                    
                    foreach ($sqlInjectionWords as $injectionWord) {
                        if (strpos($suspectString, $injectionWord) !== false) {
                            $add=false;
                            break;
                        }                        
                    }
                }
                
                if($add)$newValueArray[] = $valueWord;
            }
            $value = implode(' ', $newValueArray);
        }
        return $value;
    }
}

?>

<?php

class security {
    /**
     * Recursive method to fiter an array against cross side scripting and sql injection
     * @param mixed $valueToFilter
     * @param bool $sqlI
     * @return string filtered data
     */
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
    /**
     * Fiters a value against cross side scripting and sql injection
     * @param value $value
     * @param bool $sqlI
     * @return string filtered value
     */    
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
    

    /**
     * Searches if the permission is in the permissionsChain ( sees if the user has certain permission )
     * @param string $permission
     * @param string $permissionsChain
     * @return boolean
     */
    
    function checkCrudPermission($permission,$permissionsChain) {
        $permission=strtolower($permission);
        $permissionsChain = strtolower($permissionsChain);
        
        if (stripos($permissionsChain, $permission) !== false) {
            return true;
        }
        else return false;
    }
}

?>

<?php

class encryption {
    
    /*
     * Econding and decoding from:
     * http://www.myphpscripts.net/tutorial.php?id=9
     */

    var $key;
    
    function __construct($key="") {
        $this->key=$key;
    }
    
    
    function encode($string,$key="") {
        if ($key=="") {
            $key=$this->key;
        }
        
        $key = sha1($key);
        $stringLen = strlen($string);
        $keyLen = strlen($key);
        for ($sp = 0; $sp < $stringLen; $sp++) {
            $ordStrChar = ord(substr($string,$sp,1));
            if ($j == $keyLen) { $j = 0; }
            $ordKeyChar = ord(substr($key,$j,1));
            $j++;
            $encoded .= strrev(base_convert(dechex($ordStrChar + $ordKeyChar),16,36));
        }
        return $encoded;
    }

    function decode($string,$key="") {
        if ($key=="") {
            $key=$this->key;
        }
        
        $key = sha1($key);
        $stringLen = strlen($string);
        $keyLen = strlen($key);
        for ($i = 0; $i < $stringLen; $i+=2) {
            $ordStrChar = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
            if ($j == $keyLen) { $j = 0; }
            $ordKeyChar = ord(substr($key,$j,1));
            $j++;
            $decoded .= chr($ordStrChar - $ordKeyChar);
        }
        return $decoded;
    }

}

?>

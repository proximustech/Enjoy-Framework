<?php

class e_user {

    var $valid=false;
    var $identified=false;
    var $identifier;
    var $appServerConfig;
    var $data=null;
    var $user;
    var $userFileName;

    function __construct($identifier,$appServerConfig) {
        $this->identifier=$identifier;
        $this->appServerConfig=$appServerConfig;
    }
    
    function profile($data) {
        
        if ($this->appServerConfig['base']['platform']=='windows')
            $directorySeparator="\\";
        else
            $directorySeparator="/";
        
        $this->data=$data;
        $this->user=$data['user'];
        $this->userFileName=$this->appServerConfig['base']['controlPath']."users".$directorySeparator.$this->user.'_info.php';        
        
    }
    
    function check() {
        $this->identified=$this->identifier->check($this->data);
        
        //TODO : implement the getInfo method to validate
        if ($this->identified) {
            $info=$this->getInfo();
            if (is_array($info)) {
                $this->valid=true;
            }
        }
        
    }
    
    function getInfo() {
        
        if (file_exists($this->userFileName)) {
            return unserialize(file_get_contents($this->userFileName));
        }
        else return false;
    }
    
    function saveInfo($info) {
        file_put_contents($this->userFileName,serialize($info));
    }
    
    
    
}

class e_dbIdentifier {
    
    var $dataRep;

    
    function __construct($dataRep) {
        $this->dataRep=$dataRep;
    }
    function check($data) {

        /*
            JOIN roles ON u.id_role =roles.id,
            JOIN roles_applications ra ON roles.id=ra.id_role,
            JOIN applications apps ON ra.id_app=apps.id
         */
        
        $sql = "SELECT * FROM 
                    users u
                WHERE 
                    u.user_name='{$data['user']}'
                    AND u.password='{$data['password']}'
                    AND u.active=1
        ";

        $query = $this->dataRep->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
        $identified=false;
        if (count($results)==1) {
            $identified=true;
        }
        
        return $identified;
    }
}

?>

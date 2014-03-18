<?php

class e_user {

    var $valid=false;
    var $identified=false;
    var $info=array();
    var $identifier;
    var $controlPath;
    var $user;

    function __construct(&$identifier,$controlPath) {
        $this->identifier=$identifier;
        $this->controlPath=$controlPath;
    }
    
    function check($data) {
        $this->user=$data['user'];
        $this->identified=$this->identifier->check($data);
        
        //TODO : implement the getInfo method to validate
        if ($this->identified) {
            $this->valid=true;
        }
        
    }
    
    function getInfo() {
        $userFileName=$this->controlPath.'users/'.$this->user.'info.php';
        if (file_exists($userFileName)) {
            $info=unserialize(file_get_contents($userFileName));
        }
        else $info=array();
        
        return $info;
    }
    
    function saveInfo() {
        $userFileName=$this->controlPath.'users/'.$this->user.'info.php';
        file_put_contents($userFileName,serialize($info));
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

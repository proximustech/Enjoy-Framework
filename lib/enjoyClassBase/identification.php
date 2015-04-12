<?php

class e_user {

    var $valid=false;
    var $identified=false;
    var $identifier;
    var $appServerConfig;
    var $data=null;
    var $user;
    var $userFileName;

    /**
     * Creates a user operations handler
     * @param userIdentificator $identifier To Identificate a user
     * @param array $appServerConfig
     */
    
    function __construct($identifier,$appServerConfig) {
        $this->identifier=$identifier;
        $this->appServerConfig=$appServerConfig;
    }
    
    /**
     * Profiles a user inside the Enjoy user control
     * @param array $data Array with the user key
     */
    function profile($data) {
        
        if ($this->appServerConfig['base']['platform']=='windows')
            $directorySeparator="\\";
        else
            $directorySeparator="/";
        
        $this->data=$data;
        $this->user=$data['user'];
        $this->userFileName=$this->appServerConfig['base']['controlPath']."users".$directorySeparator.$this->user.'_info.php';        
        
    }
    
    
    /**
     * Checks the validity of a user is identified correctly
     * and has an information File 
     */
    
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
    
    /**
     * Returns the info in the user file if exists
     * @return mixed
     */
    
    function getInfo() {
        
        if (file_exists($this->userFileName)) {
            return unserialize(file_get_contents($this->userFileName));
        }
        else return false;
    }
    
    /**
     * Saves the user information in to a control file 
     * @param array $info
     */
    function saveInfo($info) {
        file_put_contents($this->userFileName,serialize($info));
    }
    
    /**
     * Removes the user control file
     */
    
    function removeControlFile() {
        unlink($this->userFileName);
    }
    
    
}

class e_dbIdentifier {
    
    var $dataRep;
    var $appServerConfig;

    /**
     * Identificates a user through the enjoy_admin user structure
     * @param PDO $dataRep
     * @param array $appServerConfig
     */
    
    function __construct($dataRep,$appServerConfig) {
        $this->dataRep=$dataRep;
        $this->appServerConfig=$appServerConfig;
    }
    
    function encodePassword($password) {
        
        $password=md5($this->appServerConfig['encryption']['hashText'].$password);
        return $password;
        
    }
    
    /**
     * Checks if the credentials correspond with the info in the dataBase
     * @param array $data with user and password keys
     * @return boolean
     */
    
    function check($data) {

        /*
            JOIN roles ON u.id_role =roles.id,
            JOIN roles_applications ra ON roles.id=ra.id_role,
            JOIN applications apps ON ra.id_app=apps.id
         */
        
        $encodedPassword=$this->encodePassword($data['password']);
        
        $sql = "SELECT * FROM 
                    users u
                WHERE 
                    u.user_name='{$data['user']}'
                    AND u.password='$encodedPassword'
                    AND u.active=1
        ";

        $query = $this->dataRep->pdo->prepare($sql);
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

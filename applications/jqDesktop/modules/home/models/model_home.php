<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';

class homeModel extends modelBase {

    function getPrivileges($user) {
    
        $sql="      
            SELECT
                r.name AS role,
                a.name AS app
            FROM
                users u
                JOIN roles r ON u.id_role=r.id
                JOIN roles_applications ra ON ra.id_role=r.id
                JOIN applications a ON ra.id_app=a.id
            WHERE
                u.user_name='$user'
            GROUP BY
                r.name,a.name
        ";
        $query = $this->dataRep->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
    
}

?>

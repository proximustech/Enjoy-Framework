<?php

//Model Class

require_once 'lib/enjoyClassBase/modelBase.php';

class homeModel extends modelBase {

    function getPrivileges($user) {
    
        $sql="      
            SELECT
                r.name AS role,
                a.name AS app,
                m.name AS module,
                am.permission AS permission
            FROM
                users u
                JOIN roles r ON u.id_role=r.id
                JOIN roles_applications ra ON ra.id_role=r.id
                JOIN applications a ON ra.id_app=a.id
                JOIN modules m ON m.id_app=a.id
                JOIN roles_applications_modules am ON am.id_role_app=ra.id AND am.id_module=m.id
            WHERE
                u.user_name='$user'

        ";
        $query = $this->dataRep->prepare($sql);
        $query->execute();
        $modulesPrivileges = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $sql="      
            SELECT
                r.name AS role,
                a.name AS app,
                c.name AS component,
                ac.permission AS permission
            FROM
                users u
                JOIN roles r ON u.id_role=r.id
                JOIN roles_applications ra ON ra.id_role=r.id
                JOIN applications a ON ra.id_app=a.id
                JOIN components c ON c.id_app=a.id
                JOIN roles_applications_components ac ON ac.id_role_app=ra.id AND ac.id_component=c.id
            WHERE
                u.user_name='$user'

        ";
        $query = $this->dataRep->prepare($sql);
        $query->execute();
        $componentsPrivileges = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return array($modulesPrivileges,$componentsPrivileges);
    }
    
}

?>

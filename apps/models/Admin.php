<?php

/**
 * Description of Admin
 *
 * @author Hendro Steven
 */
class Admin extends DB\SQL\Mapper {

    function __construct(\DB\SQL $db) {
        parent::__construct($db, "tadmin");
    }

    
}

<?php

/**
 * Description of Tag
 *
 * @author Hendro Steven
 */
class Tag extends DB\SQL\Mapper {

    function __construct(\DB\SQL $db) {
        parent::__construct($db, "ttag");
    }

    
}

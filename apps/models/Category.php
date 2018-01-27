<?php

/**
 * Description of Category
 *
 * @author Hendro Steven
 */
class Category extends DB\SQL\Mapper {

    function __construct(\DB\SQL $db) {
        parent::__construct($db, "tcategory");
    }

    
}

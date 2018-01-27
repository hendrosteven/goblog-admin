<?php

/**
 * Description of Post
 *
 * @author Hendro Steven
 */
class Post extends DB\SQL\Mapper {

    function __construct(\DB\SQL $db) {
        parent::__construct($db, "tpost");
    }

    
}

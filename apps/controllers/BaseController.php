<?php

class BaseController {

    protected $f3;
    protected $db; 
    protected $logger;

    function __construct() {
        $f3 = Base::instance();
        $dbh = new DB\SQL($f3->get('db_dns') . $f3->get('db_name'), $f3->get('db_user'), $f3->get('db_pass'));       
        $this->f3 = $f3;
        $this->db = $dbh;       
        $this->logger = new Log('app.log');
    }

   

}

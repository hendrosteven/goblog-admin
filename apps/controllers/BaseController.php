<?php

class BaseController
{

    protected $f3;
    protected $db;
    protected $logger;

    public function __construct()
    {
        $f3 = Base::instance();
        $dbh = new DB\SQL($f3->get('db_dns') . $f3->get('db_name'), $f3->get('db_user'), $f3->get('db_pass'), 
                array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        $this->f3 = $f3;
        $this->db = $dbh;
        $this->logger = new Log('app.log');
    }

}

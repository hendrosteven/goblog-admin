<?php

class Controller extends BaseController {

    function beforeroute() {
        if (!$this->f3->exists('SESSION.user')) {
            $this->f3->reroute('/login');
        }
    }

    function afterroute() {
        echo Template::instance()->render('layout.html');
        $this->f3->clear('SESSION.flash');
    }

}

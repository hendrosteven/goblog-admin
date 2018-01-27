<?php

class LoginController extends BaseController {

    public function index() {        
        echo Template::instance()->render('login.html');
        $this->f3->clear('SESSION.flash');
    }

}

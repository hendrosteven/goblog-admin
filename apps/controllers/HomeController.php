<?php

class HomeController extends Controller {

    public function index() {        
        $this->f3->set('view','pages/home.html');
    }

}

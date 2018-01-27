<?php

class LoginController extends BaseController {

    public function index() {        
        echo Template::instance()->render('login.html');
        $this->f3->clear('SESSION.flash');
    }

    public function signout() {
        $this->f3->clear('SESSION');
        $this->f3->reroute('/login');
    }

    public function signin() {        
        $email = $this->f3->get('POST.email');
        $password = $this->f3->get('POST.password');
        $remember = $this->f3->get('POST.remember');

        $v = new Valitron\Validator(array('Email' => $email, 'Password' => $password));
        $v->rule('required', ['Email', 'Password']);
        $v->rule('email', 'Email');

        if ($v->validate()) {
            $admin = new Admin($this->db);
            $pwd = md5($password);
            $admin->load(array('email=? and password=?', "$email", "$pwd"));
            if (!$admin->dry()) {               
                $admin->last_login = date('Y-m-d H:i:s');
                $admin->save();
                //create session
                $this->f3->set('SESSION.user', $admin->cast());
                if($remember==TRUE){
                    //create cookie
                    $this->f3->set('COOKIE.email', $email, 3600);  // 1 hour
                    $this->f3->set('COOKIE.password', $password, 3600);  // 1 hour
                }
                $this->f3->reroute('/');                
            } else {
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('Login fail, wrong username or password')),
                    'email' => $email
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/login');
            }
        } else {
            $flash = array(
                'errorType' => 'Error(s)',
                'errors' => $v->errors(),
                'email' => $email
            );
            $this->f3->set('SESSION.flash', $flash);
            $this->f3->reroute('/login');
        }
    }

}

<?php

class MemberController extends Controller
{

    public function index()
    {
        $member = new Member($this->db);
        $this->f3->set('members', $member->find());
        $this->f3->set('view', 'pages/member/list.html');
    }

    public function add()
    {
        $this->f3->set('view', 'pages/member/add.html');
    }

    public function save()
    {
        $full_name = $this->f3->get('POST.full_name');
        $email = $this->f3->get('POST.email');
        $password = $this->f3->get('POST.password');
        $role = $this->f3->get('POST.role');
        $status = $this->f3->get('POST.status');

        $v = new Valitron\Validator(array('Full Name' => $full_name, 'Email' => $email, 'Password' => $password));
        $v->rule('required', ['Full Name', 'Email', 'Password']);
        $v->rule('email', ['Email']);

        if ($v->validate()) {
            $member = new Member($this->db);
            $member->load(array('email=?', $email));
            if ($member->dry()) {
                $member->full_name = $full_name;
                $member->email = $email;
                $member->password = md5($password);
                $member->role = $role;
                $member->status = $status;
                $member->registration_date = date('Y-m-d H:i:s');
                $member->activation_date = date('Y-m-d H:i:s');
                try {
                    $member->save();
                    $flash = array(
                        'errorType' => 'Success',
                        'infos' => array(array('Data tersimpan')),
                    );
                    $this->f3->set('SESSION.flash', $flash);
                    $this->f3->reroute('/members');
                } catch (Exception $ex) {
                    $flash = array(
                        'errorType' => 'Error(s)',
                        'errors' => array(array('Terjadi kesalahan, silahkan periksa data yang diinput')),
                        'full_name' => $full_name,
                        'email' => $email,
                    );
                    $this->f3->set('SESSION.flash', $flash);
                    $this->f3->reroute('/members/add');
                }
            }else{
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('Email sudah terdaftar')),
                    'full_name' => $full_name,
                    'email' => $email,
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/members/add');
            }
        } else {
            $flash = array(
                'errorType' => 'Error(s)',
                'errors' => $v->errors(),
                'full_name' => $full_name,
                'email' => $email,
            );
            $this->f3->set('SESSION.flash', $flash);
            $this->f3->reroute("/members/add");
        }
    }

    function edit(){
        $id = $this->f3->get('PARAMS.id');
        $v = new Valitron\Validator(array('Member ID' => $id));
        $v->rule('required', ['Member ID']);
        if ($v->validate()) {           
            $member = new Member($this->db);
            $this->f3->set('member', $member->load(array('id=?', $id)));
            $this->f3->set('view', 'pages/member/edit.html');
        } else {
            $this->f3->reroute('/members');
        }
    }

    function update(){
        $id = $this->f3->get('POST.id');
        $full_name = $this->f3->get('POST.full_name');
        $email = $this->f3->get('POST.email');
        $password = $this->f3->get('POST.password');
        $role = $this->f3->get('POST.role');
        $status = $this->f3->get('POST.status');

        $v = new Valitron\Validator(array('Full Name' => $full_name, 'Email' => $email, 'Password' => $password));
        $v->rule('required', ['Full Name', 'Email', 'Password']);
        $v->rule('email', ['Email']);

        if ($v->validate()) {
            $member = new Member($this->db);
            $member->load(array('id=?',$id));
            $emailAvailable = true;

            //jika email diubah pastikan email tsb belum terdaftar
            if($member->email!==$email){
                $tmp = new Member($this->db);
                $tmp->load(array('email=?', $email));
                if(!$tmp->dry()){
                    $emailAvailable = false;
                }
            }
           
            if ($emailAvailable) {
                $member->full_name = $full_name;
                $member->email = $email;
                $member->password = md5($password);
                $member->role = $role;
                $member->status = $status;               
                try {
                    $member->update();
                    $flash = array(
                        'errorType' => 'Success',
                        'infos' => array(array('Data tersimpan')),
                    );
                    $this->f3->set('SESSION.flash', $flash);
                    $this->f3->reroute('/members');
                } catch (Exception $ex) {
                    $flash = array(
                        'errorType' => 'Error(s)',
                        'errors' => array(array('Terjadi kesalahan, silahkan periksa data yang diinput')),
                        'full_name' => $full_name,
                        'email' => $email,
                    );
                    $this->f3->set('SESSION.flash', $flash);
                    $this->f3->reroute("/members/edit/$id");
                }
            }else{
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('Email sudah terdaftar')),
                    'full_name' => $full_name,
                    'email' => $email,
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute("/members/edit/$id");
            }
        } else {
            $flash = array(
                'errorType' => 'Error(s)',
                'errors' => $v->errors(),
                'full_name' => $full_name,
                'email' => $email,
            );
            $this->f3->set('SESSION.flash', $flash);
            $this->f3->reroute("/members/edit/$id");
        }
    }

    public function remove()
    {
        $id = $this->f3->get('PARAMS.id');
        $v = new Valitron\Validator(array('Member ID' => $id));
        $v->rule('required', ['Member ID']);
        if ($v->validate()) {
            try {                
                $member = new Member($this->db);
                $member->load(array('id=?', $id));
                $member->erase();
                $flash = array(
                    'errorType' => 'Success',
                    'infos' => array(array('Member deleted'))
                );
                $this->f3->set('SESSION.flash', $flash);
            } catch (Exception $ex) {
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('Member can not deleted'))
                );
                $this->f3->set('SESSION.flash', $flash);
            }
        }
        $this->f3->reroute('/members');
    }

}

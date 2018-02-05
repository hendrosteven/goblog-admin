<?php

class ProfileController extends Controller
{
    public function detail()
    {
        $this->f3->set('view', 'pages/profile/edit.html');
    }

    public function update()
    {
        $fullName = $this->f3->get('POST.fullName');
        $avatar = $this->f3->get('POST.avatar');

        $v = new Valitron\Validator(array('Full Name' => $fullName));
        $v->rule('required', ['Full Name']);

        if ($v->validate()) {
            $userSession = $this->f3->get('SESSION.user');
            $admin = new Admin($this->db);
            $admin->load(array('id=?', $userSession['id']));
            $admin->full_name = $fullName;
            $admin->avatar = $avatar;
            $admin->update();
            $this->f3->set('SESSION.user', $admin->cast());

            $flash = array(
                'errorType' => 'Informations',
                'infos' => array(array('Your Profile updated')),
            );
            $this->f3->set('SESSION.flash', $flash);
            $this->f3->reroute('/profile');
        } else {
            $flash = array(
                'errorType' => 'Error(s)',
                'errors' => $v->errors(),
            );
            $this->f3->set('SESSION.flash', $flash);
            $this->f3->reroute('/profile');
        }
    }

    public function updatePassword()
    {
        $oldpassword = $this->f3->get('POST.oldpassword');
        $password = $this->f3->get('POST.password');
        $repassword = $this->f3->get('POST.repassword');

        $v = new Valitron\Validator(array('Old Password' => $oldpassword, 'Password' => $password, 'Retype Password' => $repassword));
        $v->rule('required', ['Old Password', 'Password', 'Retype Password']);
        $v->rule('equals', 'Retype Password', 'Password');

        if ($v->validate()) {
            $userLogin = $this->f3->get('SESSION.user');
            if ($userLogin['password'] == md5($oldpassword)) {
                $admin = new Admin($this->db);
                $admin->load(array('id=?', $userLogin['id']));
                $admin->password = md5($password);
                $admin->update();
                $this->f3->set('SESSION.user', $admin->cast());

                $flash = array(
                    'errorType' => 'Informations',
                    'infos' => array(array('Password updated, please sign out and login again with your new password')),
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/profile');
            } else {
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('Your old password is invalid')),
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/profile');
            }
        } else {
            $flash = array(
                'errorType' => 'Error(s)',
                'errors' => $v->errors(),
            );
            $this->f3->set('SESSION.flash', $flash);
            $this->f3->reroute('/profile');
        }
    }
}

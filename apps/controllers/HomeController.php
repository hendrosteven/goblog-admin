<?php

class HomeController extends Controller {

    public function index() {        
        $member = new Member($this->db);
        $this->f3->set('total_post',$this->db->exec("SELECT count(*) as total FROM tpost WHERE status=1"));
        $this->f3->set('total_category',$this->db->exec("SELECT count(*) as total FROM tcategory WHERE status=1"));
        $this->f3->set('total_free_member',$this->db->exec("SELECT count(*) as total FROM tmember WHERE role=0 AND status=1"));
        $this->f3->set('total_premium_member',$this->db->exec("SELECT count(*) as total FROM tmember WHERE role=1 AND status=1"));
        $this->f3->set('members',$member->find());
        $this->f3->set('view','pages/home.html');
    }

}

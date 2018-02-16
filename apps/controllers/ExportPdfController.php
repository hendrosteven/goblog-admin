<?php

class ExportPdfController extends BaseController{

    function beforeroute() {
        if (!$this->f3->exists('SESSION.user')) {
            $this->f3->reroute('/login');
        }
    }

    function export(){

        $member = new Member($this->db);
        $this->f3->set('members',$member->find());
        $html = Template::instance()->render('print/member.html');

        $dompdf = new Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream("daftar_member.pdf");

    }
    

}
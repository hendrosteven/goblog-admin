<?php

class PageController extends Controller
{

    public function index()
    {
        $page = new Page($this->db);
        $this->f3->set('pages', $page->find());
        $this->f3->set('view', 'pages/page/list.html');
    }

    public function add()
    {
        $this->f3->set('view', 'pages/page/add.html');
    }

    public function save(){
        $name = $this->f3->get('POST.name');
        $content = $this->f3->get('POST.content');
        $index = $this->f3->get('POST.index');
        $allow_comment = $this->f3->get('POST.allow_comment');
        $visible = $this->f3->get('POST.visible');

        $v = new Valitron\Validator(array('Name' => $name, 'Content' => $content, 'Index' => $index));
        $v->rule('required', ['Name', 'Content', 'Index']);

        if ($v->validate()) {
            $page = new Page($this->db);
            $page->name = $name;
            $page->content = $content;
            $page->index = $index;
            $page->allow_comment = $allow_comment;
            $page->visible = $visible;

            try{
                $page->save();
                $flash = array(
                    'errorType' => 'Success',
                    'infos' => array(array('Data tersimpan'))
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/pages');
            }catch(Exception $ex){
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('Terjadi kesalahan, silahkan periksa data yang diinput')),
                    'name' => $name,
                    'content' => $content,
                    'index' => $index
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/pages/add');
            }
        }else{
            $flash = array(
                'errorType' => 'Error(s)',
                'errors' => $v->errors(),
                'name' => $name,
                'content' => $content,
                'index' => $index
            );
            $this->f3->set('SESSION.flash', $flash);
            $this->f3->reroute("/pages/add");
        }
    }

    function edit(){
        $id = $this->f3->get('PARAMS.id');
        $v = new Valitron\Validator(array('Page ID' => $id));
        $v->rule('required', ['Page ID']);
        if ($v->validate()) {           
            $page = new Page($this->db);
            $this->f3->set('page', $page->load(array('id=?', $id)));
            $this->f3->set('view', 'pages/page/edit.html');
        } else {
            $this->f3->reroute('/pages');
        }
    }


    function update(){
        $id = $this->f3->get('POST.id');
        $name = $this->f3->get('POST.name');
        $content = $this->f3->get('POST.content');
        $index = $this->f3->get('POST.index');
        $allow_comment = $this->f3->get('POST.allow_comment');
        $visible = $this->f3->get('POST.visible');

        $v = new Valitron\Validator(array('Name' => $name, 'Content' => $content, 'Index' => $index));
        $v->rule('required', ['Name', 'Content', 'Index']);

        if ($v->validate()) {
            $page = new Page($this->db);
            $page->load(array('id=?',$id));

            $page->name = $name;
            $page->content = $content;
            $page->index = $index;
            $page->allow_comment = $allow_comment;
            $page->visible = $visible;

            try{
                $page->update();
                $flash = array(
                    'errorType' => 'Success',
                    'infos' => array(array('Data tersimpan'))
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/pages');
            }catch(Exception $ex){
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('Terjadi kesalahan, silahkan periksa data yang diinput')),
                    'name' => $name,
                    'content' => $content,
                    'index' => $index
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute("/pages/edit/$id");
            }
        }else{
            $flash = array(
                'errorType' => 'Error(s)',
                'errors' => $v->errors(),
                'name' => $name,
                'content' => $content,
                'index' => $index
            );
            $this->f3->set('SESSION.flash', $flash);
            $this->f3->reroute("/pages/edit/$id");
        }
    }

    public function remove()
    {
        $id = $this->f3->get('PARAMS.id');
        $v = new Valitron\Validator(array('Page ID' => $id));
        $v->rule('required', ['Page ID']);
        if ($v->validate()) {
            try {                
                $page = new Page($this->db);
                $page->load(array('id=?', $id));
                $page->erase();
                $flash = array(
                    'errorType' => 'Success',
                    'infos' => array(array('Page deleted'))
                );
                $this->f3->set('SESSION.flash', $flash);
            } catch (Exception $ex) {
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('Page can not deleted'))
                );
                $this->f3->set('SESSION.flash', $flash);
            }
        }
        $this->f3->reroute('/pages');
    }
}
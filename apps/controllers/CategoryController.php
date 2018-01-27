<?php

class CategoryController extends Controller {

    function index() {       
        $category = new Category($this->db);
        $this->f3->set('categories', $category->find());
        $this->f3->set('view','pages/category/list.html');
    }

    function add(){
        $this->f3->set('view', 'pages/category/add.html');
    }

    function save(){
        $categoryName = $this->f3->get('POST.categoryName');             
        $categoryStatus = $this->f3->get('POST.categoryStatus');

        $v = new Valitron\Validator(array('Category Name' => $categoryName));
        $v->rule('required', ['Category Name']);   

        if ($v->validate()) {
            $category = new Category($this->db);
            $category->name = $categoryName;
            $category->status = $categoryStatus;
            try{
                $category->save();
                $flash = array(
                    'errorType' => 'Success',
                    'infos' => array(array('Data tersimpan'))
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/categories');
            }catch(Exception $ex){
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('Terjadi kesalahan, silahkan periksa data yang diinput')),
                    'categoryName' => $categoryName
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/categories/add');
            }
        }else{
            $flash = array(
                'errorType' => 'Error(s)',
                'errors' => $v->errors()
            );
            $this->f3->set('SESSION.flash', $flash);
            $this->f3->reroute("/categories/add");
        }
    }

    function edit(){
        
    }

    function update(){
        
    }
}
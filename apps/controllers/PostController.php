<?php

class PostController extends Controller
{

    public function index()
    {
        $post = new Post($this->db);
        $this->f3->set('postings', $post->find());
        $this->f3->set('view', 'pages/post/list.html');
    }

    public function add()
    {
        $this->f3->set('view', 'pages/post/add.html');
    }

    public function save()
    {
        $title = $this->f3->get('POST.title');
        $short_content = $this->f3->get('POST.short_content');
        $full_content = $this->f3->get('POST.full_content');
        $tags = $this->f3->get('POST.tags');
        $allow_comments = $this->f3->get('POST.allow_comments');
        $types = $this->f3->get('POST.types');
        $status = $this->f3->get('POST.status');

        $v = new Valitron\Validator(array('Title' => $title, 'Short Content' => $short_content, 'Full Content' => $full_content, 'Tags' => $tags));
        $v->rule('required', ['Title', 'Short Content', 'Full Content', 'Tags']);

        if ($v->validate()) {
            $post = new Post($this->db);
            $post->title = $title;
            $post->short_content = $short_content;
            $post->full_content = $full_content;
            $post->image = $this->parseImage($full_content);
            $post->create_date = date("Y-m-d H:i:s");
            if ($status == 1) {
                $post->publish_date = date("Y-m-d H:i:s");
            }
            $post->tags = $tags;
            $post->allow_comments = $allow_comments;
            $post->types = $types;
            $post->status = $status;

            try {
                $post->save();
                $flash = array(
                    'errorType' => 'Success',
                    'infos' => array(array('Posting saved')),
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/postings');
            } catch (Exception $ex) {
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('There is an error, please check your input and try again')),
                    'title' => $title,
                    'short_content' => $short_content,
                    'full_content' => $full_content,
                    'tags' => $tags,
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/postings/add');
            }

        } else {
            $flash = array(
                'errorType' => 'Error(s)',
                'errors' => $v->errors(),
                'title' => $title,
                'short_content' => $short_content,
                'full_content' => $full_content,
                'tags' => $tags,
            );
            $this->f3->set('SESSION.flash', $flash);
            $this->f3->reroute("/postings/add");
        }
    }

    public function edit()
    {
        $id = $this->f3->get('PARAMS.id');
        $v = new Valitron\Validator(array('Post ID' => $id));
        $v->rule('required', ['Post ID']);
        if ($v->validate()) {
            $post = new Post($this->db);
            $this->f3->set('posting', $post->load(array('id=?', $id)));
            $this->f3->set('view', 'pages/post/edit.html');
        } else {
            $this->f3->reroute('/postings');
        }
    }

    public function update()
    {
        $id = $this->f3->get('POST.id');
        $title = $this->f3->get('POST.title');
        $short_content = $this->f3->get('POST.short_content');
        $full_content = $this->f3->get('POST.full_content');
        $tags = $this->f3->get('POST.tags');
        $allow_comments = $this->f3->get('POST.allow_comments');
        $types = $this->f3->get('POST.types');
        $status = $this->f3->get('POST.status');

        $v = new Valitron\Validator(array('Title' => $title, 'Short Content' => $short_content, 'Full Content' => $full_content, 'Tags' => $tags));
        $v->rule('required', ['Title', 'Short Content', 'Full Content', 'Tags']);

        if ($v->validate()) {
            $post = new Post($this->db);
            $post->load(array('id=?',$id));
            $post->title = $title;
            $post->short_content = $short_content;
            $post->full_content = $full_content;
            $post->image = $this->parseImage($full_content);
            if ($status == 1 && $post->publish_date==null ) {
                $post->publish_date = date("Y-m-d H:i:s");
            }
            $post->tags = $tags;
            $post->allow_comments = $allow_comments;
            $post->types = $types;
            $post->status = $status;

            try {
                $post->update();
                $flash = array(
                    'errorType' => 'Success',
                    'infos' => array(array('Posting updated')),
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute('/postings');
            } catch (Exception $ex) {
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('There is an error, please check your input and try again')),
                    'title' => $title,
                    'short_content' => $short_content,
                    'full_content' => $full_content,
                    'tags' => $tags,
                );
                $this->f3->set('SESSION.flash', $flash);
                $this->f3->reroute("/postings/edit/$id");
            }

        } else {
            $flash = array(
                'errorType' => 'Error(s)',
                'errors' => $v->errors(),
                'title' => $title,
                'short_content' => $short_content,
                'full_content' => $full_content,
                'tags' => $tags,
            );
            $this->f3->set('SESSION.flash', $flash);
            $this->f3->reroute("/postings/edit/$id");
        }
    }

    public function remove()
    {
        $id = $this->f3->get('PARAMS.id');
        $v = new Valitron\Validator(array('Post ID' => $id));
        $v->rule('required', ['Post ID']);
        if ($v->validate()) {
            try {                
                $post = new Post($this->db);
                $post->load(array('id=?', $id));
                $post->erase();
                $flash = array(
                    'errorType' => 'Success',
                    'infos' => array(array('Posting deleted'))
                );
                $this->f3->set('SESSION.flash', $flash);
            } catch (Exception $ex) {
                $flash = array(
                    'errorType' => 'Error(s)',
                    'errors' => array(array('Posting can not deleted'))
                );
                $this->f3->set('SESSION.flash', $flash);
            }
        }
        $this->f3->reroute('/postings');
    }

    public function parseImage($content)
    {
        $first_img = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
        $first_img = $matches[1][0];

        if (empty($first_img)) { //Defines a default image
            $first_img = '';
        }
        return $first_img;
    }

}

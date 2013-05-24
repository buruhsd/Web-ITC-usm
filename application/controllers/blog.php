<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Blog extends CI_Controller
{
    function __construct()
    {
        parent::__construct();         
        $this->load->model('blog_model');
        $this->load->helper('url');
    }
 
    function index()
    {
        //this function will retrive all entry in the database
        $data['query'] = $this->blog_model->get_all_posts();
        $this->load->view('blog/index',$data);
    }
 
    function add_new_entry()
    {
        $this->load->helper('form');
        $this->load->library(array('form_validation','session'));
 
        //set validation rules
        $this->form_validation->set_rules('entry_name', 'Title', 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('entry_body', 'Body', 'required|xss_clean');
 
        if ($this->form_validation->run() == FALSE)
        {
            //if not valid
            $this->load->view('blog/add_new_entry');
        }
        else
        {
            //if valid
            $name = $this->input->post('entry_name');
            $body = $this->input->post('entry_body');
            $this->blog_model->add_new_entry($name,$body);
            $this->session->set_flashdata('message', '1 new entry added!');
            redirect('blog/add_new_entry');
        }
    }
}
 
/* End of file blog.php */
/* Location: ./application/controllers/blog.php */

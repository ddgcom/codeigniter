<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
    }
    
    function users_management()
    {
        $crud = new grocery_CRUD();
    
        $crud->set_table('users');
        $crud->columns('username','password','select','file_url','multiselect');
        $crud->fields('username','password','select','file_url','multiselect');
        // LABEL FIELDS
        $crud->display_as('file_url','file');
        // FORMAT FIELDS
        $crud->field_type('select','dropdown', array(1 => "uno", 2 => "dos", 3 => "tres", 4 => "cautro"));
        $crud->field_type('multiselect','multiselect', array(1 => "uno", 2 => "dos", 3 => "tres", 4 => "cautro"));
        $crud->set_field_upload('file_url','assets/uploads/files');
        // REQUIRED FIELDS
        $crud->required_fields('username', 'password', 'select');
        $crud->set_subject('users');
    
        $output = $crud->render();
    
       
		$this->load->view('templates/template',$output);
    } 

    public function index()
    {
        $this->load->view('templates/template',(object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
    }

    public function ajax(){
        if ( !$this->db->simple_query('SELECT * FROM `users`') || !$this->input->server('REQUEST_METHOD') == 'POST'){ // VALIDATE QUERY
            show_error($this->db->error()); // Has keys 'code' and 'message'
            $output = "error";
        } else {
            $output = $this->db->query('SELECT `username`,`password`,`select`,`file_url`,`multiselect` FROM `users`')->result_array();
        }

        // FORMAT
        // $output_format["draw"] = 1;
        $output_format["recordsTotal"] = count($output);
        $output_format["recordsFiltered"] = count($output);
        $fake = array(array(
            "Airi",
            "Satou",
            "Accountant",
            "Tokyo",
            "28th Nov 08",
            "$162,700"),
          array(
            "Angelica",
            "Ramos",
            "Chief Executive Officer (CEO)",
            "London",
            "9th Oct 09",
            "$1,200,000"
          ));
        // DELETE KEYS 
        foreach ($output as $key => $value) {
            foreach ($value as $k => $v) {
                $result[$key][] = $v;
            }
        }
        $output_format["data"] = $result;
  
        // DEBUG
        // echo "<pre>";
        // print_r($result); 
        // echo "</pre>"; die();

        // OUTPUT ARRAY TO JSON
        echo json_encode($output_format); die();
    }

    public function install()
    {
        try{
            $this->load->dbforge();
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'username' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                    'null' => FALSE,
                ),
                'password' => array(
                    'type' =>'VARCHAR',
                    'constraint' => '255',
                    'null' => FALSE,
                ),
                'select' => array(
                    'type' => 'TiNYINT',
                    'null' => FALSE,
                ),
                'file_url' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                    'null' => TRUE,
                ),
                'multiselect' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                    'null' => TRUE,
                )
            );
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_field($fields);
            $this->dbforge->create_table('users', TRUE);

            $data = array(
                array(
                    'username' => 'diego',
                    'password' => '123',
                    'select' => 1,
                    'file_url' => 'test-2.pdf',
                    'multiselect' => '1,2,3',
                ),
                array(
                    'username' => 'camilo',
                    'password' => '123',
                    'select' => 1,
                    'file_url' => 'test-2.pdf',
                    'multiselect' => '1,2',
                ),
                array(
                    'username' => 'juan',
                    'password' => '123',
                    'select' => 1,
                    'file_url' => 'test-2.pdf',
                    'multiselect' => '1,3',
                ),
                array(
                    'username' => 'carlos',
                    'password' => '123',
                    'select' => 1,
                    'file_url' => 'test-2.pdf',
                    'multiselect' => '1,3',
                ),
                array(
                    'username' => 'diana',
                    'password' => '123',
                    'select' => 1,
                    'file_url' => 'test-2.pdf',
                    'multiselect' => '1',
                )
            );
            
            $this->db->insert_batch('users', $data);
            
            echo "successful demo!";
            die();
        } catch(Exception $e){
        	show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Uadmin_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'uadmin';
	private $current_page = 'uadmin/';
	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'branch_model',
			'category_model',
			'company_model',
			'product_model',
			'user_model',
		));
	}
	public function index()
	{
		$branchs = $this->branch_model->branchs()->result();
		$company = $this->company_model->company()->row();
		$categories = $this->category_model->categories()->num_rows();
		$employees = $this->user_model->employees()->num_rows();
		$products = $this->product_model->products()->num_rows();

		$add_branch = array(
			"name" => " <i class='fas fa-plus'></i> Tambah",
			"modal_id" => "add_branch_",
			"button_color" => "primari",
			"url" => site_url($this->current_page . "home/add/"),
			"form_data" => array(
				"name" => array(
					'type' => 'text',
					'label' => "Cabang",
					'value' => "",
				),
				"phone" => array(
					'type' => 'number',
					'label' => "Nomor Telepon",
					'value' => "",
				),
				"street" => array(
					'type' => 'text',
					'label' => "Alamat",
					'value' => "",
				),
				'data' => NULL
			),
		);

		$add_branch = $this->load->view('templates/actions/modal_form', $add_branch, true);

		$this->data["add_branch"] =  $add_branch;
		
		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["branchs"] = $branchs;
		$this->data["company"] = $company;
		$this->data["categories"] = $categories;
		$this->data["employees"] = $employees;
		$this->data["products"] = $products;
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Group";
		$this->data["header"] = "Group";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "uadmin/dashboard" );
	}

	public function add(  )
	{
		if( !($_POST) ) redirect(site_url(  $this->current_page ));  

		// echo var_dump( $data );return;
		$this->form_validation->set_rules( "name", "Nama", 'required|trim' );
		$this->form_validation->set_rules( "phone", "Telepon", 'required|trim' );
		$this->form_validation->set_rules( "street", "Alamat", 'required|trim' );
        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['phone'] = $this->input->post( 'phone' );
			$data['street'] = $this->input->post( 'street' );

			if( $this->branch_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->branch_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->branch_model->errors() ) );
			}
		}
        else
        {
          $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->branch_model->errors() : $this->session->flashdata('message')));
          if(  validation_errors() || $this->branch_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect( site_url($this->current_page)  );
	}

	public function edit_company() {
		if( !($_POST) ) redirect(site_url(  $this->current_page ));  

		// echo var_dump( $data );return;
		$this->form_validation->set_rules( "name", "name", "required" );
        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['phone'] = $this->input->post( 'phone' );
			$data['tagline'] = $this->input->post( 'tagline' );
			$data['description'] = $this->input->post( 'description' );
			if($_FILES['image']['name']){
				$data['image'] = $this->upload_image();
			}
			$data_param['id'] = $this->input->post( 'id' );
			$this->company_model->update( $data, $data_param );
		}
		
		redirect( site_url($this->current_page )  );
		
	}

	public function upload_image($userfile = 'image', $path = 'users_photo/')
	{
		$upload = $this->config->item('upload', 'ion_auth');

		$file = $_FILES[ $userfile ];
		$upload_path = 'uploads/' . $path;

		$config 				= $upload;
		$config['file_name'] 	= time() . "_" . $file['name'];
		$config['upload_path']	= './' . $upload_path;
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload( $userfile ) )
		{
			var_dump($this->upload->display_errors());
			die;
			// $this->set_error( 'upload_unsuccessful' );
			return FALSE;
		}
		else
		{
			if(NULL !== $this->input->post('image_old')){
				if($this->input->post('image_old') != 'default.jpg')
					@unlink( $path . $this->input->post('image_old') );
			}
			$file_data = $this->upload->data();
			return $file_data['file_name'];
		}
	}
}

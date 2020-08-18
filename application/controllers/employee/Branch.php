<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Branch extends Employee_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'employee';
	private $current_page = 'employee/branch/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Branch_services');
		$this->services = new Branch_services;
		$this->load->model(array(
			'branch_model',
			'product_branch_model',
			'product_model',
		));

	}

	public function index()
	{
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) -  1 ) : 0;
		// echo $page; return;
        //pagination parameter
        $pagination['base_url'] = base_url( $this->current_page ) .'/index';
        $pagination['total_records'] = $this->product_branch_model->record_count() ;
        $pagination['limit_per_page'] = 10;
        $pagination['start_record'] = $page*$pagination['limit_per_page'];
        $pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records'] > 0 ) $this->data['pagination_links'] = $this->setPagination($pagination);
		#################################################################3
		$table = $this->services->get_table_config_branch( $this->current_page );
		$table[ "rows" ] = $this->branch_model->branchs( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Cabang";
		$this->data["header"] = "Daftar Cabang";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function detail($id = null)
	{
		if( !($id) ) redirect(site_url('uadmin/home'));  
		
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) -  1 ) : 0;
		// echo $page; return;
        //pagination parameter
        $pagination['base_url'] = base_url( $this->current_page ) .'/index';
        $pagination['total_records'] = $this->product_branch_model->record_count() ;
        $pagination['limit_per_page'] = 10;
        $pagination['start_record'] = $page*$pagination['limit_per_page'];
        $pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records'] > 0 ) $this->data['pagination_links'] = $this->setPagination($pagination);
		#################################################################3
		$table = $this->services->get_table_config( $this->current_page );
		$table[ "rows" ] = $this->product_branch_model->product_branchs( $id, $pagination['start_record'], $pagination['limit_per_page'] )->result();
		$table = $this->load->view('templates/tables/plain_table', $table, true);

		$branch = $this->branch_model->branch($id)->row();
		

		$products = $this->product_model->products()->result();
		foreach ($products as $key => $product) {
			$list_product[$product->id] = $product->name;
		}

		$this->data[ "contents" ] = $table;
		$add_menu = array(
			"name" => "Tambah Produk",
			"modal_id" => "add_product_",
			"button_color" => "primary",
			"url" => site_url( $this->current_page."add/"),
			"form_data" => array(
				"branch_id" => array(
					'type' => 'hidden',
					'label' => "id",
					'value' => $id,
				),
				"product_id" => array(
					'type' => 'select',
					'label' => "Produk",
					'options' => $list_product,
				),
				"qty" => array(
					'type' => 'number',
					'label' => "Jumlah",
					'value' => "-",
				),
			),
			'data' => NULL
		);

		$add_menu= $this->load->view('templates/actions/modal_form', $add_menu, true ); 

		$this->data[ "header_button" ] =  $add_menu;
		// return;
		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Cabang";
		$this->data["header"] = $branch->name;
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function add(  )
	{
		if( !($_POST) ) redirect(site_url(  $this->current_page ));  

		// echo var_dump( $data );return;
		$this->form_validation->set_rules( $this->services->validation_config_product() );
        if ($this->form_validation->run() === TRUE )
        {
			$branch_id = $this->input->post( 'branch_id' );
			$data['branch_id'] = $branch_id;
			$data['product_id'] = $this->input->post( 'product_id' );
			$data['qty'] = $this->input->post( 'qty' );

			if( $this->product_branch_model->create( $data  ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_branch_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_branch_model->errors() ) );
			}
		}
        else
        {
          $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->product_branch_model->errors() : $this->session->flashdata('message')));
          if(  validation_errors() || $this->product_branch_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect( site_url('uadmin/branch/detail/' . $branch_id)  );
	}

	public function edit(  )
	{
		if( !($_POST) ) redirect(site_url(  $this->current_page ));  

		// echo var_dump( $data );return;
		$this->form_validation->set_rules( $this->services->validation_config_branch() );
        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['phone'] = $this->input->post( 'phone' );
			$data['street'] = $this->input->post( 'street' );

			$data_param['id'] = $this->input->post( 'id' );

			if( $this->branch_model->update( $data, $data_param  ) ){
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
		
		redirect( site_url('uadmin/home')  );
	}

	public function edit_qty(  )
	{
		$branch_id = $this->input->post( 'branch_id' );
		if( !($_POST) ) redirect(site_url(  $this->current_page . 'detail/' . $branch_id ));  

		$this->form_validation->set_rules( 'qty', 'Jumlah', 'required|trim' );
        if ($this->form_validation->run() === TRUE )
        {
			$data['qty'] = $this->input->post( 'qty' );

			$data_param['id'] = $this->input->post( 'id' );

			if( $this->product_branch_model->update( $data, $data_param  ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_branch_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_branch_model->errors() ) );
			}
		}
        else
        {
          $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->product_branch_model->errors() : $this->session->flashdata('message')));
          if(  validation_errors() || $this->product_branch_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect(site_url(  $this->current_page . 'detail/' . $branch_id ));
	}

	public function delete(  ) {
		if( !($_POST) ) redirect( site_url($this->current_page) );
	  
		$data_param['id'] 	= $this->input->post('id');
		if( $this->branch_model->delete( $data_param ) ){
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->branch_model->messages() ) );
		}else{
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->branch_model->errors() ) );
		}
		redirect( site_url($this->current_page)  );
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends Employee_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'employee';
	private $current_page = 'employee/product/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Product_services');
		$this->services = new Product_services;
		$this->load->model(array(
			'category_model',
			'color_model',
			'product_model',
			'product_color_model',
			'product_image_model',
		));

	}

	public function list_categories() {
		$categories = $this->category_model->categories()->result();
		$list_categories[] = "-- Pilih Kategori --";
		foreach ($categories as $key => $category) {
			$list_categories[$category->id] = $category->name;
		}

		return $list_categories;
	}

	public function index()
	{
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) -  1 ) : 0;
		// echo $page; return;
        //pagination parameter
        $pagination['base_url'] = base_url( $this->current_page ) .'/index';
        $pagination['total_records'] = $this->product_model->record_count() ;
        $pagination['limit_per_page'] = 10;
        $pagination['start_record'] = $page*$pagination['limit_per_page'];
        $pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records'] > 0 ) $this->data['pagination_links'] = $this->setPagination($pagination);
		#################################################################3
		$products = $this->product_model->products_with_image( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		$list_categories = $this->list_categories();

		$add_menu = array(
			"name" => "Tambah Produk",
			"modal_id" => "add_product_",
			"button_color" => "primary",
			"url" => site_url( $this->current_page."add/"),
			"form_data" => array(
				"name" => array(
					'type' => 'text',
					'label' => "Nama Produk",
					'value' => "",
				),
				"category_id" => array(
					'type' => 'select',
					'label' => "Kategori",
					'options' => $list_categories,
				),
				"price" => array(
					'type' => 'number',
					'label' => "Harga Produk",
					'value' => "",
				),
				"qty" => array(
					'type' => 'number',
					'label' => "Jumlah Produk",
					'value' => "",
				),
				"description" => array(
					'type' => 'textarea',
					'label' => "Deskripsi",
					'value' => "-",
				),
			),
			'data' => NULL
		);

		$add_menu= $this->load->view('templates/actions/modal_form', $add_menu, true ); 

		$this->data[ "header_button" ] =  $add_menu;
		
		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["products"] = $products;
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["header"] = "Produk";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "employee/product" );
	}


	public function add(  )
	{
		if( !($_POST) ) redirect(site_url(  $this->current_page ));  

		// echo var_dump( $data );return;
		$this->form_validation->set_rules( $this->services->validation_config() );
        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['category_id'] = $this->input->post( 'category_id' );
			$data['price'] = $this->input->post( 'price' );
			$data['qty'] = $this->input->post( 'qty' );
			$data['description'] = $this->input->post( 'description' );

			$id = $this->product_model->create( $data );
			if( $id ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_model->errors() ) );
			}
		}
        else
        {
          $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->product_model->errors() : $this->session->flashdata('message')));
          if(  validation_errors() || $this->product_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect( site_url($this->current_page . 'detail/' . $id)  );
	}

	public function detail( $id = null )
	{
		$colors = $this->color_model->colors( $id )->result();
		$product = $this->product_model->product( $id )->row();
		$product_colors = $this->product_color_model->product_colors( $id )->result();
		$product_images = $this->product_image_model->product_images( $id )->result();
		$list_categories = $this->list_categories();

		$add_image = array(
			"name" => "<span class='text-secondary'><i class='fas fa-plus'></i> Tambah</span>",
			"modal_id" => "add_image_",
			"button_color" => "primari",
			"url" => site_url( $this->current_page."form_image/"),
			"form_data" => array(
				"image" => array(
					'type' => 'file',
					'label' => "Gambar",
				),
				"product_id" => array(
					'type' => 'hidden',
					'label' => "id",
					'value' => $id
				),
			),
			'data' => NULL
		);
		$add_image= $this->load->view('templates/actions/modal_form_multipart', $add_image, true ); 
		$this->data[ "add_image" ] =  $add_image;

		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["product"] = $product;
		$this->data["product_colors"] = $product_colors;
		$this->data["product_images"] = $product_images;
		$this->data["list_categories"] = $list_categories;
		$this->data["colors"] = $colors;
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["header"] = "Detail Produk";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "employee/product_detail" );
	}

	public function edit_detail($id = NULL) {
		if( !($_POST) ) redirect(site_url(  $this->current_page ));  

		// echo var_dump( $data );return;
		$this->form_validation->set_rules( $this->services->validation_config() );
        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['category_id'] = $this->input->post( 'category_id' );
			$data['price'] = $this->input->post( 'price' );
			$data['qty'] = $this->input->post( 'qty' );
			$data['description'] = $this->input->post( 'description' );
			
			$data_param['id'] = $id;
			$this->product_model->update( $data, $data_param );
		}
		
		redirect( site_url($this->current_page . 'detail/' . $id)  );
	}

	public function edit_color($id = NULL) {
		$data_param['product_id'] = $id;
		$this->product_color_model->delete( $data_param );

		$checkboxs = $this->input->post('color');
		foreach ($checkboxs as $key => $checkbox) {
			$data[] = array(
				'product_id' => $id,
				'color_id' => $key
			);
		}
		$this->product_color_model->create( $data );
		redirect( site_url($this->current_page . 'detail/' . $id)  );
	}

	public function form_image( $image_id = NULL ) {
		$id = $this->input->post('product_id');
		$data['product_id'] = $id;
		$data['img'] = $this->upload_image();

		if($image_id){
			$data_param['id'] = $image_id;
			$result = $this->product_image_model->update( $data, $data_param );
		}else {
			$result = $this->product_image_model->create( $data );
		}
		if( $result ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_image_model->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_image_model->errors() ) );
		}
		redirect( site_url($this->current_page . 'detail/' . $id)  );
	}

	public function delete(  ) {
		if( !($_POST) ) redirect( site_url($this->current_page) );
		$id = $this->input->post('id');
	
		$product_images = $this->product_image_model->product_images( $id )->result();
		foreach ($product_images as $key => $product_image) {
			$this->unlink_image($product_image->image_file);
		}
		$data_param['id'] 	= $id;
		if( $this->product_model->delete( $data_param ) ){
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_model->messages() ) );
		}else{
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_model->errors() ) );
		}
		redirect( site_url($this->current_page)  );
	}

	public function delete_image(  ) {
		if( !($_POST) ) redirect( site_url($this->current_page) );
		$id = $this->input->post('product_id');
		$data_param['id'] 	= $this->input->post('id');
	  
		$this->unlink_image();

		if( $this->product_image_model->delete( $data_param ) ){
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_image_model->messages() ) );
		}else{
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_image_model->errors() ) );
		}
		redirect( site_url($this->current_page . 'detail/' . $id)  );
	}

	public function upload_image($userfile = 'image', $path = 'product_image/')
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
			// $this->set_error( 'upload_unsuccessful' );
			return FALSE;
		}
		else
		{
			$this->unlink_image();
			$file_data = $this->upload->data();
			return $file_data['file_name'];
		}
	}

	public function unlink_image($data = NULL, $path = './uploads/product_image/') {
		if(!$data){
			if(NULL !== $this->input->post('image_old')){
				if($this->input->post('image_old') != 'default.jpg')
					@unlink( $path . $this->input->post('image_old') );
			}
		}else {
			if($data != 'default.jpg')
				@unlink( $path . $data );
		}
	}
}

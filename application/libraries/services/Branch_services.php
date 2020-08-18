<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Branch_services
{
  function __construct(){
  }

  public function __get($var)
  {
    return get_instance()->$var;
  }
  
  public function get_table_config_branch( $_page, $start_number = 1 )
  {
      $table["header"] = array(
        'name' => 'Cabang',
        'street' => 'Jalan',
      );
      $table["number"] = $start_number;
      $table[ "action" ] = array(
              array(
                "name" => 'Detail',
                "type" => "link",
                "url" => site_url( $_page."detail/"),
                "param" => "id",
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                    "branch_id" => array(
                      'type' => 'hidden',
                      'label' => "id",
                    ),
                    "qty" => array(
                        'type' => 'number',
                        'label' => "Jumlah",
                    ),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
    );
    return $table;
  }

  public function get_table_config( $_page, $start_number = 1 )
  {
      $table["header"] = array(
        'name' => 'Produk',
        'qty' => 'Jumlah',
      );
      $table["number"] = $start_number;
      $table[ "action" ] = array(
              array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_",
                "url" => site_url( $_page."edit_qty/"),
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                    "branch_id" => array(
                      'type' => 'hidden',
                      'label' => "id",
                    ),
                    "qty" => array(
                        'type' => 'number',
                        'label' => "Jumlah",
                    ),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
              array(
                "name" => 'X',
                "type" => "modal_delete",
                "modal_id" => "delete_",
                "url" => site_url( $_page."delete/"),
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                  "id" => array(
                    'type' => 'hidden',
                    'label' => "id",
                  ),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
    );
    return $table;
  }
  public function validation_config_product( ){
    $config = array(
        array(
          'field' => 'branch_id',
          'label' => 'branch_id',
          'rules' =>  'required',
        ),
        array(
          'field' => 'qty',
          'label' => 'qty',
          'rules' =>  'trim|required',
        ),
    );
    
    return $config;
  }

  public function validation_config_branch( ){
    $config = array(
        array(
          'field' => 'name',
          'label' => 'name',
          'rules' =>  'trim|required',
        ),
        array(
          'field' => 'phone',
          'label' => 'phone',
          'rules' =>  'trim|required',
        ),
        array(
          'field' => 'street',
          'label' => 'street',
          'rules' =>  'trim|required',
        ),
    );
    
    return $config;
  }
}
?>

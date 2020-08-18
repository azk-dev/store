<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_color_model extends MY_Model
{
  protected $table = "product_color";

  function __construct() {
      parent::__construct( $this->table );
  }

  /**
   * create
   *
   * @param array  $data
   * @return static
   * @author madukubah
   */
  public function create( $data )
  {
      // Filter the data passed
      $this->db->insert_batch($this->table, $data);
      // $data = $this->_filter_data($this->table, $data);

      // $this->db->insert($this->table, $data);
      // $id = $this->db->insert_id($this->table . '_id_seq');
    
      if( isset($id) )
      {
        $this->set_message("berhasil");
        return $id;
      }
      $this->set_error("gagal");
          return FALSE;
  }
  /**
   * update
   *
   * @param array  $data
   * @param array  $data_param
   * @return bool
   * @author madukubah
   */
  public function update( $data, $data_param  )
  {
    $this->db->trans_begin();
    $data = $this->_filter_data($this->table, $data);

    $this->db->update($this->table, $data, $data_param );
    if ($this->db->trans_status() === FALSE)
    {
      $this->db->trans_rollback();

      $this->set_error("gagal");
      return FALSE;
    }

    $this->db->trans_commit();

    $this->set_message("berhasil");
    return TRUE;
  }
  /**
   * delete
   *
   * @param array  $data_param
   * @return bool
   * @author madukubah
   */
  public function delete( $data_param  )
  {
    $this->db->trans_begin();

    $this->db->delete($this->table, $data_param );
    if ($this->db->trans_status() === FALSE)
    {
      $this->db->trans_rollback();

      $this->set_error("gagal");//('group_delete_unsuccessful');
      return FALSE;
    }

    $this->db->trans_commit();

    $this->set_message("berhasil");//('group_delete_successful');
    return TRUE;
  }

    /**
   * group
   *
   * @param int|array|null $id = id_groups
   * @return static
   * @author madukubah
   */
  public function product_color( $id = NULL  )
  {
      if (isset($id))
      {
        $this->where($this->table.'.id', $id);
      }

      $this->limit(1);
      $this->order_by($this->table.'.id', 'desc');

      $this->product_colors(  );

      return $this;
  }
  /**
   * product_colors
   *
   *
   * @return static
   * @author madukubah
   */
  public function product_colors( $product_id = NULL )
  {
    $this->select("product_color.id");
    $this->select("product_color.color_id");
    $this->select("color.name");
    $this->select("color.value");
    $this->join(
      "color",
      "color.id = product_color.color_id",
      "join"
    );
    $this->where($this->table . '.product_id', $product_id);
    $this->order_by($this->table . '.color_id', 'asc');
    return $this->fetch_data();
  }

}
?>

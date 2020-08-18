<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-6">
            <h1 class="m-0 text-dark"><?= $header ?></h1>
          </div>
          <div class="col-6">
            <ol class="float-sm-right">
              <?= $header_button ?>
            </ol>
          </div>
        </div>
      </div>
    </div>
    
    <section class="content">
        <div class="container-fluid">
        
            <div class="row"> <!-- justify-content-center -->
                <?php $curr_product = null; foreach ($products as $key => $product) { 
                    if($curr_product != $product->name ) { 
                        $curr_product = $product->name; 
                        $product_img = $product->image ? $product->image : base_url('uploads/product_image/default.jpg');    
                    ?> 
                    <div class="col-lg-2 col-8">
                        <div class="card">
                            <img src="<?= $product_img ?>" class="card-img-top" alt="product">
                            <div class="card-body">
                                <a href="<?= base_url("employee/product/detail/") . $product->id ?>"><h4 class="card-title"><b><?= $product->name ?></b></h4></a>
                                <br>
                                <p class="text-secondary" style="font-size: 12px; margin-bottom: -10px">Rp. <?= $product->price ?></p>
                            </div>
                            <div class="card-footer text-right">
                                <a href="#" data-toggle="modal" data-target="#delete_prdocut" class="btn btn-sm"><i class="fas fa-trash"></i></a>
                                <div class="modal fade" id="delete_prdocut" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <?php echo form_open( base_url('employee/product/delete/') ); ?>
                                            <div class="modal-header">
                                                <h6 class="modal-title">Hapus</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="word-wrap: break-word;" class="alert alert-danger">
                                                    <div style="word-wrap: break-word !important;" class="text-left">Apa Anda Yakin menghapus produk <?= $product->name ?> ?</div>
                                                    <input name="id" type="hidden" value="<?= $product->id ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer ">
                                                <button type="submit" class="btn btn-danger">Ya</button>
                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</button>
                                            </div>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }} ?>                
            </div>
            
        </div>
    </section>
    
  </div>
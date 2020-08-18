<style>
    .hidden {
        display: none;
    }
</style>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= $header ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url($current_page) ?>">Produk</a></li>
              <li class="breadcrumb-item active"><?= $header ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detail Produk</h3>
                            <div class="card-tools">
                                <a href="#" data-toggle="modal" data-target="#delete_prdocut" class="btn btn-sm"><i class="fas fa-trash"></i> Delete</a>
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
                </div>

                <div class="col-lg-6">
                    <div class="col-12 row justify-content-between">
                        <p>Gambar</p>
                        <?= $add_image ?>
                        <!-- <a href="#" class="text-sm text-black-50"><i class="fas fa-plus"></i> Tambah</a> -->
                    </div>
                    <div class="row">
                        <?php foreach ($product_images as $key => $product_image) { ?> 
                            <div class="col-4 text-right">
                                <img src="<?= $product_image->image ?>" class="img-thumbnail" alt="product">
                                
                                <button data-toggle="modal" data-target="#delete_image_<?= $product_image->id ?>" class="btn btn-xs mt-1"><i class="fas fa-trash"></i></button>
                                <div class="modal fade" id="delete_image_<?= $product_image->id ?>" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <?php echo form_open( base_url('employee/product/delete_image/') . $product_image->id ); ?>
                                            <div class="modal-header">
                                                <h6 class="modal-title">Hapus</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="word-wrap: break-word;" class="alert alert-danger">
                                                    <div style="word-wrap: break-word !important;" class="text-left">Apa Anda Yakin menghapus gambar ini ?</div>
                                                    <input name="id" type="hidden" value="<?= $product_image->id ?>">
                                                    <input name="image_old" type="hidden" value="<?= $product_image->image_file ?>">
                                                    <input name="product_id" type="hidden" value="<?= $product->id ?>">
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
                                
                                
                                <button data-toggle="modal" data-target="#edit_image_<?= $product_image->id ?>" class="btn btn-xs btn-primary mt-1">Edit</button>
                                <div class="modal fade" id="edit_image_<?= $product_image->id ?>" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <?php echo form_open_multipart( base_url('employee/product/form_image/') . $product_image->id );?>
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-left">
                                                <input name="image_old" type="hidden" value="<?= $product_image->image_file ?>">
                                                <input name="product_id" type="hidden" value="<?= $product->id ?>">
                                                <label for="image">Gambar</label>
                                                <?php
                                                $form_image = array(
                                                    'name' => 'image',
                                                    'id' => 'image',
                                                    'class' => 'form-control',  
                                                );
                                                echo form_upload( $form_image );
                                                ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn  btn-success">Ok</button>
                                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</button>
                                            </div>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="col-12 row justify-content-between">
                        <p>Detail</p>
                        <a id="btn-edit-detail" href="#" class="text-sm text-black-50"><i class="fas fa-pen"></i> Edit</a>
                    </div>
                    <div class="card" id="card-detail">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3"><b>Produk: </b></div>
                                <div class="col-9"><?= $product->name ?></div>
                                <div class="col-3"><b>Kategori: </b></div>
                                <div class="col-9"><?= $list_categories[$product->category_id] ?></div>
                                <div class="col-3"><b>Harga: </b></div>
                                <div class="col-9"><?= $product->price ?></div>
                                <div class="col-3"><b>Jumlah: </b></div>
                                <div class="col-9"><?= $product->qty ?></div>
                                <div class="col-3"><b>Deskripsi: </b></div>
                                <div class="col-9"><?= $product->description ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="card hidden" id="card-form-detail">
                        <?= form_open(base_url($current_page . 'edit_detail/' . $product->id)); ?>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-line mb-2"> 
                                    <input name="name" type="text" class="form-control" value="<?= $product->name ?>" placeholder="Nama Produk">
                                </div>
                                <div class="form-line mb-2">
                                <?php
                                    $form['name'] = 'category_id';
                                    $form['id'] = 'category_id';
                                    $form['class'] = 'form-control';
                                    $form['options'] = $list_categories;
                                    $form['selected'] = $product->category_id;
                                    echo form_dropdown( $form );
                                ?>
                                </div>
                                <div class="form-line mb-2"> 
                                    <input name="price" type="number" class="form-control" value="<?= $product->price ?>" placeholder="Harga Produk">
                                </div>
                                <div class="form-line mb-2"> 
                                    <input name="qty" type="number" class="form-control" value="<?= $product->qty ?>" placeholder="Jumlah Produk">
                                </div>
                                <div class="form-line mb-2"> 
                                    <textarea name="description" id="description" class="form-control" rows="10"><?= $product->description ?></textarea>
                                </div>
                                <div class="text-right">
                                    <a href="#" id="btn-reset-detail" class="btn btn-sm">Batal</a>
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>

                    <div class="card">
                        <?= form_open(base_url($current_page . 'edit_color/' . $product->id)); ?>
                        <div class="card-header">
                            <div class="card-title"><h6>Warna</h6></div>
                            <div class="div-tools text-right">
                                <a id="btn-edit-color" href="#" class="text-sm text-black-50"><i class="fas fa-pen"></i> Edit</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php $i = 0; foreach ($colors as $key => $color) { ?> 
                                    <div class="col-3">
                                        <div class="form-check">
                                            <?php if($i < count($product_colors) && $color->id == $product_colors[$i]->color_id){ $i++; ?>
                                                <input name="<?= "color[$color->id]" ?>" class="checkbox form-check-input" disabled="" checked type="checkbox">
                                            <?php } else { ?>
                                                <input name="<?= "color[$color->id]" ?>" class="checkbox form-check-input" disabled="" type="checkbox">
                                            <?php } ?>
                                            <label class="form-check-label"><?= $color->name ?></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-footer hidden text-right" id="btn-form-color">
                            <a href="#" id="btn-reset-color" class="btn btn-sm">Batal</a>
                            <button type="submit" href="#" class="text-sm btn btn-sm btn-primary">Simpan</button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
    
</div>

<script>
    const btnEditDetail = document.getElementById('btn-edit-detail');
    const btnEditColor = document.getElementById('btn-edit-color');
    const btnResetDetail = document.getElementById('btn-reset-detail');
    const btnResetColor = document.getElementById('btn-reset-color');
    const checkboxs = document.getElementsByClassName('checkbox');

    const cardDetail = document.getElementById('card-detail');
    const cardFormDetail = document.getElementById('card-form-detail');
    const btnFormColor = document.getElementById('btn-form-color');

    btnEditDetail.addEventListener('click', function() {
        toggleClassHiddenDetail();
    })

    btnEditColor.addEventListener('click', function() {
        toggleClassHiddenColor();
        Object.values(checkboxs).forEach(checkbox => {
            checkbox.removeAttribute('disabled');
        })
    })

    btnResetDetail.addEventListener('click', function() {
        toggleClassHiddenDetail();
    })

    btnResetColor.addEventListener('click', function() {
        toggleClassHiddenColor();
        Object.values(checkboxs).forEach(checkbox => {
            checkbox.setAttribute('disabled', "");
        })
    })



    function toggleClassHiddenDetail() {
        btnEditDetail.classList.toggle('hidden')
        cardDetail.classList.toggle('hidden')
        cardFormDetail.classList.toggle('hidden')
    }

    function toggleClassHiddenColor() {
        btnEditColor.classList.toggle('hidden')
        btnFormColor.classList.toggle('hidden')
    }


</script>
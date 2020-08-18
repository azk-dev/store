<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Beranda</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Beranda</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    
    <section class="content">
      <div class="container-fluid">
        
        <div class="row">
            <div class="col-lg-3 col-6">
                
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-code-branch"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Cabang</span>
                        <span class="info-box-number">
                            <?= count($branchs) ?>
                        </span>
                    </div>
                </div>
            </div>
          
            <div class="col-lg-3 col-6">
                
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dolly"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><a href="<?= base_url('employee/product') ?>">Produk</a></span>
                        <span class="info-box-number">
                            <?= $products ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                
                <div class="info-box">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fab fa-delicious"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><a href="<?= base_url('employee/category') ?>">Kategori Produk</a></span>
                        <span class="info-box-number">
                            <?= $categories ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><a href="<?= base_url('uadmin/users') ?>">Karyawan</a></span>
                        <span class="info-box-number">
                            <?= $employees ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                  Usaha
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-7">
                            <h2 class="lead"><b><?= $company->name ?></b></h2>
                            <p class="text-muted text-sm"><b>Tagline: <?= $company->tagline ?></b> </p>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small mb-2"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Alamat: <?= $company->description ?></li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Kontak #: <?= $company->phone ?></li>
                            </ul>
                        </div>
                        <div class="col-5 text-center">
                            <img src="<?= $company->image ?>" alt="" class="img-circle img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <button data-toggle="modal" data-target="#edit_company" class="btn btn-xs btn-primary"><i class="fas fa-pen"></i> Edit</button>
                        <div class="modal fade" id="edit_company" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <?php echo form_open_multipart( base_url('uadmin/home/edit_company/') );?>
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-left">
                                        <input name="id" type="hidden" value="<?= $company->id ?>">
                                        <input name="image_old" type="hidden" value="<?= $company->image_old ?>">
                                        <label for="name">Nama</label>
                                        <input name="name" type="text" class="form-control" value="<?= $company->name ?>">
                                        <label for="phone" class="mt-1">Nomor Telepon</label>
                                        <input name="phone" type="text" class="form-control" value="<?= $company->phone ?>">
                                        <label for="tagline" class="mt-1">Tagline</label>
                                        <input name="tagline" type="text" class="form-control" value="<?= $company->tagline ?>">
                                        <label for="description" class="mt-1">Jalan</label>
                                        <input name="description" type="text" class="form-control" value="<?= $company->description ?>">
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
                </div>
              </div>
            </div>

            <div class="col-lg-1"></div>
            <div class="col-lg-7 row">
                <div class="col-12 row justify-content-between">
                    <p>Daftar Cabang</p>
                    <span><?= $add_branch ?></span>
                </div>
                <?php foreach ($branchs as $key => $branch) { ?>                    
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-code-branch"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number">
                                <a href="<?= base_url('employee/branch/detail/') . $branch->id ?>"><?= $branch->name ?></a>
                            </span>
                            <span class="info-box-text text-sm"><?= $branch->street ?></span>
                            <p class="text-black-50" style="font-size: 11px;"><?= $branch->phone ?></p>
                            <button class="btn btn-xs" data-toggle="modal" data-target="#edit_branch_<?= $branch->id ?>"><i class="fas fa-pen"></i> Edit</button>
                        </div>
                    </div>
                    <div class="modal fade" id="edit_branch_<?= $branch->id ?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <?php echo form_open( base_url('employee/branch/edit/') . $branch->id );?>
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <input name="id" type="hidden" value="<?= $branch->id ?>">
                                    <label for="name">Nama</label>
                                    <input name="name" type="text" class="form-control" value="<?= $branch->name ?>">
                                    <label for="phone" class="mt-1">Nomor Telepon</label>
                                    <input name="phone" type="text" class="form-control" value="<?= $branch->phone ?>">
                                    <label for="street" class="mt-1">Jalan</label>
                                    <input name="street" type="text" class="form-control" value="<?= $branch->street ?>">
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
        
       
        
      </div>
    </section>
    
  </div>
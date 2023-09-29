<?= $this->extend('templates/default')?>
<?= $this->section('content')?>
<div class="container-xxl position-relative bg-white d-flex p-0">
    <?= $this->include('templates/partials/sidebar', ['active'=>$active]) ?>
    <div class="content">
    <?= $this->include('templates/partials/navbar', ['username'=>$username]) ?>
    <?= isset($validation)? 
            '<div class="alert alert-warning alert-dismissible fade show" role="alert">'
            . $validation->listErrors() . 
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>': '' 
    ?>
    <?= isset($success)?
            ($success==true?
                '<div class="alert alert-success alert-dismissible fade show" role="alert">Add '
                    .$view.
                    ' data suceesfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
                    :
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                    .$view.
                    ' data Failed to insert<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'):''
    ?> 
    <?=isset($role) && $role == 'way_bridge'? 
        $this->include('templates/partials/add_production_formdata_n', ['view'=>$view]): '' ?>
    <?= $this->include('templates/partials/view_production_tabledata_n',
                 ['tableData'=>isset($tableData)?$tableData:false, 'date'=>isset($date)?$date:'','cname'=>isset($cname)?$cname:'', 'view'=>$view])?> 
    <?= $this->include('templates/partials/footer') ?> 
</div>
</div>
<?= $this->endSection() ?>
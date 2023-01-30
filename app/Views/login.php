<?= $this->extend('templates/default')?>
<?= $this->section('content')?>
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <?php if(session()->getFlashdata('msg')){
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">'
                        .session()->getFlashdata('msg').
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                    ?>
                        <img src="<?php echo base_url("/img/onkar.png") ?>" class="rounded mx-auto d-block mb-2" alt="...">
                        <h5 class="text-black text-center">Korp Resources Pvt Ltd</h5>
                        <?= form_open('') ?>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="loginInput" placeholder="username" value="" name="username">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="loginPassword" placeholder="Password" value="" name="password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4 fs-5">Login</button>
                        <?= form_close() ?>
                        <div class="form-floating mb-4">
                            <input type="checkbox" onclick="togglePass()"/><span class="px-2">Show Password</span>
                        </div> 
                        <p class="text-center" style="font-size: 12px;">Korp Resources Pvt Ltd | ©2022 All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
<?= $this->endSection() ?>
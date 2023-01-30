<?= $this->extend('templates/default')?>
<?= $this->section('content')?>

<div class="container-xxl position-relative bg-white d-flex p-0">
<?= $this->include('templates/partials/sidebar', ['active'=>$active]) ?>
        <!-- Content Start -->
        <div class="content">
            <?= $this->include('templates/partials/navbar', ['username'=>$username]) ?>
                    <!--Inward Start -->
                    <div class="container-fluid pt-4 px-4">
                        <h3 class="text-start text-primary">Inward Today</h3>
                        <div class="row g-4">
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">ROM</h4>
                                        <p class="mb-2 text-light"><span class="fs-2">40</span> Ton</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">Screen</h4>
                                        <p class="mb-2 text-light"><span class="fs-2">20</span> Ton</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">O.B.</h4>
                                        <p class="mb-2 text-light"><span class="fs-2">60</span> Ton</p>  
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                    <!-- Inward End -->

                    <!--Outward Start -->
                    <div class="container-fluid pt-4 px-4">
                        <h3 class="text-start text-primary">Outward Today</h3>
                        <div class="row g-4">
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">5X18</h4>
                                        <p class="mb-2 text-light"><span class="fs-2">10</span> Ton</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">10X40</h4>
                                        <p class="mb-2 text-light"><span class="fs-2">10</span> Ton</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">Fines</h4>
                                        <p class="mb-2 text-light"><span class="fs-2">10</span> Ton</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Outward End -->
            <?= $this->include('templates/partials/footer') ?>
        </div>
        <!-- Content End -->
</div>

<?= $this->endSection() ?>
<?= $this->extend('templates/default')?>
<?= $this->section('content')?>

<div class="container-xxl position-relative bg-white d-flex p-0">
<?= $this->include('templates/partials/sidebar', ['active'=>$active]) ?>
        <!-- Content Start -->
        <div class="content">
            <?= $this->include('templates/partials/navbar', ['username'=>$username]) ?>
                    <h3 class="text-center text-primary">Minerals Processed</h3>
                    <div class="ms-4">
                        <label>Select Date:</label>
                        <input type="date" value="" name="date" autocomplete="off" onchange="getAllMineralValue(event)"></input>
                    </div>
                    <!--Inward Start -->
                    <div class="container-fluid pt-4 px-4">
                        <h3 class="text-start text-primary">Inwards</h3>
                        <div class="row g-4">
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">ROM</h4>
                                        <p class="mb-2 text-light"><span class="fs-2" id="rom">...</span> Ton</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">O.B.</h4>
                                        <p class="mb-2 text-light"><span class="fs-2" id="ob">...</span> Ton</p>  
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                    <!-- Inward End -->

                    <!--Production Start -->
                    <div class="container-fluid pt-4 px-4">
                        <h3 class="text-start text-primary">Production</h3>
                        <div class="row g-4">
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">Crusher</h4>
                                        <p class="text-light">5X18:  <span id="crusher-5-18">...</span> Ton</p>
                                        <p class="text-light">10X40: <span id="crusher-10-40">...</span> Ton</p>
                                        <p class="text-light">Fines: <span id="crusher-fines">...</span> Ton</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">Chute</h4>
                                        <p class="text-light">5X18:  <span id="chute-5-18">...</span> Ton</p>
                                        <p class="text-light">10X40: <span id="chute-10-40">...</span> Ton</p>
                                        <p class="text-light">Fines: <span id="chute-fines">...</span> Ton</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">Mines</h4>
                                        <p class="text-light">5X18:  <span id="mines-5-18">...</span> Ton</p>
                                        <p class="text-light">10X40: <span id="mines-10-40">...</span> Ton</p>
                                        <p class="text-light">Fines: <span id="mines-fines">...</span> Ton</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">Screen</h4>
                                        <p class="text-light">5X18:  <span id="screen-5-18">...</span> Ton</p>
                                        <p class="text-light">10X40: <span id="screen-10-40">...</span> Ton</p>
                                        <p class="text-light">Fines: <span id="screen-fines">...</span> Ton</p>
                                        <p class="text-light">OB: <span id="screen-ob">...</span> Ton</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                                    <div class="ms-0">
                                        <h4 class="mb-0 text-light">Tantra</h4>
                                        <p class="text-light">5X18:  <span id="tantra-5-18">...</span> Ton</p>
                                        <p class="text-light">10X40: <span id="tantra-10-40">...</span> Ton</p>
                                        <p class="text-light">Fines: <span id="tantra-fines">...</span> Ton</p>
                                        <p class="text-light">OB: <span id="tantra-ob">...</span> Ton</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Production End -->
            <?= $this->include('templates/partials/footer') ?>
        </div>
        <!-- Content End -->
    <script>
        const urlLocation =  window.location;
        function totalMWeightData(pathName, node){
            const url =  `${urlLocation.protocol}//${urlLocation.host}${pathName}`;
            fetch(url, {
                method: "GET",
                headers:{
                    "X-Requested-With": "XMLHttpRequest" 
                }
            }).then(res=>res.json())
            .then(data=>node.innerText = parseFloat(data.total).toFixed(3));
        }

        function getAllMineralValue(event=null){
            const date = event?event.target.value:'';
            totalMWeightData(date?`/inwards/rom/current-mweight?date=${date}`:'/inwards/rom/current-mweight', document.getElementById('rom'));
            totalMWeightData(date?`/inwards/ob/current-mweight?date=${date}`:'/inwards/ob/current-mweight', document.getElementById('ob'));

            totalMWeightData(date?`/production/crusher/current-mweight?type=5-18&date=${date}`:'/production/crusher/current-mweight?type=5-18', document.getElementById('crusher-5-18'));
            totalMWeightData(date?`/production/crusher/current-mweight?type=10-40&date=${date}`:'/production/crusher/current-mweight?type=10-40', document.getElementById('crusher-10-40'));
            totalMWeightData(date?`/production/crusher/current-mweight?type=fines&date=${date}`:'/production/crusher/current-mweight?type=fines', document.getElementById('crusher-fines'));

            totalMWeightData(date?`/production/chute/current-mweight?type=5-18&date=${date}` :'/production/chute/current-mweight?type=5-18', document.getElementById('chute-5-18'));
            totalMWeightData(date?`/production/chute/current-mweight?type=10-40&date=${date}`:'/production/chute/current-mweight?type=10-40', document.getElementById('chute-10-40'));
            totalMWeightData(date?`/production/chute/current-mweight?type=fines&date=${date}`:'/production/chute/current-mweight?type=fines', document.getElementById('chute-fines'));

            totalMWeightData(date?`/production/mines/current-mweight?type=5-18&date=${date}` :'/production/mines/current-mweight?type=5-18', document.getElementById('mines-5-18'));
            totalMWeightData(date?`/production/mines/current-mweight?type=10-40&date=${date}`:'/production/mines/current-mweight?type=10-40', document.getElementById('mines-10-40'));
            totalMWeightData(date?`/production/mines/current-mweight?type=fines&date=${date}`:'/production/mines/current-mweight?type=fines', document.getElementById('mines-fines'));

            totalMWeightData(date?`/production/screen/current-mweight?type=5-18&date=${date}` :'/production/screen/current-mweight?type=5-18', document.getElementById('screen-5-18'));
            totalMWeightData(date?`/production/screen/current-mweight?type=10-40&date=${date}`:'/production/screen/current-mweight?type=10-40', document.getElementById('screen-10-40'));
            totalMWeightData(date?`/production/screen/current-mweight?type=fines&date=${date}`:'/production/screen/current-mweight?type=fines', document.getElementById('screen-fines'));
            totalMWeightData(date?`/production/screen/current-mweight?type=ob&date=${date}`   :'/production/screen/current-mweight?type=fines', document.getElementById('screen-ob'));


            totalMWeightData(date?`/production/tantra/current-mweight?type=5-18&date=${date}` :'/production/tantra/current-mweight?type=5-18', document.getElementById('tantra-5-18'));
            totalMWeightData(date?`/production/tantra/current-mweight?type=10-40&date=${date}`:'/production/tantra/current-mweight?type=10-40', document.getElementById('tantra-10-40'));
            totalMWeightData(date?`/production/tantra/current-mweight?type=fines&date=${date}`:'/production/tantra/current-mweight?type=fines', document.getElementById('tantra-fines'));
            totalMWeightData(date?`/production/tantra/current-mweight?type=ob&date=${date}`   :'/production/tantra/current-mweight?type=fines', document.getElementById('tantra-ob'));
        }

        setTimeout(function(){
            getAllMineralValue();
        },1000);
    </script>
</div>

<?= $this->endSection() ?>
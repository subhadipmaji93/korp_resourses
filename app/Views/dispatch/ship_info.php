<?= $this->extend('templates/default')?>
<?= $this->section('content')?>
<div class="container-xxl position-relative bg-white d-flex p-0">
    <?= $this->include('templates/partials/sidebar', ['active'=>$active]) ?>
    <div class="content">
        <?= $this->include('templates/partials/navbar', ['username'=>$username]) ?>
        <div class="container-fluid mt-2 pt-2 px-2 w-100">
            <div class="bg-light rounded p-4">
                <h6 class="mb-4">Shipping Info Database</h6>
                <div class="mb-2 ms-2 w-100 client-list">
                    <label for="clientList">Client: </label>
                    <select id="clientList" class="ms-4 form-select-md" aria-label="client list" onchange="fetchShipList(event)" hidden>               
                        <option selected value="default">Select Client</option>    
                    </select>
                </div>
                <div class="table-responsive data-table">
                    <table class="table table-bordered">
                        <thead class="table-primary fixed-head">
                            <tr>
                                <th scope="Col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Pincode</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="shipList" style="height: 200px; overflow-y: scroll;">
                            <tr><td colspan='5' class='text-center fs-2'>Select Client</td><tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary" onclick="addShipModal()">ADD</button>
                </div>
            </div>
            <div class="modal" id="Modal" tabindex="-1" aria-labelledby="staticBackdropLabel" 
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="shipForm" class="d-flex flex-column">
                                <div class="form-floating mb-2 w-100">
                                    <input id="shipName" type="text" class="form-control" placeholder="Name" value="" name="name" autocomplete="off" required></input>
                                    <label for="shipName">Name</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="shipAddress" type="text" class="form-control" placeholder="Address" value="" name="address" autocomplete="off" required></input>
                                    <label for="shipAddress">Address</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="shipPincode" type="text" class="form-control" placeholder="Pincode" value="" name="pincode" autocomplete="off" pattern="^\d{6}"  required></input>
                                    <label for="shipPincode">Pincode</label>
                                </div>
                                <input type="submit" class="btn btn-success w-25" value="Save">
                            </form>
                        </div>
                    </div>
            </div>
        </div>
        <script src="<?php echo base_url("js/shipInfo.js");?>"></script>
        <?= $this->include('templates/partials/footer') ?> 
    </div>
</div>
<?= $this->endSection() ?>
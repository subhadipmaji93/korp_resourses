<?= $this->extend('templates/default')?>
<?= $this->section('content')?>

<div class="container-xxl position-relative bg-white d-flex p-0">
    <?= $this->include('templates/partials/sidebar', ['active'=>$active]) ?>
    <div class="content">
        <?= $this->include('templates/partials/navbar', ['username'=>$username]) ?>
        <div class="container-fluid mt-2 pt-2 px-2 w-100">
            <div class="d-flex mb-2">
                <div class="w-50">
                    <label for="clientList">Client: </label>
                    <select id="clientList" class="ms-4 form-select-md" aria-label="client list" onchange="fetchClientData(event)" hidden>               
                        <option selected value="default">Select Client</option>    
                    </select>
                </div>
                <div class="w-50">
                    <label for="shipList">Ship To: </label>
                    <select id="shipList" class="ms-4 form-select-md" aria-label="ship list" onchange="fetchShipData(event)" hidden>               
                        <option selected value="default">Select</option>    
                    </select>
                </div>
            </div>
        <form class="row g-2" action="" method="POST" target="_blank" onsubmit="setChallanId()">
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="bg-light rounded py-2">
                            <fieldset class="border p-2">
                                <legend class="float-none w-auto p-2 fs-6">Buyer Details</legend>
                                <div class="form-floating mb-2 w-100">
                                    <input id="buyerName" type="text" placeholder="Name" class="form-control" value="" name="buyerName" autocomplete="off" required></input>
                                    <label for="buyerName">Name</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="buyerAddress" type="text" placeholder="Address" class="form-control" value="" name="buyerAddress" autocomplete="off" required></input>
                                    <label for="buyerAddress">Address</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="buyerGST" type="text" placeholder="GST No:" class="form-control" value="" name="buyerGST" autocomplete="off" required></input>
                                    <label for="buyerGST">GST No:</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="buyerState" type="text" placeholder="State Code:" class="form-control" value="" name="buyerState" autocomplete="off"></input>
                                    <label for="buyerState">State Code:</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="buyerCIN" type="text" placeholder="CIN No:" class="form-control" value="" name="buyerCIN" autocomplete="off"></input>
                                    <label for="buyerCIN">CIN No:</label>
                                </div>
                            </fieldset>                            
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="bg-light rounded py-2">
                            <fieldset class="border p-2">
                                <legend class="float-none w-auto p-2 fs-6">Challan Info</legend>
                                <div class="w-100 d-flex">
                                    <div class="form-floating mb-2 w-75 pe-2">
                                        <input id="challanNo" type="text" placeholder="Challan No:" class="form-control" value="" name="challanNo" autocomplete="off" required></input>
                                        <label for="challanNo">Challan No:</label>
                                    </div>
                                    <div class="form-floating mb-2 w-50 pe-2">
                                        <input id="challanDate" type="date" placeholder="Date:" class="form-control" value="" name="challanDate" autocomplete="off" required></input>
                                        <label for="challanDate">Date:</label>
                                    </div>
                                    <div class="form-floating mb-2 w-50">
                                        <input id="tpNo" type="text" placeholder="T.P. No:" class="form-control" value="" name="tpNo" autocomplete="off" required></input>
                                        <label for="tpNo">T.P. No:</label>
                                    </div>
                                </div>
                                <div class="w-100">
                                    <fieldset class="border p-2">
                                        <legend class="float-none w-auto p-2 fs-6">Ship Info</legend>
                                        <div class="form-floating mb-2 w-100">
                                            <input id="shipName" type="text" placeholder="Name" class="form-control" value="" name="shipName" autocomplete="off" required></input>
                                            <label for="shipName">Name</label>
                                        </div>
                                        <div class="form-floating mb-2 w-100">
                                            <input id="shipAddress" type="text" placeholder="Address" class="form-control" value="" name="shipAddress" autocomplete="off" required></input>
                                            <label for="shipAddress">Address</label>
                                        </div>
                                       <div class="w-100 d-flex">
                                            <div class="form-floating mb-2 w-50 pe-2">
                                                <input id="shipPincode" type="text" placeholder="Pin Code::" class="form-control" value="" name="shipPincode" autocomplete="off" required></input>
                                                <label for="shipPincode">Pin Code:</label>
                                            </div>
                                            <div class="form-floating mb-2 w-50">
                                                <input id="shipTruckNo" type="text" placeholder="Truck No:" class="form-control" value="" name="shipTruckNo" autocomplete="off" required></input>
                                                <label for="shipTruckNo">Truck No:</label>
                                            </div>
                                       </div>
                                    </fieldset>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="bg-light rounded py-2">
                            <fieldset class="border p-2">
                                <legend class="float-none w-auto p-2 fs-6">Material Info</legend>
                                <div class="mb-2 w-100">
                                    <label for="materialName" class="pe-2">Desc:</label>
                                    <select id="materialName" class="form-select-md" name="materialName" required>
                                        <option selected>Select Material Description</option>
                                        <option value="Calibrated Iron Ore Lump CLO(10-40)">Calibrated Iron Ore Lump CLO(10-40)</option>
                                        <option value="Calibrated Iron Ore Lump CLO(5-18)">Calibrated Iron Ore Lump CLO(5-18)</option>
                                        <option value="Calibrated Iron Ore Crushed fines(0-10 mm)">Calibrated Iron Ore Crushed fines(0-10 mm)</option>
                                        <option value="Calibrated Iron Ore Screened fines(0-10 mm)">Calibrated Iron Ore Screened fines(0-10 mm)</option>
                                    </select>
                                </div>
                                <div class="mb-2 w-100">
                                    <label for="materialGrade">Grade:</label>
                                    <select id="materialGrade" class="form-select-md" name="materialGrade" required>
                                        <option selected>Select Grade</option>
                                        <option value="45% to below 51%">45% to below 51%</option>
                                        <option value="51% to below 55%">51% to below 55%</option>
                                        <option value="55% to below 58%">55% to below 58%</option>
                                        <option value="58% to below 60%">58% to below 60%</option>
                                    </select>
                                </div>
                                <div class="mb-2 w-100">
                                    <label for="materialSize" class="pe-3">Size:</label>
                                    <select id="materialSize" class="form-select-md" aria-label="Default select example" name="materialSize" required>
                                        <option selected>Select type</option>
                                        <option value="5-18">5-18</option>
                                        <option value="10-40">10-40</option>
                                        <option value="fines">Fines</option>
                                    </select>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="materialQnty" type="text" placeholder="QNTY (MT)" class="form-control" value="" name="materialQnty" autocomplete="off" required></input>
                                    <label for="materialQnty">QNTY (MT)</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="materialRate" type="text" placeholder="RATE" class="form-control" value="" name="materialRate" autocomplete="off" required></input>
                                    <label for="materialRate">RATE</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="hsnCode" type="text" placeholder="HSN Code" class="form-control" value="2601" name="hsnCode" autocomplete="off"></input>
                                    <label for="hsnCode">HSN Code</label>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="bg-light rounded py-2">
                            <fieldset class="border p-2">
                                <legend class="float-none w-auto p-2 fs-6">Amount Info</legend>
                                <div class="form-floating mb-2 w-100">
                                    <input id="amount" type="text" placeholder="Amount:" class="form-control" value="" name="amount" pattern="^\d*(\.\d{0,2})?$" autocomplete="off" required></input>
                                    <label for="amount">Amount:</label>
                                </div>
                                <div class="mb-2 w-100">
                                    <label for="selectGST">GST: </label>
                                    <select id="selectGST" class="form-select-md" aria-label="select gst" onchange="gstType(event)" name="selectGST">
                                        <option value="default">Select GST Type</option>
                                        <option value="c-s">CGST + SGST</option>
                                        <option value="i">IGST</option>
                                    </select>
                                </div>
                                <div id="gst-container"></div>
                                <div class="mb-2 w-100 d-flex">
                                    <div class="form-floating mb-2 w-75 pe-2">
                                        <input id="totalAmount" type="text" placeholder="Total Amount:" class="form-control" value="" name="totalAmount" pattern="^\d*(\.\d{0,2})?$" autocomplete="off" required></input>
                                        <label for="totalAmount">Total Amount:</label>
                                    </div>
                                    <div class="form-floating mb-2 w-25">
                                        <input id="roundOff" type="text" placeholder="Round Off::" class="form-control" value="" name="roundOff" autocomplete="off"></input>
                                        <label for="roundOff">Round:</label>
                                    </div>
                                </div>
                                <div class="w-50 form-check form-switch">
                                        <label for="addTCS">Include TCS:</label>
                                        <input type="checkbox" id="addTCS" class="form-check-input" onchange="addTcs(event)">
                                </div>
                                <div id="tcs-container"></div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="amountWord" type="text" placeholder="Amount In Words:" class="form-control" value="" name="amountWord" autocomplete="off" required></input>
                                    <label for="amountWord">Amount In Words:</label>
                                </div>
                            </fieldset>
                        </div>
                        <button class="btn btn-primary" onclick="resetForm(event)">Reset</button>
                        <button class="btn btn-primary" onclick="calculate(event)">Calculate</button>
                        <input type="submit" class="btn btn-primary float-end" value="Submit">
                    </div>
                </form>
        </div>
        <script src="<?php echo base_url("js/challan.js");?>"></script>
        <?= $this->include('templates/partials/footer') ?>   
    </div>
</div>
<?= $this->endSection() ?>
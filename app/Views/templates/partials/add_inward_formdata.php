<!-- Start Form Data -->
        <div class="container-fluid pt-2 px-2">
            <button class="btn btn-primary ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#formData" aria-expanded="false" aria-controls="formData">
            <i class="fas fa-plus-circle"></i><span class="px-2">ADD</span>
            </button>
            <div id="formData" class="collapse ms-4">   
                <h6 class="mb-2 p-2">Add <?= esc($view);?> Details</h6>
                <?= form_open('') ?>
                    <div class="row g-2">
                        <div class="col-sm-3 col-xl-3">
                            <div class="bg-light rounded h-100 p-1">
                                <select class="form-select-lg w-100" aria-label="Default select example" name="contractor">
                                    <option selected>select Contractor</option>
                                    <option value="PS BROTHERS">PS BRTOHERS</option>
                                    <option value="EASTERN ZONE">EASTERN ZONE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3">
                            <div class="bg-light rounded h-100 p-1  ">
                                <div class="form-floating mb-2 w-100">
                                    <input type="text" class="form-control" id="floatingVehicle"
                                        placeholder="Vehicle No" value="" name="vehicle" autocomplete="off" >
                                    <label for="floatingVehicle">Vehicle No:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3">
                            <div class="bg-light rounded h-100 p-1  ">
                                <div class="form-floating mb-2 w-100">
                                    <input type="text" class="form-control" id="floatingTotalWeight"
                                        placeholder="Gross Weight" value="" name="gross_weight" autocomplete="off" >
                                    <label for="floatingTotalWeight">Gross Weight (MT)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3">
                            <div class="bg-light rounded h-100 p-1  ">
                                <div class="form-floating mb-2 w-100">
                                    <input type="text" class="form-control" id="floatingTareWeight"
                                        placeholder="Tare Weight" value="" name="tare_weight" autocomplete="off" >
                                    <label for="floatingTareWeight">Tare Weight (MT)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3">
                            <div class="bg-light rounded h-100 p-1  ">
                                <div class="form-floating mb-2 w-100">
                                    <input type="text" class="form-control" id="floatingMineralWeight"
                                        placeholder="Mineral Weight" value="" name="mineral_weight" autocomplete="off" >
                                    <label for="floatingMineralWeight">Mineral Weight (MT)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3">
                            <div class="bg-light rounded h-100 p-1  ">
                                <div class="form-floating mb-2 w-100">
                                    <input type="text" class="form-control" id="floatingFrom"
                                        placeholder="From" value="" name="from" autocomplete="off" >
                                <label for="floatingFrom">From:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3">
                            <div class="bg-light rounded h-100 p-1  ">
                                <div class="form-floating mb-2 w-100">
                                    <input type="text" class="form-control" id="floatingTo"
                                        placeholder="To" value="" name="to" autocomplete="off" >
                                    <label for="floatingTo">To:</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xl-3">
                            <div class="bg-light rounded h-100 p-1">
                                <div class="form-floating mb-2 w-100">
                                    <textarea class="form-control" name="purpose" id="floatingPurpose" cols="30" rows="5"></textarea>
                                <label for="floatingPurpose">Purpose:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <button class="btn btn-primary px-2" onclick="connect(event)">Capture</button> -->
                    <input class="btn btn-primary px-2" type="submit" value="Submit">
                <?= form_close() ?>
            </div>
        </div>
<!-- End form data -->
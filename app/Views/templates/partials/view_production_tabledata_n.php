<div class="container-fluid pt-2 px-2">
                <div class="row g-2">
                    <div class="col-sm-12 col-md-9 col-xl-9">
                        <div class="bg-light rounded h-100 p-1">
                            <h6 class="mb-4"><?= isset($view)? esc($view):''?> Table</h6>
                            <div class="table-responsive data-table">
                                <table class="table table-sm table-bordered text-center">
                                    <thead class="table-primary fixed-head">
                                        <tr>
                                            <th scope="col">Time</th>
                                            <th scope="col">To</th>
                                            <th scope="col">Vehicle No:</th>
                                            <th scope="col">Gross w/t (MT)</th>
                                            <th scope="col">Tare w/t (MT)</th>
                                            <th scope="col">Mineral w/t (MT)</th>
                                            <th scope="col">Purpose</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" colspan="7">Date: <?= isset($date)?$date:''?></th>
                                        </tr>
                                        <tr>
                                            <th scope="col" colspan="7">Type: <?= isset($type)?$type:''?></th>
                                        </tr>
                                        <tr>
                                            <th scope="col" colspan="7">Contractor: <?= isset($cname)?$cname:''?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php if(isset($tableData)){
                                                $total = 0.000;
                                                foreach($tableData as $data){
                                                    $total += $data->mineral_weight;
                                                    echo "<tr>
                                                    <td>$data->time</td>
                                                    <td>$data->to</td>
                                                    <td>$data->vehicle</td>
                                                    <td>$data->gross_weight</td>
                                                    <td>$data->tare_weight</td>
                                                    <td>$data->mineral_weight</td>
                                                    <td>$data->purpose</td>
                                                    </tr>";
                                                }
                                            }
                                            ?>
                                    </tbody>
                                    <tfoot class="table-primary fixed-foot">
                                        <tr>
                                            <th colspan="5">Total Mineral Weight:</th>
                                            <th colspan="1"><?= isset($total)?number_format($total, 3):'' ?> TON</th>
                                            <th colspan="1"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-3 col-xl-3">
                        <div class="bg-light rounded h-100 py-4">
                            <?= form_open('', ['method'=>'get'])?>
                                <div class="d-flex flex-column align-items-center justify-content-between">
                                    <h6 class="mb-2">Select date for view</h6>
                                    <div class="form-floating mb-2 w-100">
                                        <input id="calender" type="datetime" class="form-control"
                                         placeholder="pick a date" value="" name="date"></input>
                                         <label for="calendar">Select date</label>
                                    </div>
                                    <h6 class="mb-2">Select Contractor</h6>
                                    <div class="form-floating mb-2 w-100">
                                    <select class="form-select-lg w-100" aria-label="Default select example" name="cname">
                                        <option selected value="PS BROTHERS">PS BRTOHERS</option>
                                        <option value="EASTERN ZONE">EASTERN ZONE</option>
                                    </select>
                                    </div>
                                    <h6 class="mb-2">Select Type for view</h6>
                                    <div class="form-floating mb-2 w-100">
                                    <select class="form-select-lg w-100" aria-label="Default select example" name="type">
                                        <option selected value="5-18">5X18</option>
                                        <option value="10-40">10X40</option>
                                        <option value="fines">Fines</option>
                                    </select>
                                    </div>
                                    <div class="form-floating mb-2 w-100 px-2">
                                        <input type="submit" class="btn btn-primary px-4" name="action" value="Fetch">
                                        <input type="submit" class="btn btn-primary px-4" name="action" value="Export">
                                    </div>
                                </div>
                            <?=form_close()?>
                        </div>
                    </div>
                </div>
            </div>
<?= $this->extend('templates/default')?>
<?= $this->section('content')?>

<div class="container-xxl position-relative bg-white d-flex p-0">
    <?= $this->include('templates/partials/sidebar', ['active'=>$active]) ?>
    <div class="content">
        <?= $this->include('templates/partials/navbar', ['username'=>$username]) ?>
        <div class="container-fluid mt-2 pt-2 px-2 w-100">
            <button class="btn btn-primary mb-2" onclick="addStackModal(event)">Add</button>
            <div id="stackList" class="row g-4"><p class="fs-2">Wait...</p></div>
            <div class="modal" id="Modal" tabindex="-1" aria-labelledby="staticBackdropLabel" 
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="StackForm" class="d-flex flex-column">
                                <div class="form-floating mb-2 w-100">
                                    <input id="stackName" type="text" class="form-control" placeholder="Name" value="" name="name" autocomplete="off" required></input>
                                    <label for="stackName">Name</label>
                                </div>
                                <div class="w-100 d-flex align-items-center mb-2">
                                    <div class="form-floating w-50 pe-2">
                                        <input id="stackCapacity" type="text" class="form-control" placeholder="Max Capacity" value="" name="capacity" autocomplete="off" pattern="^\d*(\.\d{0,3})?$"  required></input>
                                        <label for="stackCapacity">Capacity (MT)</label>
                                    </div>
                                    <div class="form-floating w-50">
                                        <input id="stackCurrent" type="text" class="form-control" placeholder="Current Material" value="" name="current" autocomplete="off" pattern="^\d*(\.\d{0,3})?$"></input>
                                        <label for="stackCurrent">Current Material (MT)</label>
                                    </div>
                                </div>
                                <div class="w-100 d-flex align-items-center mb-2">
                                    <div class="w-50">
                                        <label for="stackMSize" class="pe-3">Size:</label>
                                        <select id="stackMSize" class="form-select-md" aria-label="Select Size" name="size" required>
                                            <option selected>Select type</option>
                                            <option value="5-18">5-18</option>
                                            <option value="10-40">10-40</option>
                                            <option value="fines">Fines</option>
                                        </select>
                                    </div>
                                    <div class="form-floating w-50">
                                        <input id="stackMGrade" type="number"  class="form-control" placeholder="Grade" value="" name="grade" autocomplete="off" min="45" max="60" required></input>
                                        <label for="stackMGrade">Grade (%)</label>
                                    </div>
                                </div>
                                <div class="w-100 mb-2">
                                    <fieldset class="border p-2 d-flex align-items-center">
                                        <legend class="float-none w-auto p-2 fs-6">FORM-K</legend>
                                        <div class="mb-2 w-50 pe-2" id="forEdit">
                                            <input class="form-control" type="file" id="stackFormKDoc" name="form_k_doc"
                                            onchange="validateFile(event)">
                                        </div>
                                        <div class="form-floating w-50">
                                            <input id="stackFormKGrade" type="number" class="form-control" placeholder="Grade" value="" name="form_k_grade" autocomplete="off" min="45" max="60"></input>
                                            <label for="stackFormKGrade">Grade (%)</label>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="w-100 mb-2">
                                    <fieldset class="border p-2">
                                        <legend class="float-none w-auto p-2 fs-6">Applied For</legend>
                                        <div class="w-100 mb-2 d-flex align-items-center">
                                            <div class="w-50">
                                                <label for="stackClientList">Client:</label>
                                                <select id="stackClientList" class="form-select-md" aria-label="Select Client" hidden>
                                                    <option selected value="default">Select Client</option>
                                                </select>
                                            </div>
                                            <div class="form-floating w-50">
                                                <input id="stackClientQuantity" type="text" class="form-control" placeholder="Current Material" value="" autocomplete="off" pattern="^\d*(\.\d{0,3})?$"></input>
                                                <label for="stackClientQuantity">Quantity (MT)</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="button" onclick="addParty(event)">Add</button>
                                    </fieldset>
                                </div>
                                <div id="parties" class="w-100"></div>
                                <input type="submit" class="btn btn-success w-25" value="submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url("js/stackInfo.js");?>"></script>
        <?= $this->include('templates/partials/footer') ?> 
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('templates/default')?>
<?= $this->section('content')?>

<div class="container-xxl position-relative bg-white d-flex p-0">
    <?= $this->include('templates/partials/sidebar', ['active'=>$active]) ?>
    <!-- Content Start -->
    <div class="content">
        <?= $this->include('templates/partials/navbar', ['username'=>$username]) ?>
        <div class="container-fluid pt-2 px-2 w-100">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-4 col-xl-3">
                        <div class="bg-light rounded h-100 py-4">
                            <h6 class="mb-4 text-center">Return List</h6>
                            <div id="returnList" class="row g-2 loading" style="height: 350px; overflow-y: scroll;">
                            </div>
                            <input type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" onclick="addModal2(event)" value="Add"></input>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-4">
                        <div class="bg-light rounded h-100 p-4 d-flex flex-column">
                            <h6 class="mb-4 text-center">Alert List</h6>
                            <div id="alertList" class="row g-2 loading" style="height: 350px; overflow-y: scroll;">
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-5">
                        <div class="bg-light rounded h-100 p-4 d-flex flex-column">
                            <h6 class="mb-4 text-center">View Return Data</h6>
                            <div id="returnDataList" class="row g-2" style="height: 350px; overflow-y: scroll;">
                               <div class="text-center fs-4">Select Date</div>
                            </div>
                            <div class="d-flex flex-row justify-content-start mt-2" >
                            <input type="date" placeholder="" 
                            class="form-control me-2" value=""></input>
                            <button class="btn btn-primary me-2" onclick="fetchReturnDataList(event)">Fetch</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         <!-- Modal Start-->
            <div class="modal" id="Modal" tabindex="-1" aria-labelledby="staticBackdropLabel" 
                data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Return File Upload</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="d-flex flex-column" onsubmit="uploadReturnData(event)">
                                <input type="hidden" name="id" value="" id="returnDataId">
                                <input type="hidden" name="type" value="" id="uploadType">
                                <div class="form-floating mb-2 w-100">
                                    <input id="returnName" type="text" class="form-control" value="" name="name" disabled></input>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="submitDate" type="date" placeholder="Submit Date" class="form-control"
                                    value="" name="submit_date" autocomplete="off" disabled></input>
                                    <label for="submitDate">Submit Date</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input class="form-control" type="file" name="files[]" id="returnFile" onchange="ifSelected(event)" multiple>
                                </div>
                                <div class="mb-2 w-100">
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="submit" id="returnSave" class="btn btn-success" value="Save" disabled></input>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    function ifSelected(event){
                        event.preventDefault();
                        let fileList = event.target.files;
                        if(fileList.length>0){
                            let elm = event.target.parentElement.nextElementSibling;
                            elm.innerHTML = '';
                            let ul = document.createElement("ul");
                            let status = "";
                            for(let item of fileList){
                                if(item.type === 'application/pdf' && item.size/1024<2048){
                                    ul.innerHTML += `<li class="text-success">${item.name}</li>`;
                                } else {
                                    status = "disabled";
                                    ul.innerHTML += `<li class="text-danger">${item.name}</li>`;
                                }
                            }
                            if(status === 'disabled'){
                                let p = document.createElement("p");
                                p.className = "text-info";
                                p.innerText = "files must be a pdf and file size within 2MB";
                                elm.appendChild(p);
                            }
                            elm.appendChild(ul);
                            let saveButton = document.getElementById("returnSave");
                            if(status === 'disabled'){
                                saveButton.disabled = true;
                            } else {
                                saveButton.disabled = false;
                            }
                        }
                    }
                </script>
            </div>
            <!-- Modal End  -->

            <!-- Modal Add or Edit Return Start-->
            <div class="modal" id="Modal2" tabindex="-1" aria-labelledby="staticBackdropLabel" 
                data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row g-2">
                            <form onsubmit="saveReturnListData(event)">
                                <div class="form-floating mb-2 w-100">
                                    <input id="returnName" type="text" class="form-control" placeholder="Retrun Name" value="" name="name" autocomplete="off"></input>
                                    <label for="returnName">Return Name</label>
                                </div>
                                <div class="form-floating mb-2 w-50">
                                    <select class="form-select form-select-md form-control" aria-label=".form-select-sm" size="1" id="returnType"
                                    name="type" onchange="showSubmitMonth(this.value)">
                                        <option selected value="Month">Per Month</option>
                                        <option value="Year">Per Year</option>
                                        <option value="FiveYear">Per Five Years</option>
                                    </select>
                                    <label for="returnType">Duration</label>
                                </div>
                                <div class="form-floating mb-2 w-50">
                                    <select class="form-select form-select-md form-control" aria-label=".form-select-sm" size="1"
                                    id="returnMonth" name="submit_month" onchange="setMaximumDays(this.value)" hidden disabled>
                                    <option value="1">January</option>
                                    <option selected value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                    </select>
                                    <label for="returnMonth" hidden>Select Month</label>
                                </div>
                                <div class="form-floating mb-2 w-50">
                                    <input type="number" id="alertDay" min="1" max="" placeholder="Alert Day" class="form-control" name="alert_day" value="5"></input>
                                    <label for="alertDay">Alert Day</label>
                                </div>
                                <div class="form-floating mb-2 w-50">
                                    <input type="number" id="submitDay" min="1" max="" placeholder="Submit Day" class="form-control" name="submit_day" value="10"></input>
                                    <label for="submitDay">Submit Day</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="submit" class="btn btn-success" value="Save"></input>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    function showSubmitMonth(value){
                        let returnMonth = document.getElementById("returnMonth");
                        if(value === "Month"){
                            returnMonth.hidden = true;
                            returnMonth.disabled = true;
                            returnMonth.nextElementSibling.hidden = true;
                            return;
                        }
                        returnMonth.hidden = false;
                        returnMonth.disabled = false;
                        returnMonth.nextElementSibling.hidden = false;
                    }
                    function setMaximumDays(val){
                        document.getElementById("alertDay").setAttribute("max", daysInMonth(val));
                        document.getElementById("submitDay").setAttribute("max", daysInMonth(val));
                    }
                    function daysInMonth(val){
                        return new Date(0, val, 0).getDate();
                    }
                </script>
            </div>
            <!-- Modal Add or Edit Return Start-->
            <script src="<?php echo base_url("js/return.js");?>"></script>
            <?= $this->include('templates/partials/footer') ?>
    </div>
</div>
<?= $this->endSection() ?>
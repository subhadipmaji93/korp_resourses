<?= $this->extend('templates/default')?>
<?= $this->section('content')?>

<div class="container-xxl position-relative bg-white d-flex p-0">
    <?= $this->include('templates/partials/sidebar', ['active'=>$active]) ?>
    <div class="content">
        <?= $this->include('templates/partials/navbar', ['username'=>$username]) ?>
        <div class="container-fluid mt-2 pt-2 px-2 w-100">
            <div class="bg-light rounded p-4">
                    <h6 class="mb-4">Client Database</h6>
                    <div class="table-responsive data-table">
                        <table class="table table-bordered">
                            <thead class="table-primary fixed-head">
                                <tr>
                                    <th scope="Col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="clientList" style="height: 300px; overflow-y: scroll;">
                            </tbody>
                        </table>
                        <button class="btn btn-primary" onclick="addClientModal()">ADD</button>
                    </div>
            </div>
        </div>
        <div class="modal" id="Modal" tabindex="-1" aria-labelledby="staticBackdropLabel" 
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Client Info</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="addClient" class="d-flex flex-column" onsubmit="addClientData(event)">
                                <div class="form-floating mb-2 w-100">
                                    <input id="clientName" type="text" class="form-control" placeholder="Name" value="" name="name" autocomplete="off" required></input>
                                    <label for="clientName">Name</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                        <input id="clientAddress" type="text" class="form-control" placeholder="Address" value="" name="address" autocomplete="off" required></input>
                                        <label for="clientAddress">Address</label>
                                </div>
                                <div class="mb-2">
                                    <label for="clientType" class="pb-2">Client Type</label>
                                    <select class="form-select form-select-md mb-2 w-50" id="clientType" name="type"
                                        aria-label=".form-select-md" onchange="showPolAdd(this.value)">
                                        <option selected value="trader">Trader</option>
                                        <option value="exporter">Exporter</option>
                                        <option value="manufacturer">Manufacturer</option>
                                    </select>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="clientGST" type="text" class="form-control" placeholder="GST" value="" name="gst" autocomplete="off" required></input>
                                    <label for="clientGST">GST</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="clientPAN" type="text" class="form-control" placeholder="PAN" value="" name="pan" autocomplete="off" required></input>
                                    <label for="clientPAN">PAN</label>
                                </div>
                                <div class="form-floating mb-2 w-100">
                                    <input id="clientCIN" type="text" class="form-control" placeholder="CIN" value="" name="cin" autocomplete="off"></input>
                                    <label for="clientCIN">CIN</label>
                                </div>
                                <div class="mb-2">
                                    <label for="clientFormD" class="form-label">FORM-D</label>
                                    <input class="form-control" type="file" id="clientFormD" name="form_d"
                                        onchange="validateFile(event)" required>
                                </div>
                                <div class="mb-2">
                                    <label for="clientIBM" class="form-label">IBM</label>
                                    <input class="form-control" type="file" id="clientIBM" name="ibm"
                                        onchange="validateFile(event)" required>
                                </div>
                                <input type="submit" class="btn btn-success w-25">
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    function showPolAdd(val){
                        const addClientForm = document.querySelector('#addClient');
                        const polRef = addClientForm.querySelector('.pol');
                        const addRef = addClientForm.querySelector('.add');

                        if(val !== 'trader'){
                            if(polRef && addRef){
                                return;
                            }

                            let pollution = document.createElement('div');
                            let addProof = document.createElement('div');

                            pollution.className = 'mb-2 pol';
                            addProof.className = 'mb-2 add';

                            pollution.innerHTML = `<label for="clientPollution" class="form-label">Pollution</label>
                                                   <input class="form-control" type="file" id="clientPollution" name="pollution"
                                                    onchange="validateFile(event)" required>
                            `;
                            addProof.innerHTML = `<label for="clientAddProof" class="form-label">Address Proof</label>
                                                  <input class="form-control" type="file" id="clientAddProof" name="address_proof"
                                                    onchange="validateFile(event)" required>
                            `;
                            addClientForm.insertBefore(pollution, addClientForm.lastElementChild);
                            addClientForm.insertBefore(addProof, addClientForm.lastElementChild);
                        } else {
                            if(polRef && addRef){
                                addClientForm.removeChild(polRef);
                                addClientForm.removeChild(addRef);
                            }
                        }
                    }
                </script>
        </div>
        <div class="modal" id="Modal2" tabindex="-1" aria-labelledby="staticBackdropLabel" 
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Client Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="viewClient" class="fs-6">
                        </form>
                        <button class="btn btn-success mt-2 px-3" onclick="editEnable(event)">Edit</button>
                        <button class="btn btn-danger mt-2 px-3" onclick="deleteClient(event)">Delete</button>
                    </div>
                </div>
            </div>
            <script>
                function editEnable(event){
                    event.preventDefault();
                    const parent = event.target.parentElement;
                    const viewClient = document.getElementById("viewClient");
                    for (let item of viewClient.children) {
                        if(item.dataset.ignore === "true") continue;
                        item.innerHTML += '<button type="button" class="btn-close float-end" aria-label="Close" onclick="editField(event)"></button>';
                    }
                    parent.previousElementSibling.firstElementChild.innerText = "Edit Client Info";
                    parent.removeChild(event.target.nextElementSibling);
                    parent.removeChild(event.target);

                    const saveButton = document.createElement("button");
                    saveButton.className = "btn btn-success mt-2 px-3 edit-client";
                    saveButton.innerText = "Save";
                    saveButton.addEventListener("click", editClient);
                    parent.appendChild(saveButton);
                }

                function editField(event){
                    event.preventDefault();
                    const parent = event.target.parentElement;
                    parent.className = "";
                    parent.innerHTML = "";
                    const dataSet = parent.dataset;
                    if(dataSet.input === "file"){
                        parent.className = "mb-1 mt-1";
                        parent.innerHTML = `
                                    <label for="${dataSet.id}">${dataSet.label}</label>
                                    <input id="${dataSet.id}" type="${dataSet.input}" class="form-control" placeholder="${dataSet.label}" value="" name="${dataSet.name}" autocomplete="off" onchange="validateFile(event)" required></input>
                    `;
                    } else {
                        parent.className = "form-floating mb-2 w-100";
                        parent.innerHTML = `
                                    <input id="${dataSet.id}" type="${dataSet.input}" class="form-control" placeholder="${dataSet.label}" value="" name="${dataSet.name}" autocomplete="off" required></input>
                                    <label for="${dataSet.id}">${dataSet.label}</label>
                    `;
                    }
                }
            </script>
        </div>
        <script src="<?php echo base_url("js/clientInfo.js");?>"></script>
        <?= $this->include('templates/partials/footer') ?>   
    </div>
</div>
<?= $this->endSection() ?>

const urlLocation = window.location;
const baseUrl = `${urlLocation.protocol}//${urlLocation.host}${urlLocation.pathname}`;

function addClientModal(){
    $('#Modal').modal('show');
}

function addClientData(event){
    event.preventDefault();
    let url = baseUrl + "/client";
    let formData = new FormData(event.target);
    
    fetch(url, {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest" 
        },
        body: formData
    }).then((res)=>res.json())
    .then((data)=>{
        $('#Modal').modal('hide');
        event.target.reset();
        showAlert(data);
        fetchClientList();
    });
}

function fetchClientList(){
    const clientList = document.getElementById("clientList");
    clientList.innerHTML = "";
    const url = baseUrl + "/client";

    fetch(url, {
        method:"GET",
        headers:{
            "X-Requested-With": "XMLHttpRequest" 
        }
    }).then((res)=>res.json())
    .then((clist)=>{
        let template = "";
        if(clist.length>0){
            for(const item of clist){
                let tr = document.createElement('tr');
                tr.innerHTML = `<td width="5%">${item.id}</td> 
                                <td width="30%">${item.name}</td>
                                <td width="60%">${item.address}</td>
                                <td width="5%"><button class="btn btn-primary" onclick="viewClient(event)">View</button></td>
                `;
                template += tr.outerHTML;
            }
            clientList.innerHTML = template;
        } else{
            clientList.innerHTML = "<tr><td colspan='4' class='text-center fs-2'>Nothing to show!!</td><tr>";
        }
    });
}

setTimeout(fetchClientList, 2000);

let Modal2 = document.getElementById("Modal2");
Modal2.addEventListener("hidden.bs.modal", function(event){
    event.preventDefault();
    document.getElementById("viewClient").innerHTML = "";
    const modalBody = document.getElementById("viewClient").parentElement;
    modalBody.previousElementSibling.firstElementChild.innerText = "View Client Info";
    if(modalBody.children.length !== 3){
        const saveButton = modalBody.lastElementChild;
        saveButton.removeEventListener("click", editClient);
        modalBody.removeChild(saveButton);
        modalBody.innerHTML += `
        <button class="btn btn-success mt-2 px-3" onclick="editEnable(event)">Edit</button>
        <button class="btn btn-danger mt-2 px-3" onclick="deleteClient(event)">Delete</button>
        `;
    }
});


function viewClient(event){
    event.preventDefault();
    const id = event.target.parentElement.parentElement.children[0].innerText;
    const url = baseUrl + `/client?id=${id}`;
    fetch(url, {
        method:"GET",
        headers:{
            "X-Requested-With": "XMLHttpRequest" 
        }
    }).then((res)=>res.json())
    .then((cData)=>{
        const viewClient = document.getElementById("viewClient");
        viewClient.innerHTML = `
            <input type="tconst url = baseUrlext" value="${cData.id}" hidden name="id">
            <div class="bg-light rounded p-4 mt-2 mb-2" data-ignore="true">
                Full Name: <span>${cData.full_name}</span>
            </div>
            <div class="bg-light rounded p-4 mt-2 mb-2" data-ignore="true">
                Type: <span>${cData.type}</span>
            </div>
            <div class="bg-light rounded p-4 mt-2 mb-2" data-id="clientName" data-label="Name" data-name="name" data-input="text">
                Name: <span>${cData.name}</span>
            </div>
            <div class="bg-light rounded p-4 mt-2 mb-2" data-id="clientAddress" data-label="Address" data-name="address" data-input="text">
                Address: <span>${cData.address}</span>
            </div>
            <div class="bg-light rounded p-4 mt-2 mb-2" data-id="clientGST" data-label="GST" data-name="gst" data-input="text">
                GST: <span>${cData.gst}</span>
            </div>
            <div class="bg-light rounded p-4 mt-2 mb-2" data-id="clientPAN" data-label="PAN" data-name="pan" data-input="text">
                PAN: <span>${cData.pan}</span>
            </div>
            <div class="bg-light rounded p-4 mt-2 mb-2" data-id="clientCIN" data-label="CIN" data-name="cin" data-input="text">
                CIN: <span>${cData.cin}</span>
            </div>
            <div class="bg-light rounded p-4 mt-2 mb-2" data-id="clientFormD" data-label="FORM-D" data-name="form_d" data-input="file">
                FORM-D: <i class="fas fa-file"></i> <a href="${urlLocation.protocol}//${urlLocation.host}/uploads/clients/${cData.form_d}" target="_blank" rel="noopener noreferrer">${cData.form_d}</a>
            </div>
            <div class="bg-light rounded p-4 mt-2 mb-2" data-id="clientIBM" data-label="IBM" data-name="ibm" data-input="file">
            IBM: <i class="fas fa-file"></i> <a href="${urlLocation.protocol}//${urlLocation.host}/uploads/clients/${cData.ibm}" target="_blank" rel="noopener noreferrer">${cData.ibm}</a>
            </div>
        `;
        if(cData.type !== 'trader'){
            viewClient.innerHTML +=  `
                <div class="bg-light rounded p-4 mt-2 mb-2" data-id="clientPollution" data-label="Pollution" data-name="pollution" data-input="file">
                Pollution: <i class="fas fa-file"></i> <a href="${urlLocation.protocol}//${urlLocation.host}//uploads/clients/${cData.pollution}" target="_blank" rel="noopener noreferrer">${cData.pollution}</a>
                </div>
                <div class="bg-light rounded p-4 mt-2 mb-2" data-id="clientAddProof" data-label="Address Proof" data-name="address_proof" data-input="file">
                Add Proof: <i class="fas fa-file"></i> <a href="${urlLocation.protocol}//${urlLocation.host}/uploads/clients/${cData.address_proof}" target="_blank" rel="noopener noreferrer">${cData.address_proof}</a>
                </div>
            `;
        }
        $('#Modal2').modal('show');
    });
}

function deleteClient(event){
    event.preventDefault();
    if(window.confirm("Do you really want to delete?")===false) return;
    const id = document.getElementById("viewClient").firstElementChild.value;
    const url = baseUrl + `/client`;
    fetch(url, {
        method:"DELETE",
        headers:{
            "Content-type": "application/json",
            "X-Requested-With": "XMLHttpRequest" 
        },
        body:JSON.stringify({id:id})
    }).then((res)=>res.json())
    .then((data)=>{
        $('#Modal2').modal('hide');
        showAlert(data);
        fetchClientList();
    });
}

function editClient(){
    const form = document.getElementById("viewClient");
    if(form.getElementsByTagName("input").length === 1) return;

    const formData = new FormData(form);
    formData.append('_method','PUT');
    const url = baseUrl + '/client';
    fetch(url, {
        method:"POST",
        headers:{
            "X-Requested-With": "XMLHttpRequest",
        },
        body: formData,
    }).then((res)=>res.json())
    .then((data)=>{
        $('#Modal2').modal('hide');
        showAlert(data);
    });
}

function showAlert(data){
    let container = document.getElementsByClassName("container-fluid")[0];
    if(container.firstElementChild.classList.contains("alert")){
      container.removeChild(container.firstElementChild);
    }
    let div = document.createElement("div");
    div.className = `alert alert-${data.alert} alert-dismissible fade show`;
    div.setAttribute("role", "alert");
    let ul = document.createElement("ul");
    for (const item of Object.keys(data.message)) {
      ul.innerHTML += `<li>${data.message[item]}</li>`;      
    }
    div.appendChild(ul);
    div.innerHTML += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    container.insertBefore(div, container.firstElementChild);
}


function validateFile(event){
    event.preventDefault();
    if(event.target.files.length === 0) return;
    let item = event.target.files[0];
    if(item.type === 'application/pdf' && item.size/1024<2048) return;
    else if(item.type.split('/')[0] === 'image' && item.size/1024<2048) return;
    else {
        alert("File Type must be pdf or Image and size within 2 MB");
        event.target.value = "";
    }
}
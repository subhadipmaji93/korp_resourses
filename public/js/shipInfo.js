const urlLocation = window.location;
const baseUrl = `${urlLocation.protocol}//${urlLocation.host}${urlLocation.pathname}`;

function fetchClientList(){
    const clientList = document.getElementById("clientList");
    const url = `${urlLocation.protocol}//${urlLocation.host}/client-info/client`;

    fetch(url, {
        method:"GET",
        headers:{
            "X-Requested-With": "XMLHttpRequest" 
        }
    }).then((res)=>res.json())
    .then((clist)=>{
        if(clist.length>0){
            for(const item of clist){
                clientList.innerHTML += `<option value="${item.id}">${item.name}</option>`;
            }
            clientList.hidden = false;
        }
    })
}
setTimeout(fetchClientList, 1000);

function fetchShipList(event){
    event.preventDefault();
    const clientId = event.target.value;
    const shipList = document.getElementById("shipList");
    shipList.innerHTML = "";

    const url = baseUrl + `/ship?client_id=${clientId}`;
    fetch(url, {
        method:"GET",
        headers:{
            "X-Requested-With": "XMLHttpRequest" 
        }
    }).then((res)=>res.json())
    .then((slist)=>{
        let template = "";
        if(slist.length>0){
            for(const item of slist){
                let tr = document.createElement('tr');
                tr.innerHTML = `<td width="5%">${item.id}</td> 
                                <td width="20%">${item.name}</td>
                                <td width="60%">${item.address}</td>
                                <td width="10%">${item.pincode}</td>
                                <td width="5%" class="d-flex">
                                    <button class="btn btn-primary me-1" onclick="editShipModal(event)">Edit</button>
                                    <button class="btn btn-danger" onclick="deleteShipData(event)">Delete</button>
                                </td>
                `;
                template += tr.outerHTML;
            }
            shipList.innerHTML = template;
        }else{
            shipList.innerHTML = "<tr><td colspan='5' class='text-center fs-2'>Nothing To Show!!</td><tr>"
        }
    });
}

const Modal = document.getElementById("Modal")
Modal.addEventListener("hidden.bs.modal", function(event){
    event.preventDefault();
    const form = document.getElementById("shipForm");
    form.removeChild(form.firstElementChild);
    event.target.querySelector(".modal-title").innerText = "";
    form.removeAttribute('onsubmit');
    form.reset();
});

function addShipModal(){
    const form = document.getElementById("shipForm");
    const modalTitle = Modal.querySelector(".modal-title");
    const clientListElm = document.querySelector(".client-list").cloneNode(true);
    clientListElm.querySelector('#clientList').removeAttribute('onchange');
    modalTitle.innerText = "Add Ship Info";
    form.insertBefore(clientListElm, form.firstElementChild);
    form.setAttribute('onsubmit', 'addShipData(event)');
    $('#Modal').modal('show');
}

function editShipModal(event){
    event.preventDefault();
    const form = document.getElementById("shipForm");
    const modalTitle = Modal.querySelector(".modal-title");
    const trElm = event.target.parentElement.parentElement;
    const shipIdElm = document.createElement("input");
    modalTitle.innerText = "Edit Ship Info";
    shipIdElm.hidden = true;
    shipIdElm.setAttribute("name", 'id');
    shipIdElm.value = trElm.children[0].innerText;
    form.insertBefore(shipIdElm, form.firstElementChild);
    form.querySelector("#shipName").value = trElm.children[1].innerText;
    form.querySelector("#shipAddress").value = trElm.children[2].innerText;
    form.querySelector("#shipPincode").value = trElm.children[3].innerText;
    form.setAttribute('onsubmit', 'editShipData(event)');
    $('#Modal').modal('show');
}

function addShipData(event){
    event.preventDefault();
    const url = baseUrl + "/ship";
    const formData = new FormData(event.target);
    formData.append('client_id', Modal.querySelector("#clientList").value);
    
    fetch(url, {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Content-type":"application/json"
        },
        body: JSON.stringify(Object.fromEntries(formData))
    }).then((res)=>res.json())
    .then((data)=>{
        $('#Modal').modal('hide');
        event.target.reset();
        showAlert(data);
    });
}

function editShipData(event){
    event.preventDefault();
    const formData = new FormData(event.target);
    const url = baseUrl + "/ship";

    fetch(url,{
        method: "PUT",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Content-type":"application/json"
        },
        body: JSON.stringify(Object.fromEntries(formData))
    }).then((res)=>res.json())
    .then((data)=>{
        $('#Modal').modal('hide');
        event.target.reset();
        showAlert(data);
    });
}

function deleteShipData(event){
    event.preventDefault();
    const id = event.target.parentElement.parentElement.children[0].innerText;
    const url = baseUrl + "/ship";
    
    fetch(url, {
        method: "DELETE",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Content-type":"application/json"
        },
        body: JSON.stringify({"id":id})
    }).then((res)=>res.json())
    .then((data)=>{
        showAlert(data)
        document.getElementById("shipList").removeChild(event.target.parentElement.parentElement);
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

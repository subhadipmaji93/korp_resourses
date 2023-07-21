const urlLocation = window.location;
const baseUrl = `${urlLocation.protocol}//${urlLocation.host}${urlLocation.pathname}`;

const Modal = document.getElementById("Modal");
Modal.addEventListener("hidden.bs.modal", function(event){
    event.preventDefault();
    document.getElementsByClassName("modal-title")[0].innerText = "";
    document.getElementById("parties").innerHTML = "";
    let stackForm = document.getElementById("StackForm");
    stackForm.reset();
    if(Modal.dataset.type === "add"){
        stackForm.removeEventListener("submit", addStackData);
    } else if(Modal.dataset.type === "edit"){
        stackForm.removeEventListener("submit", editStackData);
        let stackId = document.getElementById("stackId");
        stackForm.removeChild(stackId);
        editField();
    }
    Modal.removeAttribute("data-type");
});

function addStackModal(event){
    event.preventDefault();
    Modal.dataset.type = "add";
    document.getElementsByClassName("modal-title")[0].innerText = "Add Stack Info";
    document.getElementById("StackForm").addEventListener("submit", addStackData);
    $('#Modal').modal('show');
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

function fetchStackList(){
    const stackList = document.getElementById("stackList");
    stackList.innerHTML = "";
    const url = baseUrl + "/stack";

    fetch(url, {
        method:"GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    }).then((res)=>res.json())
    .then((slist)=>{
        let template = "";
        if(slist.length>0){
            for(const item of slist){
                let div = document.createElement("div");
                div.className = "col-sm-3 col-md-3 col-xl-3";
                let div2 = document.createElement("div");
                div2.className = "rounded d-flex align-items-center justify-content-center flex-column";
                let currPrcnt = (parseInt(item.current)*100)/parseInt(item.capacity);
                if(currPrcnt >= 90) div2.classList.add("bg-danger");
                else if(currPrcnt >= 70 && currPrcnt < 90) div2.classList.add("bg-warning");
                else div2.classList.add("bg-success");
                div2.style.height = '200px';
                div2.dataset.id = item.id;
                div2.innerHTML = `<div class="rounded bg-light w-75 ps-1" style="font-size: 12px;">
                                        <span>Name: ${item.name}</span><br>
                                        <span>Size: ${item.size}</span><br>
                                        <span>Grade: ${item.grade}%</span><br>
                                        <span>Capacity: ${item.capacity} TON</span><br>
                                        <span>Current: ${item.current} TON</span>
                                </div>
                                <div class="mt-2 bg-light p-2 rounded">
                                    <button class="btn btn-success" onclick="viewStackModal(event)">Edit</button>
                                    <button class="btn btn-danger" onclick="deleteStack(event)">Delete</button>
                                </div>`;
                div.appendChild(div2);
                template += div.outerHTML;
            }
            stackList.innerHTML = template;
        }else{
            stackList.innerHTML = "<p class='fs-2 text-center'>No Stack Added</p>"
        }
    });
}

setTimeout(fetchStackList, 2000);

function fetchClientList(){
    const clientList = document.getElementById("stackClientList");
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
                clientList.innerHTML += `<option value="${item.name}">${item.name}</option>`;
            }
            clientList.hidden = false;
        }
    })
}

setTimeout(fetchClientList, 1000);

function addParty(event){
    event.preventDefault();
    const client = document.getElementById("stackClientList");
    const quantity = document.getElementById("stackClientQuantity");
    if(client.value === "default" || quantity.value === "") return;
    const stackCapacity = parseFloat(document.getElementById("stackCapacity").value).toFixed(3);
    const stackCurrent = document.getElementById("stackCurrent");
    if(isNaN(stackCapacity) || Number(parseFloat(quantity.value).toFixed(3))>Number(stackCapacity)){
        alert("Can't set client's quantity value greater than Stack Capacity!!");
        return;
    }
    let stackCurrentValue = Number(parseFloat(stackCurrent.value)) + Number(parseFloat(quantity.value));
    if(Number(stackCurrentValue.toFixed(3)) > Number(stackCapacity)){
        alert("Stack Current value exceeded Stack Capacity value!!");
        return;
    }
    stackCurrent.value = stackCurrentValue.toFixed(3);
    const parties = document.getElementById("parties");
    parties.innerHTML += `<div class="bg-light rounded p-4 mt-2 mb-2">
        <span>${client.value} : ${quantity.value}</span>
        <button type="button" class="btn-close float-end" aria-label="Close" onclick="deleteParty(event)"></button>
    </div>`;
    client.value = "default";
    quantity.value = "";
}

function deleteParty(event){
    event.preventDefault();
    const stackCurrent = document.getElementById("stackCurrent");
    let quantity = parseFloat(event.target.previousElementSibling.innerText.split(":")[1].trim()).toFixed(3);
    let stackCurrentValue = Number(parseFloat(stackCurrent.value).toFixed(3)) - Number(quantity);
    stackCurrent.value = stackCurrentValue.toFixed(3);
    document.getElementById("parties").removeChild(event.target.parentElement);
}

function addStackData(event){
    event.preventDefault();
    const stackForm = document.getElementById("StackForm");
    const formData = new FormData(stackForm);
    if(document.getElementById("parties").children.length>0){
        const parties = [];

        for (let elm of document.getElementById("parties").children) {
            let val = elm.firstElementChild.innerText.split(":");
            parties.push({"name":val[0].trim(), "quantity":val[1].trim()});
        }
        formData.append("applied_for", JSON.stringify(parties));
    }
    let url = baseUrl + '/stack';

    fetch(url, {
        method:"POST",
        headers:{
            "X-Requested-With": "XMLHttpRequest"
        },
        body: formData
    }).then((res)=>res.json())
    .then((data)=>{
        $('#Modal').modal('hide');
        showAlert(data);
        fetchStackList();
    });
}

function viewStackModal(event){
    event.preventDefault();
    Modal.dataset.type = "edit";
    document.getElementsByClassName("modal-title")[0].innerText = "Edit Stack Info";
    document.getElementById("StackForm").addEventListener("submit", editStackData);
    const id = event.target.parentElement.parentElement.dataset.id;
    const url = baseUrl + `/stack?id=${id}`;
    fetch(url, {
        method:"GET",
        headers:{
            "X-Requested-With": "XMLHttpRequest"
        }
    }).then((res)=>res.json())
    .then((sData)=>{
        let stackForm = document.getElementById("StackForm");
        let stackId = document.createElement("input");
        stackId.value = sData.id;
        stackId.setAttribute("id","stackId");
        stackId.setAttribute("name", "id");
        stackId.hidden = true;
        stackForm.appendChild(stackId);
        document.getElementById("stackName").value = sData.name;
        document.getElementById("stackCapacity").value = sData.capacity;
        document.getElementById("stackCurrent").value = sData.current;
        document.getElementById("stackMSize").value = sData.size;
        document.getElementById("stackMGrade").value = sData.grade;
        document.getElementById("stackFormKGrade").value = sData.form_k_grade;
        let stackFormKDoc = document.getElementById("stackFormKDoc");
        let forEdit = document.getElementById("forEdit");
        if(sData.form_k_doc !== null){
            forEdit.removeChild(stackFormKDoc);
            forEdit.innerHTML = `Form-K :  <i class="fas fa-file"></i> <a href="${urlLocation.protocol}//${urlLocation.host}/uploads/${sData.form_k_doc}" target="_blank" rel="noopener noreferrer">${sData.form_k_doc}</a>
                                <button type="button" class="btn-close float-end" aria-label="Close" onclick="editField()"></button>`;
        }
        if(sData.applied_for !== null){
            const parties = document.getElementById("parties");
            for (let party of JSON.parse(sData.applied_for)) {
                parties.innerHTML +=  `<div class="bg-light rounded p-4 mt-2 mb-2">
                                            <span>${party.name} : ${party.quantity}</span>
                                            <button type="button" class="btn-close float-end" aria-label="Close" onclick="deleteParty(event)"></button>
                                        </div>`;
            }
        }
        $('#Modal').modal('show');
    });
}

function editField(){
    let forEdit = document.getElementById("forEdit");
    forEdit.innerHTML = ` <input class="form-control" type="file" id="stackFormKDoc" name="form_k_doc"
                            onchange="validateFile(event)">`;
}

function editStackData(event){
    event.preventDefault();
    const stackForm = document.getElementById("StackForm");
    const formData = new FormData(stackForm);
    formData.append('_method','PUT');
    if(document.getElementById("parties").children.length>0){
        const parties = [];

        for (let elm of document.getElementById("parties").children) {
            let val = elm.firstElementChild.innerText.split(":");
            parties.push({"name":val[0].trim(), "quantity":val[1].trim()});
        }
        formData.append("applied_for", JSON.stringify(parties));
    }
    let url = baseUrl + '/stack';
    fetch(url, {
        method: "POST",
        headers:{
            "X-Requested-With": "XMLHttpRequest",
        },
        body: formData,
    }).then((res)=>res.json())
    .then((data)=>{
        $('#Modal').modal('hide');
        showAlert(data);
        fetchStackList();
    });
}

function deleteStack(event){
    event.preventDefault();
    const id = event.target.parentElement.parentElement.dataset.id;
    const url = baseUrl + `/stack`;
    fetch(url, {
        method:"DELETE",
        headers:{
            "Content-type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify({id:id})
    }).then((res)=>res.json())
    .then((data)=>{
        $('#Modal').modal('hide');
        showAlert(data);
        fetchStackList();
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
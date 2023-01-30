const urlLocation = window.location;
const baseUrl = `${urlLocation.protocol}//${urlLocation.host}${urlLocation.pathname}`;

let Modal2 = document.getElementById("Modal2");
let form2 = Modal2.getElementsByTagName("form")[0];
Modal2.addEventListener("hidden.bs.modal", function(event){
  event.preventDefault();
  let returnName = Modal2.querySelector("#returnName");
  returnName.disabled = false;
  if(Modal2.dataset.type === "edit"){
    form2.removeChild(form2.children[5]);
  }
  if(Modal2.dataset.type === "new"){
    form2.removeChild(form2.children[5]);
  } 
  form2.reset();
});

function addModal2(event){
  event.preventDefault();
  Modal2.dataset.type = "new";
  let returnType = Modal2.querySelector("#returnType");
  returnType.onchange();
  Modal2.getElementsByClassName("modal-title")[0].innerText = "Add Return";
  // create initial alert submit date
  let div = document.createElement("div");
  div.className = "form-floating mb-2 w-50";
  div.innerHTML = `<input type="date" class="form-control" value="" name="submit_date" id="submitDate"></input>
                    <label for="submitDate">Initial Submit Date</label>`;
  form2.insertBefore(div, form2.children[5]);
  $('#Modal2').modal('show');
}

function editModal2(event){
  event.preventDefault();
  Modal2.dataset.type = "edit";
  let id = event.target.parentElement.dataset.id;
  let alert = event.target.parentElement.dataset.alert;
  let name = event.target.parentElement.children[0].textContent.trim();
  let type = event.target.parentElement.children[2].textContent.split(":")[1].trim();
  let month = type === "Month"? "" : event.target.parentElement.children[4].textContent.split(":")[1].trim();
  let day = type === "Month"? event.target.parentElement.children[4].textContent.split(":")[1].trim() : event.target.parentElement.children[6].textContent.split(":")[1].trim();
  
  Modal2.getElementsByClassName("modal-title")[0].innerText = "Edit Return";
  
  let returnId = document.createElement("input");
  let returnName = Modal2.querySelector("#returnName");
  let returnType = Modal2.querySelector("#returnType");
  let returnMonth = Modal2.querySelector("#returnMonth");
  let alertDay = Modal2.querySelector("#alertDay");
  let submitDay = Modal2.querySelector("#submitDay");

  returnId.hidden = true;
  returnId.value = id;
  returnName.disabled = true;
  returnName.value = name;
  returnType.value = type;
  returnMonth.value = month?month:2;
  alertDay.value = alert
  submitDay.value = day;

  form2.insertBefore(returnId, form2.children[5]);
  returnType.onchange();
  $('#Modal2').modal('show');
}

function saveReturnListData(event){
  event.preventDefault();
  let url = baseUrl + "/list";
  if(Modal2.dataset.type === "edit"){
    let name = form2[0].value;
    let id = form2.children[5].value;
    let formData = new FormData(event.target);
    formData.append('id', id);
    formData.append('name', name);
    let data = Object.fromEntries(formData);

    fetch(url, {
      method:"PUT",
      headers: {
        "Content-type": "application/json",
        "X-Requested-With": "XMLHttpRequest"
      },
      body: JSON.stringify(data)
    }).then(res=>res.json())
    .then((data)=>{
      showAlert(data);
      $('#Modal2').modal('hide');
      fetchReturnListData();
    });
  } else if(Modal2.dataset.type === "new"){
    let formData = new FormData(event.target);
    let data = Object.fromEntries(formData);

    fetch(url, {
      method:"POST",
      headers: {
        "Content-type": "application/json",
        "X-Requested-With": "XMLHttpRequest"
      },
      body: JSON.stringify(data)
    }).then(res=>res.json())
    .then((data)=>{
      showAlert(data);
      $('#Modal2').modal('hide');
      fetchReturnListData();
    });
  } 
}

function fetchReturnListData(){
  let returnList = document.getElementById("returnList");
  let url = baseUrl + "/list";

  fetch(url, {
    method:"GET",
      headers: {
        "Content-type": "application/json",
        "X-Requested-With": "XMLHttpRequest"
      },
  }).then((res)=>res.json())
  .then((rlist)=>{
    let template = "";
    if(rlist.length>0){
      for(const item of rlist){
        let div = document.createElement('div');
        div.className = "rounded";
        div.dataset.id = item.id;
        div.dataset.alert = item.alert_day;
        div.innerHTML = `<span class="px-2 fs-4"><i class="fas fa-sticky-note"></i> ${item.name}</span><br>
                          <span class="px-2"><b>Duration: </b>${item.type}</span><br>
                        `;
        if(item.submit_month){
          div.innerHTML += `<span class="px-2"><b>Month No: </b>${item.submit_month}</span><br>`;
        }
        div.innerHTML += `<span class="px-2"><b>Day No: </b>${item.submit_day}</span><br>
                          <span class="px-2"><b>Created At: </b>${item.created_at}</span><br>
                          <span class="px-2"><b>Updated At: </b>${item.updated_at}</span>
                          <input class="bg-primary rounded text-light float-end"
                          type="button" value="Edit" data-bs-toggle="modal" onclick="editModal2(event)">`;
        template += div.outerHTML;
      }
    } else {
      template += '<div class="text-center fs-4" style="height: 350px">No Items!!</div>';
    }
    returnList.classList.remove("loading");
    returnList.innerHTML = template;
  });
}

setTimeout(fetchReturnListData, 2000);

let Modal = document.getElementById('Modal');
let form = Modal.getElementsByTagName("form")[0];

Modal.addEventListener("hidden.bs.modal", function(event){
  event.preventDefault();
  form.children[5].innerHTML = "";
  Modal.querySelector("#returnSave").disabled = true;
  form.reset();
});


function fetchAlert(){
  let alertList = document.getElementById("alertList");
  if(!alertList.classList.contains("loading")){
    alertList.classList.toggle("loading");
  }
  let url = baseUrl + "/alert";

  fetch(url, {
    method:"GET",
    headers: {
      "Content-type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    },
  }).then(resp=>resp.json())
  .then((rlist)=>{
    let template = "";
      if(rlist.length>0){
        for (const item of rlist) {
          let div = document.createElement('div');
          div.className = "rounded";
          div.style.height = "100px";
          div.dataset.id = item.id;
          div.innerHTML = `<span  class="px-2 fs-4"><i class="fas fa-sticky-note"></i> ${item.name}</span><br>
                          <span class="px-2"><b>Submit Date: </b> ${item.submit_date}</span><br>
                          <input class="bg-primary rounded text-light float-end mt-2"
                                    type="button" value="Upload" data-bs-toggle="modal" onclick="uploadAlertData(event)">
                          `;
          template += div.outerHTML;
        }
      } else {
        template += '<div class="text-center fs-4">No Alerts!!</div>';
      }
      alertList.classList.toggle("loading");
      alertList.innerHTML = template;
  });
}

setTimeout(fetchAlert, 2000);

function uploadAlertData(event){
  event.preventDefault();
  let name = event.target.parentElement.children[0].textContent.trim();
  let submitDate = event.target.parentElement.children[2].textContent.split(":")[1].trim();
  let id = event.target.parentElement.dataset.id;

  Modal.querySelector('#returnDataId').value = id;
  Modal.querySelector('#returnName').value = name;
  Modal.querySelector('#uploadType').value = 'alert';
  Modal.querySelector('#submitDate').value = submitDate;
  $('#Modal').modal('show');
}

function uploadViewData(event){
  event.preventDefault();
  let name = event.target.parentElement.children[0].textContent.trim();
  let submitDate = event.target.parentElement.children[2].textContent.split(":")[1].trim();
  let id = event.target.parentElement.dataset.id;

  Modal.querySelector('#returnDataId').value = id;
  Modal.querySelector('#returnName').value = name;
  Modal.querySelector('#uploadType').value = 'view';
  Modal.querySelector('#submitDate').value = submitDate;
  $('#Modal').modal('show');
}

function uploadReturnData(event){
  event.preventDefault();
  let url = baseUrl + "/upload";
  let formData = new FormData(event.target);
  
  fetch(url, {
    method: "POST",
    headers: {
      "X-Requested-With": "XMLHttpRequest"
    },
    body: formData
  }).then((res)=>res.json())
  .then((data)=>{
    showAlert(data);
    $('#Modal').modal('hide');
    fetchAlert();
  });
}

function fetchReturnDataList(event){
  event.preventDefault();
  let date = event.target.previousElementSibling.value;
  if(!date) return;

  let returnDataList = document.getElementById("returnDataList");
  returnDataList.innerHTML = "";
  if(!returnDataList.classList.contains("loading")){
    returnDataList.classList.add("loading");
  }
  let url = baseUrl + `/data?date=${date}`;
  fetch(url, {
    method:"GET",
    headers: {
      "X-Requested-With": "XMLHttpRequest"
    },
  }).then(resp=>resp.json())
  .then((rlist)=>{
    let template = "";
    if(rlist.length>0){
      for(const item of rlist){
        let div = document.createElement('div');
        div.className = "rounded";
        div.dataset.id = item.id;
        div.innerHTML = `<span class="px-2 fs-4"><i class="fas fa-sticky-note"></i> ${item.name}</span><br>
                          <span class="px-2"><b>Submit Date: </b>${item.submit_date}</span><br>
                          <span class="px-2"><b>Updated At: </b>${item.updated_at}</span><br>
                        `;
        if(item.file_list){
          let ul = document.createElement("ul");
          let fileList = JSON.parse(item.file_list)
          let url = `${urlLocation.protocol}//${urlLocation.host}/uploads`;
          for (const file of fileList){
            ul.innerHTML += `<li><a href="${url}/${file}" target="_blank" rel="noopener noreferrer">${file}</a></li>`;
          }
          div.innerHTML += ul.outerHTML;
        }
        div.innerHTML += `<input class="bg-primary rounded text-light float-end"
                          type="button" value="Upload" data-bs-toggle="modal" onclick="uploadViewData(event)">`;
        template += div.outerHTML;
      }
    } else {
      template += '<div class="text-center fs-4">No Data!!</div>';
    }
    returnDataList.classList.remove("loading");
    returnDataList.innerHTML = template;
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

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

function fetchClientData(event){
    event.preventDefault();
    const clientId = event.target.value;
    const url = `${urlLocation.protocol}//${urlLocation.host}/client-info/client?id=${clientId}`;
    fetchShipList(clientId);

    fetch(url, {
        method:"GET",
        headers:{
            "X-Requested-With": "XMLHttpRequest"  
        }
    }).then((res)=>res.json())
    .then((data)=>{
        document.getElementById("buyerName").value = data.full_name;
        document.getElementById("buyerAddress").value = data.address;
        document.getElementById("buyerGST").value = data.gst;
        document.getElementById("buyerCIN").value = data.cin;
    });
}

function fetchShipList(id){
    const shipList = document.getElementById("shipList");
    shipList.innerHTML = `<option selected value="default">Select</option>`;
    const url = `${urlLocation.protocol}//${urlLocation.host}/dispatch/ship-info/ship-list?client_id=${id}`;
    fetch(url, {
        method:"GET",
        headers:{
            "X-Requested-With": "XMLHttpRequest"  
        }
    }).then((res)=>res.json())
    .then((slist)=>{
        if(slist.length>0){
            for(const item of slist){
                shipList.innerHTML += `<option value="${item.id}">${item.name}</option>`;
            }
            shipList.hidden = false;
        }
    });
}

function fetchShipData(event){
    event.preventDefault();
    const url = `${urlLocation.protocol}//${urlLocation.host}/dispatch/ship-info/ship?id=${event.target.value}`;

    fetch(url, {
        method:"GET",
        headers:{
            "X-Requested-With": "XMLHttpRequest"  
        }
    }).then((res)=>res.json())
    .then((data)=>{
        document.getElementById("shipName").value = data.name;
        document.getElementById("shipAddress").value = data.address;
        document.getElementById("shipPincode").value = data.pincode;
    });
}

function calculate(event){
    event.preventDefault();

    const materialQnty = document.getElementById("materialQnty").value;
    const materialRate = document.getElementById("materialRate").value;
    if(!isDigit(materialQnty)){
        alert("Please Enter Valid Material Quanity");
        return;
    }
    if(!isDigit(materialRate)){
        alert("Please Enter Valid Material Rate");
        return;
    }
    const amount = document.getElementById("amount");
    const materialAmount = (parseFloat(materialQnty) * parseFloat(materialRate)).toFixed(2);
    amount.value = materialAmount;

    const selectGST = document.getElementById("selectGST").value;
    let GSTAmount;

    if(selectGST === "default"){
        alert("Select GST Type");
        return;
    }else{
        switch (selectGST) {
            case 'c-s':
                const cgstPrcnt = document.getElementById("cgstPrcnt").value;
                const sgstPrcnt = document.getElementById("sgstPrcnt").value;
                const cgstVal = document.getElementById("cgstVal");
                const sgstVal = document.getElementById("sgstVal");

                if(cgstPrcnt === "default"){alert("Please Select CGST Percentage"); return;}
                const cgstAmount = ((parseFloat(cgstPrcnt) * materialAmount)/100).toFixed(2);
                if(sgstPrcnt === "default"){alert("Please Select SGST Percentage"); return;}
                const sgstAmount = ((parseFloat(sgstPrcnt) * materialAmount)/100).toFixed(2);
                cgstVal.value = cgstAmount;
                sgstVal.value = sgstAmount;
                GSTAmount = parseFloat(cgstAmount) + parseFloat(sgstAmount);
                break;
        
            case 'i':
                const igstPrcnt = document.getElementById("igstPrcnt").value;
                const igstVal = document.getElementById("igstVal");

                const igstAmount = ((parseFloat(igstPrcnt) * materialAmount)/100).toFixed(2);
                igstVal.value = igstAmount;
                GSTAmount = parseFloat(igstAmount);
                break;
        }
    }
   

    const roundOff = document.getElementById("roundOff").value ? document.getElementById("roundOff").value : 0;
    let sign, roundOffNumber;

    if(roundOff !== 0 && !isValidRoundOff(roundOff)){
        alert("Please Enter Valid Round Off Number");
        return;
    } else if(roundOff === 0){
        sign = "";
        roundOffNumber = roundOff;
    } else {
        sign = roundOff[0];
        roundOffNumber = roundOff.slice(1);
    }

    const tAmount = parseFloat(materialAmount) + parseFloat(GSTAmount);
    const isTcs = document.getElementById("addTCS").checked;
    
    const totalAmount = document.getElementById("totalAmount");

    switch (sign) {
        case "+":
            totalAmount.value = (tAmount + parseFloat(roundOffNumber)).toFixed(2); 
            break;
        case "-":
            totalAmount.value = (tAmount - parseFloat(roundOffNumber)).toFixed(2); 
            break;
        default:
            totalAmount.value = (tAmount).toFixed(2); 
            break;
    }

    const amountWord = document.getElementById("amountWord");
    if(isTcs){
        const tcsAmount = Math.round((materialAmount * 1)/100);
        document.getElementById("grandAmount").value = (parseFloat(totalAmount.value) + tcsAmount).toFixed(2);
        document.getElementById("tcsVal").value = parseFloat(tcsAmount).toFixed(2);
        amountWord.value = inWords(parseInt(document.getElementById("grandAmount").value));
    } else {
        amountWord.value = inWords(parseInt(totalAmount.value));
    }
}

function inWords(num){
    const a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
    const b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).slice(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; let str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
    return str + 'only ';
}

function isDigit(val) {
    if (/^\d+(\.\d{0,3})?$/.test(val)) {
        return true;
    } else {
        return false;
    }
}

function isValidRoundOff(val){
    if(/^[+-][0-9]+(\.\d{0,2})?$/.test(val)) return true;
    else return false;
}

function resetForm(event){
    event.preventDefault();
    const form = document.querySelector("form");
    const clientList = document.getElementById("clientList");
    const shipList = document.getElementById("shipList");
    form.reset();
    clientList.value = "default";
    shipList.innerHTML = `<option selected value="default">Select</option>`;
    document.getElementById("gst-container").innerHTML = "";
    document.getElementById("tcs-container").innerHTML = "";
    setChallanNo();
}

function gstType(event){
    event.preventDefault();
    const type = event.target.value;
    const container = document.getElementById("gst-container");
    container.innerHTML = "";
    switch (type) {
        case 'c-s':
            template = `<div class="mb-2 w-100 d-flex">
                <div class="mb-2 w-25 pe-2 align-self-center">
                    <label for="cgstPrcnt">CGST(%):</label>
                    <select id="cgstPrcnt" class="form-select-md" name="cgstPrcnt" required>
                       <option selected value="default">Select</option>
                       <option value="0.500">0.500</option>
                       <option value="0.750">0.750</option>
                       <option value="3.750">3.750</option>
                       <option value="0">0</option>
                       <option value="2.500">2.500</option>
                       <option value="6">6</option>
                       <option value="9">9</option>
                       <option value="14">14</option>
                       <option value="1.500">1.500</option>
                       <option value="0.050">0.050</option>
                       <option value="0.125">0.125</option>
                       <option value="3">3</option> 
                    </select>
                </div>
                <div class="form-floating mb-2 w-75">
                    <input id="cgstVal" type="text" placeholder="Value:" class="form-control" value="" name="cgstVal" pattern="^\\d*(\\.\\d{0,2})?$" autocomplete="off" required></input>
                    <label for="cgstVal">Value:</label>
                </div>
            </div>
            <div class="mb-2 w-100 d-flex">
                <div class="mb-2 w-25 pe-2 align-self-center">
                    <label for="sgstPrcnt">SGST(%):</label>
                    <select id="sgstPrcnt" class="form-select-md" name="sgstPrcnt" required>
                        <option selected value="default">Select</option>
                        <option value="0.500">0.500</option>
                        <option value="0.750">0.750</option>
                        <option value="3.750">3.750</option>
                        <option value="0">0</option>
                        <option value="2.500">2.500</option>
                        <option value="6">6</option>
                        <option value="9">9</option>
                        <option value="14">14</option>
                        <option value="1.500">1.500</option>
                        <option value="0.050">0.050</option>
                        <option value="0.125">0.125</option>
                        <option value="3">3</option> 
                    </select>
                </div>
                <div class="form-floating mb-2 w-75">
                    <input id="sgstVal" type="text" placeholder="Value:" class="form-control" value="" name="sgstVal" pattern="^\\d*(\\.\\d{0,2})?$" autocomplete="off" required></input>
                    <label for="sgstVal">Value:</label>
                </div>
            </div>`;
            container.innerHTML = template;
            break;
    
        case 'i':
            template = `<div class="mb-2 w-100 d-flex">
                <div class="mb-2 w-25 pe-2 align-self-center">
                    <label for="igstPrcnt">IGST(%):</label>
                    <select id="igstPrcnt" class="form-select-md" name="igstPrcnt" required>
                        <option selected value="default">Select</option>
                        <option value="1">1</option>
                        <option value="1.500">1.500</option>
                        <option value="7.500">7.500</option>
                        <option value="0">0</option>
                        <option value="5">5</option>
                        <option value="12">12</option>
                        <option value="18">18</option>
                        <option value="28">28</option>
                        <option value="3">3</option>
                        <option value="0.100">0.100</option>
                        <option value="0.250">0.250</option>
                        <option value="6">6</option>
                    </select>
                </div>
                <div class="form-floating mb-2 w-75">
                    <input id="igstVal" type="text" placeholder="Value:" class="form-control" value="" name="igstVal" pattern="^\\d*(\\.\\d{0,2})?$" autocomplete="off" required></input>
                    <label for="igstVal">Value:</label>
                </div>
            </div>`;
            container.innerHTML = template;
            break;
    }
}

function addTcs(event){
    event.preventDefault();
    const container = document.getElementById("tcs-container");
    const isChecked = event.target.checked;
    if(isChecked){
        container.innerHTML = ` <div class="mb-2 w-100 d-flex">
            <div class="form-floating mb-2 w-75 pe-2">
                <input id="grandAmount" type="text" placeholder="Grand Total Amount:" class="form-control" value="" name="grandAmount" pattern="^\\d*(\\.\\d{0,2})?$" autocomplete="off" required></input>
                <label for="grandAmount">Grand Total Amount:</label>    
            </div>
            <div class="form-floating mb-2 w-25">
                <input id="tcsVal" type="text" placeholder="TCS:" class="form-control" value="" name="tcsVal" pattern="^\\d*(\\.\\d{0,2})?$" autocomplete="off" required></input>
                <label for="tcsVal">TCS:</label>    
            </div>
        </div>`;
    } else {
        container.innerHTML = "";
    }
}

function challanFinanceYear(){
    const currentTime = new Date(Date.now());
    let challanFinanceYear = "";
    if(currentTime.getMonth()<=2){
        challanFinanceYear = `${(currentTime.getFullYear()-1).toString().slice(2)}-${currentTime.getFullYear().toString().slice(2)}`;
    } else {
        challanFinanceYear = `${currentTime.getFullYear().toString().slice(2)}-${(currentTime.getFullYear()+1).toString().slice(2)}`;
    }
   return `${challanFinanceYear}/${currentTime.getFullYear().toString().slice(2)}/`;
};


function setChallanId(){
    const challanNo = document.getElementById("challanNo").value;
    const id = challanNo.split("/")[2];
    if(id) localStorage.setItem("cNo", id);
    else return;
}

function getChallanId(){
    const challanId = localStorage.getItem("cNo");
    return challanId?parseInt(challanId)+1:'';
}

function setChallanNo(){
    const challanNo = challanFinanceYear()+getChallanId();
    document.getElementById("challanNo").value = challanNo;
}

setChallanNo();
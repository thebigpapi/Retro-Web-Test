if(readfile = document.getElementById('bulk-upload-btn'))
    readfile.addEventListener("click", bulkUploadPrep);
let manufArray = {};
function setMsg(msg){
    if(label = document.getElementById('bios-form-label'))
        label.innerHTML = msg;
}
function getManufacturers(){
    
}
function bulkUploadPrep(){
    let url = window.location.origin + "/dashboard/getbiosmanufacturers";
    let xhr = new XMLHttpRequest()
    xhr.open('GET', url, true)
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
    xhr.send();
    setMsg("Please wait ...");
    xhr.onload = function () {
        if(xhr.status === 200) {
            manufArray = JSON.parse(xhr.responseText);
            bulkUpload()
        }
        else{
            setMsg("Error " + xhr.status + ": " + xhr.statusText);
        }
    }
}
function bulkUpload(){
    try{
        getManufacturers();
        let add = document.getElementById('Motherboard_motherboardBios_collection').previousElementSibling;
        let bulkInput = document.getElementById('bios-bulk-upload');
        let csvInput = document.getElementById('bios-bot-input');
        let csvReader = new FileReader();
        let bioses = document.getElementsByClassName("Motherboard_motherboardBios_cssid");
        let oldBioses = [...bioses];
        let currentLength = bioses.length;
        if(bulkInput.files.length == 0){
            setMsg("Error: No BIOS files have been selected!");
            return;
        }
        for (let i = 0; i < bulkInput.files.length; i++) {
            add.click();
        }
        let newBioses = [...bioses].filter(x => !oldBioses.includes(x));
        currentLength = bioses.length;
        if(csvInput.files.length > 0){
            let csvExtension = csvInput.files[0].name.split('.').pop().toLowerCase();
            if(csvExtension != "csv"){
                setMsg("Error: not a CSV file!");
                return;
            }
            csvReader.onload=function(){
                let csv = csvToArray(csvReader.result);
                if(csv.length < 2){
                    setMsg("Error: CSV is empty or invalid!");
                    return;
                }
                for(let i = 0; i < newBioses.length; i++){
                    let found = csv.find(item => item[0].includes(bulkInput.files[i].name));
                    if(found){
                        newBioses[i].querySelector("input[id*='postString']").value = found[3].slice(1,-1);
                        newBioses[i].querySelector("input[id*='boardVersion']").value = found[4].slice(1,-1);
                        let coreVersion = found[2].slice(1,-1);
                        if(coreVersion.startsWith('v4') || coreVersion.startsWith('v6')){
                            coreVersion = coreVersion.substring(1);
                        }
                        newBioses[i].querySelector("input[id*='coreVersion']").value = coreVersion;
                        let manufacturer = found[1].slice(1,-1);
                        let select = newBioses[i].querySelector("select[id*='manufacturer_autocomplete']");
                        select.tomselect.addOption({entityId: manufArray[manufacturer], entityAsString: manufacturer});
                        select.tomselect.addItem(manufArray[manufacturer]);
                        select.tomselect.sync();
                    }
                }
                if(newBioses.length > 0){
                    if(newBioses.length < csv.length){
                        setMsg("Warning: Added only " + newBioses.length + " BIOS files [CSV: " + csv.length + ", provided files: " + newBioses.length + "]");
                    }
                    else{
                        setMsg("Added " + newBioses.length + " BIOS files");
                    }
                }
                else{
                    setMsg("Error: No BIOSes added!");
                }
            }
            csvReader.readAsText(csvInput.files[0]);
        }
        else{
            setMsg("Warning: Added " + newBioses.length + " files without CSV processing!");
        }
        for(let i = 0; i < newBioses.length; i++){
            const file = bulkInput.files[i]
            const dt = new DataTransfer();
            let bios = newBioses[i].querySelector('input[type=file]');
            let label = newBioses[i].querySelector("div[id*='romFile_file_new_file_name']");
            label.innerHTML = bulkInput.files[i].name;
            dt.items.add(file);
            bios.files = dt.files;
        }
    }
    catch(error){
        setMsg(error);
    }
}

function csvToArray(csv) {
    try{
        let rows = csv.split('\"\n');
        // remove the header, not needed
        rows = rows.slice(1);
        let result = [];
        for (const row of rows) {
            let values = row.split(',');
            // remove metadata and ROMs, not needed
            values.pop();
            values.pop();
            result.push(values);
        }
        // remove last element (empty array)
        result.pop();
        return result;
    }
    catch(error){
        setMsg(error);
    }
}
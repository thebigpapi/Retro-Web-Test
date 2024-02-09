if(readfile = document.getElementById('read-file-btn'))
    readfile.addEventListener("click", readFile);
if(readfile = document.getElementById('bulk-upload-btn'))
    readfile.addEventListener("click", bulkUpload);

function setMsg(msg){
    if(label = document.getElementById('bios-form-label'))
        label.innerHTML = msg;
}

function bulkUpload(){
    try{
        let add = document.getElementById('Motherboard_motherboardBios_collection').previousElementSibling;
        let input = document.getElementById('bios-bulk-upload');
        let bioses = document.getElementById('Motherboard_motherboardBios');
        if(!bioses){
            bioses = document.getElementById('Motherboard_motherboardBios_collection').children[0].children[0];
            if(bioses.innerHTML != "Empty"){
                bioses = document.getElementById('Motherboard_motherboardBios_collection').children[0].children[0].children[0].children[0];
            }
        }
        if(bioses.childElementCount != 0){
            setMsg("Error: BIOS section must be empty!");
            return;
        }
        if(input.files.length == 0){
            setMsg("Error: No files have been selected!");
            return;
        }
        console.log(input.files);
        let cnt = 1;
        for (let i = 0; i < input.files.length; i++) {
            add.click();
            const file = input.files[i]
            const dt = new DataTransfer();
            bios = document.getElementById('Motherboard_motherboardBios_' + cnt + '_romFile_file');
            while(!bios){
                cnt++;
                bios = document.getElementById('Motherboard_motherboardBios_' + cnt + '_romFile_file');
            }
            label = document.getElementById('Motherboard_motherboardBios_' + cnt + '_romFile_file_new_file_name');
            label.innerHTML = input.files[i].name;
            dt.items.add(file);
            bios.files = dt.files;
            cnt++;
        }
        let csvinput = document.getElementById('bios-bot-input');
        if(input.files[0]){
            readFile()
        }
    }
    catch(error){
        setMsg(error);
    }
}

function readFile(){
    try{
        let fr=new FileReader();
        let input = document.getElementById('bios-bot-input');
        fr.onload=function(){
            csv=csvToArray(fr.result);
            if(csv.length < 2){
                setMsg("Error: CSV is empty or invalid!");
                return;
            }
            processFile(csv);
        }
        if(!input.files[0]){
            setMsg("Warning: no CSV file selected!");
            return;
        }
        let extension = input.files[0].name.split('.').pop().toLowerCase();
        if(extension != "csv"){
            setMsg("Error: not a CSV file!");
            return;
        }
        if(confirm("BIOS strings are about to be changed, proceed?"))
            fr.readAsText(input.files[0]);
        else
            return;
    }
    catch(error){
        setMsg(error);
    }
}

function processFile(csv){
    try{
        let bioses = document.getElementById('Motherboard_motherboardBios');
        if(!bioses){
            bioses = document.getElementById('Motherboard_motherboardBios_collection').children[0].children[0];
            if(bioses.innerHTML == "Empty"){
                setMsg("Error: no BIOSes added!");
                return;
            }
            bioses = document.getElementById('Motherboard_motherboardBios_collection').children[0].children[0].children[0].children[0];
        }
        if(bioses.childElementCount == 0){
            setMsg("Error: no BIOSes added!");
            return;
        }
        if(bioses.childElementCount < csv.length){
            setMsg("Error: there are more BIOSes in the CSV than in the editor!\nCSV: " + csv.length + "\neditor: " + bioses.childElementCount);
            return;
        }
        let bios_cnt = bioses.childElementCount;
        let cnt = 0;
        while(bios_cnt > 0){
            //read file name
            if(file = document.getElementById("Motherboard_motherboardBios_" + cnt + "_romFile_file_new_file_name")){
                let name = file.innerHTML.split(" (")[0];
                if(name == ""){
                    if(link = document.getElementById("Motherboard_motherboardBios_" + cnt + "_romFile_file_link"))
                        name = link.getAttribute('title');
                }
                if(name != ""){
                    let found = csv.find(item => item[0].includes(name));
                    console.log(name, found);
                    if(found){
                        document.getElementById("Motherboard_motherboardBios_" + cnt + "_postString").value = found[3].slice(1,-1);
                        document.getElementById("Motherboard_motherboardBios_" + cnt + "_boardVersion").value = found[4].slice(1,-1);
                        document.getElementById("Motherboard_motherboardBios_" + cnt + "_coreVersion").value = found[2].slice(1,-1);
                        let select = document.getElementById("Motherboard_motherboardBios_" + cnt + "_manufacturer");
                        const options = Array.from(select.options);
                        const optionToSelect = options.find(item => found[1].slice(1,-1).includes(item.text));
                        select.value = optionToSelect.value;
                        select.tomselect.sync();
                    }
                }
                bios_cnt--;
            }
            cnt++;
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
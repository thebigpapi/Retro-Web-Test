let settings = {
    plugins: {
        dropdown_input: {},
    },
    render: {
        option: function (data, escape) {
            return '<div>' + escape(data.text) + '</div>';
        },
        item: function (data, escape) {
            return '<div>' + escape(data.text) + '</div>';
        },
        option_create: function (data, escape) {
            return '<div class="create">Add <strong>' + escape(data.input) + '</strong>&hellip;</div>';
        },
        no_results: function (data, escape) {
            return '<div class="no-results">No results found for "' + escape(data.input) + '"</div>';
        },
        not_loading: function (data, escape) {
            // no default content
        },
        optgroup: function (data) {
            let optgroup = document.createElement('div');
            optgroup.className = 'optgroup';
            optgroup.appendChild(data.options);
            return optgroup;
        },
        optgroup_header: function (data, escape) {
            return '<div class="optgroup-header">' + escape(data.label) + '</div>';
        },
        loading: function (data, escape) {
            return '<div class="spinner"></div>';
        },
        dropdown: function () {
            return '<div></div>';
        }
    }
};
let keywords = {
    "front": "front",
    "top": "top",
    "bottom": "bottom",
    "back": "back",
    "schema": "schema",
    "misc": "photo misc",
    "bracket": "bracket",
    "io": "photo misc",
    "schema-misc": "schema misc",
    "schema_misc": "schema misc"
};
let readimages = document.getElementById('image-bulk-upload-btn');
if(readimages){
    readimages.addEventListener("click", bulkUpload);
    let url = window.location.origin + "/dashboard/getcreditors";
    let xhr = new XMLHttpRequest()
    xhr.open('GET', url, true)
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
    xhr.send();
    xhr.onload = function () {
        if(xhr.status === 200) {
            let creditorSel = document.getElementById("image-bulk-upload-creditors");
            let creditorArray = JSON.parse(xhr.responseText);
            for(let id in Object.keys(creditorArray)){
                let opt = document.createElement('option');
                opt.value = id;
                opt.innerHTML = creditorArray[id];
                if(id == 0){
                    opt.value = "";
                    opt.innerHTML = "Type to select a creditor ...";
                }
                creditorSel.appendChild(opt);
            }
            new TomSelect('#image-bulk-upload-creditors', settings);
            creditorSel.tomselect.sync();
        }
    }

}
function setMsg(msg){
    if(label = document.getElementById('image-bulk-upload-label'))
        label.innerHTML = msg;
}
function bulkUpload(){
    //try{
        let input = document.getElementById('image-bulk-upload');
        let entity = input.getAttribute("data-entity");
        let add = document.getElementById(entity + '_collection').previousElementSibling;
        let images = document.getElementsByClassName(entity + "_cssid");
        let creditor = document.getElementById('image-bulk-upload-creditors');
        console.log(creditor)
        let inputCnt = input.files.length;
        let cnt = 0;
        let typeList = {};
        if(inputCnt == 0){
            setMsg("Error: No files have been selected!");
            return;
        }
        let msg = "Added " + inputCnt + " image" + (inputCnt == 1 ? "" : "s");
        let msgCreditor = " with no creditor";
        for(let i = 0; i < inputCnt; i++)
            add.click();
        for(let image of images){
            let count = image.getAttribute('data-id');
            let existingFile = image.querySelectorAll("img");
            let pendingFile = document.getElementById(entity + '_' + count + '_imageFile_file_new_file_name');
            if(existingFile.length < 1 && pendingFile.innerHTML == ""){
                const file = input.files[cnt]
                const dt = new DataTransfer();
                let image = document.getElementById(entity + '_' + count + '_imageFile_file');
                let label = document.getElementById(entity + '_' + count + '_imageFile_file_new_file_name');
                let sort = document.getElementById(entity + '_' + count + '_sort');
                let type = document.getElementById(entity + '_' + count + '_type');
                if(!type)
                    type = document.getElementById(entity + '_' + count + '_motherboardImageType');
                if(type){
                    if(Object.keys(typeList) == 0)
                        for(let opt of type.options){
                            if(opt.value != "")
                                typeList[opt.value] = opt.innerHTML.toLowerCase();
                        }
                    for(let word of Object.keys(keywords)){
                        if(input.files[cnt].name.toLowerCase().includes(word)){
                            for(let i of Object.keys(typeList))
                                if(typeList[i].includes(keywords[word])){
                                    type.value = i;
                                    type.tomselect.sync();
                                    break;
                                }
                        }
                    }
                }
                if(sort)
                    sort.value = 1;
                if(creditor){
                    let creditorName = creditor.options[creditor.selectedIndex].text
                    let creditorSelect = document.getElementById(entity + '_' + count + '_creditor_autocomplete');
                    creditorSelect.tomselect.addOption({entityId: creditor.value, entityAsString: creditorName});
                    creditorSelect.tomselect.addItem(creditor.value);
                    creditorSelect.tomselect.sync();
                    if(creditor.value > 0)
                        msgCreditor = " with creditor: " + creditorName;
                }
                label.innerHTML = input.files[cnt].name;
                dt.items.add(file);
                image.files = dt.files;
                cnt++;
            }
            setMsg(msg + msgCreditor);
        }
    //}
    //catch(error){
    //    setMsg(error);
    //}
}
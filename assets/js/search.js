window.paginate = paginate;
window.expand = expand;
window.remove = remove;
//initialize tom-select
var settings = {
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

const form = document.forms[0];
let static_selects = [
    "chipsetManufacturer",
    "moboManufacturer",
    "chipManufacturer",
    "cpuManufacturer",
    "hddManufacturer",
    "cddManufacturer",
    "fddManufacturer",
    "chipset",
    "cpuSocket1",
    "cpuSocket2",
    "manufacturer",
    "platform1",
    "platform2",
    "formFactor",
    "cpuSpeed",
    "type",
    "fsbSpeed",
    'cardExpansionSlot'
];

let dynamic_selects = {
    'motherboardExpansionSlots-fields-list': '_expansion_slot',
    'motherboardIoPorts-fields-list': '_io_port',
    'motherboardMemoryConnectors-fields-list': '_',
    'cardIoPorts-fields-list': '_io_port',
    'cardTypes-fields-list': '',
    'chips-fields-list': '',
    'dramTypes-fields-list': '',
    'sockets-fields-list': '',
    'osFlags-fields-list': '',
    'families-fields-list': ''
};

// init tom-selects
decodeURL();
for (let item of static_selects) {
    loadTS(item);
}

// event listeners
let search_paginate = document.getElementById('search-paginate-id');
let search_live = document.getElementById('pagination_redir');
let resetbtn = document.getElementById('rst-btn');
if (search_paginate)
    search_paginate.addEventListener("click", function () {
        paginate(search_paginate.getAttribute("data-paginate"), search_paginate.getAttribute("data-target"));
    }, false);
if (search_live)
    search_live.addEventListener("click", searchLive);
if (resetbtn)
    resetbtn.addEventListener("click", reset);

// functions
function setCookie(cName, cValue, expDays) {
    let date = new Date();
    date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
}

function getCookie(cName) {
    const name = cName + "=";
    const cDecoded = decodeURIComponent(document.cookie); //to be careful
    const cArr = cDecoded.split('; ');
    let res;
    cArr.forEach(val => {
        if (val.indexOf(name) === 0) res = val.substring(name.length);
    })
    return res;
}

function decodeURL() {
    let url = window.location.href.substring(window.location.href.indexOf("?") + 1, window.location.href.length);
    let p = url.split("&");
    let params = [];
    let split = [];
    for (const i of p) {
        split = i.split("=");
        if (split.length > 2 && split[0].includes("sign"))
            params[split[0]] = split[1] + "%3D";
        else
            params[split[0]] = split[1];
    }
    console.log(Object.keys(params));
    if(Object.keys(params).length > 1){
        updateFields(params);
        let fieldset = document.getElementById("search-fieldset");
        let dropdown = fieldset.querySelector('label[class="dropdown-header"]')
        console.log(dropdown);
        dropdown.click();
    }
}

function updateFields(params) {
    let static_fields = ["name", "capacity", "deviceId"];
    let complex_cnt = 0;
    let complex_arr = [];
    for (const [key, value] of Object.entries(params)) {
        if (key.includes("osFlagIds") ||
            key.includes("chipIds") ||
            key.includes("dramTypeIds") ||
            key.includes("cardTypeIds") ||
            key.includes("socketIds") ||
            key.includes("familyIds")
            ) {
            updateMultiSelect(key, value);
        }
        else if (key.includes("cardIoPortIds") || key.includes("expansionSlotsIds") || key.includes("ioPortsIds") || key.includes("memoryConnectorsIds")) {
            complex_cnt++;
            let first_split = key.split("Ids%5B");
            let second_split = first_split[1].split("%5D%5B");
            complex_arr[second_split[1].split("%5D")[0]] = value;
            if (complex_cnt == 3) {
                updateMultiSelectCount(first_split[0], second_split[0], complex_arr);
                complex_cnt = 0;
                complex_arr = [];
            }
        }
        else if (static_fields.includes(key))
            document.getElementById("search_" + key).value = decodeURI(value);
        else if (key.includes("Id")) {
            updateSelect(key.substring(0, key.length - 2), value);
        }
        else if (key == "itemsPerPage"){
            document.getElementById("search_itemsPerPage").value = value;
        }
        else if (key == "processNode"){
            document.getElementById("search_processNode").value = value;
        }
        else if (key == "tdp"){
            document.getElementById("search_tdp").value = value;
        }
        else {
            if (key.includes("cpuSocket") || key.includes("platform"))
                updateSelect(key, value);
            if (key == "postString") {
                document.getElementById("search_post_string").value = value;
            }
            if (key == "coreVersion") {
                document.getElementById("search_core_version").value = value;
            }
        }
    }
}

function updateMultiSelect(key, value) {
    let type = key.split("Ids%5B")
    let pos = type[1].split("%5D")[0];
    let el = type[0];
    if(el == "family")
        el = "familie";
    let add = document.getElementById(el + "s-add-id");
    add.click();
    let select = document.getElementById("search_" + el + "s_" + pos);
    if(select){
        select.value = value;
        select.tomselect.sync();
    }
}

function updateMultiSelectCount(type, pos, arr) {
    let sign = "";
    switch (arr["sign"]) {
        case "%3E%3D":
            sign = ">=";
            break;
        case "%3C%3D":
            sign = "<=";
            break;
        case "%3E":
            sign = ">";
            break;
        case "%3C":
            sign = "<";
            break;
        default:
            break;
    }
    if (type == "expansionSlots") {
        let add = document.getElementById("motherboardExpansionSlots-add-id");
        add.click();
        let select = document.getElementById("search_motherboardExpansionSlots_" + pos + "_expansion_slot");
        let box = document.getElementById("search_motherboardExpansionSlots_" + pos + "_count");
        select.value = arr["id"];
        select.tomselect.sync();
        box.value = sign + arr["count"];
    }
    else if (type == "ioPorts") {
        let add = document.getElementById("motherboardIoPorts-add-id");
        add.click();
        let select = document.getElementById("search_motherboardIoPorts_" + pos + "_io_port");
        let box = document.getElementById("search_motherboardIoPorts_" + pos + "_count");
        select.value = arr["id"];
        select.tomselect.sync();
        box.value = sign + arr["count"];
    }
    else if (type == "cardIoPort") {
        let add = document.getElementById("cardIoPorts-add-id");
        add.click();
        let select = document.getElementById("search_cardIoPorts_" + pos + "_io_port");
        let box = document.getElementById("search_cardIoPorts_" + pos + "_count");
        select.value = arr["id"];
        select.tomselect.sync();
        box.value = sign + arr["count"];
    }
    else if (type == "memoryConnectors") {
        let add = document.getElementById("motherboardMemoryConnectors-add-id");
        add.click();
        let select = document.getElementById("search_motherboardMemoryConnectors_" + pos + "_io_port");
        let box = document.getElementById("search_motherboardMemoryConnectors_" + pos + "_count");
        select.value = arr["id"];
        select.tomselect.sync();
        box.value = sign + arr["count"];
    }
    else return false;

}

function updateSelect(idx, value) {
    let val = value.toString();
    let sel = document.getElementById("search_" + idx);
    if (idx == "chipsetManufacturer" && (window.location.href.includes("motherboards") || window.location.href.includes("bios"))) {
        sel = document.getElementById("search_chipset");
        val = "0" + val;
    }
    if (idx == "biosManufacturer") {
        sel = document.getElementById("search_manufacturer");
    }
    const options = Array.from(sel.options);
    const optionToSelect = options.find(item => val == item.getAttribute("data-id"));
    sel.value = optionToSelect.value;
}

function loadTS(targetId) {
    let el = document.getElementById('search_' + targetId);
    if (el) {
        new TomSelect('#search_' + targetId, settings);
        el.tomselect.sync();
    }
}

function displayalias(idx) {
    let el = document.getElementById('cpu-alias-box-' + idx);
    if (el.getAttribute("class") == "cpu-aliases-box")
        el.setAttribute("class", "cpu-aliases-box visible");
    else
        el.setAttribute("class", "cpu-aliases-box");
}

if(form){
    form.addEventListener("keydown", (e) => {
        if (!e.repeat && e.key == "Enter") {
            e.preventDefault;
            paginate(search_paginate.getAttribute("data-paginate"), search_paginate.getAttribute("data-target"));
        }
    });
}

function paginate(newPageIdx, target) {
    var redirElem = document.getElementById('pagination_redir');
    if(validate())
        return false;
    if (redirElem) {
        redirElem.setAttribute("value", newPageIdx);
        let routeResults = document.getElementById("route-results");
        if (routeResults)
            routeResults.remove();
        window.history.replaceState({}, '', window.origin + '/' + target + '/');
        redirElem.click();
    }
    return false;
}
function validate(){
    let state = false;
    let errors = [];
    for(let elementId of Object.keys(dynamic_selects)){
        let element = document.getElementById(elementId);
        if(element){
            for(let item of element.children){
                if(item.children[0].tagName.toLowerCase() === 'input'){
                    if(item.children[0].value == ""){
                        errors[item.children[0].getAttribute('id')] = "Count cannot be empty!";
                        state = true;
                    }
                    if(isNaN(parseInt(item.children[0].value.replace(/>=|<=|>|<|=/,'')))){
                        errors[item.children[0].getAttribute('id')] = "Count input is invalid!";
                        state = true;
                    }
                }
                if(item.children[0].tagName.toLowerCase() === 'select' && item.children[0].value == ""){
                    errors[item.children[0].getAttribute('id')] = "Field cannot be empty!";
                    state = true;
                }
                if(item.children[1].tagName.toLowerCase() === 'select' && item.children[1].value == ""){
                    errors[item.children[1].getAttribute('id')] = "Field cannot be empty!";
                    state = true;
                }
            }
        }
    }
    let labels = document.getElementsByClassName('search-errors-label');
    let elements = document.getElementsByClassName('search-errors');
    while(labels.length > 0){
        labels[0].parentNode.parentNode.removeChild(labels[0].parentNode);
    }
    for (var i = 0; i < elements.length; i++) {
        elements[i].classList.remove('search-errors');
    }
    if(Object.keys(errors).length > 0){
        for(let [key, value] of Object.entries(errors)){
            let element = document.getElementById(key);
            if(element.tagName.toLowerCase() === "select"){
                element.nextElementSibling.children[0].classList.add("search-errors");
            } else{
                element.classList.add("search-errors");
            }
            let labelContainer = document.createElement('div');
            let label = document.createElement('span');
            let dud = document.createElement('div');
            label.classList.add("search-errors-label");
            label.innerHTML = value;
            labelContainer.appendChild(label);
            labelContainer.appendChild(dud);
            element.parentNode.after(labelContainer);
            console.log(label, element.parentNode)
            console.log(key, value);
        }
    }
    return state;
}

function reset() {
    for (let id of static_selects) {
        let select = document.getElementById('search_' + id);
        if (select) {
            var control = select.tomselect;
            control.clear();
        }
    }
    for (let id of Object.keys(dynamic_selects)) {
        let select = document.getElementById(id);
        if (select){
            select.innerHTML = "";
        }
    }
    let search = document.getElementById("search_liveResults");
    if (search) {
        search.innerHTML = "";
    }
}

function setResult(searchedName, searchedValue, targetId) {
    let form = document.forms[0];
    let params = new FormData();
    params.set(searchedName, searchedValue);

    (async () => {
        const rawResponse = await fetch(form.action, {
            method: 'POST',
            body: params
        });
        let parser = new DOMParser();
        let parsedResponse = parser.parseFromString(await rawResponse.text(), "text/html");
        document.getElementById(targetId).innerHTML = parsedResponse.getElementById(targetId).innerHTML;
        document.getElementById(targetId).scrollIntoView({ behavior: "smooth" });
    })();
}

function searchLive() {
    let form = document.forms[0];
    let url = {};
    const formData = new URLSearchParams();
    for (const pair of new FormData(form)) {
        if (pair[1]){
            url[pair[0].substring(7, pair[0].length - 1)] = pair[1];
        }
        formData.append(pair[0], pair[1]);
    }
    var redirElem = document.getElementById('pagination_redir');
    var targetId = redirElem.getAttribute("data-results-id");
    if (redirElem) {
        formData.append("page", redirElem.getAttribute("value"));
    } else {
        formData.append("page", 1);
    }
    formData.append("domTarget", targetId);
    document.getElementById(targetId).innerHTML = "Loading results...";

    (async () => {
        const rawResponse = await fetch(form.getAttribute('data-live-action'), {
            method: 'POST',
            body: formData
        });
        let parser = new DOMParser();
        let parsedResponse = parser.parseFromString(await rawResponse.text(), "text/html");
        let responseDiv = parsedResponse.getElementById(targetId);
        let resultDiv = document.getElementById(targetId);
        if (responseDiv) {
            resultDiv.innerHTML = responseDiv.innerHTML;
            let string = document.getElementById('search-params-id');
            window.history.replaceState({}, '', string.firstChild.data);
            const lightbox = GLightbox({});
            getDates();
        } else {
            resultDiv.innerHTML = "Critical error while fetching results:<br>" + parsedResponse.title;
        }
        resultDiv.scrollIntoView({ behavior: "smooth" });
    })();
}

function expand(idx) {
    let list = document.getElementById(idx);
    //store the table widget DOM in list and newWidget, increment the counter
    let counter = list.getAttribute("data-widget-counter");
    let newWidget = list.getAttribute("data-prototype");
    newWidget = newWidget.replace(/__name__/g, counter).replace("/>", ">");
    counter++;
    //set the new increment, create the new widget and concatenate after list
    list.setAttribute("data-widget-counter", counter);
    let newElem = document.createElement('div');
    newElem.setAttribute("class", "editor-row");
    newElem.innerHTML = newWidget;
    list.appendChild(newElem);
    //tom-select
    if (Object.keys(dynamic_selects).includes(idx)){
        let el = document.getElementById('search_' + idx.substring(0, idx.length - 12) + '_' + (counter - 1) + dynamic_selects[idx]);
        new TomSelect('#search_' + idx.substring(0, idx.length - 12) + '_' + (counter - 1) + dynamic_selects[idx], settings);
        el.tomselect.sync();
    }
}

function remove(el) {
    var element = el.parentNode;
    element.remove();
}

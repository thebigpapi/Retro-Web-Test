const ioPortsListened = [];
let miscSpecsListCounter = 0;
let miscSpecsTableListCounter = 0;
let miscSpecsJson = [];
let miscSpecsIds = [];
let miscSpecsTableIds = {};

if (ioPorts = document.getElementById('ExpansionCard_ioPorts')?.children) {
    const ioPortsArray = getElementIdsFromIoPorts(ioPorts);
    ioPortsArray.map(ioPort => addListenersToIoPortForm(ioPort));
    ioPortsListened.push(...ioPortsArray);
}

if (ioPortsBtn = document.getElementById('ExpansionCard_ioPorts_collection')?.previousElementSibling) {
    ioPortsBtn.addEventListener('click', () => {
        setTimeout(() => { //Ensures it's executed after EA's action
            let ioPorts = document.getElementById('ExpansionCard_ioPorts')?.children;
            if (!ioPorts)
                ioPorts = document.getElementById('ExpansionCard_ioPorts_collection').children[0].children[0].children[0].children[0]?.children;
            for (let ioPort of getElementIdsFromIoPorts(ioPorts)) {
                if (ioPortsListened.includes(ioPort)) {
                    continue;
                }
                addListenersToIoPortForm(ioPort);
                ioPortsListened.push(ioPort);
            }
        })
    })
}

if (miscSpecs = document.getElementById('ExpansionCard_miscSpecs')) {
    const listElement = document.getElementById('specs-collection');
    if(saveretbtn = document.getElementById("js-save"))
        saveretbtn.addEventListener('click', () => submit(miscSpecs, "action-saveAndReturn"), false);
    if(savecontbtn = document.getElementById("js-save-continue"))
        savecontbtn.addEventListener('click', () => submit(miscSpecs, "action-saveAndContinue"), false);
    if(update_btn = document.getElementById("update-specs-btn"))
        update_btn.addEventListener('click', () => saveAsJson(miscSpecs));
    if(template_btn = document.getElementById("set-template-btn"))
        template_btn.addEventListener('click', () => applyTemplate(miscSpecs));
    if(item_btn = document.getElementById("specs-add-item-btn"))
        item_btn.addEventListener('click', () => addSpec(listElement));
    if(table_btn = document.getElementById("specs-add-table-btn"))
        table_btn.addEventListener('click', () => addTable(listElement));
    setupForm(listElement, false);
}
function submit(el, name){
    saveAsJson(el);
    let save = document.getElementsByClassName(name)[0];
    save.click();
}
function setMsg(msg){
    if(label = document.getElementById('specs-form-label'))
        label.innerHTML = msg;
}
//ExpansionCard_miscSpecs_table_collection_0
function setupForm(listElement, clear) {
    if(clear){
        listElement.innerHTML = "";
    }
    miscSpecsJson = JSON.parse(miscSpecs.value);
    if (miscSpecsJson.length === 0) {
        miscSpecsJson = {};
        return false;
    }
    for (const key of Object.keys(miscSpecsJson)) {
        if (typeof miscSpecsJson[key] === "object") {
            addTable(listElement, key, miscSpecsJson[key]);
        } else {
            addSpec(listElement, key, miscSpecsJson[key]);
        }
    }
    return true;
}
function addSpec(listElement, key = null, value = null) {
    document.getElementById('ExpansionCard_miscSpecs_emptybadge').innerHTML = "";
    const elementId = miscSpecsListCounter;
    miscSpecsIds.push(elementId);
    miscSpecsListCounter++;
    const element = document.createElement("div");
    let specsHtml = document.getElementById('specs-template-item').innerHTML.replace(new RegExp('{id}', 'gi'), elementId);
    element.innerHTML = specsHtml;
    listElement.appendChild(element);
    if (key) {
        document.getElementById(`ExpansionCard_miscSpecs_${elementId}_key`).value = key;
        document.getElementById(`ExpansionCard_miscSpecs_${elementId}_value`).value = value;

    }
    const deleteBtn = document.getElementById(`ExpansionCard_miscSpecs_${elementId}_deletebtn`);
    deleteBtn.addEventListener('click', () => {
        miscSpecsIds.splice(miscSpecsIds.indexOf(elementId), 1);
        const element = document.getElementById(`ExpansionCard_miscSpecs_${elementId}-contents`);
        element.parentNode.parentNode.remove();
    });

}

async function addTable(listElement, key=null, values = null) {
    document.getElementById('ExpansionCard_miscSpecs_emptybadge').innerHTML = "";
    const elementId = miscSpecsTableListCounter;
    miscSpecsTableIds[elementId]={counter:0,ids:[]};
    miscSpecsTableListCounter++;
    const element = document.createElement("div");
    let specsHtml = document.getElementById('specs-template-table').innerHTML.replace(new RegExp('{id}', 'gi'), elementId);
    element.innerHTML = specsHtml;
    listElement.appendChild(element);
    const elementContainer = document.getElementById("specs-table-collection-" + elementId);

    const addBtn = document.getElementById(`ExpansionCard_miscSpecs_table_${elementId}_addbtn`);
    addBtn.addEventListener('click', () => addTableSpec(elementContainer, elementId));

    if (key) {
        document.getElementById(`ExpansionCard_miscSpecs_table_${elementId}_name`).value = key;
        if (values)
            for (const subKey of Object.keys(values))
                addTableSpec(elementContainer, elementId, subKey, values[subKey]);
    }

    const deleteBtn = document.getElementById(`ExpansionCard_miscSpecs_table_${elementId}_deletebtn`);
    deleteBtn.addEventListener('click', () => {
        delete miscSpecsTableIds[elementId];
        const element = document.getElementById(`ExpansionCard_miscSpecs_table_${elementId}-contents`);
        element.parentNode.parentNode.remove();
    });
}


async function addTableSpec(listElement, tableId, key = null, value = null) {

    console.log("addTableSpec" + tableId, listElement);
    document.getElementById('ExpansionCard_miscSpecs_emptybadge_' + tableId).innerHTML = "";
    const elementId = miscSpecsTableIds[tableId]['counter'];
    miscSpecsTableIds[tableId]['ids'].push(elementId);
    miscSpecsTableIds[tableId]['counter']++;
    const element = document.createElement("div");
    let specsHtml = document.getElementById('specs-template-table-item').innerHTML.replace(new RegExp('{id1}', 'gi'), tableId).replace(new RegExp('{id2}', 'gi'), elementId);
    element.innerHTML = specsHtml;
    listElement.appendChild(element);
    if (key) {
        document.getElementById(`ExpansionCard_miscSpecs_table_${tableId}_${elementId}_key`).value = key;
        document.getElementById(`ExpansionCard_miscSpecs_table_${tableId}_${elementId}_value`).value = value;

    }
    const deleteBtn = document.getElementById(`ExpansionCard_miscSpecs_table_${tableId}_${elementId}_deletebtn`);
    deleteBtn.addEventListener('click', () => {
        miscSpecsTableIds[tableId]['ids'].splice(miscSpecsTableIds[tableId]['ids'].indexOf(elementId), 1);
        const element = document.getElementById(`ExpansionCard_miscSpecs_table_${tableId}_${elementId}-contents`);
        element.parentNode.parentNode.remove();
    });

}

async function applyTemplate(miscSpecs) {
    const listElement = document.getElementById('specs-collection');
    
    let typeCollection = document.getElementById('ExpansionCard_type_collection').children[0].children[0];
    if(typeCollection.innerHTML == "Empty"){
        setMsg("No card types are present!");
        return;
    }
    const typeList = Array.from(typeCollection.children[0].children);
    const types = [];
    for (const typeElement of typeList) {
        types.push(typeElement.children[0].children[0].children[0].children[0].children[0].value);
    }

    const url = `${window.location.origin}/dashboard/getexpansioncardtemplate?ids=${JSON.stringify(types)}`;

    fetch(url, { cache: "force-cache" })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error: ${response.status}`)
            }
            return response.text();
        })
        .then((text) => {
            const obj = JSON.parse(text);
            miscSpecs.textContent = JSON.stringify(obj, null, 4);
            setupForm(listElement, true);
            setMsg("Applied template with " + Object.keys(obj).length + " specs");
        })
        .catch((error) => {
            console.log(`Could not fetch template : ${error}`);
        });
}
function saveAsJson(miscSpecs) {
    console.log("saveAsJson");
    const jsonMap = {};
    console.log(miscSpecsIds);
    let msg = "Set ";
    let spec_cnt = 0, table_cnt = 0;
    for (const id of miscSpecsIds) {
        const key = document.getElementById(`ExpansionCard_miscSpecs_${id}_key`)?.value;
        let value = document.getElementById(`ExpansionCard_miscSpecs_${id}_value`)?.value;
        if (key) {
            jsonMap[key]=value;
            spec_cnt++;
        }
    }
    for (const id of Object.keys(miscSpecsTableIds)) {
        const tableName = document.getElementById(`ExpansionCard_miscSpecs_table_${id}_name`)?.value;
        if (tableName && miscSpecsTableIds[id]['ids'].length) {
            const subObject = {};
            for (const subId of miscSpecsTableIds[id]['ids']) {
                const key = document.getElementById(`ExpansionCard_miscSpecs_table_${id}_${subId}_key`)?.value;
                let value = document.getElementById(`ExpansionCard_miscSpecs_table_${id}_${subId}_value`)?.value;
                if (key) {
                    subObject[key]=value;
                    spec_cnt++;
                }
            }
            jsonMap[tableName] = subObject;
            table_cnt++;
        }
        //console.log(tableName);
    }
    if(spec_cnt > 0){
        msg += spec_cnt + " spec";
        if(spec_cnt > 1)
            msg += "s";
    }
    if(table_cnt > 0){
        if(spec_cnt > 0){
            msg += " and";
        }
        msg += " " +  table_cnt + " table";
        if(table_cnt > 1)
            msg += "s";
    }
    miscSpecs.textContent = JSON.stringify(jsonMap, null, 4);
    setMsg(msg);
}

/* I/O port stuff from here downwards */

function addListenersToIoPortForm(ioPortId) {
    const ioPortInterfaceSignalSelect = document.getElementById(ioPortId + '_ioPortInterfaceSignal');
    //const ioPortInterfaceSelect = document.getElementById(ioPortId + '_ioPortInterface');
    //const ioPortSignalsSelect = document.getElementById(ioPortId + '_ioPortSignals');
    ioPortInterfaceSignalSelect.addEventListener('change', event => ioPortInterfaceSignalChange(event, ioPortId));
}

function ioPortInterfaceSignalChange(event, ioPortId) {
    const url = `${window.location.origin}/dashboard/getioports/${event.target.value}`;

    fetch(url, { cache: "force-cache" })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error: ${response.status}`)
            }
            return response.text();
        })
        .then((text) => {
            const res = JSON.parse(text);
            const intefaceId = res[0].interface;
            const signalIds = res[0].signal

            const ioPortInterfaceSelect = document.getElementById(ioPortId + '_ioPortInterface');
            const ioPortSignalsSelect = document.getElementById(ioPortId + '_ioPortSignals');

            ioPortInterfaceSelect.value = intefaceId;
            Array.from(ioPortSignalsSelect.options).forEach(function (option) {
                if (signalIds.includes(parseInt(option.value))) {
                    option.selected = true;
                } else {
                    option.selected = false;
                }
            });
            ioPortInterfaceSelect.tomselect.sync();
            ioPortSignalsSelect.tomselect.sync();
        })
        .catch((error) => {
            console.log(`Could not fetch ioport : ${error}`);
        });
}

/**
 * 
 * @param {HTMLCollection} ioPorts 
 * @returns {string[]}
 */
function getElementIdsFromIoPorts(ioPorts) {
    return [].slice.call(ioPorts).map(port => port.children[0].children[0].id.replace('-contents', ''));
}
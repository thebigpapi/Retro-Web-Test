const ioPortsListened = [];
let miscSpecsListCounter = 0;
let miscSpecsJson = [];
let miscSpecsIds = [];

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
    if(saveretbtn = document.getElementById("js-save")){
        saveretbtn.addEventListener('click', function(event){
            submit(miscSpecs, "action-saveAndReturn");
        }, false);
    }
    if(savecontbtn = document.getElementById("js-save-continue")){
        savecontbtn.addEventListener('click', function(event){
            submit(miscSpecs, "action-saveAndContinue");
        }, false);
    }
    setupMiscSpecsForm(true);
}
function setMsg(msg){
    if(label = document.getElementById('set-template-label'))
        label.innerHTML = msg;
}

function setupMiscSpecsForm(firstRun = false) {
    const update_btn = document.getElementById("update-specs-btn");
    const template_btn = document.getElementById("set-template-btn");
    let container = document.getElementById("formatted-specs");

    if (!firstRun) {
        container.children[0].remove();
    }

    miscSpecsJson = JSON.parse(miscSpecs.value);

    if (miscSpecsJson.length === 0) {
        miscSpecsJson = {};
    }
    addMiscSpecsForm(container).then((form) => {
        for (const key of Object.keys(miscSpecsJson)) {
            addMiscSpecsFormElement(form, key, miscSpecsJson[key]);
        }
        if (firstRun) {
            update_btn.addEventListener('click', () => saveMiscSpecsAsJson(miscSpecs));
            template_btn.addEventListener('click', () => applyTemplate(miscSpecs));
        }
    });
}

function submit(el, name){
    saveMiscSpecsAsJson(el);
    let save = document.getElementsByClassName(name)[0];
    save.click();
}

function saveMiscSpecsAsJson(miscSpecs) {
    const jsonMap = {};
    for (const id of miscSpecsIds) {
        const key = document.getElementById(`ExpansionCard_miscSpecs_${id}_key`).value;
        const value = document.getElementById(`ExpansionCard_miscSpecs_${id}_value`).value;
        console.log(key, value);
        if (key) {
            jsonMap[key]=value;
        }
    }
    miscSpecs.textContent = JSON.stringify(jsonMap, null, 4);
    setMsg("Set " + Object.keys(jsonMap).length + " specs");
}

async function applyTemplate(miscSpecs) {
    const typeList = Array.from(document.getElementById('ExpansionCard_type_collection').children[0].children[0].children[0].children);
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
            miscSpecsIds = [];
            setupMiscSpecsForm();
            setMsg("Aplied template with " + Object.keys(obj).length + " specs");
        })
        .catch((error) => {
            console.log(`Could not fetch template : ${error}`);
        });
}


async function addMiscSpecsForm(miscSpecsParent) {
    let form = document.createElement("div");
    form.classList.add("form-widget");


    const resp = await fetch("build/html/jsonKeyValueForm.html", { cache: "force-cache" });
    const html = await resp.text();
    form.innerHTML = html;

    const button = form.getElementsByTagName('button')[0];
    button.addEventListener('click', () => addMiscSpecsFormElement(form));
    miscSpecsParent.appendChild(form)
    return form;
}

async function addMiscSpecsFormElement(form, key = null, value = null) {
    const listElement = form.querySelectorAll('[data-empty-collection]')[0];

    const elementId = miscSpecsListCounter;
    miscSpecsIds.push(elementId);
    miscSpecsListCounter++;
    //Creating the element
    const element = document.createElement("div");
    element.classList.add(["field-collection-item", "field-collection-item-complex", "field-collection-item-first", "field-collection-item-last"])
    const resp = await fetch("build/html/jsonKeyValueFormElement.html", { cache: "force-cache" });
    const html = (await resp.text()).replace(new RegExp('{id}', 'gi'), elementId);
    element.innerHTML = html;

    //Adding the element to the html
    listElement.appendChild(element);
    if (key) {
        document.getElementById(`ExpansionCard_miscSpecs_${elementId}_key`).value = key;
        document.getElementById(`ExpansionCard_miscSpecs_${elementId}_value`).value = value;

    }

    const deleteBtn = document.getElementById(`ExpansionCard_miscSpecs_${elementId}_deletebtn`);
    deleteBtn.addEventListener('click', () => deleteMiscSpecsFormElement(elementId));

}

function deleteMiscSpecsFormElement(id) {
    miscSpecsIds.splice(miscSpecsIds.indexOf(id), 1);
    const element = document.getElementById(`ExpansionCard_miscSpecs_${id}-contents`);
    element.parentNode.parentNode.remove();
}

/* I/O port stuff from here downwards */

function addListenersToIoPortForm(ioPortId) {
    const ioPortInterfaceSignalSelect = document.getElementById(ioPortId + '_ioPortInterfaceSignal');
    const ioPortInterfaceSelect = document.getElementById(ioPortId + '_ioPortInterface');
    const ioPortSignalsSelect = document.getElementById(ioPortId + '_ioPortSignals');

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
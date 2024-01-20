/** Keeps track of which elements already have element listeners and which don't
 *  @type {string[]}
 */
const ioPortsListened = [];
let miscSpecsListCounter = 0;
let miscSpecsJson = [];

/** Keeps track of which misc specs are in the form
 *  @type {number[]}
 */
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
    //miscSpecs.parentNode.hidden = true;
    miscSpecsJson = JSON.parse(miscSpecs.value);
    addMiscSpecsForm(miscSpecs.parentNode.parentNode).then((form) => {
        for (const valueObj of miscSpecsJson) {
            addMiscSpecsFormElement(form, valueObj);
        }

        Array.from(document.getElementsByClassName('action-save')).map(
            saveButton => {
                saveButton.addEventListener('mouseenter', () => saveMiscSpecsAsJson(miscSpecs));
                saveButton.addEventListener('click', () => cleanUp(form))
            });
    });
}

function saveMiscSpecsAsJson(miscSpecs, form) {
    const jsonList = [];
    for (const id of miscSpecsIds) {
        const key = document.getElementById(`ExpansionCard_miscSpecs_${id}_key`).value;
        const value = document.getElementById(`ExpansionCard_miscSpecs_${id}_value`).value;
        if (key && value) {
            let obj = {};
            obj[key] = value;
            jsonList.push(obj);
            console.log(obj);
        }
    }
    console.log(JSON.stringify(jsonList));
    miscSpecs.textContent = JSON.stringify(jsonList);
    const event = new Event('change', { bubbles: true});
    miscSpecs.dispatchEvent(event);
    //console.log(test);
}

function cleanUp(form) {
    form.remove();
}

/**
 * 
 * @param {ParentNode} miscSpecsParent 
 * @returns {Promise<HTMLDivElement>}
 */
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

/**
 * 
 * @param {HTMLDivElement} form 
 */
async function addMiscSpecsFormElement(form, valueObj = null) {
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

    if (valueObj) {
        const objKey = Object.keys(valueObj)[0];
        document.getElementById(`ExpansionCard_miscSpecs_${elementId}_key`).value = objKey;
        document.getElementById(`ExpansionCard_miscSpecs_${elementId}_value`).value = valueObj[objKey];

    }

    const deleteBtn = document.getElementById(`ExpansionCard_miscSpecs_${elementId}_deletebtn`);
    deleteBtn.addEventListener('click', () => deleteMiscSpecsFormElement(elementId));

}

/**
 * 
 * @param {number} id 
 */
function deleteMiscSpecsFormElement(id) {
    miscSpecsIds.splice(miscSpecsIds.indexOf(id), 1);
    const element = document.getElementById(`ExpansionCard_miscSpecs_${id}-contents`);
    element.parentNode.parentNode.remove();
}

/**
 * Adds all the necessary listeners to a given io port form
 * @param {string} ioPortId 
 */
function addListenersToIoPortForm(ioPortId) {
    const ioPortInterfaceSignalSelect = document.getElementById(ioPortId + '_ioPortInterfaceSignal');
    const ioPortInterfaceSelect = document.getElementById(ioPortId + '_ioPortInterface');
    const ioPortSignalsSelect = document.getElementById(ioPortId + '_ioPortSignals');

    ioPortInterfaceSignalSelect.addEventListener('change', event => ioPortInterfaceSignalChange(event, ioPortId));
}

/**
 * Updates the connector and signal based on what ioPort the user selected
 * @param {Event} event 
 * @param {string} ioPortId 
 */
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
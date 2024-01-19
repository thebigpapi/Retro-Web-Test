/** Keeps track of which elements already have element listeners and which don't
 *  @type {string[]}
 */
const ioPortsListened = [];

if (ioPorts = document.getElementById('ExpansionCard_ioPorts')?.children) {
    const ioPortsArray = getElementIdsFromIoPorts(ioPorts);
    ioPortsArray.map(ioPort => addListenersToIoPortForm(ioPort));
    ioPortsListened.push(...ioPortsArray);

}

if (ioPortsBtn = document.getElementById('ExpansionCard_ioPorts_collection')?.previousElementSibling) {
    ioPortsBtn.addEventListener('click', () => {
        setTimeout(() => { //Ensures it's executed after EA's action
            let ioPorts = document.getElementById('ExpansionCard_ioPorts')?.children;
            if(!ioPorts)
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
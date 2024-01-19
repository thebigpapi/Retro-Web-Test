//Keep track of which elements already have element listeners and which don't
/** @type {string[]}*/
const ioPortsListened = [];

if (ioPorts = document.getElementById('ExpansionCard_ioPorts')?.children) {
    const ioPortsArray = getElementIdsFromIoPorts(ioPorts);
    ioPortsArray.map(ioPort => addListenersToIoPortForm(ioPort));
    ioPortsListened.push(...ioPortsArray);

}

if (ioPortsBtn = document.getElementById('ExpansionCard_ioPorts_collection')?.parentNode?.children[0]) {
    ioPortsBtn.addEventListener('click', () => {
        setTimeout(() => { //Ensures it's executed after EA's action
            const ioPorts = document.getElementById('ExpansionCard_ioPorts').children;
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
 * 
 * @param {string} ioPortId 
 */
function addListenersToIoPortForm(ioPortId) {
    const baseId = ioPortId.replace('-contents', '');
    const ioPortInterfaceSignalSelect = document.getElementById(baseId + '_ioPortInterfaceSignal');
    const ioPortInterfaceSelect = document.getElementById(baseId + '_ioPortInterface');
    const ioPortSignalsSelect = document.getElementById(baseId + '_ioPortSignals');

    ioPortInterfaceSignalSelect.addEventListener('change', event => ioPortInterfaceSignalChange(event, baseId));
}

/**
 * Updates the connector and signal based on what ioPort the user selected
 * @param {Event} event 
 * @param {string} baseId 
 */
function ioPortInterfaceSignalChange(event, baseId) {
    const url = `${window.location.origin}/dashboard/getioports/${event.target.value}`;

    fetch(url)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error: ${response.status}`)
            }
            return response.text();
        })
        .then((text) => {
            const res = JSON.parse(text);
            const intefaceId = res[0].interface;
            const signalId = res[0].signal

            const ioPortInterfaceSelect = document.getElementById(baseId + '_ioPortInterface');
            const ioPortSignalsSelect = document.getElementById(baseId + '_ioPortSignals');

            ioPortInterfaceSelect.value = intefaceId;
            ioPortSignalsSelect.value = signalId;

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
    return [].slice.call(ioPorts).map(port => port.children[0].children[0].id);
}
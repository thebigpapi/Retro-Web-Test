import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        window.onload = () => {
            if(document.getElementById('search_chipsetManufacturer')){
                var select = document.getElementById('search_chipsetManufacturer');
                var idx = select.options[select.selectedIndex].value;
                if(idx)
                    this.setResult('search[chipsetManufacturer]', idx, 'search_chipset');
            }
            if(document.getElementById('search_cpuSocket1')){
                var select1 = document.getElementById('search_cpuSocket1');
                var idx1 = select1.options[select1.selectedIndex].value;
                if(idx1)
                    this.setResult('search[cpuSocket1]', idx1, 'search_platform1');
            }
            if(document.getElementById('search_cpuSocket2')){
                var select2 = document.getElementById('search_cpuSocket2');
                var idx2 = select2.options[select2.selectedIndex].value;
                if(idx2)
                    this.setResult('search[cpuSocket2]', idx2, 'search_platform2');
            }
        }
    }

    /**
     * Called when the reset button is pressed
     * @param {*} event 
     */
    reset(event) {
        let _this = this;
        let searchs = event.target.dataset.resetIds.split(' ');

        searchs.forEach(selectId => {
            let search = document.getElementById(selectId);
            let targetId = search.dataset.targetId;
            _this.setResult(search.name, "", targetId);
        });
    }

    /**
     * Called when a select change
     * @param {*} event 
     */
    search(event) {
        let _this = this;
        let search = event.target;
        let targetId = search.dataset.targetId;
        _this.setResult(search.name, search.value, targetId);
    }

    /**
     * Set the result of searching searched to target
     * @param {*} searchedName The name of the select element that will be sent to the server
     * @param {*} searchedValue The value selected in the select element that will be sent to the server
     * @param {*} target The target element for the server's response
     */
    setResult(searchedName, searchedValue, targetId) {
        let _this = this;
        let form = _this.element;

        let params = new FormData();
        params.set(searchedName, searchedValue);

        console.log(searchedName + " " + searchedValue);

        (async () => {
            const rawResponse = await fetch(form.action, {
                method: 'POST',
                body: params
            });
            let parser = new DOMParser();
            let parsedResponse = parser.parseFromString(await rawResponse.text(), "text/html");

            document.getElementById(targetId).innerHTML = parsedResponse.getElementById(targetId).innerHTML;
        })();
    }
}
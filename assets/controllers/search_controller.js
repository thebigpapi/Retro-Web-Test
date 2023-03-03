import { Controller } from 'stimulus';
import TomSelect from "tom-select"

export default class extends Controller {
    connect() {
        window.onload = () => {
            if(document.getElementById('search_chipsetManufacturer')){
                var select_chipmanuf = document.getElementById('search_chipsetManufacturer');
                var idx_chipmanuf = select_chipmanuf.options[select_chipmanuf.selectedIndex].value;
                if(idx_chipmanuf)
                    this.setResult('search[chipsetManufacturer]', idx_chipmanuf, 'search_chipset');
                //tom-select sync
                select_chipmanuf.tomselect.sync();
            }
            if(document.getElementById('search_cpuSocket1')){
                var select_cpuskt1 = document.getElementById('search_cpuSocket1');
                var idx_cpuskt1 = select_cpuskt1.options[select_cpuskt1.selectedIndex].value;
                if(idx_cpuskt1)
                    this.setResult('search[cpuSocket1]', idx_cpuskt1, 'search_platform1');
                //tom-select sync
                select_cpuskt1.tomselect.sync();
            }
            if(document.getElementById('search_cpuSocket2')){
                var select_cpuskt2 = document.getElementById('search_cpuSocket2');
                var idx_cpuskt2 = select_cpuskt2.options[select_cpuskt2.selectedIndex].value;
                if(idx_cpuskt2)
                    this.setResult('search[cpuSocket2]', idx_cpuskt2, 'search_platform2');
                //tom-select sync
                select_cpuskt2.tomselect.sync();
            }
            // tom-select sync for non ajax elements
            if(document.getElementById('search_manufacturer'))
                document.getElementById('search_manufacturer').tomselect.sync();
            if(document.getElementById('search_platform1'))
                document.getElementById('search_platform1').tomselect.sync();
            if(document.getElementById('search_platform2'))
                document.getElementById('search_platform2').tomselect.sync();
            if(document.getElementById('search_formFactor'))
                document.getElementById('search_formFactor').tomselect.sync();
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
        let select_ids = [
            "search_manufacturer", 
            "search_chipsetManufacturer",
            "search_cpuSocket1",
            "search_cpuSocket2",
            "search_platform1",
            "search_platform2",
            "search_formFactor"
        ];
        for(let id of select_ids){
            var select = document.getElementById(id);
            var control = select.tomselect; 
            control.clear();
        }
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
            console.log(targetId);
            document.getElementById(targetId).innerHTML = parsedResponse.getElementById(targetId).innerHTML;
            if(targetId != "search_chipset"){
                var select = document.getElementById(targetId);
                var control = select.tomselect;
                control.clear();
                control.clearOptions(); 
                control.sync();
            }
        })();
    }
}
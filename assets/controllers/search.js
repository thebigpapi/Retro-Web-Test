/*if(document.getElementById('search_chipsetManufacturer')){
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
    document.getElementById('search_formFactor').tomselect.sync();*/
//alert("trig");
let search_live = document.getElementById('pagination_redir');
if(search_live)
    search_live.addEventListener("click", searchLive);
function reset() {
        let _this = this;
        let searchs = event.target.dataset.resetIds.split(' ');
        searchs.forEach(selectId => {
            let search = document.getElementById(selectId);
            let targetId = search.dataset.targetId;
            setResult(search.name, "", targetId);
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
        let search = document.getElementById("search_moboResults");
        if (search) {
            search.innerHTML = "";
        }
    }

function search() {
        let search = event.target;
        let targetId = search.dataset.targetId;
        setResult(search.name, search.value, targetId);
    }

function setResult(searchedName, searchedValue, targetId) {
        let _this = this;
        let form = _this.element;

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
            if (targetId != "search_chipset" && targetId != "search_moboResults"){
                var select = document.getElementById(targetId);
                var control = select.tomselect;
                control.clear();
                control.clearOptions(); 
                control.sync();
            }
        })();
    }

function searchLive() {
        let form = document.getElementsByName('search_motherboard')[0];

        const formData = new URLSearchParams();
        for (const pair of new FormData(form)) {
            formData.append(pair[0], pair[1]);
        }
        var redirElem = document.getElementById('pagination_redir');
        var targetId = redirElem.getAttribute("data-results-id");
        if (redirElem) {
            console.log(redirElem);
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
            if (responseDiv) {
                document.getElementById(targetId).innerHTML = responseDiv.innerHTML;
            } else {
                document.getElementById(targetId).innerHTML = "Critical error while fetching results";
            }
        })();
    }
    window.expand = expand;
    window.remove = remove;
    function expand(idx) {
        let list = document.getElementById(idx);
        //store the table widget DOM in list and newWidget, increment the counter
        let counter = list.getAttribute("data-widget-counter");
        let newWidget = list.getAttribute("data-prototype");
        newWidget = newWidget.replace(/__name__/g, counter);
        newWidget = newWidget.replace("/>", ">");
        counter++;
        //set the new increment, create the new widget and concatenate after list
        list.setAttribute("data-widget-counter", counter);
        let newElem = document.createElement('div');
        if (list.id === 'motherboardBios-fields-list')
            newElem.setAttribute("class", "bios-image-container");
        else
            newElem.setAttribute("class", "editor-row");
        newElem.innerHTML = newWidget;
        list.appendChild(newElem);
    }
    function remove(el){
        var element = el.parentNode;
        element.remove();
    }



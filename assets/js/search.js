//initialize tom-select
var settings = {};
if(select_chipmanuf = document.getElementById('search_chipsetManufacturer')){
    new TomSelect('#search_chipsetManufacturer',settings);
    select_chipmanuf.tomselect.sync();
}
if(select_cpuskt1 = document.getElementById('search_cpuSocket1')){
    new TomSelect('#search_cpuSocket1',settings);
    select_cpuskt1.tomselect.sync();
}
if(select_cpuskt2 = document.getElementById('search_cpuSocket2')){
    new TomSelect('#search_cpuSocket2',settings);
    select_cpuskt2.tomselect.sync();
}
if(select_manuf = document.getElementById('search_manufacturer')){
    new TomSelect('#search_manufacturer',settings);
    select_manuf.tomselect.sync();
}
if(select_platform1 = document.getElementById('search_platform1')){
    new TomSelect('#search_platform1',settings);
    select_platform1.tomselect.sync();
}
if(select_platform2 = document.getElementById('search_platform2')){
    new TomSelect('#search_platform2',settings);
    select_platform1.tomselect.sync();
}
if(select_formfactor = document.getElementById('search_formFactor')){
    new TomSelect('#search_formFactor',settings);
    select_formfactor.tomselect.sync();
}
// event listeners
if(search_paginate = document.getElementById('search-paginate-id'))
    search_paginate.addEventListener("click", function(){
        paginate(search_paginate.getAttribute("data-paginate"), search_paginate.getAttribute("data-target"));
    }, false);
var search_live = document.getElementById('pagination_redir');
if(search_live)
    search_live.addEventListener("click", searchLive);
let chpsel = document.getElementById('search_chipsetManufacturer');
if(chpsel && document.getElementById('search_chipset'))
    chpsel.addEventListener("change", function(){
        setResult(chpsel.name, chpsel.value, chpsel.getAttribute('data-target-id'));
    }, false);
let cpu1sel = document.getElementById('search_cpuSocket1');
if(cpu1sel)
    cpu1sel.addEventListener("change", function(){
        setResult(cpu1sel.name, cpu1sel.value, cpu1sel.getAttribute('data-target-id'));
    }, false);
let cpu2sel = document.getElementById('search_cpuSocket2');
if(cpu2sel)
    cpu2sel.addEventListener("change", function(){
        setResult(cpu2sel.name, cpu2sel.value, cpu2sel.getAttribute('data-target-id'));
    }, false);

function paginate(newPageIdx, target) {
    var redirElem = document.getElementById('pagination_redir');
    if (redirElem) {
        redirElem.setAttribute("value", newPageIdx);
        if(el = document.getElementById("route-results"))
            el.remove();
        window.history.replaceState({},'', window.origin + '/' + target + '/');
        redirElem.click();
    }
    return false;
    }

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
        let search = document.getElementById("search_liveResults");
        if (search) {
            search.innerHTML = "";
        }
    }
function setResult(searchedName, searchedValue, targetId) {
        let form = document.getElementsByName('search_motherboard')[0];
        if(!form)
            form = document.getElementsByName('search_chipset')[0];
        if(!form)
            form = document.getElementsByName('search_hdd')[0];
        if(!form)
            form = document.getElementsByName('search_cdd')[0];
        if(!form)
            form = document.getElementsByName('search_fdd')[0];
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
        })();
    }

function searchLive() {
        let form = document.getElementsByName('search_motherboard')[0];
        if(!form)
            form = document.getElementsByName('search_chipset')[0];
        if(!form)
            form = document.getElementsByName('search_driver')[0];
        if(!form)
            form = document.getElementsByName('search_hdd')[0];
        if(!form)
            form = document.getElementsByName('search_cdd')[0];
        if(!form)
            form = document.getElementsByName('search_fdd')[0];
        let url = {};
        const formData = new URLSearchParams();
        for (const pair of new FormData(form)) {
            if(pair[1])
                url[pair[0].substring(7, pair[0].length-1)] = pair[1];
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
            if (responseDiv) {
                document.getElementById(targetId).innerHTML = responseDiv.innerHTML;
                let string = document.getElementById('search-params-id');
                window.history.replaceState({},'', string.firstChild.data);
                const lightbox = GLightbox({});
                getDates();
            } else {
                document.getElementById(targetId).innerHTML = "Critical error while fetching results";
            }
        })();
    }
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
        //tom-select
        if(idx == "motherboardExpansionSlots-fields-list"){
            el = document.getElementById('search_motherboardExpansionSlots_' + (counter - 1) + '_expansion_slot');
            new TomSelect('#search_motherboardExpansionSlots_' + (counter - 1) + '_expansion_slot', {});
            el.tomselect.sync();
        }
        if(idx == "motherboardIoPorts-fields-list"){
            el = document.getElementById('search_motherboardIoPorts_' + (counter - 1) + '_io_port');
            new TomSelect('#search_motherboardIoPorts_' + (counter - 1) + '_io_port', {});
            el.tomselect.sync();
        }
        if(idx == "expansionChips-fields-list"){
            el = document.getElementById('search_expansionChips_' + (counter - 1));
            new TomSelect('#search_expansionChips_' + (counter - 1), {});
            el.tomselect.sync();
        }
    }
    function remove(el){
        var element = el.parentNode;
        element.remove();
    }



//initialize tom-select
var settings = {};
const form = document.forms[0];
let static_selects = [
    "chipsetManufacturer",
    "moboManufacturer",
    "expansionChipManufacturer",
    "cpuManufacturer",
    "chipset",
    "cpuSocket1",
    "cpuSocket2",
    "manufacturer",
    "platform1",
    "platform2",
    "formFactor",
    "cpuSpeed",
    "type",
    "fsbSpeed"
];
let dynamic_selects = [
    'motherboardExpansionSlots-fields-list',
    'motherboardIoPorts-fields-list',
    'expansionChips-fields-list',
    'dramTypes-fields-list',
    'sockets-fields-list',
    'platforms-fields-list'
];
// init tom-selects
for(let item of static_selects){
    loadTS(item);
}
// event listeners
if(search_paginate = document.getElementById('search-paginate-id'))
    search_paginate.addEventListener("click", function(){
        paginate(search_paginate.getAttribute("data-paginate"), search_paginate.getAttribute("data-target"));
    }, false);
if(search_live = document.getElementById('pagination_redir'))
    search_live.addEventListener("click", searchLive);
if(cpu1sel = document.getElementById('search_cpuSocket1'))
    cpu1sel.addEventListener("change", function(){
        setResult(cpu1sel.name, cpu1sel.value, cpu1sel.getAttribute('data-target-id'));
    }, false);
if(cpu2sel = document.getElementById('search_cpuSocket2'))
    cpu2sel.addEventListener("change", function(){
        setResult(cpu2sel.name, cpu2sel.value, cpu2sel.getAttribute('data-target-id'));
    }, false);
if(resetbtn = document.getElementById('rst-btn'))
    resetbtn.addEventListener("click", reset);
// cookies
if(search_image = document.getElementById('search_searchWithImages')){
    if(getCookie('searchImage') == "false")
        search_image.nextElementSibling.click();
    search_image.addEventListener("click", function(){
        setCookie('searchImage', search_image.checked, 5);
    }, false);
}
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
    const cArr = cDecoded .split('; ');
    let res;
    cArr.forEach(val => {
        if (val.indexOf(name) === 0) res = val.substring(name.length);
    })
    return res;
}
function loadTS(targetId){
    if(el = document.getElementById('search_' + targetId)){
        new TomSelect('#search_' + targetId, settings);
        el.tomselect.sync();
    }
}
function displayalias(idx){
    let el = document.getElementById('cpu-alias-box-' + idx);
    if (el.getAttribute("class") == "cpu-aliases-box")
        el.setAttribute("class", "cpu-aliases-box visible");
    else
        el.setAttribute("class", "cpu-aliases-box");
}
form.addEventListener("keydown", (e) => {
    if (!e.repeat && e.key == "Enter") {
        console.log(e.key);
        e.preventDefault;
        paginate(search_paginate.getAttribute("data-paginate"), search_paginate.getAttribute("data-target"));
    }
});

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
    for(let id of static_selects){
        if(select = document.getElementById('search_' + id)){
            var control = select.tomselect;
            control.clear();
        }
    }
    for(let id of dynamic_selects){
        if(select = document.getElementById(id))
            select.innerHTML = "";
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
    })();
}

function searchLive() {
        let form = document.forms[0];
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
                document.getElementById(targetId).innerHTML = "Critical error while fetching results:<br>" + parsedResponse.title;
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
        if(idx == "dramTypes-fields-list"){
            el = document.getElementById('search_dramTypes_' + (counter - 1));
            new TomSelect('#search_dramTypes_' + (counter - 1), {});
            el.tomselect.sync();
        }
        if(idx == "sockets-fields-list"){
            el = document.getElementById('search_sockets_' + (counter - 1));
            new TomSelect('#search_sockets_' + (counter - 1), {});
            el.tomselect.sync();
        }
        if(idx == "platforms-fields-list"){
            el = document.getElementById('search_platforms_' + (counter - 1));
            new TomSelect('#search_platforms_' + (counter - 1), {});
            el.tomselect.sync();
        }
    }
    function remove(el){
        var element = el.parentNode;
        element.remove();
    }



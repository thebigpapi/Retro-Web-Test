let search_live = document.getElementById('pagination_redir');
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
        let url = {};
        const formData = new URLSearchParams();
        for (const pair of new FormData(form)) {
            if(pair[1])
                url[pair[0].substring(7, pair[0].length-1)] = pair[1];
            formData.append(pair[0], pair[1]);
        }
        var redirElem = document.getElementById('pagination_redir');
        var targetId = redirElem.getAttribute("data-results-id");
        console.log(targetId);
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
            console.log(parsedResponse);
            if (responseDiv) {
                console.log(responseDiv);
                document.getElementById(targetId).innerHTML = responseDiv.innerHTML;
                let string = document.getElementById('search-params-id');
                window.history.replaceState({},'', string.firstChild.data);
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



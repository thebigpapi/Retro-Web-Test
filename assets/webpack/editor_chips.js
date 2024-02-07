if(updatechipsbtn = document.getElementById('Motherboard_chipset'))
    updatechipsbtn.addEventListener("change", updateChips);
if(updatechipsetbtn = document.getElementById('update-chipset-btn'))
    updatechipsetbtn.addEventListener("click", updateChipset);
if(resetchipsetbtn = document.getElementById('reset-chipset-btn'))
    resetchipsetbtn.addEventListener("click", resetChipset);
// chipset functions
function resetChipset() {
    let chipsetArray = {};
    let url = window.location.origin + "/dashboard/getallchipsets";
    let xhr = new XMLHttpRequest()
    xhr.open('POST', url, true)
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
    xhr.send();
    xhr.onload = function () {
        if(xhr.status === 200) {
            chipsetArray = JSON.parse(xhr.responseText);
            let chipset = document.getElementById('Motherboard_chipset');
            chipset.innerHTML = "";
            for(const key in chipsetArray){
                let option = new Option(chipsetArray[key],key);
                chipset.add(option);
            }
            chipset.tomselect.clearOptions();
            chipset.tomselect.sync();
            setMessage("Chipset list length is now: " + Object.keys(chipsetArray).length);
        }
    }
}
function getElementIdsFromElements(elements) {
    return [].slice.call(elements).map(el => el.children[0].children[0].id.replace('-contents', ''));
}
function updateChipset() {
    let params = [];
    let cnt = 0;
    // read expansion chips
    let chips = document.getElementById('Motherboard_expansionChips_autocomplete');
    console.log(chips.tomselect.getValue())
    if(chips.childElementCount > 0)
        for(let item of chips.children)
            params.push(parseInt(item.getAttribute('value')));
    if(params.length > 0)
        setChipset(params);
    else{
        setMessage("Error: no expansion chips listed!");
        return;
    }
}
function setChipset(values){
    // fetch new platforms based on chips
    let post = JSON.stringify(values)
    let chipsetArray = {};
    let url = window.location.origin + "/dashboard/getchipsets";
    let xhr = new XMLHttpRequest()
    xhr.open('POST', url, true)
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
    xhr.send(post);
    xhr.onload = function () {
        if(xhr.status === 200) {
            chipsetArray = JSON.parse(xhr.responseText);
            let chipset = document.getElementById('Motherboard_chipset');
            chipset.innerHTML = "";
            for(const key in chipsetArray){
                let option = new Option(chipsetArray[key],key);
                chipset.add(option);
            }
            chipset.tomselect.clearOptions();
            chipset.tomselect.sync();
            setMessage("Chipset list length is now: " + Object.keys(chipsetArray).length);
        }
    }
}
// expansion chip functions
function updateChips() {
    let params = [];
    // read chipset
    let chipset = document.getElementById('Motherboard_chipset');
    let chipset_value = chipset.value;
    // read expansion chips
    let chips = document.getElementById('Motherboard_expansionChips_autocomplete');
    if(chips.childElementCount > 0)
        for(let item of chips.children)
            params.push(parseInt(item.getAttribute('value')));
    if(chipset_value){
        setChips(chipset_value, params.length);
    }
    else
        return;
}
function setChips(value, verify){
    // fetch new chips based on chipset
    let post = JSON.stringify(value)
    let chipsArray = {};
    let url = window.location.origin + "/dashboard/getchips";
    let xhr = new XMLHttpRequest()
    xhr.open('POST', url, true)
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
    xhr.send(post);
    xhr.onload = function () {
        if(xhr.status === 200) {
            chipsArray = JSON.parse(xhr.responseText);
            if(verify > 0)
                verifyChips(chipsArray);
            else{
                addChips(chipsArray);
                setMessage("Expansion chips added: " + Object.keys(chipsArray).length);
            }
        }
    }
}
function addChips(addArray){
    let chips = document.getElementById('Motherboard_expansionChips_autocomplete');
    for(const chip in addArray){
        console.log(chip, addArray[chip]);
        chips.tomselect.addOption({entityId: chip, entityAsString: addArray[chip]});
        chips.tomselect.addItem(chip);
        chips.tomselect.sync();
    }
    chips.tomselect.sync();
}
function removeChips(deleteArray){
    let container = document.getElementById('Motherboard_expansionChips_autocomplete-ts-control');
    for(const value of deleteArray){
        let el = container.querySelector(`[data-value="${value}"]`);
        if(el){
            el.children[0].children[0].click();
        }
    }
    console.log(deleteArray);
}
function verifyChips(addArray){
    let cnt = 0;
    let chip_array = [];
    let chips = document.getElementById('Motherboard_expansionChips_autocomplete');
    if(chips.childElementCount > 0)
        for(let item of chips.children)
            chip_array.push(parseInt(item.getAttribute('value')));
    let post = JSON.stringify(chip_array)
    let newChipsArray = {};
    let url = window.location.origin + "/dashboard/filterchips";
    let xhr = new XMLHttpRequest()
    xhr.open('POST', url, true)
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
    xhr.send(post);
    xhr.onload = function () {
        if(xhr.status === 200) {
            deleteArray = JSON.parse(xhr.responseText);
            removeChips(deleteArray);
            addChips(addArray);
            if(deleteArray.length == 0){
                if(addArray.length == 0)
                    setMessage("Expansion chips unchanged");
                else
                    setMessage("Expansion chips added: " + addArray.length);
            }
            else{
                if(addArray.length == 0)
                    setMessage("Expansion chips removed: " + deleteArray.length);
                else
                    setMessage("Expansion chips removed: " + deleteArray.length + ", added: " + addArray.length);
            }
        }
    }
}
function identifyFirstSelect(targetId){
    let select_container = document.getElementById(targetId);
    let cnt = 0;
    if(!select_container){
        select_container = document.getElementById(targetId + '_collection').children[0].children[0].children[0].children[0];
    }
    let select_cnt = select_container.childElementCount;
    while(select_cnt > 0){
        if(document.getElementById("Motherboard_expansionChips_" + cnt)){
            select_cnt--;
        }
        if(select_cnt == 0)
            return cnt;
        cnt++;
    }
    return 0;
}
function setMessage(msg){
    let message = document.getElementById('update-chipset-label');
    message.innerHTML = msg;
}
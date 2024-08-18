if(updatechipsbtn = document.getElementById('update-chips-btn'))
    updatechipsbtn.addEventListener("click", updateChips);
if(updatechipsetbtn = document.getElementById('update-chipset-btn'))
    updatechipsetbtn.addEventListener("click", updateChipset);
if(resetchipsetbtn = document.getElementById('reset-chipset-btn'))
    resetchipsetbtn.addEventListener("click", resetChipset);
let chipset_init = false;
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
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
            let chipset = document.getElementById('Motherboard_chipset_autocomplete');
            chipset.tomselect.clearOptions();
            chipset.tomselect.sync();
            setMessage("Chipset list reset.");
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
    let chips = document.getElementById('Motherboard_chips_autocomplete');
    //console.log(chips.tomselect.getValue())
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
            let chipset = document.getElementById('Motherboard_chipset_autocomplete');
            if(!chipset_init){
                setMessage("Please wait, initializing ajax...");
                chipset.tomselect.open();
                sleep(500).then(() => { document.getElementById('update-chipset-btn').click(); });
            }
            chipset.tomselect.clearOptions();
            for(const key in chipsetArray){
                chipset.tomselect.addOption({entityId: key, entityAsString: chipsetArray[key]});
                chipset.tomselect.addItem(key);
            }
            chipset.tomselect.sync();
            if(chipset_init)
                setMessage("Chipset list length is now: " + Object.keys(chipsetArray).length);
            chipset_init = true;
        }
    }
}
// expansion chip functions
function updateChips() {
    let params = [];
    // read chipset
    let chipset = document.getElementById('Motherboard_chipset_autocomplete');
    let chipset_value = chipset.value;
    // read expansion chips
    let chips = document.getElementById('Motherboard_chips_autocomplete');
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
    //console.log(value)
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
            //console.log(chipsArray, chipsArray.length);
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
    let chips = document.getElementById('Motherboard_chips_autocomplete');
    for(const chip in addArray){
        //console.log(chip, addArray[chip]);
        chips.tomselect.addOption({entityId: chip, entityAsString: addArray[chip]});
        chips.tomselect.addItem(chip);
    }
    chips.tomselect.sync();
}
function removeChips(deleteArray){
    let container = document.getElementById('Motherboard_chips_autocomplete-ts-control');
    for(const value of deleteArray){
        let el = container.querySelector(`[data-value="${value}"]`);
        if(el){
            el.children[0].children[0].click();
        }
    }
}
function verifyChips(addArray){
    let addLen = Object.keys(addArray).length;
    let chip_array = [];
    let chips = document.getElementById('Motherboard_chips_autocomplete');
    if(chips.childElementCount > 0)
        for(let item of chips.children)
            chip_array.push(parseInt(item.getAttribute('value')));
    let post = JSON.stringify(chip_array)
    let deleteArray = {};
    let url = window.location.origin + "/dashboard/filterchips";
    let xhr = new XMLHttpRequest()
    xhr.open('POST', url, true)
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
    xhr.send(post);
    xhr.onload = function () {
        if(xhr.status === 200) {
            deleteArray = JSON.parse(xhr.responseText);
            let delLen = Object.keys(deleteArray).length;
            removeChips(deleteArray);
            addChips(addArray);
            if(delLen == 0){
                if(addLen == 0)
                    setMessage("Expansion chips unchanged");
                else
                    setMessage("Expansion chips added: " + addLen);
            }
            else{
                if(addLen == 0)
                    setMessage("Expansion chips removed: " + delLen);
                else
                    setMessage("Expansion chips removed: " + delLen + ", added: " + addLen);
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
        if(document.getElementById("Motherboard_chips_" + cnt)){
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
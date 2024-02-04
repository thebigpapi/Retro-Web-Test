/*if(updatechipsbtn = document.getElementById('Motherboard_chipset'))
    updatechipsbtn.addEventListener("change", updateChips);*/
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
            if(verify < 0)
                verifyChips(chipsArray);
            else{
                addChips(chipsArray);
                setMessage("Expansion chips added: " + Object.keys(chipsArray).length);
            }
        }
    }
}
function addChips(values){
    let chips = document.getElementById('Motherboard_expansionChips_autocomplete');
    chips.tomselect.registerOptionGroup(values);
    for(const chip in values){
        console.log(chip);
        chips.tomselect.addOption(chip);
    }
    chips.tomselect.sync();
}
function verifyChips(array){
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
            newChipsArray = JSON.parse(xhr.responseText);
            let removecnt = 0;
            let addcnt = Object.keys(array).length;
            for(let i=0; i<cnt;i++){
                let element = document.getElementById("Motherboard_expansionChips_" + i);
                if(element && !Object.keys(newChipsArray).includes(element.value)){
                    document.getElementById("Motherboard_expansionChips_" + i + "_deletebtn").click();
                    removecnt++;
                }
            }
            addChips(array);
            if(removecnt == 0){
                if(addcnt == 0)
                    setMessage("Expansion chips unchanged");
                else
                    setMessage("Expansion chips added: " + addcnt);
            }
            else{
                if(addcnt == 0)
                    setMessage("Expansion chips removed: " + removecnt);
                else
                    setMessage("Expansion chips removed: " + removecnt + ", added: " + addcnt);
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
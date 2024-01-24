if(slugbtn = document.getElementById('get-slug-btn'))
    slugbtn.addEventListener("click", getslug);
if(slugbtncard = document.getElementById('get-slug-btn-card'))
    slugbtncard.addEventListener("click", getslugcard);
function getslug() {
    let manuf = document.getElementById('Motherboard_manufacturer');
    let name = document.getElementById('Motherboard_name');
    let slug = document.getElementById('Motherboard_slug');
    let string = manuf.options[manuf.selectedIndex].text;
    if(string == '')
        string = 'unknown ' + name.value;
    else
        string = string + ' ' + name.value;
    slug.value = string.replace(/[^a-z0-9_]+/gi, '-').replace(/^-|-$/g, '').toLowerCase().substring(0, 43);
}
function getslugcard() {
    let manuf = document.getElementById('ExpansionCard_manufacturer');
    let name = document.getElementById('ExpansionCard_name');
    let slug = document.getElementById('ExpansionCard_slug');
    let string = manuf.options[manuf.selectedIndex].text;
    if(string == '')
        string = 'unknown ' + name.value;
    else
        string = string + ' ' + name.value;
    slug.value = string.replace(/[^a-z0-9_]+/gi, '-').replace(/^-|-$/g, '').toLowerCase().substring(0, 43);
}
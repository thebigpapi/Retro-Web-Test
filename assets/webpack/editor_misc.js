if(slugbtn = document.getElementById('get-slug-btn'))
    slugbtn.addEventListener("click", getslug);
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
const trw_tabs = ["tab-nav-1", "tab-nav-2", "tab-nav-3", "tab-nav-4", "tab-nav-5"];
const trw_pageElements = ["sh-general", "sh-specs", "sh-chips", "sh-downloads", "sh-bios", "sh-driver", "sh-docs"];
const easyadmin = {
    "tab-basic-data": "sh-general",
    "tab-chips": "sh-chips",
    "tab-connectors": "sh-general",
    "tab-bios": "sh-bios",
    "tab-drivers": "sh-driver",
    "tab-docs": "sh-docs",
    "tab-images": "sh-general",
    "tab-other-attachments": "sh-general",
    "tab-features": "sh-general",
    "tab-specs": "sh-chips",
    "tab-associations": "sh-chips"
}

update_tab_selection();

trw_tabs.forEach((tabId) => {
    let gentab = document.getElementById(tabId);
    if (gentab)
        gentab.addEventListener("click", switch_tab);
});

let edittab = document.getElementById('tab-nav-0');
if (edittab)
    edittab.addEventListener("click", redirect);
let historytab = document.getElementById('tab-nav-h');
if (historytab)
    historytab.addEventListener("click", redirect);

function update_tab_selection() {
    for (const element of trw_pageElements) {
        let anchorName = "#" + element.substring(3);
        if (window.location.href.indexOf(anchorName) != -1) {
            inner_switch_tab(element);
            let tabLabel = find_tab_label(element);
            if (tabLabel) {
                tabLabel.checked = true;
            }
            return;
        }
    }
    //easyadmin tabs
    for (const el of Object.keys(easyadmin)) {
        if (window.location.href.indexOf(el) != -1) {
            inner_switch_tab(easyadmin[el]);
            let tabLabel = find_tab_label(easyadmin[el]);
            if (tabLabel) {
                tabLabel.checked = true;
            }
            return;
        }
    }
}

function find_tab_label(tabContainer) {
    for (const tabId of trw_tabs) {
        let tabLabel = document.getElementById(tabId);
        if (tabLabel && tabLabel.hasAttribute("data-tab") && tabLabel.getAttribute("data-tab") === tabContainer) {
            return tabLabel;
        }
    }
    return null;
}

function switch_tab(event) {
    if (!event.currentTarget.hasAttribute("data-tab")) {
        return;
    }

    let tabTarget = event.currentTarget.dataset.tab;
    inner_switch_tab(tabTarget);
    event.currentTarget.checked = true;
}

function inner_switch_tab(tabTarget) {
    if (document.getElementById(tabTarget)){
        document.getElementById(tabTarget).style.display = 'block';
        trw_pageElements.forEach((element) => {
            if (element !== tabTarget && document.getElementById(element))
                document.getElementById(element).style.display = 'none';
        });
        if (tabTarget !== "sh-general") {
            change_tag("#" + tabTarget.substring(3));
        } else {
            change_tag("0");
        }
    }
    else{
        change_tag("0");
    }
}

function redirect(event) {
    if (!event.currentTarget.hasAttribute("data-URL")) {
        return;
    }
    window.location.href = event.currentTarget.getAttribute("data-URL");
}

function change_tag(parameter) {
    let nextURL = window.location.href;
    let nextIndex = nextURL.indexOf("#");
    if (parameter == "0") {
        if (nextIndex != -1) {
            nextURL = nextURL.substring(0, nextIndex);
            window.history.replaceState({}, '', nextURL);
        }
    }
    else {
        nextURL = nextURL.substring(0, nextIndex) + parameter;
        window.history.replaceState({}, '', nextURL);
    }
}

function expandDropdown(el){
    let container = el.parentNode;
    let dropdown = container.querySelector("div[class*=dropdown-contents]");
    let input = container.querySelector("input[type=checkbox]");
    if(input.checked){
        dropdown.setAttribute("class", "dropdown-contents visible");
    }
    else{
        dropdown.setAttribute("class", "dropdown-contents");
    }
}

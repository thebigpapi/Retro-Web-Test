/**
 * Refreshed tab navigation logic for supporting more than a tabbed-div in the same page!
 */

const DEFAULT_TAB = "general";

let boundTabButtons = {}; // contains string references to which app-show-tabnav to use and app-show-tab to show/hide
let currentTab = {}; // currently displayed app-show-tab and navbar-button for each app-show-tabnav
let primaryNav = null; // only a single app-show-tabnav can be used as primary page nav. url anchors will apply to this one
let boundTabAnchors = {}; // map url anchors to primary nav and app-show-tab

function initNav() {
    const tabNavbars = document.getElementsByClassName("app-show-navbar");
    for (const tabNavbar of tabNavbars) {
        if (!("target" in tabNavbar.dataset))
            continue;

        // get target app-show-tabnav and make sure it exists in the dom
        const navContextTargetId = tabNavbar.dataset.target;
        const navContextTarget = document.getElementById(navContextTargetId);
        if (!navContextTarget)
            continue;

        // create base object for current state
        currentTab[navContextTargetId] = {
            "selectedBtn": null,
            "shownDiv": null,
        };

        // save primary app-show-tabnav, if it's unset
        if (primaryNav === null && navContextTarget.hasAttribute("primary")) {
            primaryNav = navContextTarget;
        }

        // get the buttons in the navbar, save their working info and add an event listener
        const tabButtons = tabNavbar.getElementsByTagName("input");
        for (const tabButton of tabButtons) {
            if ("tab" in tabButton.dataset) {
                boundTabButtons[tabButton.id] = {
                    "trigger": tabButton.id,
                    "context": navContextTargetId,
                    "tab": tabButton.dataset.tab,
                };
                tabButton.addEventListener('click', onTabClick);
            } else if ("url" in tabButton.dataset) {
                tabButton.addEventListener('click', onTabRedirect);
            }
        }
    }

    if (primaryNav !== null) {
        const availTabs = primaryNav.getElementsByClassName("app-show-tab");
        for (const availTab of availTabs) {
            if (!("anchor" in availTab.dataset)) continue;
            boundTabAnchors[availTab.dataset.anchor] = availTab.id;
        }
    }

    // console.debug("buttons", boundTabButtons);
    // console.debug("primaryNav", primaryNav);
    // console.debug("anchors", boundTabAnchors);
}

/**
 * 
 * @returns {string?} requested anchor name or null
 */
function activeTabFromUrl() {
    var urlParts = window.location.href.split('#');
    if (urlParts.length > 1) return urlParts[1];
    return null;
}

/**
 * @param {Event} event
 */
function onTabClick(event) {
    _onTabChange(event.currentTarget);
}

/**
 * @param {Event} event
 */
function onTabRedirect(event) {
    if (!("url" in event.currentTarget.dataset)) return;
    window.location.href = event.currentTarget.dataset.url;
}

/**
 * 
 * @param {string} tabId 
 * @returns {HTMLElement?}
 */
function getButtonByTab(tabId) {
    for (const btnId in boundTabButtons) {
        if (boundTabButtons[btnId]["tab"] !== tabId) continue;
        return document.getElementById(btnId);
    }
    console.error("no button for tab %s", tabId);
    return null;
}

/**
 * 
 * @param {HTMLElement?} targetNav 
 * @param {string?} anchor 
 */
function selectTabByAnchor(targetNav, anchor) {
    if (!targetNav) return;
    if (!anchor) return;
    if (!(anchor in boundTabAnchors)) return;

    let targetBtn = getButtonByTab(boundTabAnchors[anchor]);
    if (!targetBtn) return;
    _onTabChange(targetBtn);
}

function selectFirstTab() {
    for (const id in currentTab) {
        if (currentTab[id]["shownDiv"] !== null) continue;

        const tabs = document.getElementById(id).getElementsByClassName("app-show-tab");
        if (tabs.length == 0) continue;

        let targetBtn = getButtonByTab(tabs[0].id);
        if (!targetBtn) continue;

        _onTabChange(targetBtn);
    }
}

/**
 * 
 * @param {string?} tag 
 */
function setUrlAnchor(tag = null) {
    let nextURL = window.location.href;
    let nextIndex = nextURL.indexOf("#");
    if (tag === null) {
        if (nextIndex != -1) {
            nextURL = nextURL.substring(0, nextIndex);
            window.history.replaceState({}, '', nextURL);
        }
    }
    else {
        nextURL = nextURL.substring(0, nextIndex) + '#' + tag;
        window.history.replaceState({}, '', nextURL);
    }
}

/**
 * @param {HTMLElement} trigger
 */
function _onTabChange(trigger) {
    if (!(trigger.id in boundTabButtons))
        return;

    const currBtn = boundTabButtons[trigger.id];
    if (!(currBtn["context"] in currentTab))
        return;

    let buttonTarget = document.getElementById(currBtn["tab"]);
    if (currentTab[currBtn["context"]]["shownDiv"] !== null) {
        currentTab[currBtn["context"]]["shownDiv"].classList.remove("app-show-tab-active");
    }
    buttonTarget.classList.add("app-show-tab-active");
    currentTab[currBtn["context"]]["shownDiv"] = buttonTarget;

    if (currentTab[currBtn["context"]]["selectedBtn"] !== null &&
        currentTab[currBtn["context"]]["selectedBtn"] !== trigger
    ) {
        currentTab[currBtn["context"]]["selectedBtn"].removeAttribute("checked");
    }
    trigger.setAttribute("checked", true);
    currentTab[currBtn["context"]]["selectedBtn"] = trigger;

    if (primaryNav === null) {
        setUrlAnchor();
        return;
    }

    if (primaryNav.id !== currBtn["context"]) return;

    let anchorLabel = null;
    if ("anchor" in currentTab[currBtn["context"]]["shownDiv"].dataset)
        anchorLabel = currentTab[currBtn["context"]]["shownDiv"].dataset.anchor;
    if (anchorLabel === DEFAULT_TAB)
        anchorLabel = null;
    setUrlAnchor(anchorLabel);
}

// -----
initNav();
selectTabByAnchor(primaryNav, activeTabFromUrl());
selectFirstTab();

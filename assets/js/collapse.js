var triggers = document.getElementsByClassName("app-collapsible-trigger");

var i;
for (i = 0; i < triggers.length; i++) {
    triggers[i].addEventListener("click", toggleCollapsible);
    if (!("target" in triggers[i].dataset)) continue;
    let targetElem = document.getElementById(triggers[i].dataset.target);
    if (!targetElem) continue;
    updateCollapsedState(targetElem, targetElem.classList.contains("open"));
    targetElem.classList.add("animate");
}

function toggleCollapsible(event) {
    if (!("target" in this.dataset)) return;

    let targetElem = document.getElementById(this.dataset.target);
    if (!targetElem) return;

    let toggle = targetElem.classList.toggle("open");
    updateCollapsedState(targetElem, toggle);
    this.classList.toggle("open");
}

function updateCollapsedState(targetElem, isOpen) {
    if (!isOpen) {
        if (targetElem.classList.contains("app-collapsible-x")) {
            var width = targetElem.offsetWidth;
            targetElem.style.transform = "translateX(-" + width + "px)";
        } else if (targetElem.classList.contains("app-collapsible-y")) {
            var height = targetElem.offsetHeight;
            targetElem.style.transform = "translateY(-" + height + "px)";
        }
        targetElem.style.display = "none";
    } else {
        targetElem.style.transform = "";
        targetElem.style.display = "";
        targetElem.style.position = "";
    }
}

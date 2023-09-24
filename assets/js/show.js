let URL = window.location.href;
if (URL.indexOf("#downloads") != -1 && URL.indexOf("entity=") == -1)
    show_downloads();
if (URL.indexOf("#expchips") != -1)
    show_expchips();
let gentab = document.getElementById('tab-nav-1');
if(gentab)
    gentab.addEventListener("click", show_general);
let chiptab = document.getElementById('tab-nav-2');
if(chiptab)
    chiptab.addEventListener("click", show_expchips);
let dwtab = document.getElementById('tab-nav-3');
if(dwtab)
    dwtab.addEventListener("click", show_downloads);
let edittab = document.getElementById('tab-nav-0');
if(edittab)
    edittab.addEventListener("click", goToEdit);
let historytab = document.getElementById('tab-nav-h');
if(historytab)
    historytab.addEventListener("click", goToLogs);

function show_general(){
        document.getElementById('sh-general').style.display = 'block';
        if(document.getElementById('sh-expchips'))
            document.getElementById('sh-expchips').style.display = 'none';
        document.getElementById('sh-downloads').style.display = 'none';
        change_tag("0");
	}
function show_expchips(){
        document.getElementById('tab-nav-2').checked = true;
        document.getElementById('sh-general').style.display = 'none';
        document.getElementById('sh-expchips').style.display = 'block';
        document.getElementById('sh-downloads').style.display = 'none';
        change_tag("#expchips");
	}
function show_downloads(){
        document.getElementById('tab-nav-3').checked = true;
        document.getElementById('sh-general').style.display = 'none';
        if(document.getElementById('sh-expchips'))
            document.getElementById('sh-expchips').style.display = 'none';
        document.getElementById('sh-downloads').style.display = 'block';
        change_tag("#downloads");
	}

function goToURL(target){
        //window.location.href = document.getElementById(target).getAttribute("data-URL");
        console.log(target);
    }
function goToLogs(){
    window.location.href = document.getElementById('tab-nav-h').getAttribute("data-URL");
}
function goToEdit(){
    window.location.href = document.getElementById('tab-nav-0').getAttribute("data-URL");
}

function change_tag(parameter){
        let nextURL = window.location.href;
        let nextIndex = nextURL.indexOf("#");
        if (parameter == "0"){
            if(nextIndex != -1){
                nextURL = nextURL.substring(0, nextIndex);
                window.history.replaceState({},'', nextURL);
            }
        }
        else{
            nextURL = nextURL.substring(0, nextIndex) + parameter;
            window.history.replaceState({},'', nextURL);
        }

    }
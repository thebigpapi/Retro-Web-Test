
let form = document.getElementById('edit-LargeFile-form');
let formtype = "edit-LargeFile-form";
if(!form){
    form = document.getElementById('new-LargeFile-form');
    formtype = "new-LargeFile-form";
}
if(form){
    if(saveretbtn = document.getElementById("js-save"))
        saveretbtn.addEventListener('click', () => submit("saveAndReturn"), false);
    if(savecontbtn = document.getElementById("js-save-continue"))
        savecontbtn.addEventListener('click', () => submit("saveAndContinue"), false);
}
function submit(type) {
    setArch();
    let file_name = document.getElementById('LargeFile_file_file_new_file_name');
    if(file_name.innerHTML != ""){
        let date = new Date()
        let bytesLoaded = 0
        let xhr = new XMLHttpRequest();
        xhr.open("POST", window.location.href);
        xhr.onprogress = function (e) {
            if (e.lengthComputable) {
                console.log(e.loaded + " / " + e.total)
            }
        }
        let speedText;
        let bar;
        xhr.upload.addEventListener("progress", function (evt) {
            if (evt.lengthComputable) {
                bar = document.getElementById('progressBar')
                bar.value = evt.loaded
                bar.max = evt.total
                bar.innerHTML = evt.loaded / evt.total * 100
                document.getElementById("driver-message-err").setAttribute("style","display:none;");
                if (evt.loaded == evt.total) {
                    document.getElementById("message").innerHTML = "Processing ..."
                }
                else {
                    let newdate = new Date()
                    let speed = (evt.loaded - bytesLoaded) * (1000 / (newdate.getTime() - date.getTime()))
                    if (speed > 1024)
                        if (speed > 1024 * 1024)
                            speedText = Number.parseFloat(speed / 1024 / 1024).toFixed(1) + "MB/s";
                        else
                            speedText = Number.parseFloat(speed / 1024).toFixed(1) + "KB/s";
                    else
                        speedText = Math.round(speed) + "Bytes/sec";
                    document.getElementById("message").innerHTML = "Upload in progress ..." + speedText;
                    date = newdate
                    bytesLoaded = evt.loaded
                }
            }
        }, false);
        xhr.onloadstart = function (e) {
            bar = document.getElementById('progressBar')
            bar.hidden = false
            document.getElementsByClassName('action-saveAndReturn btn btn-primary action-save')[0].setAttribute('disabled', true);
        }
        xhr.onloadend = function (e) {
            document.getElementsByClassName('action-saveAndReturn btn btn-primary action-save')[0].removeAttribute('disabled');
            bar = document.getElementById('progressBar')
            bar.hidden = true
            if (xhr.status == 200) {
                let parser = new DOMParser();
                let doc = parser.parseFromString(xhr.responseText, "text/html");
                if (doc.getElementById("message")) {
                    document.getElementById("message").innerHTML = doc.getElementById("message").innerHTML
                }
                else {
                    window.location.href = xhr.responseURL
                    document.body.innerHTML = xhr.responseText
                }
                if (doc.getElementById("errors-message")) {
                    console.log(doc.getElementById("errors-message"));
                    document.getElementById("errors-message").innerHTML = doc.getElementById("errors-message").innerHTML
                }
            }
            else if(xhr.status == 500){
                let parser = new DOMParser();
                let doc = parser.parseFromString(xhr.responseText, "text/html");
                document.getElementById("message").innerHTML = xhr.statusText
                let img = document.getElementById("driver-message-err");
                img.setAttribute("style","display:inline;");
                let errorDiv = document.getElementById("driver-error-div");
                errorDiv.setAttribute("style", "display: block;")
                errorDiv.children[0].innerHTML = doc.getElementsByClassName('break-long-words exception-message')[0].innerHTML;
            }
            else {
                document.getElementById("message").innerHTML = xhr.statusText
                document.getElementById("driver-message-err").setAttribute("style","display:inline;");
            }
        }
        console.log(formtype);
        let formData = new FormData(document.getElementById(formtype));
        formData.append("ea[newForm][btn]", type);
        if(type == "saveAndReturn" && document.getElementById('new-LargeFile-form'))
            window.onbeforeunload = null;
        xhr.send(formData);
        if(type == "saveAndContinue"){
            window.onbeforeunload = null;
            window.location.reload();
        }
    }
    else{
        let save = document.getElementsByClassName("action-" + type)[0];
        if(save.getAttribute('data-valid') == "true"){
            saveretbtn.setAttribute("disabled", "disabled");
            savecontbtn.setAttribute("disabled", "disabled");
            save.click();
            if(document.getElementsByClassName('badge-danger').length > 0){
                saveretbtn.removeAttribute("disabled");
                savecontbtn.removeAttribute("disabled");
            }
        }
    }
}
function setArch(){
    let arch = document.getElementsByClassName("LargeFile_osArchitecture_cssid");
    if(arch.length > 0)
        return;
    let addbtn = document.getElementById("LargeFile_osArchitecture_collection").previousElementSibling;
    addbtn.click();
    let id = arch[0].getAttribute("data-id");
    let archSelect = document.getElementById("LargeFile_osArchitecture_" + id);
    archSelect.value = 1;
    archSelect.tomselect.sync();
}
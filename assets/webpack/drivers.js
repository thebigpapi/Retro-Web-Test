
let form = document.getElementById('edit-LargeFile-form');
if(!form)
    form = document.getElementById('new-LargeFile-form');
if(form){
    let submitreturn_btn = document.getElementsByClassName('action-saveAndReturn btn btn-primary action-save')[0];
    if(submitreturn_btn)
        submitreturn_btn.addEventListener("click", function(event){
            submit(event, "saveAndReturn", submitreturn_btn.getAttribute('form'));
        }, false);
    let submitcontinue_btn = document.getElementsByClassName('action-saveAndContinue btn btn-secondary action-save')[0];
    if(submitcontinue_btn)
        submitcontinue_btn.addEventListener("click", function(event){
            submit(event, "saveAndContinue", submitcontinue_btn.getAttribute('form'));
        }, false);
}
function submit(event, type, formtype) {
        let date = new Date()
        let bytesLoaded = 0
        event.preventDefault()
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
                img.setAttribute("title", doc.getElementsByClassName('break-long-words exception-message')[0].innerHTML);
            }
            else {
                document.getElementById("message").innerHTML = xhr.statusText
                document.getElementById("driver-message-err").setAttribute("style","display:inline;");
            }
        }
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
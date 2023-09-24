
function  submitcontinue(event) {
        let _this=this;
        _this.submit(event, "saveAndContinue", "edit-LargeFile-form");
    }
    /**
     * Submit the form
     * @param {*} event
     */
function  submitnewadd(event) {
        let _this=this;
        _this.submit(event, "saveAndAddAnother", "new-LargeFile-form");
    }
    /**
     * Submit the form
     * @param {*} event
     */
function submitreturn(event) {
        let _this=this;
        _this.submit(event, "saveAndReturn", "edit-LargeFile-form");
    }

function submitnewreturn(event) {
        let _this=this;
        _this.submit(event, "saveAndReturn", "new-LargeFile-form");
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
        xhr.send(formData);
    }
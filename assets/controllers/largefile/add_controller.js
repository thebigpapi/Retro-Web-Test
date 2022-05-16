import { Controller } from 'stimulus';

export default class extends Controller {
    /**
     * Check that everything is fine before submiting the board
     * @param {*} event 
     */
    check(event) {
        let error = false;
        let errorMessage = "";
        let name = document.getElementById('large_file_form_name');
        let file = document.getElementById('large_file_form_file');
        let existingFile = document.getElementById('large_file_form_file_name');
        let subdir = document.getElementById('large_file_form_subdirectory');
        if(!name.value){
            error = true;
            errorMessage += "The name field is empty!\n";
        }
        if(!file.files[0] && existingFile.value == ""){
            error = true;
            errorMessage += "No file is uploaded!\n";
        }
        if(subdir.value == ""){
            error = true;
            errorMessage += "Subdirectory not selected!\n";
        }
        if (error) {
            alert(errorMessage);
            return false;
        }
        return true;
    }
    /**
     * Submit the form
     * @param {*} event 
     */
     submit_try(event) {
         if (this.check())
            this.submit(event);
     }
    /**
     * Submit the form
     * @param {*} event 
     */
    submit(event) {
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

        let bar;
        xhr.upload.addEventListener("progress", function (evt) {
            if (evt.lengthComputable) {
                //console.log("add upload event-listener" + evt.loaded + "/" + evt.total);
                bar = document.getElementById('progressBar')
                bar.value = evt.loaded
                bar.max = evt.total
                bar.innerHTML = evt.loaded / evt.total * 100

                if (evt.loaded == evt.total) {
                    document.getElementById("message").innerHTML = "<ul><li>Processing ...</li></ul>"
                }
                else {
                    let newdate = new Date()
                    let speed = (evt.loaded - bytesLoaded) * (1000 / (newdate.getTime() - date.getTime()))
                    if (speed > 1024)
                        if (speed > 1024 * 1024)
                            speedText = Number.parseFloat(speed / 1024 / 1024).toFixed(1) + "MiB/s"
                        else
                            speedText = Number.parseFloat(speed / 1024).toFixed(1) + "KiB/s"
                    else
                        speedText = Math.round(speed) + "B/s"
                    //console.log(((evt.loaded - bytesLoaded) * (1000/(newdate.getTime() - date.getTime()))/1024/1024))
                    document.getElementById("message").innerHTML = "<ul><li>Upload in progress ...</li><li>" + speedText + "</li></ul>"
                    date = newdate
                    bytesLoaded = evt.loaded
                }
            }
        }, false);

        let button;
        let messageRow;
        xhr.onloadstart = function (e) {
            bar = document.getElementById('progressBar')
            bar.hidden = false
            button = document.getElementById('large_file_form_save')
            button.hidden = true
            messageRow = document.getElementById("messageRow") 
            messageRow.hidden = false
        }
        xhr.onloadend = function (e) {
            button = document.getElementById('large_file_form_save')
            button.hidden = false
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
            }
            else {
                document.getElementById("message").innerHTML = xhr.statusText
            }
        }
        xhr.send(new FormData(document.getElementsByName('large_file_form')[0]));

    }
}
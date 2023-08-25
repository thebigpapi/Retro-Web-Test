import { Controller } from 'stimulus';

export default class extends Controller {

    connect() {
    }
    /**
     * Check that everything is fine before submiting the board
     * @param {*} event 
     */
    check(event) {
        //this.clearErrors();

        /*let name = document.getElementById('large_file_form_name');
        let file = document.getElementById('large_file_form_file');
        let existingFile = document.getElementById('large_file_form_file_name');
        let subdir = document.getElementById('large_file_form_subdirectory');
        if (!this.dateCheckAndUpdate()) {
            this.appendError('Invalid date');
        } 
        if(!name.value){
            this.appendError('The name field is empty!');
        }
        if(!file.files[0] && existingFile.value == ""){
            this.appendError('No file is uploaded!');
        }
        if(subdir.value == ""){
            this.appendError('Subdirectory not selected!');
        }
        if (this.errorCount()) { //Errors found
            return false;
        }*/
        return true;
    }
    /**
     * Submit the form
     * @param {*} event 
     */
     submit_try(event) {
         if (this.check()) {
            this.submit(event);
         }
     }

    /*submit() {
        let submit_btn = document.getElementsByClassName('action-saveAndReturn btn btn-primary action-save')[0];
        if (submit_btn.disabled)
            submit_btn.disabled=false;
        //this.checkAllCheckBoxes();
        submit_btn.click();
    }*/
    submitcontinue() {
        let submit_btn = document.getElementsByClassName('action-saveAndContinue btn btn-secondary action-save')[0];
        if (submit_btn.disabled)
            submit_btn.disabled=false;
        //this.checkAllCheckBoxes();
        submit_btn.click();
    }
    submitnewadd() {
        let submit_btn = document.getElementsByClassName('action-saveAndAddAnother btn btn-secondary action-save')[0];
        if (submit_btn.disabled)
            submit_btn.disabled=false;
        //this.checkAllCheckBoxes();
        submit_btn.click();
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
        alert("submit?");
        let speedText;
        let bar;
        xhr.upload.addEventListener("progress", function (evt) {
            if (evt.lengthComputable) {
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
                    document.getElementById("message").innerHTML = "<ul><li>Upload in progress ...</li><li>" + speedText + "</li></ul>"
                    date = newdate
                    bytesLoaded = evt.loaded
                }
            }
        }, false);
        alert("uploaded?");
        let messageRow;
        xhr.onloadstart = function (e) {
            bar = document.getElementById('progressBar')
            bar.hidden = false
            document.getElementsByClassName('action-saveAndReturn btn btn-primary action-save')[0].setAttribute('disabled', true);
            //messageRow = document.getElementById("messageRow")
            //messageRow.hidden = false
        }
        alert("uploaded?");
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
            else {
                document.getElementById("message").innerHTML = xhr.statusText
            }
        }
        alert("uploaded?");
        //xhr.send(new FormData(document.getElementById('edit-LargeFile-form')));

    }

    dateCheckAndUpdate() {
        // Getting values from the mock forms
        let year = document.getElementById('large_file_form_releaseDate_year_mock').value;
        let month = document.getElementById('large_file_form_releaseDate_month_mock').value;
        let day = document.getElementById('large_file_form_releaseDate_day_mock').value;

        if (isNaN(year) || (month !== '' && isNaN(month)) || (day !== '' && isNaN(day))) {
            return false;
        }

        year = parseInt(year);
        month = parseInt(month);
        day = parseInt(day);

        if (year > new Date().getFullYear()) {
            return false;
        }

        let datePrecision = null;

        if (year !== '' && month !== '' && day !== '') {
            //full date
            datePrecision = 'd';
        } else if (year !== '' && month !== '' && day === '') {
            //year + month
            day = '01';

            datePrecision = 'm';
        }
        else if (year !== '' && month === '' && day === '') {
            //year only
            day = '01';
            month = '01';

            datePrecision = 'y';
        } else {
            return false;
        }

        //Updating the real form that's hidden
        document.getElementById('large_file_form_releaseDate_year').value = year;
        document.getElementById('large_file_form_releaseDate_month').value = month;
        document.getElementById('large_file_form_releaseDate_day').value = day;

        // Checking date format
        let fullDate = `${year}-${month}-${day}`;
        let dateParsed = new Date(Date.parse(fullDate));

        if (!(dateParsed instanceof Date) || isNaN(dateParsed)) {           
            return false;
        }
        
        // Updating date precision
        document.getElementById('large_file_form_datePrecision').value = datePrecision;

        // Succeeded
        return true
    }


    appendError(errorMessage) {
        let errorNode = document.createElement('li');
        errorNode.textContent = errorMessage;
        document.getElementById('errors-message').firstChild.appendChild(errorNode);
    }

    clearErrors() {
        document.getElementById('errors-message').firstChild.innerHTML = '';
    }

    errorCount() {
        return document.getElementById('errors-message').firstChild.getElementsByTagName("li").length
    }
}
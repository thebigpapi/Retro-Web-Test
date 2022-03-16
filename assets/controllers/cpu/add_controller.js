import { Controller } from 'stimulus';

export default class extends Controller {

    /**
    * Clone the motherboard
    */
    clone() {
        if (confirm('[EXPERIMENTAL, check all the fields!!] Clone this CPU ?')) {
            //replace the form URL
            let str = window.location.href;
            let form = document.getElementsByName("processor_form")[0];
            form.action = str.substring(0, str.search("admin")) + 'admin/manage/processingunits/processors/add';
            // remove all files
            let images = document.getElementById("processingUnit.chip.images-fields-list");
            images.innerHTML = '';
            // submit the page
            this.submit();
        }
    }
    submit() {
        let submit_btn = document.getElementById('processor_form_save');
        submit_btn.click();
    }
}
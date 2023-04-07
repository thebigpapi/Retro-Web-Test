import { Controller } from 'stimulus';

export default class extends Controller {

    /**
    * Clone the motherboard
    */
    clone() {
        if (confirm('Are you sure you want to clone this CPU ?')) {
            //replace the form URL
            let str = window.location.href;
            let form = document.getElementsByName("processor_form")[0];
            form.action = str.substring(0, str.search("admin")) + 'admin/manage/processingunits/processors/add';
            // remove all files
            let images = document.getElementById("processingUnit.chip.images-fields-list");
            images.innerHTML = '';
            let aliases = document.getElementById("chip.chipAliases-fields-list");
            aliases.innerHTML = '';
			window.history.replaceState({},'', window.location.origin + '/admin/manage/motherboards/motherboards/add');
        }
    }
    submit() {
        let submit_btn = document.getElementById('processor_form_save');
        submit_btn.click();
    }
}
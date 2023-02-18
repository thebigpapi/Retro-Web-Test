import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        let URL = window.location.href;
        if (URL.indexOf("#downloads") != -1 && URL.indexOf("entity=") == -1)
            this.show_downloads();
        if (URL.indexOf("#cpus") != -1)
            this.show_cpus();
        let toggle = document.getElementById('table-switch');
        if(toggle){
            let item = document.getElementsByClassName("plain-list")[0];
            let item_class = item.getAttribute("class");
            if(document.cookie == "state=1"){
                item_class = item_class.substring(0,item_class.indexOf("table")-1);
                item.setAttribute("class", item_class)
                toggle.checked = true;
            }
        }
    }
    show_general(){
        document.getElementById('sh-general').style.display = 'block';
        document.getElementById('sh-downloads').style.display = 'none';
        if(document.getElementById('sh-cpus'))
            document.getElementById('sh-cpus').style.display = 'none';
        this.change_tag("0");
	}
	show_downloads(){
        document.getElementById('tab-nav-2').checked = true;
        document.getElementById('sh-general').style.display = 'none';
        document.getElementById('sh-downloads').style.display = 'block';
        if(document.getElementById('sh-cpus'))
            document.getElementById('sh-cpus').style.display = 'none';
        this.change_tag("#downloads");
	}
	show_cpus(){
        document.getElementById('tab-nav-3').checked = true;
        document.getElementById('sh-general').style.display = 'none';
        document.getElementById('sh-downloads').style.display = 'none';
        document.getElementById('sh-cpus').style.display = 'block';
        this.change_tag("#cpus");
	}
    /**
     * @param {*} event 
     */
    goToURL(event){
        window.location.href = event.target.getAttribute("data-URL");
    }
    
    goToDelete(){
        let idx = window.location.href.indexOf("/admin/manage/motherboards");
        window.location.href = window.location.href.substring(0,idx) + "/motherboards" + window.location.href.substring(idx+39,window.location.href.indexOf("/edit")) + "/delete";
    }
    change_tag(parameter){
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
    show_table(){
        let toggle = document.getElementById('table-switch');
        let item = document.getElementsByClassName("plain-list")[0];
        let item_class = item.getAttribute("class");
        if (toggle.checked){
            document.cookie = "state=1";
            item_class = item_class.substring(0,item_class.indexOf("table")-1);
            item.setAttribute("class", item_class)
        }
        else{
            item_class = item.getAttribute("class");
            if(document.cookie != "state=0")
                document.cookie = "state=0";
            item.setAttribute("class", item_class + " table")
        }
    }
}
import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        
        /*let history = window.history.length;
        document.onmouseover = function(){
            window.innerDocClick = true;
        }
        document.onmouseleave = function(){
            window.innerDocClick = false;
        }
        window.onpopstate = function(){
            //alert(window.innerDocClick);
            //history.pushState({name: 'Example'}, "pushState example", 'page3.html');
            alert(history.state);
            if(!window.innerDocClick)
                window.history.go(history - window.history.length);
        }*/
        let URL = window.location.href;
        if (URL.indexOf("#downloads") != -1)
            this.show_downloads();
        if (URL.indexOf("#cpus") != -1)
            this.show_cpus();
    }
    show_general(){
        document.getElementById('sh-general').style.display = 'block';
	    document.getElementById('sh-downloads').style.display = 'none';
	    document.getElementById('sh-cpus').style.display = 'none';
        this.change_tag("0");
	}
	show_downloads(){
        document.getElementById('sh-general').style.display = 'none';
	    document.getElementById('sh-downloads').style.display = 'block';
	    document.getElementById('sh-cpus').style.display = 'none';
        this.change_tag("#downloads");
	}
	show_cpus(){
        document.getElementById('sh-general').style.display = 'none';
	    document.getElementById('sh-downloads').style.display = 'none';
	    document.getElementById('sh-cpus').style.display = 'block';
        this.change_tag("#cpus");
	}
    change_tag(parameter){
        let nextURL = window.location.href;
        let nextIndex = nextURL.indexOf("#");
        if (parameter == "0" && nextIndex != -1){
            nextURL = nextURL.substring(0, nextIndex);
            window.history.replaceState({},'', nextURL);
        }
        else{
            nextURL = nextURL.substring(0, nextIndex) + parameter;
            window.history.replaceState({},'', nextURL);
        }

    }
}
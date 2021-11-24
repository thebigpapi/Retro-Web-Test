import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        let history = window.history.length;
        document.onmouseover = function(){
            window.innerDocClick = true;
        }
        document.onmouseleave = function(){
            window.innerDocClick = false;
        }
        window.onhashchange = function(){
            if(!window.innerDocClick)
                window.history.go(history - window.history.length);
        }
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
        this.remove_tag();
	}
	show_downloads(){
        document.getElementById('sh-general').style.display = 'none';
	    document.getElementById('sh-downloads').style.display = 'block';
	    document.getElementById('sh-cpus').style.display = 'none';
	}
	show_cpus(){
        document.getElementById('sh-general').style.display = 'none';
	    document.getElementById('sh-downloads').style.display = 'none';
	    document.getElementById('sh-cpus').style.display = 'block';
	}
    remove_tag(){
        let nextURL = window.location.href;
        let nextIndex = nextURL.indexOf("#");
        if(nextIndex != -1){
            nextURL = nextURL.substring(0, nextIndex);
            window.history.pushState({},'', nextURL);
            window.history.replaceState({},'', nextURL);
        }
    }
}
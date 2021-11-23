import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        let URL = window.location.href;
        if (URL.indexOf("#downloads") != -1)
            this.show_downloads();
        if (URL.indexOf("#cpus") != -1)
            this.show_cpus();
    }
    show_general(){
        let showgen = document.getElementById('sh-general');
	    let showdw = document.getElementById('sh-downloads');
	    let showcpu = document.getElementById('sh-cpus');
		showgen.style.display = 'block';
		showdw.style.display = 'none';
		showcpu.style.display = 'none';
        this.remove_tag();
	}
	show_downloads(){
        let showgen = document.getElementById('sh-general');
	    let showdw = document.getElementById('sh-downloads');
	    let showcpu = document.getElementById('sh-cpus');
		showgen.style.display = 'none';
		showdw.style.display = 'block';
		showcpu.style.display = 'none';
	}
	show_cpus(){
        let showgen = document.getElementById('sh-general');
	    let showdw = document.getElementById('sh-downloads');
	    let showcpu = document.getElementById('sh-cpus');
		showgen.style.display = 'none';
		showdw.style.display = 'none';
		showcpu.style.display = 'block';
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
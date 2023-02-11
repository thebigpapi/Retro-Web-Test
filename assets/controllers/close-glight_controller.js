import { Controller } from 'stimulus';

export default class extends Controller {

    listeningImage = false;
    oldState = window.history.state;

    connect() {
        this.detectBodyClassChange();
    }

    detectBodyClassChange() {
        let body = document.querySelector("body");
      
        // Get the current class of the body element
        let currentClass = body.className;
      
        // Use a MutationObserver to detect changes in the body element
        let observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === "class") {
                let newClass = mutation.target.className;
        
                // If the class of the body element has changed
                if (newClass !== currentClass) {
                    currentClass = newClass;
                }
                }
            });
            
            let opened = false;
            for (let classToTest of currentClass.split(' ')) {
                if (classToTest === 'glightbox-open') {
                    opened = true;
                }
            }

            if (opened && !this.listeningImage) {
                window.history.pushState({id:1}, null, window.location.href);
                window.addEventListener('popstate', event => {
                    event.preventDefault();
                    let closeBtn = document.getElementsByClassName('gclose')[0];
                    closeBtn.click();
                })

                this.listeningImage = true;
            }
            else if (!opened) {
                window.removeEventListener('popstate', null);
                window.history.replaceState({id:1}, null, undefined);
                this.listeningImage = false;
            }
        });
      
        // Start observing the body element for changes
        observer.observe(body, {
          attributes: true
        });
    }
}
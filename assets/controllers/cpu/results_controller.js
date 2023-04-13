import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        let list = document.getElementById('cpu-results-table');
        for (let i=1; i< list.children.length;i++) {
            let button = list.children[i].children[1].children[1];
            if(button){
                button.addEventListener("click", function() {
                    this.classList.toggle("active");
                    let content = button.nextElementSibling;
                    if (content.getAttribute("class") == "cpu-aliases-box"){
                        content.setAttribute("class", "cpu-aliases-box visible");
                    } else {
                        content.setAttribute("class", "cpu-aliases-box");
                    }
                });
            }
        }
    }
}
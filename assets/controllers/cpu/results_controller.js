import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        let list = document.getElementById('cpu-results-table');
        for (let i=1; i< list.children.length;i++) {
            let button = list.children[i].children[1];
            if(button){
                button.addEventListener("click", function() {
                    let content = this.children[2];
                    console.log(content);
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
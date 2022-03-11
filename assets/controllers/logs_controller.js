import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        let list = document.getElementById('logs-table').children[1].children;
        for (let element of list) {
            let changes = element.children[3];
            changes.innerHTML = "<button class='log-collapsible'>View details</button><pre class='log-content'>" + this.syntaxHighlight(changes.innerHTML) + "</pre>";
            changes.children[0].addEventListener("click", function() {
            this.classList.toggle("active");
            let content = this.nextElementSibling;
            if (content.style.maxHeight){
              content.style.maxHeight = null;
            } else {
              content.style.maxHeight = "560px";
              content.style.overflowY = "scroll";
            } 
          });
        }
    }
    syntaxHighlight(json) {
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            var cls = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) {
                    cls = 'key';
                } else {
                    cls = 'string';
                }
            } else if (/true|false/.test(match)) {
                cls = 'boolean';
            } else if (/null/.test(match)) {
                cls = 'null';
            }
            return '<span class="' + cls + '">' + match + '</span>';
        });
    }
}
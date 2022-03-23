import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        this.changeTime("index-datetime")
    }

    changeTime(id) {
        let list = document.getElementById(id).children
        for (let element of list) {
            element.children[0].children[1].innerHTML = new Intl.DateTimeFormat('en-ca-iso8601', {
                year: 'numeric', 
                month: 'numeric', 
                day: 'numeric', 
                hour: '2-digit',
                hourCycle:'h23',
                minute: '2-digit', 
                timeZoneName:'short' 
            }).format(new Date(element.children[0].children[1].innerHTML));
        }
    }
}
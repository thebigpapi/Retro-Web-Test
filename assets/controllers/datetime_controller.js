import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        this.changeTime()
    }

    changeTime() {
        let list = document.getElementsByClassName("perk-date");
        for (let element of list) {
            element.innerHTML = new Intl.DateTimeFormat('en-ca-iso8601', {
                year: 'numeric', 
                month: 'numeric', 
                day: 'numeric', 
                hour: '2-digit',
                hourCycle:'h23',
                minute: '2-digit', 
                timeZoneName:'short' 
            }).format(new Date(element.innerHTML));
        }
    }
}
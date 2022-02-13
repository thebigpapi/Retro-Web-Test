import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        this.changeTime("index-datetime")
    }

    changeTime(id) {
        let list = document.getElementById(id).children
        for (let element of list) {
            let board = element.children[0].innerHTML;
            let date = new Date(board.substring(0, board.indexOf("|")));

            element.children[0].innerHTML = date.toLocaleString([], {year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit', timeZoneName:'short'});
            if (document.getElementById(id).nodeName != "DIV")
                element.children[0].innerHTML += " " + board.substring(board.indexOf("|"));
        }
    }
}
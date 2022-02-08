import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        this.changeTime("index-datetime")
    }
    changeTime(param){
        let list = document.getElementById(param).children
        for (let i = 0; i < list.length; i++) {
            let board = list[i].children[0].innerHTML;
            let date = new Date(board.substring(0,board.indexOf("|")));
            let month = ((date.getMonth())<9? '0' : '') + (date.getMonth() + 1);
            let day = ((date.getDate())<10? '0' : '') + (date.getDate());
            let hours = ((date.getHours())<10? '0' : '') + (date.getHours());
            let minutes = ((date.getMinutes())<10? '0' : '') + (date.getMinutes());
            let timezone = date.toString().substring(date.toString().indexOf("G"),date.toString().indexOf("G")+8);
            let new_date = date.getFullYear() + "-" + month + "-" + day + ", " + hours + ":" + minutes + " " + timezone;
            list[i].children[0].innerHTML = new_date + " " + board.substring(board.indexOf("|"));
        }
    }
}
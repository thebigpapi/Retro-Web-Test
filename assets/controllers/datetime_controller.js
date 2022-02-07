import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        let board_list = document.getElementById("index-datetime").children;
        for (let i = 0; i < board_list.length; i++) {
            let board = board_list[i].children[0].innerHTML;
            let date = new Date(board.substring(0,board.indexOf("|")));
            let date_offset = this.getTimeZone(date.getTimezoneOffset());
            board_list[i].children[0].innerHTML = board.substring(0,board.indexOf("|")) + date_offset + board.substring(board.indexOf("|"));
        }
        
    }
    getTimeZone(offset){
        offset = Math.abs(offset);
        let sign = offset < 0? '-' : '+';
        let z1 = ((offset/60 | 0)<10? '0' : '') + (offset/60 | 0);
        let z2 = ((offset%60)<10? '0' : '') + (offset%60);
        return " GMT" + sign + z1 + z2;
    }
}
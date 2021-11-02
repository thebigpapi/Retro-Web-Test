import { Controller } from 'stimulus';

export default class extends Controller {

    connect() {
        //Loading ajax on page load
        console.log("Loading ajax");
        let _this = this
        _this.xhttp = new XMLHttpRequest();
    }

    reset() {
        let _this = this;
        _this.setChipset(1, formtype, "setchip1", "setchip2", "setchip-lb", "[chipsetManufacturer]=", chk);
        if (chk) {
            _this.setChipset(1, formtype, "setcpu1", "setcpu2", "setcpu1-lb", "[cpuSocket1]=", chk);
            _this.setChipset(1, formtype, "setcpu3", "setcpu4", "setcpu2-lb", "[cpuSocket2]=", chk);
        }
    }

    change() {
        let _this = this;
        console.log("sending");
        /* execution starts HERE; detect the selects and determine the type of search page*/
        var chk = 0;
        if (document.getElementsByName("search[platform1]")[0])
            chk = 1;
        var formtype = "search";
        var chip = document.getElementById(formtype + '_chipsetManufacturer');

        var resetButton = document.getElementById('rst-btn');
        var lb2 = document.getElementById('setchip2');

        console.log(chk);
        if (chk) {
            var cpu1 = document.getElementById(formtype + '_cpuSocket1');
            var cpu2 = document.getElementById(formtype + '_cpuSocket2');
            var lb3 = document.getElementById('setcpu2');
            var lb4 = document.getElementById('setcpu4');
        }

        document.getElementById('search-table').className = 'ajax';
        document.getElementById('setchip2').style.display = 'none';
        document.getElementById('setchip2').style.display = '';

        chip.onchange = function () {
            _this.setChipset(0, formtype, "setchip1", "setchip2", "setchip-lb", "[chipsetManufacturer]=", chk);
        };
        if (chk) {
            cpu1.onchange = function () {
                _this.setChipset(0, formtype, "setcpu1", "setcpu2", "setcpu1-lb", "[cpuSocket1]=", chk);
            };
            cpu2.onchange = function () {
                _this.setChipset(0, formtype, "setcpu3", "setcpu4", "setcpu2-lb", "[cpuSocket2]=", chk);
            };
        }
    }

    setChipset(ok, formtype, sel1, sel2, sel_lb, typ, chk) {
        let _this = this;
        var chipManuf = document.getElementById(sel1).childNodes;
        var lb1 = document.getElementById(sel_lb);
        var lb2 = document.getElementById(sel2);
        lb2.style.display = "none";
        lb1.innerHTML = ls;
        if (chk)
            var form = document.getElementsByName(formtype + "_motherboard")[0];
        else
            var form = document.getElementsByName(formtype)[0];

        _this.xhttp.onreadystatechange = function () {
            if (_this.xhttp.readyState == 4 && _this.xhttp.status == 200) {
                var currentForm = document.getElementById(sel2);
                var parser = document.getElementById('hiddenDiv');
                var lb1 = document.getElementById(sel_lb);
                lb1.innerHTML = "";
                currentForm.style.display = "";
                parser.innerHTML = _this.xhttp.responseText;
                var doc = document.getElementById(sel2);
                currentForm.innerHTML = doc.innerHTML;
                parser.innerHTML = "";
            }
        };

        var chipsetManufacturer = chipManuf[0].value;
        if (ok) chipsetManufacturer = "";
        var params = formtype + typ + chipsetManufacturer;
        _this.xhttp.open('POST', form.action, true);
        _this.xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        _this.xhttp.send(params);
    }
}
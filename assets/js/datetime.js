getDates();
getDatesSimple();
function getDates(){
    let list = document.getElementsByClassName("perk-date");
    if(list){
        for (let element of list) {
            try {
                let dateIso = element.innerHTML;
                let dateFormatted = new Intl.DateTimeFormat('en-GB', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                }).format(new Date(element.innerHTML));
                let timeFormatted = new Intl.DateTimeFormat('en-ca-iso8601', {
                    hour: '2-digit',
                    hourCycle:'h23',
                    minute: '2-digit',
                    timeZoneName:'short'
                }).format(new Date(element.innerHTML));
                element.innerHTML =  "<span title=" + dateIso + ">" +  dateFormatted + ", " + timeFormatted + "</span>"
            } catch (error) {
                console.debug("Can't format date for current element -> ", element);
            }
        }
    }
}
function getDatesSimple(){
    let list = document.getElementsByClassName("perk-date-simple");
    if(list){
        for (let element of list) {
            try {
                let dateIso = element.innerHTML;
                let date = new Date(element.innerHTML  + 'T00:00:00Z');
                let options = {year: 'numeric', timeZone:"UTC"};
                if(isNaN(date))
                    continue;
                if(dateIso.length > 4){
                    options["month"] = 'long';
                    if(dateIso.length > 7){
                        options["day"] = 'numeric';
                    }
                }
                element.innerHTML = "<span title=" + dateIso + ">" +  date.toLocaleDateString('en-GB', options) + "</span>"
            } catch (error) {
                console.debug("Can't format date for current element -> ", element);
            }
        }
    }
}
window.getDates = getDates;

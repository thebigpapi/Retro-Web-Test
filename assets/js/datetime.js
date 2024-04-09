getDates();
getDatesSimple();
function getDates(){
    let list = document.getElementsByClassName("perk-date");
    if(list){
        for (let element of list) {
            try {
                element.innerHTML = new Intl.DateTimeFormat('en-ca-iso8601', {
                    year: 'numeric', 
                    month: 'numeric', 
                    day: 'numeric', 
                    hour: '2-digit',
                    hourCycle:'h23',
                    minute: '2-digit', 
                    timeZoneName:'short' 
                }).format(new Date(element.innerHTML));
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
                let date = new Date(element.innerHTML);
                let options = {year: 'numeric'};
                if(isNaN(date))
                    continue;
                if(dateIso.length > 4){
                    options["month"] = 'long';
                    if(dateIso.length > 7){
                        options["day"] = 'numeric';
                    }
                }
                element.innerHTML = "<span title=" + dateIso + ">" +  date.toLocaleDateString('en-US', options) + "</span>"
            } catch (error) {
                console.debug("Can't format date for current element -> ", element);
            }
        }
    }
}


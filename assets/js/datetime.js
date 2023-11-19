getDates();
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


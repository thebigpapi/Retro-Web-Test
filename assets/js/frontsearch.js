// event listeners
let search_btn = document.getElementById('search-button');
if (search_btn){
    search_btn.addEventListener("click", function () {paginate(search_btn.getAttribute("data-target"));}, false);
    window.addEventListener("keydown", (e) => {
        if (!e.repeat && e.key == "Enter") {
            e.preventDefault;
            paginate(search_btn.getAttribute("data-target"));
        }
    });
}

function paginate(target) {
    let searchBox = document.getElementById('search-box');
    if (!searchBox) {
        return;
    }
    let searchText = searchBox.value;
    if (searchText.length <= 0) {
        return;
    }
    window.location.href = "/" + target + "/?page=1&itemsPerPage=24&name=" + searchText;
}

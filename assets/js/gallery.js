window.addEventListener('load', resize_gallery_div);
window.addEventListener('resize', resize_gallery_div);

function resize_gallery_div() {
    var viewportWidth = window.innerWidth || document.documentElement.clientWidth;
    var parent = document.getElementById('gallery-container');
    var child = document.getElementById('gallery');
    if (!parent || !child) return;
    
    // Get the height of the child element
    var childHeight = child.offsetHeight;
    
    // Set the height of the parent element to match the height of the child
    if (viewportWidth > 1366) parent.style.height = '';
    else parent.style.height = childHeight + 'px';
}
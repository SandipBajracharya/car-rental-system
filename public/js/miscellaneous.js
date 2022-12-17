$(document).ready(function() {
    console.log(window.location.pathname);
    if (window.location.pathname != '/') {
        document.querySelectorAll('.opt-content').forEach(item => {
            item.style.display = "block";
        });
    } else {
        document.querySelectorAll('.opt-content').forEach(item => {
            item.style.display = "none";
        });
    }
})
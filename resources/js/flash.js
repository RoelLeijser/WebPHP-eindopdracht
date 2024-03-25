flash();
function flash() {
    setTimeout(function() {
        document.getElementById('flash').remove();
    }, 4000);
}
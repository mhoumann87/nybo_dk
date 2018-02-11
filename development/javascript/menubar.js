function checked() {
    const CLICK = document.getElementById('menu-btn');
    const SHOW = document.getElementById('show');

    CLICK.onclick = function() {
        if (SHOW.classList.contains('noshow')) {
            SHOW.classList.remove('noshow');
            SHOW.classList.add('show');
        } else {
            SHOW.classList.remove('show');
            SHOW.classList.add('noshow');
        }
    }
}
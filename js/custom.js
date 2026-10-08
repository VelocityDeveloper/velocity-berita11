(function () {
    var header = document.querySelector('.header-position');
    if (!header) {
        return;
    }
    var holder = header.parentNode;
    var fixed = false;

    function update() {
        var shouldFix = window.scrollY >= 200;
        if (shouldFix === fixed) {
            return;
        }
        fixed = shouldFix;
        // Ganti ruang menu yang lepas agar isi halaman tidak meloncat.
        holder.style.paddingTop = fixed ? header.offsetHeight + 'px' : '';
        header.classList.toggle('fixedHeader', fixed);
    }

    window.addEventListener('scroll', update, { passive: true });
    update();
})();

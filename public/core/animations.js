function scrollToElement(id, time = 150) {
    const targetElement = document.getElementById(id);
    if (!targetElement) return;

    const offsetTop = targetElement.offsetTop;
    const currentScrollPosition = window.pageYOffset;
    const distance = offsetTop - currentScrollPosition;
    const duration = time;

    function animateScroll(timestamp) {
        const startTime = timestamp || performance.now();
        const progress = timestamp - startTime;
        const percentage = Math.min(progress / duration, 1);
        window.scrollTo(0, currentScrollPosition + distance * percentage);

        if (progress < duration) {
            window.requestAnimationFrame(animateScroll);
        }
    }

    window.requestAnimationFrame(animateScroll);
}

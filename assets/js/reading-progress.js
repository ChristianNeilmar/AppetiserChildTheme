document.addEventListener('DOMContentLoaded', function() {
    // Only run on single posts
    if (!document.body.classList.contains('single')) return;

    // Function to create a progress bar element
    function createProgressBar() {
        const progressBar = document.createElement('div');
        progressBar.className = 'reading-progress-bar';
        const progress = document.createElement('div');
        progress.className = 'progress';
        progressBar.appendChild(progress);
        return progressBar;
    }

    // Function to insert a progress bar after a header
    function insertProgressBarAfterHeader(headerSelector) {
        const header = document.querySelector(headerSelector);
        if (header && !header.nextElementSibling?.classList?.contains('reading-progress-bar')) {
            const progressBar = createProgressBar();
            header.after(progressBar);
            return progressBar;
        }
        return null;
    }

    // Insert progress bars after both headers if they exist
    const bars = [];
    const desktopBar = insertProgressBarAfterHeader('.infinite-header-container');
    if (desktopBar) bars.push(desktopBar);
    const mobileBar = insertProgressBarAfterHeader('.infinite-mobile-header-container');
    if (mobileBar) bars.push(mobileBar);

    // If neither header exists, poll until at least one does
    if (bars.length === 0) {
        const interval = setInterval(function() {
            const desktopBar = insertProgressBarAfterHeader('.infinite-header-container');
            const mobileBar = insertProgressBarAfterHeader('.infinite-mobile-header-container');
            if (desktopBar || mobileBar) {
                if (desktopBar) bars.push(desktopBar);
                if (mobileBar) bars.push(mobileBar);
                clearInterval(interval);
            }
        }, 100);
    }

    // Calculate and update progress for all bars
    function updateProgress() {
        const content = document.querySelector('.infinite-content-container');
        if (!content) return;
        const contentTop = content.offsetTop;
        const contentHeight = content.offsetHeight;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const windowHeight = window.innerHeight;
        const totalScrollable = contentHeight - windowHeight;
        let percent = 0;
        if (totalScrollable <= 0) {
            percent = 100;
        } else {
            const scrolled = scrollTop - contentTop;
            percent = Math.min(100, Math.max(0, (scrolled / totalScrollable) * 100));
        }
        bars.forEach(bar => {
            const progress = bar.querySelector('.progress');
            if (progress) progress.style.width = percent + '%';
        });
    }

    window.addEventListener('scroll', updateProgress);
    window.addEventListener('resize', updateProgress);
    updateProgress();
});
document.addEventListener("DOMContentLoaded", () => {
    const observer = new IntersectionObserver(entries => {
        document.querySelector("header").classList.toggle("header_bg", entries[0].intersectionRatio < 0.85)
    }, { threshold: 0.85 });

    observer.observe(document.querySelector("main"));
});






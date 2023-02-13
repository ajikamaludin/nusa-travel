<script>
    const loaderContainer = document.querySelector('.loader-container');
    const mainContainer = document.querySelector('.main-content');
    window.addEventListener('load', () => {
        loaderContainer.classList.remove('hidden');
        mainContainer.style.display = 'none';
        setTimeout(() => {
            loaderContainer.classList.add('hidden');
            mainContainer.style.display = 'block';
        }, 800);
    });
</script>
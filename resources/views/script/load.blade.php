<script>
    const loaderContainer = document.querySelector('.loader-container');
    const mainContainer = document.querySelector('.main-content');
    loaderContainer.classList.remove('hidden');
    mainContainer.style.display = 'none';
    window.addEventListener('load', () => {
        setTimeout(() => {
            loaderContainer.classList.add('hidden');
            mainContainer.style.display = 'block';
        }, 800);
    });
</script>

document.addEventListener('DOMContentLoaded', function () {
    const componentContent = document.getElementById('component-content');

    document.getElementById('acao1').addEventListener('click', function (e) {
        e.preventDefault();
        loadComponentContent('/colaboradores/acao1');
    });

    document.getElementById('acao2').addEventListener('click', function (e) {
        e.preventDefault();
        loadComponentContent('/colaboradores/acao2');
    });

    function loadComponentContent(url) {
        fetch(url)
            .then(response => response.text())
            .then(content => {
                componentContent.innerHTML = content;
            });
    }
});
document.getElementById('opsi').addEventListener('change', function(){
    const url = this.value;
    if (url) {
        window.location.href = url;
    }
});
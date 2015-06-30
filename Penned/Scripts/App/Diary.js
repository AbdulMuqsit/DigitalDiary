
//After authentication, load user's diary
(function () {
    document.getElementById('login').onclick = function () {
        var xhr = new XMLHttpRequest();

        xhr.open("GET", 'Views/Diary.html', true);
        xhr.onreadystatechange = handle;
        xhr.send(null);


        function handle() {
            if (xhr.readyState == 4) {
                document.getElementById('content').innerHTML = xhr.responseText;
                loadDiary();
                set();
            }
        }
    };
})();


//After authentication, load user's diary



(function () {
    document.getElementById('login').onclick = function () {
        var xhr = new XMLHttpRequest();

        xhr.open("GET", 'Views/Diary.html', true);
        xhr.onreadystatechange = handle;
        xhr.send(null);


        function handle(d) {
            if (xhr.readyState == 4) {
                document.getElementById('content').innerHTML = xhr.responseText;
                setUp();

                var x = new XMLHttpRequest();
                x.open('GET', 'Api/Entries.php', true);
                x.onreadystatechange = execute;
                x.send(null);

                function execute() {
                    if (x.readyState == 4) {
                        var entries = JSON.parse(x.response);
                        var pages = entries.length + 5;

                        loadDiary(pages);
                    }
                }

            }
        }
    };
})();




//After authentication, load user's diary
(function () {
    document.getElementById('login').onclick = function () {
        var receiveReq = new XMLHttpRequest();

        receiveReq.open("GET", 'Views/DiaryView.html', true);
        receiveReq.onreadystatechange = handle;
        receiveReq.send(null);


        function handle() {
            if (receiveReq.readyState == 4) {
                document.getElementById('viewPort').innerHTML = receiveReq.responseText;
                loadDiary();
            }
        }
    };
})();

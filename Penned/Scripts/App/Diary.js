
function setUp() {

    //on click at entries menu button open the entires bar and resize the main area
    document.getElementById("entriesmenubutton").onclick = function () {
        document.getElementById('main').classList.toggle('tract');
        document.getElementById('entriesmenu').classList.toggle('show');



        //if entries are not already loaded for the user, load them
        if (!document.getElementById("entries").firstChild) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'Api/Entries.php', true);
            xhr.onreadystatechange = handle;
            xhr.send(null);


            //take each entry, format it and add it to the bar
            function handle() {
                if (xhr.readyState == 4) {
                    var entries = JSON.parse(xhr.response);
                    var htmlString = "";
                    for (var key in entries) {
                        var entry = entries[key];

                        var days = ["Sunday", "Monday", "Tuesday", "Wednesday",
                        "Thursday", "Friday", "Saturday"];
                        var date = new Date(entry.TIMESTAMP);
                        var day = date.getDay();
                        var month = date.getMonth();
                        var year = date.getFullYear();
                        date = date.getDate();

                        day = days[day];


                        htmlString += '<div class="entry">' +
                                        '<h2>' + entry.Title + '</h2>' +
                                        '<p>' + day + ', ' + date + '/' + month + '/' + year+ '</p>' +
                                      '</div>';
                    }
                    document.getElementById('entries').innerHTML = htmlString;
                }
            }


        }
    };
};
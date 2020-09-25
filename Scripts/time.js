idList = document.querySelectorAll("[id^='startTime']");
var times = [];
//push initial values to array
for (var i in idList) {
    times.push(idList[i].textContent);
}
//write while loop to get array of id's like "time", then use those values in the startTime function
function startTime() {
    for (var i in times) {
        //if the value is not just "n/a"
        if (times[i] !== 'N/A') {
            //values for past time
            var time = times[i];
            var fDate = '2000/01/01 ';
            var d1 = new Date(fDate.concat(time));
            //value for current date
            var d = new Date();
            //math to get the time difference
            d.setHours(d.getHours() - d1.getHours());
            d.setMinutes(d.getMinutes() - d1.getMinutes());
            d.setSeconds(d.getSeconds() - d1.getSeconds());
            //setting hours, mins, secs, to difference
            var h = d.getHours();
            var m = d.getMinutes();
            var s = d.getSeconds();
            //add zeros if necessary
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById(idList[i].id).innerHTML = h + ':' + m + ':' + s;

        }
    }
}



function checkTime(i) {
    var j = i;
    if (i < 10) {
        j = '0' + i;
    }
    return j;
}

setInterval(function() {
    startTime();
}, 500);
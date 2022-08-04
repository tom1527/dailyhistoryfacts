setDate();

function setDate(monthLong, month, day){
    if(!month || !day){
        var date = new Date();
        var month = date.getMonth() + 1;
        var monthLong = date.toLocaleString('default', { month: 'long' });
        var day = date.getDate();
    } 

    nth = setOrdinals(day);

    if(monthLong && day && nth) {
        today = "Today's date is: " + monthLong + " " + day + nth;
        document.getElementById("today").innerHTML = today;
        factDate = "On " + monthLong + " " + day + nth + " in the past... ";
    } else {
        const dateErrorMessage = "Today's date is: Error - we couldn't read your date.";
        document.getElementById("today").innerHTML = dateErrorMessage;
    }
    
    getFact(month, day);
}

function setOrdinals(value){
    if (value > 3 && value < 21) {
        return 'th';
    }
    switch (value % 10) {
        case 1:  return "st";
        case 2:  return "nd";
        case 3:  return "rd";
        default: return "th";
    }
}

function getFact(month, day) {
    let url = "daily-fact.php?month=" + month + "&day=" + day;

    const dailyFactDate = new Request(url, {
        credentials: 'include',
        type: 'GET',
        method: 'GET',
        headers: {
            'Content-Type': 'text/html',
        },
        mode: 'same-origin',
        cache: 'default',
    });

    
    let div=document.getElementById("daily-fact");
    
        console.log("Loading fact...");
    fetch(dailyFactDate).then((response) => {
        console.log(response.status);
        // if(response.status == 200) {
        response.text().then(html => {
            div.innerHTML = html;
            if(response.status == 200) {
                document.getElementById("firstFactDate").innerHTML = factDate;
            } 
        })
    });
}

function changeFact() {
    var first = document.getElementById("first");
    var last = document.getElementById("last");
    changeVisibility(first);
    changeVisibility(last);
    document.getElementById("lastFactDate").innerHTML = factDate;
} 

function changeVisibility(element) {
    if(element.style.display === "none") {
        element.classList.add('visible');
        element.classList.remove('hidden');
        setTimeout(function() {
            element.style.display = "block";
        }, 500);
    } else {
        element.classList.add('hidden');
        element.classList.remove('visible');
        setTimeout(function() {
            element.style.display = "none";
        }, 500);
    }
}

$(function() {
    $('.DateTextBox').datepicker({
        showAnim: "",
        dateFormat: 'MM/m/d',
        changeYear: false,
        onSelect: function(date) {
            var first = document.getElementById("first");
            changeVisibility(first);
            setTimeout(function() {
                multipleDates = date.split("/");
                const monthLong = multipleDates[0];
                const month = multipleDates[1];
                const day = multipleDates[2];
                let url = "daily-fact.php?month=" + month + "&day=" + day;
                setDate(monthLong, month, day);
                changeVisibility(first);
            }, 250);
        },
    });    
});

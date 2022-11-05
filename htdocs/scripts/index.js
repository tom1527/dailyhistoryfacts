setDate();

function setDate(monthLong, month, day){
    var date = new Date();
    if(!month || !day){
        var month = date.getMonth() + 1;
        var monthLong = date.toLocaleString('default', { month: 'long' });
        var day = date.getDate();
    } 

    const systemDay = date.getDate();
    const systemMonthLong = date.toLocaleString('default', { month: 'long' });

    systemDayNth = setOrdinals(systemDay);
    nth = setOrdinals(day);

    if(monthLong && day && nth) {
        today = "Today's date is: " + systemMonthLong + " " + systemDay + systemDayNth;
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
    
    fetch(dailyFactDate).then((response) => {
        response.text().then(html => {
            div.innerHTML = html;
            if(response.status != 400) {
                document.getElementById("firstFactDate").innerHTML = factDate;
            } 
            if(response.status == 404) {
                makeFallbackRequest(day, month);
            }
        })
    });
}

function makeFallbackRequest(day, month) {
    let url = `https://en.wikipedia.org/api/rest_v1/feed/onthisday/events/${month}/${day}`
    const dailyFactDate = new Request(url, {
        // credentials: 'include',
        type: 'GET',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
        mode: 'cors',
        cache: 'default',
    });
    fetch(dailyFactDate).then((response) => {
        console.log(response.status);
        if(response.status == 200) {
            response.json().then((factList)=>{
                const results = selectFallbackFacts(factList);
                window.extractSpans = [];
                for(i = 0; i < results.length; i++) {
                    const result = results[i];
                    const fact = document.getElementById(`fact${i+1}`);

                    fact.innerHTML = `In ${result.year}, ${result.teaser}`;
                    fact.parentNode.querySelector('.card-link').innerHTML = `Click <a id="link${i}" href=${result.link} target="blank"><b>here</b></a> to learn more.`;

                    const image = document.getElementById(`image${i+1}`);
                    image.setAttribute('href', result.image);
                    image.firstElementChild.setAttribute('src', result.image);

                    const warningDiv = document.createElement("span")
                    warningDiv.innerHTML = 'Alert: this is not a curated fact like you might see on other days. As a fact hasn\'t been chosen for today, a random one has been selected. Therefore, the quality or relevance of today\'s fact may seem off.';
                    warningDiv.style.fontWeight = 'bold';
                    const div = document.createElement("div");
                    div.classList.add("alert", "alert-danger");
                    div.appendChild(warningDiv);

                    if(result.extract) {
                        var extractDiv = document.createElement("div");
                        fact.after(extractDiv);
                        var extractButton = document.createElement("button");
                        var extractSpan = document.createElement("span"); 
                        window.extractSpans.push(`extractSpan${i+1}`);
                        
                        extractButton.innerText = "Expand";
                        extractButton.id = `extractButton${i+1}`;
                        extractButton.addEventListener('click', expandFact);

                        extractSpan.id = `extractSpan${i + 1}`;
                        extractSpan.innerHTML = result.extract;
                        extractSpan.style.display = "none";

                        extractDiv.appendChild(extractSpan);
                        extractDiv.appendChild(extractButton);
                    }

                    fact.parentNode.appendChild(div.cloneNode(true));
                }
            });
        }
    });
}

function revealExtract() {
    document.getElementById("extractSpan").style.display = "block";
}

function selectFallbackFacts(factList) {
    const firstFavouredYear = 1750;
    const secondFavouredYear = 1850;
    
    const facts = factList.events
	var firstFavouredFact = selectClosestFact(facts, firstFavouredYear);
	var secondFavouredFact = selectClosestFact(facts, secondFavouredYear);
	
    var results = [];
	results.push(firstFavouredFact, secondFavouredFact);
    return results;
}

function selectClosestFact(facts, favouredYear) {
    var favouredFact = {};
    favouredFact.year = 0;
    for (var fact of facts){
        if (Math.abs (favouredYear - fact.year) < Math.abs (favouredYear - favouredFact.year)) {
            favouredFact = {
                teaser: fact.text,
                year: fact.year,
                extract: fact.pages[0].extract_html,
                link: fact.pages[0].content_urls.desktop.page,
                ...(fact.pages[0].originalimage) && {image: fact.pages[0].originalimage.source}
            }
        }
    }
    return favouredFact;
}

function changeFact() {
    var first = document.getElementById("first");
    var last = document.getElementById("last");
    changeVisibility(first);
    changeVisibility(last);
    document.getElementById("lastFactDate").innerHTML = factDate;
} 

function expandFact(event) {
        const button = event.currentTarget;
        const extractNumber = button.id.substring(13);
        var extract = document.getElementById(`extractSpan${extractNumber}`);
        if(extract.style.display == "none") {
            button.innerText = "Collapse";
            extract.style.display = "block";
        } else {
            button.innerText = "Expand";
            extract.style.display = "none";
        }                           
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
            window.scrollTo(0, 0);
        },
    });    
});

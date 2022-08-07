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
    
        console.log("Loading fact...");
    fetch(dailyFactDate).then((response) => {
        console.log(response.status);
        // if(response.status == 200) {
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
                        extractDiv.appendChild(extractSpan);
                        extractButton.innerText = "Expand";
                        extractButton.addEventListener('click', function(e){
                            if(document.getElementById("extractSpan").style.display == "none") {
                                e.currentTarget.innerText = "Collapse";
                                document.getElementById("extractSpan").style.display = "block";
                            } else {
                                e.currentTarget.innerText = "Expand";
                                document.getElementById("extractSpan").style.display = "none";
                            }
                        } );
                        extractSpan.id = "extractSpan";
                        extractSpan.innerHTML = result.extract;
                        extractSpan.style.display = "none";

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
    const facts = factList.events
    var results = [];
    for(var fact in facts) {
        if(results.length == 2) { break; }
        if(!facts[fact].year || facts[fact].year > 1945) {
            continue;
        } else if(!facts[fact].pages) {
            continue;
        } else if(!facts[fact].text || !facts[fact].pages[0].extract_html) {
            continue
        } else {
            const result = {
                teaser: facts[fact].text,
                year: facts[fact].year,
                extract: facts[fact].pages[0].extract_html,
                link: facts[fact].pages[0].content_urls.desktop.page,
                ...(facts[fact].pages[0].originalimage) && {image: facts[fact].pages[0].originalimage.source}
            }
            results.push(result);
        }
    } 
    return results;
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
            window.scrollTo(0, 0);
        },
    });    
});

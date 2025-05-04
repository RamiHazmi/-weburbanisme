function handleDialogflowResponse(response) {
    if (response.error) {
        console.error('Dialogflow error:', response.message);
        return;
    }

    // Handle the action if one is specified
    if (response.action) {
        switch (response.action) {
            case 'find_station':
                if (response.parameters && response.parameters.station_name) {
                    findStation(response.parameters.station_name);
                } else {
                    console.error('No station name provided');
                }
                break;
            case 'show_stations':
                if (response.parameters && response.parameters.station_name) {
                    showStation(response.parameters.station_name);
                } else {
                    console.error('No station name provided');
                }
                break;
            case 'show_all_stations':
                showAllStations();
                break;
        }
    }

    // Speak the response
    speak(response.reply);
}

function findStation(stationName) {
    console.log('Finding station:', stationName);
    
    // Make an AJAX call to findStation.php
    fetch('findStation.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'station_name=' + encodeURIComponent(stationName)
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error('Error finding station:', data.message);
            speak("I couldn't find that station. Please try again.");
            return;
        }

        if (data.station) {
            // Scroll to the station
            const stationElement = document.querySelector(`[data-station-id="${data.station.id}"]`);
            if (stationElement) {
                stationElement.scrollIntoView({ behavior: 'smooth' });
                // Highlight the station
                stationElement.classList.add('highlight');
                setTimeout(() => {
                    stationElement.classList.remove('highlight');
                }, 3000);
                speak(`I found station ${data.station.name}. It is located at ${data.station.location}.`);
            } else {
                speak("I found the station in the database but couldn't locate it on the map.");
            }
        } else {
            speak("I couldn't find that station. Please try again.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        speak("Sorry, there was an error finding the station.");
    });
}

function showStation(stationName) {
    console.log('Showing station:', stationName);
    
    // Get the search input element
    const searchInput = document.getElementById('station-search');
    if (!searchInput) {
        console.error('Search input element not found');
        speak("Sorry, I couldn't find the search input.");
        return;
    }

    // Set the search input value to filter stations
    searchInput.value = stationName;
    
    // Trigger the filter function
    filterStations();
    
    // Get all visible station cards after filtering
    const visibleCards = document.querySelectorAll('.station-card');
    let found = false;
    
    visibleCards.forEach(card => {
        if (card.style.display !== 'none') {
            found = true;
            // Scroll to the visible station
            card.scrollIntoView({ behavior: 'smooth' });
            
            // Highlight the station
            card.classList.add('highlight');
            setTimeout(() => {
                card.classList.remove('highlight');
            }, 3000);
            
            // Get the station name from the card
            const stationName = card.getAttribute('data-station-name');
            speak(`Here is station ${stationName}.`);
        }
    });
    
    if (!found) {
        speak("I couldn't find that station. Please try again.");
    }
}

function showAllStations() {
    console.log('Showing all stations');
    
    // Get the search input element
    const searchInput = document.getElementById('station-search');
    if (!searchInput) {
        console.error('Search input element not found');
        speak("Sorry, I couldn't find the search input.");
        return;
    }

    // Clear the search input to show all stations
    searchInput.value = '';
    
    // Trigger the filter function to show all stations
    filterStations();
    
    // Get all station cards
    const allCards = document.querySelectorAll('.station-card');
    
    if (allCards.length > 0) {
        // Scroll to the first station
        allCards[0].scrollIntoView({ behavior: 'smooth' });
        
        // Count the number of stations
        speak(`There are ${allCards.length} stations available.`);
    } else {
        speak("There are no stations available at the moment.");
    }
} 
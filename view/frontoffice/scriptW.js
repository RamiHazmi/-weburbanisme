function handleDialogflowResponse(response) {
    if (response.error) {
        console.error('Dialogflow error:', response.message);
        return;
    }

    // Log the response for debugging
    console.log('Dialogflow Response:', response);

    // Display debug information if available
    if (response.debug) {
        console.log('Debug Information:', response.debug);
        const debugPanel = document.getElementById('debug-panel') || createDebugPanel();
        debugPanel.innerHTML = `
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                <h4 style="color: #333; margin-bottom: 10px;">Debug Information</h4>
                <p style="margin: 5px 0;"><strong>Start Station:</strong> ${response.debug.start_station_name} (ID: ${response.debug.start_station_id})</p>
                <p style="margin: 5px 0;"><strong>End Station:</strong> ${response.debug.end_station_name} (ID: ${response.debug.end_station_id})</p>
                <p style="margin: 5px 0;"><strong>Available Stations:</strong> ${response.debug.all_stations.join(', ')}</p>
                <p style="margin: 5px 0;"><strong>Input Text:</strong> ${response.debug.input_text}</p>
            </div>
        `;
        debugPanel.style.display = 'block';
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

function createDebugPanel() {
    const panel = document.createElement('div');
    panel.id = 'debug-panel';
    panel.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        max-width: 300px;
        z-index: 1000;
        font-size: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        display: none;
    `;
    document.body.appendChild(panel);
    return panel;
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
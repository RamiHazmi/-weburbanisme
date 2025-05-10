function handleDialogflowResponse(response) {
    const reply = response.reply;
    const action = response.action;
    const parameters = response.parameters;
    const debug = response.debug;

    // Log debug information to console
    if (debug) {
        console.log('Debug Information:');
        console.log('Start Station:', debug.start_station_name, '(ID:', debug.start_station_id, ')');
        console.log('End Station:', debug.end_station_name, '(ID:', debug.end_station_id, ')');
    }

    // Speak the reply
    speak(reply);

    // Handle different actions
    switch (action) {
        case 'find_station':
            // Redirect to Bikesfront.php with station ID
            window.location.href = `Bikesfront.php?station_id=${parameters.station_id}`;
            break;
        case 'show_stations':
            // Update search input and filter stations
            document.getElementById('station-search').value = parameters.station_name;
            filterStations();
            break;
        case 'show_all_stations':
            // Show all stations
            document.getElementById('station-search').value = '';
            filterStations();
            break;
        case 'rent_bike':
            // Process the rental
            if (parameters.bike_id && parameters.start_station && parameters.end_station) {
                // Create a form and submit it to rentBike.php
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'rentBike.php';

                // Add hidden inputs
                const bikeIdInput = document.createElement('input');
                bikeIdInput.type = 'hidden';
                bikeIdInput.name = 'bike_id';
                bikeIdInput.value = parameters.bike_id;
                form.appendChild(bikeIdInput);

                const userIdInput = document.createElement('input');
                userIdInput.type = 'hidden';
                userIdInput.name = 'user_id';
                userIdInput.value = parameters.user_id;
                form.appendChild(userIdInput);

                const endStationInput = document.createElement('input');
                endStationInput.type = 'hidden';
                endStationInput.name = 'end_station';
                endStationInput.value = parameters.end_station;
                form.appendChild(endStationInput);

                // Add form to document and submit
                document.body.appendChild(form);
                form.submit();
            }
            break;
        case 'error':
            // Just show the error message (already spoken)
            break;
    }
}

// Add this function to handle voice input
function handleVoiceInput(text) {
    // Create debug info element if it doesn't exist
    let debugInfo = document.getElementById('debug-info');
    if (!debugInfo) {
        debugInfo = document.createElement('div');
        debugInfo.id = 'debug-info';
        debugInfo.style.cssText = 'position: fixed; top: 20px; right: 20px; background: white; padding: 10px; border: 1px solid #ccc; z-index: 1000;';
        document.body.appendChild(debugInfo);
    }

    // Clear previous content
    debugInfo.innerHTML = '';
    
    // Add the captured command
    const commandText = document.createElement('p');
    commandText.textContent = 'Voice Command: ' + text;
    debugInfo.appendChild(commandText);
    
    // Extract station names from the command
    const stationMatch = text.match(/rent\s+(?:me\s+)?a\s+bike\s+from\s+([^to]+)\s+to\s+(.+)/i);
    if (stationMatch) {
        const startStation = stationMatch[1].trim();
        const endStation = stationMatch[2].trim();
        
        const stationsText = document.createElement('p');
        stationsText.textContent = 'Stations Detected:';
        debugInfo.appendChild(stationsText);
        
        const startStationText = document.createElement('p');
        startStationText.textContent = 'Start Station: ' + startStation;
        debugInfo.appendChild(startStationText);
        
        const endStationText = document.createElement('p');
        endStationText.textContent = 'End Station: ' + endStation;
        debugInfo.appendChild(endStationText);
    }

    // Send to Dialogflow
    fetch('dialogflowHandler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'message=' + encodeURIComponent(text)
    })
    .then(response => response.json())
    .then(data => {
        // Add station IDs to debug info
        if (data.debug) {
            const startIdText = document.createElement('p');
            startIdText.textContent = 'Start Station ID: ' + data.debug.start_station_id;
            debugInfo.appendChild(startIdText);
            
            const endIdText = document.createElement('p');
            endIdText.textContent = 'End Station ID: ' + data.debug.end_station_id;
            debugInfo.appendChild(endIdText);
        }
        
        handleDialogflowResponse(data);
    })
    .catch(error => {
        const errorText = document.createElement('p');
        errorText.textContent = 'Error: ' + error;
        errorText.style.color = 'red';
        debugInfo.appendChild(errorText);
    });
} 
<?php
use Google\Cloud\Dialogflow\V2\Client\SessionsClient;
use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\DetectIntentRequest;

// Set header to JSON
header('Content-Type: application/json');

try {
    require 'vendor/autoload.php';

    // Check if message is provided
    if (!isset($_POST['message'])) {
        throw new Exception('No message provided');
    }

    // Get the project ID from Dialogflow Console
    $projectId = 'ebikevoiceassistant';
    $sessionId = uniqid();
    $languageCode = 'en-US';
    $inputText = $_POST['message'];

    error_log('Dialogflow Request - Input Text: ' . $inputText);

    // Check if credentials file exists
    $credentialsPath = "C:/xampp/htdocs/urbanisme/View/FrontOffice/ebikevoiceassistant-66bfca0c606d.json";
    if (!file_exists($credentialsPath)) {
        throw new Exception('Credentials file not found');
    }

    putenv("GOOGLE_APPLICATION_CREDENTIALS=" . $credentialsPath);

    $sessionsClient = new SessionsClient();
    $session = $sessionsClient->sessionName($projectId, $sessionId);

    $textInput = new TextInput();
    $textInput->setText($inputText);
    $textInput->setLanguageCode($languageCode);

    $queryInput = new QueryInput();
    $queryInput->setText($textInput);

    $request = new DetectIntentRequest();
    $request->setSession($session);
    $request->setQueryInput($queryInput);

    $response = $sessionsClient->detectIntent($request);
    $queryResult = $response->getQueryResult();

    // Get the intent name and parameters
    $intent = $queryResult->getIntent();
    $parameters = $queryResult->getParameters();

    error_log('Dialogflow Response - Intent: ' . $intent->getDisplayName());
    error_log('Dialogflow Response - Parameters: ' . print_r($parameters->getFields(), true));
    error_log('Dialogflow Response - Confidence: ' . $queryResult->getIntentDetectionConfidence());

    // Map Dialogflow intent names to our action names
    $intentName = $intent->getDisplayName();
    $action = '';
    $actionParameters = [];

    switch ($intentName) {
        case 'FindStation':
        case 'LocateStation':  // Add support for LocateStation intent
            $action = 'find_station';
            $stationName = $parameters->getFields()['station_name']->getStringValue();
            if (empty($stationName)) {
                // Try to extract station name from the command if parameter is empty
                if (preg_match('/(?:find|locate)\s+station\s+(.+)/i', $inputText, $matches)) {
                    $stationName = trim($matches[1]);
                }
            }
            $actionParameters = [
                'station_name' => $stationName
            ];
            break;
        case 'ShowStation':
            $action = 'show_stations';
            $stationName = $parameters->getFields()['station_name']->getStringValue();
            if (empty($stationName)) {
                // Try to extract station name from the command if parameter is empty
                if (preg_match('/(?:show|show me)\s+station\s+(.+)/i', $inputText, $matches)) {
                    $stationName = trim($matches[1]);
                }
            }
            $actionParameters = [
                'station_name' => $stationName
            ];
            break;
        case 'ShowAllStations':
            $action = 'show_all_stations';
            break;
        case 'RentBike':
            $action = 'rent_bike';
            error_log('Starting RentBike command processing');
            
            // Log the raw input and parameters
            error_log('Raw input text: ' . $inputText);
            error_log('Dialogflow parameters: ' . print_r($parameters->getFields(), true));
            
            // First try to extract station names from the command using regex
            $startStation = '';
            $endStation = '';
            error_log('Attempting to extract station names using regex patterns');
            
            // Try different patterns to extract station names
            if (preg_match('/(?:rent|get)\s+bike\s+from\s+(.+?)\s+to\s+(.+)/i', $inputText, $matches)) {
                error_log('Pattern 1 matched: "rent/get bike from X to Y"');
                $startStation = trim($matches[1]);
                $endStation = trim($matches[2]);
                error_log('Pattern 1 extracted - Start: "' . $startStation . '", End: "' . $endStation . '"');
            } else if (preg_match('/(?:rent|get)\s+bike\s+at\s+(.+?)\s+and\s+go\s+to\s+(.+)/i', $inputText, $matches)) {
                error_log('Pattern 2 matched: "rent/get bike at X and go to Y"');
                $startStation = trim($matches[1]);
                $endStation = trim($matches[2]);
                error_log('Pattern 2 extracted - Start: "' . $startStation . '", End: "' . $endStation . '"');
            } else if (preg_match('/(?:rent|get)\s+bike\s+from\s+(.+?)\s+destination\s+(.+)/i', $inputText, $matches)) {
                error_log('Pattern 3 matched: "rent/get bike from X destination Y"');
                $startStation = trim($matches[1]);
                $endStation = trim($matches[2]);
                error_log('Pattern 3 extracted - Start: "' . $startStation . '", End: "' . $endStation . '"');
            } else {
                error_log('No regex patterns matched the input text');
            }
            
            // If regex extraction failed, try Dialogflow parameters
            if (empty($startStation) || empty($endStation)) {
                error_log('Regex extraction failed, trying Dialogflow parameters');
                
                // Handle array parameters from Dialogflow
                $stationA = $parameters->getFields()['stationA'];
                $stationB = $parameters->getFields()['stationB'];
                
                // Check if parameters are arrays and get the first element
                if ($stationA && $stationA->hasListValue()) {
                    $startStation = $stationA->getListValue()->getValues()[0]->getStringValue();
                } else {
                    $startStation = $stationA->getStringValue();
                }
                
                if ($stationB && $stationB->hasListValue()) {
                    $endStation = $stationB->getListValue()->getValues()[0]->getStringValue();
                } else {
                    $endStation = $stationB->getStringValue();
                }
                
                error_log('Dialogflow parameters - Start: "' . $startStation . '", End: "' . $endStation . '"');
            }
            
            // Check bike availability
            require_once __DIR__ . '/../../Controller/BikeStationController.php';
            require_once __DIR__ . '/../../Controller/RentalController.php';
            require_once __DIR__ . '/../../Model/BikeRentalM.php';
            
            $bikeStationController = new BikeStationController();
            $rentalController = new BikeRentalController();
            
            // Get all stations for debugging
            $allStations = $bikeStationController->listStations();
            $stationNames = array_map(function($station) {
                return $station['name'];
            }, $allStations);
            error_log('Available stations: ' . implode(', ', $stationNames));
            
            // Get station IDs from names using the same method as FindStation
            error_log('Looking up station IDs...');
            error_log('Looking up start station: "' . $startStation . '"');
            $startStationId = $bikeStationController->getStationIdByNameExact($startStation);
            error_log('Looking up end station: "' . $endStation . '"');
            $endStationId = $bikeStationController->getStationIdByNameExact($endStation);
            error_log('Found station IDs - Start: ' . ($startStationId ? $startStationId : 'Not found') . 
                     ', End: ' . ($endStationId ? $endStationId : 'Not found'));
            
            // Debug information
            $debugInfo = [
                'start_station_name' => $startStation,
                'end_station_name' => $endStation,
                'start_station_id' => $startStationId ? $startStationId : 'Not found',
                'end_station_id' => $endStationId ? $endStationId : 'Not found',
                'all_stations' => $stationNames,
                'input_text' => $inputText
            ];
            
            if (!$startStationId || !$endStationId) {
                error_log('Error: Could not find one or both stations');
                $response = [
                    'reply' => "I couldn't find one or both of the stations. Please try again with correct station names.",
                    'action' => 'error',
                    'parameters' => [],
                    'debug' => $debugInfo
                ];
                echo json_encode($response);
                exit;
            }
            
            // Check available bikes
            error_log('Checking available bikes at start station: ' . $startStationId);
            $availableBikes = $bikeStationController->getAvailableBikesCount($startStationId);
            error_log('Available bikes: ' . $availableBikes);
            
            if ($availableBikes <= 0) {
                error_log('Error: No available bikes at start station');
                $response = [
                    'reply' => "I'm sorry, there are no available bikes at $startStation right now.",
                    'action' => 'error',
                    'parameters' => [],
                    'debug' => $debugInfo
                ];
                echo json_encode($response);
                exit;
            }
            
            // Get first available bike
            error_log('Getting first available bike at station: ' . $startStationId);
            $bikeId = $bikeStationController->getFirstAvailableBike($startStationId);
            error_log('Found bike ID: ' . ($bikeId ? $bikeId : 'Not found'));
            
            if (!$bikeId) {
                error_log('Error: Could not find available bike');
                $response = [
                    'reply' => "I'm sorry, I couldn't find an available bike at $startStation right now.",
                    'action' => 'error',
                    'parameters' => [],
                    'debug' => $debugInfo
                ];
                echo json_encode($response);
                exit;
            }
            
            // Create rental object
            error_log('Creating rental object...');
            $startTime = date('Y-m-d H:i:s');
            $rental = new BikeRental(
                null, // id_rental will be auto-incremented
                $bikeId,
                1, // Default user ID
                $endStationId,
                $startTime,
                null, // end_time will be set when rental is completed
                null, // feedback will be added when rental is completed
                $startStation // Use the station name instead of ID
            );
            
            // Add the rental
            error_log('Adding rental to database...');
            $rentalController->addRental($rental);
            
            // Update bike status
            error_log('Updating bike status to Rented...');
            $bikeStationController->updateBikeStatus($bikeId, 'Rented');
            
            // Decrease available bikes at start station
            error_log('Decreasing available bikes count...');
            $bikeStationController->decreaseAvailableBikes($startStationId);
            
            error_log('Rental process completed successfully');
            $response = [
                'reply' => "I've found a bike for you at $startStation. I'll process your rental now.",
                'action' => 'rent_bike',
                'parameters' => [
                    'bike_id' => $bikeId,
                    'start_station' => $startStation, // Use the station name instead of ID
                    'end_station' => $endStationId,
                    'user_id' => 1
                ],
                'debug' => $debugInfo
            ];
            echo json_encode($response);
            exit;
            break;
        case 'CheckBikes':
            $action = 'check_bikes';
            error_log('Starting CheckBikes command processing');
            
            // Log the raw input and parameters
            error_log('Raw input text: ' . $inputText);
            error_log('Dialogflow parameters: ' . print_r($parameters->getFields(), true));
            
            // First try to extract station name from the command using regex
            $stationName = '';
            error_log('Attempting to extract station name using regex patterns');
            
            // Try different patterns to extract station name
            if (preg_match('/(?:how many|check|show me)\s+bikes?\s+(?:at|in)\s+(.+)/i', $inputText, $matches)) {
                error_log('Pattern 1 matched: "how many bikes at X"');
                $stationName = trim($matches[1]);
            } else if (preg_match('/(?:bikes?\s+availability|available\s+bikes?)\s+(?:at|in)\s+(.+)/i', $inputText, $matches)) {
                error_log('Pattern 2 matched: "bikes availability at X"');
                $stationName = trim($matches[1]);
            } else if (preg_match('/(?:tell me|show me)\s+(?:the\s+)?(?:number\s+of\s+)?bikes?\s+(?:at|in)\s+(.+)/i', $inputText, $matches)) {
                error_log('Pattern 3 matched: "tell me bikes at X"');
                $stationName = trim($matches[1]);
            } else {
                error_log('No regex patterns matched the input text');
            }
            
            // If regex extraction failed, try Dialogflow parameters
            if (empty($stationName)) {
                error_log('Regex extraction failed, trying Dialogflow parameters');
                $stationParam = $parameters->getFields()['station_name'];
                
                // Handle array parameters from Dialogflow
                if ($stationParam && $stationParam->hasListValue()) {
                    $stationName = $stationParam->getListValue()->getValues()[0]->getStringValue();
                } else {
                    $stationName = $stationParam->getStringValue();
                }
                
                error_log('Dialogflow parameter - Station: "' . $stationName . '"');
            }
            
            // Check bike availability
            require_once __DIR__ . '/../../Controller/BikeStationController.php';
            $bikeStationController = new BikeStationController();
            
            // Get station ID from name
            error_log('Looking up station ID for: "' . $stationName . '"');
            $stationId = $bikeStationController->getStationIdByNameExact($stationName);
            
            if (!$stationId) {
                error_log('Error: Could not find station');
                $response = [
                    'reply' => "I couldn't find the station '$stationName'. Please try again with a correct station name.",
                    'action' => 'error',
                    'parameters' => [],
                    'debug' => [
                        'station_name' => $stationName,
                        'input_text' => $inputText
                    ]
                ];
                echo json_encode($response);
                exit;
            }
            
            // Get total and available bikes
            error_log('Getting bike counts for station: ' . $stationId);
            $availableBikes = $bikeStationController->getAvailableBikesCount($stationId);
            $totalBikes = $bikeStationController->getTotalBikesCount($stationId);
            
            error_log('Found ' . $availableBikes . ' available bikes out of ' . $totalBikes . ' total bikes');
            
            $response = [
                'reply' => "At $stationName, there are $availableBikes available bikes out of $totalBikes total bikes.",
                'action' => 'check_bikes',
                'parameters' => [
                    'station_name' => $stationName,
                    'available_bikes' => $availableBikes,
                    'total_bikes' => $totalBikes
                ],
                'debug' => [
                    'station_name' => $stationName,
                    'station_id' => $stationId,
                    'available_bikes' => $availableBikes,
                    'total_bikes' => $totalBikes,
                    'input_text' => $inputText
                ]
            ];
            echo json_encode($response);
            exit;
            break;
    }

    echo json_encode([
        'reply' => $queryResult->getFulfillmentText(),
        'action' => $action,
        'parameters' => $actionParameters
    ]);

    $sessionsClient->close();

} catch (Exception $e) {
    // Return error in JSON format
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
?>

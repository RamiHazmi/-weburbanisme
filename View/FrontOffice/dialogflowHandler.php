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

    // Check if credentials file exists
    $credentialsPath = "C:/xampp/htdocs/urbanisme/View/FrontOffice/ebikevoiceassistant-09516e5d112f.json";
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

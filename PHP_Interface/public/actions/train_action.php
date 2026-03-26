<?php
require_once("../../config_inc.php");

$api = new API_Requests();
$db = new DB_Requests();

try {
    // Get input
    $modelType = $_POST['model_type'] ?? null;
    $modelName = $_POST['model_name'] ?? null;
    $features = $_POST['features'] ?? '';
    $hyperparameters = $_POST['hyperparameters'] ?? '{}';
    $startDate = $_POST['start_date'] ?? null;
    $endDate = $_POST['end_date'] ?? null;


    // Validate
    if (!$modelType || !$features || !$hyperparameters || !$startDate || !$endDate || !$modelName) {
        throw new Exception("Missing required fields.");
    }

    $parameters = [];

    foreach($hyperparameters as $key=>$value) {
        $parameters[$key] = floatval($value);
    }


    // Call API
    $result = $api->create_model($modelType, $modelName, $parameters, $features, $startDate, $endDate);
    print($result);

    // Redirect back with success
    header("Location: ../leaderboard.php?highlight=".$modelName);
    exit;

} catch (Exception $e) {
    // Redirect back with error
    header("Location: ../train.php?error=" . urlencode($e->getMessage()));
    print($e->getMessage());
    exit;
}
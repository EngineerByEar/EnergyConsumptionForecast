<?php
require_once("../../config_inc.php");
include("../../templates/header.php");


$modelName = $_POST["model_name"];
$startDate = $_POST["start_date"];
$endDate = $_POST["end_date"];

if(!$modelName||!$startDate||!$endDate){
    die("Missing parameters");
}
$api = new API_Requests();

$res = $api->get_prediction($modelName, $startDate, $endDate);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Prediction Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

<h2 class="mb-4">Prediction Result</h2>

<div class="card shadow-sm p-4" style="gap: 1vh">

    <div class="mb-3">
        <strong>Model:</strong> <?= htmlspecialchars($modelName) ?><br>
        <strong>Range:</strong> <?= new DateTime($startDate)->format("Y-m-d h:m") ?> → <?= new DateTime($endDate)->format("Y-m-d h:m") ?>
    </div>

    <div class="text-center">
        <img
            src="data:image/png;base64,<?= $res ?>"
            class="img-fluid rounded border"
            style="max-width: 100%; height: auto;"
        >
    </div>
    <a href="../model_prediction.php?modelName=<?=$modelName?>"><button class="btn btn-primary">Create another Prediction</button></a>
    <a href="../model_info.php?modelName=<?=$modelName?>"><button class="btn btn-primary">Model Details</button></a>
    <a href="../leaderboard.php?highlight=<?=$modelName?>"><button class="btn btn-primary">Leaderboard</button></a>
</div>


</body>
</html>

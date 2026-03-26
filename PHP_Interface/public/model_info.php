<?php
require_once("../config_inc.php");
include("../templates/header.php");


$db = new DB_Requests();

if (!isset($_GET['modelName'])) {
    die("No model ID provided.");
}

$model = $db->get_model_info($_GET['modelName'])[0];

if (!$model) {
    die("Model not found.");
}

// Decode JSON fields
$features = explode("," ,$model['features']);
$hyperparameters = [];
foreach(explode("," ,$model['hyperparameters']) as $parameter){
    $name = explode(":", $parameter)[0];
    $value = explode(":", $parameter)[1];
    $hyperparameters[$name] = $value;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Model Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

<h2>Model Details</h2>

<a href="leaderboard.php" class="btn btn-secondary mb-3">← Back</a>

<div class="card p-4">

    <h4><?= $model['model_name'] ?></h4>

    <p><strong>Model Type:</strong> <?= $model['model_type'] ?></p>
    <p><strong>Score (RMSE):</strong> <?= $model['score'] ?></p>

    <p><strong>Training Range:</strong><br>
        <?= $model['training_start'] ?> → <?= $model['training_end'] ?>
    </p>

    <hr>

    <h5>Features</h5>
    <ul>
        <?php foreach ($features as $f): ?>
            <li><?= $f ?></li>
        <?php endforeach; ?>
    </ul>

    <h5>Hyperparameters</h5>
    <ul>
        <?php foreach ($hyperparameters as $key => $value): ?>
            <li><?= $key ?>: <?= $value ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="./model_prediction.php?modelName=<?=$model["model_name"]?>"><button class="btn btn-primary">Create Prediction using <?= $model["model_name"]?></button></a>

</div>

</body>
</html>
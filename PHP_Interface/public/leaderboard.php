<?php
require_once("../config_inc.php");
include("../templates/header.php");


$db = new DB_Requests();
$api = new API_Requests();
$leaderboard = $db->get_leaderboard();

$model_names = [];
$model_scores = [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

<h2>Model Leaderboard</h2>

<table class="table table-striped table-hover mt-4">
    <thead>
        <tr>
            <th>Rank</th>
            <th>Model Name</th>
            <th>Model Type</th>
            <th>Score (RMSE)*</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach ($leaderboard as $index => $row):
        array_push($model_names, $row["model_name"]);
        array_push($model_scores, $row["score"]);
        ?>
        <?php if(isset($_GET["highlight"]) && $_GET["highlight"] == $row['model_name']): ?>
            <tr style="border: solid black">
        <?php else: ?>
            <tr>
        <?php endif;?>
            <td><?= $index + 1 ?></td>

            <td>
                <a href="./model_info.php?modelName=<?= $row['model_name'] ?>">
                    <?= $row['model_name'] ?>
                </a>
            </td>

            <td><?= $row['model_type'] ?></td>
            <td><?= $row['score'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<small class="text-muted" style="margin-top: 2vh; margin-bottom: 2vh;">*Score is calculated on the next 2 weeks after the training data timeframe has ended.</small>

<?php
$res = $api->create_ranking_plot($model_names, $model_scores);
?>
<div class="container" style="display:flex; align-items:center; justify-content: center;">
<img style="width:50vw; height:auto;" id="base64image"
     src="data:image/png;base64,<?php echo $res; ?>" />
</div>
</body>
</html>
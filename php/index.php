<?php
require_once("config_inc.php");
include("./templates/header.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Energy Consumption Forecast</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .hover-underline :hover{
        text-decoration: underline darkgray;
    }
</style>
<html>
<body>

    <div class="text-center my-5">
        <h1 class="display-5 fw-bold">⚡ Energy Consumption Forecast</h1>
        <p class="lead mt-3">
            Train your own machine learning models and explore how different settings impact prediction accuracy.
        </p>

        <div class="mt-4">
            <a href="./public/train.php" class="btn btn-primary btn-lg me-2" style="margin-bottom: 1vh">Start Training</a>
            <a href="./public/leaderboard.php" class="btn btn-outline-secondary btn-lg" style="margin-bottom: 1vh">View Leaderboard</a>
        </div>
    </div>

    <hr class="my-5">

    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <a class="link-dark text-decoration-none hover-underline"  href="./public/train.php"><h4>🔧 Custom Models</h4></a>
            <p>Choose model types, features, and parameters to build your own forecasting models.</p>
        </div>

        <div class="col-md-4 mb-4">
            <a class="link-dark text-decoration-none hover-underline"  href="./public/leaderboard.php"><h4>📊 Compare Results</h4></a>
            <p>See how your models perform and compete on the leaderboard.</p>
        </div>

        <div class="col-md-4 mb-4">
            <a class="link-dark text-decoration-none hover-underline"  href="./public/model_prediction.php"><h4>📈 Visual Predictions</h4></a>
            <p>Generate forecasts and compare them with real energy consumption data.</p>
        </div>
    </div>

    <hr class="my-5">

    <div class="text-center">
        <h4>About This Project</h4>
        <p class="mb-3">
            Learn more about how this system works, including the data, models, and backend API.
        </p>
        <a href="./public/about.php" class="btn btn-outline-primary">Read More</a>
    </div>
</body>
</html>

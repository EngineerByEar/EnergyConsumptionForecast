<?php
require_once("../config_inc.php");
include("../templates/header.php");
?>

<h2 class="mb-4">About This Project</h2>

<h4>📌 Overview</h4>
<p>
    This project is a web-based platform for training and evaluating machine learning models
    to forecast energy consumption.
</p>

<h4>⚙️ System Architecture</h4>
<ul>
    <li>PHP frontend for user interaction</li>
    <li>Python API for model training and prediction</li>
    <li>MariaDB database for storing model configurations and results</li>
</ul>

<h4>🤖 Models</h4>
<p>
    Users can train different models (e.g., XGBoost, Decision Trees) by selecting:
</p>
<ul>
    <li>Features (time, weather, lag values)</li>
    <li>Hyperparameters</li>
    <li>Training time ranges</li>
</ul>

<h4>📊 Data</h4>
<p>
    The models are trained on historical energy consumption data combined with
    time-based and weather-related features.
</p>

<h4>🔌 Python API</h4>
<p>
    The backend API handles:
</p>
<ul>
    <li>Model training</li>
    <li>Evaluation (RMSE score)</li>
    <li>Prediction generation</li>
    <li>Returning plots as images</li>
</ul>
<!---
<h4>🏗️ Development Process</h4>
<p>
    You can describe here:
</p>
<ul>
    <li>Design decisions</li>
    <li>Challenges faced</li>
    <li>Improvements and future work</li>
</ul>

--->


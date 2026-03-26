<!DOCTYPE html>
<html>
<head>
    <title>Energy Forecast</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .navbar {
        border-bottom: 1px solid #e5e5e5;
    }
    .nav-link:hover {
        color: #0d6efd !important;
    }
</style>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="../index.php">
            ⚡ Energy Forecast
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="../public/train.php">Train</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../public/leaderboard.php">Leaderboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../public/model_prediction.php">Prediction</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../public/about.php">About</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Push content below fixed navbar -->
<div style="height: 70px;"></div>

<div class="container">
# ⚡Energy Consumption Forecast
## Overview
This project is a web-based platform for training and evaluating machine learning models to forecast energy consumption.

## System Architecture
PHP frontend for user interaction
Python API for model training and prediction
MariaDB database for storing model configurations and results
## Models
Users can train different models (e.g., XGBoost, Decision Trees) by selecting:

Features (time, weather, lag values)
Hyperparameters
Training time ranges
Data
The models are trained on historical energy consumption data combined with time-based and weather-related features.

## Python API
The backend API handles:

Model training
Evaluation (RMSE score)
Prediction generation
Returning plots as images

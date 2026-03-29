# ⚡ Energy Consumption Forecast

This project is a full-stack application for forecasting hourly energy consumption using machine learning models and weather data.
It combines data preprocessing, feature engineering, model training, and a simple web interface to explore and compare predictions.


## 🎯 Overview

The application predicts energy consumption based on historical usage and external factors such as weather and time-related features.
Users can:
- Train different machine learning models
- Configure feature sets and time ranges
- Compare model performance
- Generate and visualize predictions


## 🤖 Models

Two model types are implemented to compare different approaches:
- **Decision Tree** – simple and interpretable baseline  
- **XGBoost** – more complex gradient boosting model with higher predictive performance  


## 📊 Data

The models are trained on:
- Historical hourly energy consumption data  
- Weather data (e.g. temperature, wind speed, precipitation, sunlight)  

### Feature Engineering

The dataset includes:
- **Lag features** (e.g. previous hour/day consumption)
- **Rolling averages** for smoothing short-term fluctuations  
- **Derived features** such as heating and cooling demand  
- **Time-based features** (hour of day, weekday, seasonality)  

Missing values are handled using previous observations or averaged values from surrounding time periods.

## 🏗️ System Architecture

The application is structured into three main components:
- **Frontend (PHP)**  
  Interface for training models, viewing results, and generating predictions  
- **Backend API (Python / FastAPI)**  
  Handles model training, evaluation, and prediction  
- **Database (MariaDB)**  
  Stores model configurations, metadata, and evaluation results  


## 🔌 API Functionality

The backend provides endpoints for:
- Training models with selected features and parameters  
- Generating predictions  
- Evaluating models using RMSE  
- Comparing model performance across runs  

## 📈 Functionality

The frontend provides:
- A form to train new models  
- A leaderboard to compare model performance  
- A detail view for trained models  
- A prediction page with visual comparison of predicted vs. actual values  

## 🚀 Possible Extensions

- Additional model types (e.g. neural networks, ARIMA)  
- Automated hyperparameter tuning  
- Real-time prediction pipeline  

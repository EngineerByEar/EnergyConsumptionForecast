# ⚡Energy Consumption Forecast
This project is a web-based platform for training and evaluating machine learning models to forecast energy consumption.

## ⚙️System Architecture
* PHP frontend for user interaction
* Python API for model training and prediction
* MariaDB database for storing model configurations and results

## 🐍Python Tech Stack

* FastAPI
* Pandas
* Numpy
* Matplotlib
* SciKit-Learn
* XGBoost
* Pickle
* Pydantic

## 🤖Models
Users can train different models (e.g., XGBoost, Decision Trees) by selecting:

* Features (time, weather, lag values)
* Hyperparameters
* Training time ranges

## 📊Data
The models are trained on historical hourly energy consumption data, time features and weather data.

Source for Energy Data: https://www.entsoe.eu/data/power-stats/
Source for Weather Data: https://dataset.api.hub.geosphere.at/v1/docs/

## 🔌Python API
The backend API handles:

* Model training
* Evaluation (RMSE score)
* Prediction generation
* Returning plots as images

## 🏗️ Development Process
### I started out with sourcing the Data.
This process can be followed in the Data_preprocessing_and_exploration Directory.

Energy Consumption Data for Austria was fairly easy to source because I could find a prepared csv dataset.
Additionally I wanted to add weather data.
The best source I could find was the GeoSphere Austria API. The klima-v2-1h Endpoint provides hourly measurements of austrian weather stations. 
In order to get close to a average I chose 5 weather stations with close to 0 Nan values in austrias biggest citys and created a weighed average by using the city inhabitant count as weight.
The weather features consist of:
* ff = Wind Speed
* rr = Amount of Rain
* so_h = Amount of Sun during the hour
* tl = Air Temperature

Missing values were handled by either filling in data from the day before or averages of surrounding days.
Interestingly sometimes a few consecutive days were missing from certain stations. Probably Maintenance work?
Additional Features include:
* cdg = cooling degree (How likely is it that air conditioners are active and how much)
* hdg = heating degree (How likely is it that radiators are acrive and how much)
* lag features = How much energy was consumed 1h, 24h, 72h before (Useful for short time prediction, but when used long term predictions cant be made)
* rolling features = How much energy was consumed 1h, 24h, 72h before but averaged out (Useful for short time prediction, but when used long term predictions cant be made)
* Day of Week, Month, hour of day...
* Is Free Day (If its a working day or not)

### Next I created the Python API
I used Fast API to create the API.
The great thing about fast API is that it automatically creates a swagger documentation which makes testing the routes super easy.

The main routes are 
* /train/model (Trains a model on selected features, model_type, training_data_start/end and selected hyperparameters)
* /predict (Creates a prediction using a model and returns a graph comparing the prediction to the testing data)
* /plot/ranking (Creates a plot that compares the scores of all trained models)

In order to validate the request data i used pydantic schemas.

Because most free hosting services that i checked out (pythonanywhere and railway) have a limit of 500 MB for the virtual environment i stuck to only comparing 2 model types.

* Classic Machine Learning Model: Decision Tree
* Modern and Complex Model: XGBoost

XGBoost alone takes up aroung 130 MB, so i stopped adding more model options.

After training the models and features that were used(relevant for getting the right testing data) are stored on the python server using pickle.
The rest of the metadata about the models is stored in the MairaDB Database.

### Lastly the PHP FrontEnd
First of I created the classes to handle DataBase Requests and API Requests. 
Using these i created forms, that submit to the requests to the Python API and display any relevant information.
The Frontend has 3 main features:
* Form to train models
* Leaderboard where Models can be compared
* Model Details Page (showing all the model metadata)
* Predict Page (allows to create Predictions using a Model, showing the difference to the testing data in a graph)



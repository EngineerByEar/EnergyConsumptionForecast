from Python_API.schemas.train_schemas import TrainRequest
from sklearn.tree import DecisionTreeRegressor
import pandas as pd
import pickle
import os
from Python_API.utils.data_utils import get_data
import xgboost as xgb
from Python_API.utils.evaluation_utils import evaluate_model
from datetime import timedelta
from datetime import datetime
from pathlib import Path


MODEL_STORAGE = Path(os.getenv("MODEL_STORAGE_PATH", "/app/model_storage"))
MODEL_STORAGE.mkdir(parents=True, exist_ok=True)


BASE_DIR = Path(__file__).resolve().parent.parent
DATA_PATH = BASE_DIR / "data" / "energy_and_weather_data.csv"


data = pd.read_csv(DATA_PATH,
                   parse_dates=["DateUTC"])

async def train_decision_tree(request: TrainRequest):
    training_data = get_data(request.training_data_time_start, request.training_data_time_end)
    X_train = training_data[request.features]
    y_train = training_data["Value"]
    params = request.hyperparameters
    model = DecisionTreeRegressor(criterion="squared_error",
                                  max_depth=params["max_depth"],
                                  min_samples_split = params["min_samples_split"],
                                  min_samples_leaf= params["min_samples_leaf"],
                                  max_features=params["max_features"],
                                  ccp_alpha= params["ccp_alpha"]
                                  )
    model.fit(X_train, y_train)
    model_path = model_path = MODEL_STORAGE / f"{request.model_name}.pkl"

    dump = {
        "model": model,
        "features": request.features
    }
    if os.path.exists(model_path):
        return "Name already in use"
    try:
        with open(model_path, "wb") as file:
            pickle.dump(dump, file)
    except Exception as e:
        return f"Error saving model: {e}"

    eval_start = datetime.strptime(request.training_data_time_end, "%Y-%m-%dT%H:%M")
    eval_end = eval_start + timedelta(days=14)

    rmse = await evaluate_model(eval_start, eval_end, request.model_name)
    return {
        "model_name": request.model_name,
        "model_type": request.model_type,
        "hyperparameters": request.hyperparameters,
        "rmse_score": rmse,
        "features": request.features
    }

async def train_xgboost(request: TrainRequest):
    params = request.hyperparameters
    training_data = get_data(request.training_data_time_start, request.training_data_time_end)
    X_train = training_data[request.features]
    y_train = training_data["Value"]
    params = request.hyperparameters
    model = xgb.XGBRegressor(
        learning_rate=params["learning_rate"],
        n_estimators=params["n_estimators"],
        max_depth=params["max_depth"],
        subsample=params["subsample"],
        colsample_bytree=params["colsample_bytree"],
    )

    model.fit(X_train, y_train)
    model_path = model_path = MODEL_STORAGE / f"{request.model_name}.pkl"

    dump = {
        "model" : model,
        "features" : request.features
    }

    if os.path.exists(model_path):
        return "Name already in use"
    try:
        with open(model_path, "wb") as file:
            pickle.dump(dump, file)
    except Exception as e:
        return f"Error saving model: {e}"
    eval_start = datetime.strptime(request.training_data_time_end, "%Y-%m-%dT%H:%M")
    eval_end = eval_start + timedelta(days=14)
    rmse = await evaluate_model(eval_start, eval_end, request.model_name)
    return {
        "model_name": request.model_name,
        "model_type": request.model_type,
        "hyperparameters": request.hyperparameters,
        "rmse_score": rmse,
        "features": request.features
    }

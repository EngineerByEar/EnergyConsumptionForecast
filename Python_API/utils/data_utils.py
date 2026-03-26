import pandas as pd
from pathlib import Path

BASE_DIR = Path(__file__).resolve().parent.parent
DATA_PATH = BASE_DIR / "data" / "energy_and_weather_data.csv"

data = pd.read_csv(DATA_PATH,
                   parse_dates=["DateUTC"])



def get_data(start, end):
    start = pd.to_datetime(start).tz_localize(None)
    end = pd.to_datetime(end).tz_localize(None)
    return data[(start <= data["DateUTC"]) & (data["DateUTC"] <= end)]

def get_features():
    return list(data.drop(columns=["DateUTC", "Value"]).columns)

def get_hyperparameters(model_type:str):
    if model_type == "XGBoost":
        return  ["learning_rate",
        "n_estimators",
        "max_depth",
        "subsample",
        "colsample_bytree"]
    elif model_type == "DecisionTree":
        return ["max_depth", "min_samples_split" , "min_samples_leaf", "max_features", "ccp_alpha"]


import pandas as pd

data = pd.read_csv("./data/energy_and_weather_data.csv",
                   parse_dates=["DateUTC"])


def get_data(start, end):
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


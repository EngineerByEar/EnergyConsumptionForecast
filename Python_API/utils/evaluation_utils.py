from sklearn.metrics import root_mean_squared_error
import pickle
from Python_API.utils.data_utils import get_data
import os
from pathlib import Path

MODEL_STORAGE = Path(os.getenv("MODEL_STORAGE_PATH", "/app/model_storage"))
MODEL_STORAGE.mkdir(parents=True, exist_ok=True)

async def evaluate_model(start, end, model_name):
    try:
        with open(MODEL_STORAGE/f"{model_name}.pkl", "rb") as file:
            dump = pickle.load(file)
    except Exception as e:
        return f"An error occured while loading the model: {e}"
    model = dump["model"]
    features = dump["features"]

    testing_data = get_data(start, end)

    X_test = testing_data[features]
    y_test = testing_data["Value"]

    y_pred = model.predict(X_test)
    rmse = root_mean_squared_error(y_test, y_pred)
    return rmse
from sklearn.metrics import root_mean_squared_error
import pickle
from utils.data_utils import get_data

async def evaluate_model(start, end, model_name, features):
    testing_data = get_data(start, end)
    X_test = testing_data[features]
    y_test = testing_data["Value"]
    try:
        with open(f"../model_storage/{model_name}.pkl", "rb") as file:
            model = pickle.load(file)
    except Exception as e:
        return f"An error occured while loading the model: {e}"
    y_pred = model.predict(X_test)
    rmse = root_mean_squared_error(y_test, y_pred)
    return rmse
import pickle
from Python_API.utils.data_utils import get_data
from sklearn.metrics import root_mean_squared_error

async def predict_values(model_name: str, start: str, end: str):
    try:
        with open("./model_storage/"+model_name+".pkl", "rb") as file:
            dump = pickle.load(file)
    except Exception as e:
        return f"Error: {e}"

    model = dump["model"]
    features = dump["features"]

    data = get_data(start, end)

    X_test = data[features]
    y_test = data["Value"]

    prediction = model.predict(X_test)

    rmse = root_mean_squared_error(y_test, prediction)
    return {
        "y_pred": prediction.tolist(),
        "y_true": data["Value"].tolist(),
        "time": data["DateUTC"].tolist(),
        "score": rmse
    }
from fastapi import APIRouter
from Python_API.schemas.predict_schemas import PredictRequest
from Python_API.utils.predict_utils import predict_values
from Python_API.utils.plot_utils import plot_prediction
from Python_API.utils.data_utils import get_features, get_hyperparameters

router = APIRouter()

@router.post("/predict")
async def predict(request: PredictRequest):
    data = await predict_values(request.model_name, request.prediction_start, request.prediction_end)
    if type(data) is not dict:
        return data
    return await plot_prediction(data, request.model_name)

@router.get("/features")
async def return_features():
    return get_features()

@router.get("/hyperparameters")
async def return_features(model_type: str):
    return get_hyperparameters(model_type)
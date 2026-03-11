from pydantic import BaseModel

class PredictRequest(BaseModel):
    model_name: str
    prediction_start: str
    prediction_end: str
    features: list[str]
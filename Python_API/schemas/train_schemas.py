from pydantic import BaseModel
from typing import List, Dict

class TrainRequest(BaseModel):
    model_type: str
    model_name: str
    hyperparameters: Dict
    features: List[str]
    training_data_time_start: str
    training_data_time_end: str
from pydantic import BaseModel
from typing import List

class PlotPrediction(BaseModel):
    y_pred: list
    y_true: list
    time: list
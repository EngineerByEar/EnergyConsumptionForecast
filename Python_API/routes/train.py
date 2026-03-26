from fastapi import APIRouter
from Python_API.schemas.train_schemas import TrainRequest
from Python_API.utils.train_utils import train_decision_tree, train_xgboost

router = APIRouter()

@router.post("/model")
async def train_model(req: TrainRequest):
    if req.model_type == "DecisionTree":
        return await train_decision_tree(req)
    elif req.model_type == "XGBoost":
        return await train_xgboost(req)
    return "No Model Selected..."



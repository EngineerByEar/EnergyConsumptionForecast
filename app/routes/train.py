from fastapi import APIRouter
from schemas.train_schemas import TrainRequest
from utils.train_utils import train_decision_tree,train_random_forest, train_svm, train_xgboost

router = APIRouter()



@router.post("/model")
async def train_model(req: TrainRequest):
    if req.model_type == "DecisionTree":
        return await train_decision_tree(req)
    elif req.model_type == "RandomForest":
        return await train_random_forest(req)
    elif req.model_type == "SVM":
        return await train_svm(req)
    elif req.model_type == "XGBoost":
        return await train_xgboost(req)
    return "No Model Selected..."



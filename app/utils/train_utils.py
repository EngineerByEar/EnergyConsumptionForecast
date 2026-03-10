from schemas.train_schemas import TrainRequest

async def train_decision_tree(request: TrainRequest):
    return {"model": "DecisionTree"}
async def train_random_forest(request: TrainRequest):
    return {"model": "RandomForest"}
async def train_svm(request: TrainRequest):
    return {"model": "SVM"}
async def train_xgboost(request: TrainRequest):
    return {"model": "XGBoost"}
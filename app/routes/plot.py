from fastapi import APIRouter
from utils.plot_utils import plot_ranking
import pandas as pd

router = APIRouter()

@router.post("/ranking")
async def generate_ranking(model_names : list[str], model_scores : list[float]):
    data = pd.DataFrame({"model_name": model_names, "score": model_scores})
    data = data.sort_values(by=["score"], ascending=False)
    print(data)
    return await plot_ranking(data)

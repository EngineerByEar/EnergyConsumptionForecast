from fastapi import FastAPI
from Python_API.routes.train import router as train_router
from Python_API.routes.predict import router as predict_router
from Python_API.routes.plot import router as plot_router

app = FastAPI()

app.include_router(train_router, prefix="/train", tags=["train"])
app.include_router(predict_router, tags=["predict"])
app.include_router(plot_router, prefix="/plot", tags=["plot"])

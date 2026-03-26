import io
import matplotlib.pyplot as plt
import matplotlib.dates as mdates
from Python_API.schemas.plot_schemas import PlotPrediction
from fastapi.responses import StreamingResponse

async def plot_prediction(data: PlotPrediction, model_name: str):

    fig, ax = plt.subplots(figsize=(12, 5))
    ax.plot(data["time"], data["y_pred"], label="Prediction", alpha=0.5)
    ax.plot(data["time"], data["y_true"], label="True")

    if len(data["time"]) < 48:
        ax.xaxis.set_major_locator(mdates.HourLocator(range(25)[::2]))
        ax.xaxis.set_major_formatter(mdates.DateFormatter("%D-%H:%M"))
    elif 48 < len(data["time"]) < 500:
        ax.xaxis.set_major_locator(mdates.DayLocator())
        ax.xaxis.set_major_formatter(mdates.DateFormatter("%y-%m-%d"))
    else:
        ax.xaxis.set_major_locator(mdates.DayLocator(interval = 7))
        ax.xaxis.set_major_formatter(mdates.DateFormatter("%A-%m-%d"))

    plt.title(f"Prediction vs Reality from {min(data["time"])} to {max(data["time"])} using {model_name}. Score: {int(data["score"])}")
    plt.xticks(rotation=45)
    plt.xlabel("Time")
    plt.ylabel("Value")
    plt.legend()

    buf = io.BytesIO()
    plt.savefig(buf, format="png", bbox_inches="tight")
    plt.close(fig)
    buf.seek(0)
    return StreamingResponse(buf, media_type="image/png")

async def plot_ranking(data):
    colors = [f"C{v}" for v in range(len(data))]

    plt.bar(data["model_name"], data["score"], label = data["model_name"], color = colors)
    plt.title("Model Performance")
    plt.xlabel("Model")
    plt.ylabel("RMSE-Score")
    plt.legend(bbox_to_anchor=(1,1))
    plt.xticks(rotation=90)

    buf = io.BytesIO()
    plt.savefig(buf, format="png", bbox_inches="tight")
    plt.close()

    buf.seek(0)
    return StreamingResponse(buf, media_type="image/png")


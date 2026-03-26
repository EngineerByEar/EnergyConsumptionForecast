<?php

require_once("../config_inc.php");
include("../templates/header.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Train Model</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
<h2>Train Model</h2>

<form method="POST" action="actions/train_action.php" id="trainForm">

    <!-- Model Type -->
    <div class="mb-3">
        <label class="form-label">Model Type</label>
        <select name="model_type" id="model_type" class="form-select" required>
            <option value="">Select...</option>
            <option value="XGBoost">XGBoost</option>
            <option value="DecisionTree">Decision Tree</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Model Name</label>
        <input type="text" name="model_name" class="form-control" required>
    </div>

    <!-- Features (multi-select) -->
    <div class="mb-3 d-none d-md-block">
        <label class="form-label">Select Features</label>
        <select name="features[]" class="form-select" multiple size="27">
            <?php
            $features = [
                "Friday","Monday","Saturday","Sunday","Thursday","Tuesday","Wednesday",
                "day","hour","month","lag_1","lag_24","lag_168",
                "rolling_mean_24","rolling_std_24","rolling_mean_168","rolling_std_168",
                "is_free_day","ff","rr","so_h","tl","temp_24h","temp_72h","sun_24h","hdg","cdg"
            ];

            foreach ($features as $f) {
                echo "<option value=\"$f\">$f</option>";
            }
            ?>
        </select>
        <small class="text-muted">Hold CTRL / CMD to select multiple</small>
    </div>

    <div class="mb-3 d-block d-md-none">
        <label class="form-label">Select Features</label>

        <div class="d-flex flex-wrap gap-2">
            <?php foreach ($features as $f): ?>
                <input type="checkbox" class="btn-check feature-checkbox"
                       name="features[]"
                       value="<?= $f ?>"
                       id="btn_<?= $f ?>">

                <label class="btn btn-outline-primary btn-sm"
                       for="btn_<?= $f ?>">
                    <?= $f ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Hyperparameters (dynamic) -->
    <div class="mb-3">
        <label class="form-label">Select Hyperparameters</label>
        <div id="hyperparameters-container"></div>
        <small class="text-muted" id="selection_reminder">Select Model Type to see available Hyperparameters</small>
    </div>

    <!-- Date Range -->
    <div class="mb-3">
        <label class="form-label">Start Date</label>
        <input type="datetime-local" name="start_date" class="form-control"
               min="2019-01-01T00:00" max="2025-06-01T00:00" value ="2019-01-01T00:00" required>
        <small class="text-muted">Training Data starts on 2019-01-01</small>

    </div>

    <div class="mb-3">
        <label class="form-label">End Date</label>
        <input type="datetime-local" name="end_date" class="form-control"
               min="2019-01-01T00:00" max="2025-06-01T00:00" required>
        <small class="text-muted">Training Data ends on 2025-06-01</small>
    </div>

    <button class="btn btn-primary">Train Model</button>

</form>

<script>
    const hyperparametersConfig = {
        XGBoost: {
            learning_rate: {
                min: 0.01, max: 0.3, step: 0.01,
                desc: "How quickly the model learns; lower values make learning slower but more careful."
            },
            n_estimators: {
                min: 50, max: 1000, step: 1,
                desc: "How many steps the model takes to learn; more steps can improve accuracy but take longer."
            },
            max_depth: {
                min: 3, max: 12, step: 1,
                desc: "How complex each decision step can be; higher values allow more detailed patterns."
            },
            subsample: {
                min: 0.5, max: 1.0, step: 0.01,
                desc: "How much of the data is used each time; lower values can help avoid overfitting."
            },
            colsample_bytree: {
                min: 0.5, max: 1.0, step: 0.01,
                desc: "How many input factors are used each time; fewer can make the model more robust."
            }
        },

        DecisionTree: {
            max_depth: {
                min: 2, max: 50, step: 1,
                desc: "How deep the decision process goes; deeper means more detailed but can overfit."
            },
            min_samples_split: {
                min: 2, max: 50, step: 1,
                desc: "Minimum number of data points needed before making a new decision step."
            },
            min_samples_leaf: {
                min: 1, max: 20, step: 1,
                desc: "Minimum number of data points required at the final decision points."
            },
            max_features: {
                min: 0.1, max: 1.0, step: 0.1,
                desc: "How many input factors are considered when making decisions."
            },
            ccp_alpha: {
                min: 0.0, max: 0.1, step: 0.001,
                desc: "How much the model is simplified to avoid overfitting."
            }
        }
    };
    document.getElementById("model_type").addEventListener("change", function () {
        const selectionReminder = document.getElementById("selection_reminder");
        selectionReminder.style.display = "none";


        const container = document.getElementById("hyperparameters-container");
        container.innerHTML = "";

        const selectedModel = this.value;
        if (!hyperparametersConfig[selectedModel]) return;

        Object.entries(hyperparametersConfig[selectedModel]).forEach(([param, settings])=> {
            const div = document.createElement("div");
            div.classList.add("mb-2");
            console.log(param);

            div.innerHTML = `
            <label class="form-label">${param}</label>
            <input type="number" min = ${settings["min"]} max = ${settings["max"]} step = ${settings["step"]} name="hyperparameters[${param}]" class="form-control">
            <small class="text-muted">Range: ${settings["min"]}-${settings["max"]}</small>
            <small class="text-muted">${settings["desc"]}</small>`;
            container.appendChild(div);

        });
    });
</script>

</body>
</html>
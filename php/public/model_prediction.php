<?php
require_once("../config_inc.php");
include("../templates/header.php");


$db = new DB_Requests();
$api = new API_Requests();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Prediction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
<h2>Create Prediction</h2>

<form method="POST" action="actions/prediction_action.php" id="predForm">

    <div class="mb-3">
        <label class="form-label" for="model_selector">Model Name</label>
        <select name="model_name" id = "model_selector" class="form-select" required>

            <?php
            $models = $db->get_all_model_names();

            if(isset($_GET["modelName"])){
                $modelName = $_GET["modelName"];
                    echo("<option value='$modelName'>$modelName</option>");
                $models = array_diff($models, [$modelName]);
            }

            foreach($models as $model_name){
                echo("<option value='$model_name'>$model_name</option>");
            } ?>
        </select>
        <small class="text-muted">Select the Model that will create the prediction</small>

    </div>
    <div class="mb-3">
        <label class="form-label" for="start_date">Start Date</label>
        <input type="datetime-local" id="start_date" name="start_date" class="form-control"
               min="" max="2025-06-01T00:00" value ="2019-01-01T00:00" required>
        <small class="text-muted">Predictions can only be made outside the Training Data range</small>
    </div>

    <div class="mb-3">
        <label class="form-label" for="end_date">End Date</label>
        <input type="datetime-local" id="end_date" name="end_date" class="form-control"
               min="2019-01-01T00:00" max="2025-09-01T00:00" required>
        <small class="text-muted">Testing Data ends on 2025-09-01</small>

    </div>

    <button class="btn btn-primary">Get Prediction</button>

</form>
<script>
    const trainingDates = {
        <?php foreach($db->get_all_model_names() as $model_name):
            $training_end = $db->get_model_info($model_name)[0]["training_end"];
        ?>

            "<?=$model_name?>" : "<?=$training_end?>",
        <?php endforeach;?>
    };

    const startDateField = document.getElementById("start_date");
    const endDateField = document.getElementById("end_date");

    function pad(num){
        return num.toString().padStart(2,'0');
    }

    function toDateTimeLocal(dt) {
        return `${dt.getFullYear()}-${pad(dt.getMonth()+1)}-${pad(dt.getDate())}T${pad(dt.getHours())}:${pad(dt.getMinutes())}`;
    }

    function set_start_date(selectedModel){
        const start_time = trainingDates[selectedModel];

        startDateField.min = start_time;
        startDateField.value = start_time;

        const end_time = new Date(start_time);
        end_time.setHours(end_time.getHours() + 1);

        endDateField.min = toDateTimeLocal(end_time);
        endDateField.value = toDateTimeLocal(end_time);
    }

    const modelSelector = document.getElementById("model_selector");

    set_start_date(modelSelector.value);

    modelSelector.addEventListener("change", function(){
        const selectedModel = this.value;
        set_start_date(selectedModel);
    });

</script>
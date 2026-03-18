<?php
require_once("DB_Requests.php");
class API_Requests{

    private $url;
    private $DB_reqs;

    function __construct(){
        $this->url = "https://energyconsumptionforecasthosting-production.up.railway.app";
        $this->DB_reqs = new DB_Requests();
    }

    public function create_model($model_type, $model_name, $hyperparameters, $features, $training_start, $training_end){

        $data = json_encode([
            "model_type" => $model_type,
            "model_name" => $model_name,
            "hyperparameters" => $hyperparameters,
            "features" => $features,
            "training_data_time_start" => $training_start,
            "training_data_time_end" => $training_end
        ]);

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/json",
                'content' => $data
            ]
        ];
        $context = stream_context_create($options);

        $response = file_get_contents($this->url."/train/model", false, $context);
        $res = json_decode($response);

        if($res === null ||!isset($res->rmse_score)){
            return "No Response";
        } else {
            print("DB");
            $db_response = $this->DB_reqs->insert_model($model_name, "Mike", $model_type, $hyperparameters, $features, $training_start, $training_end, $res->rmse_score);
            return $db_response;
        }


    }

    public function create_ranking_plot($model_names, $model_scores){

        $data = json_encode([
            "model_names"=>$model_names,
            "model_scores"=>$model_scores
        ]);

        $options = [
            "http" => [
                "method" => "POST",
                "header" => "Content-Type: application/json",
                "content" => $data
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($this->url."/plot/ranking", false, $context);
        $base64 = base64_encode($response);
        return $base64;

    }

    public function get_prediction($model_name, $prediction_start, $prediction_end){

        $data = json_encode([
            "model_name"=>$model_name,
            "prediction_start"=>$prediction_start,
            "prediction_end"=>$prediction_end,
        ]);
        $options = [
            "http" => [
                "method" => "POST",
                "header" => "Content-Type: application/json",
                "content" => $data
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($this->url."/predict", false, $context);
        return base64_encode($result);

    }


}
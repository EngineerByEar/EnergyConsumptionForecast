<?php

class API_Requests{

    private $url;
    function __construct(){
        $this->url = "https://energyconsumptionforecasthosting-production.up.railway.app";
    }

    public function create_model($model_type, $model_name, $hyperparameters, $features, $training_start, $training_end){
        $ch = curl_init($this->url."/train/model");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            "model_type" => $model_type,
            "model_name" => $model_name,
            "hyperparameters" => $hyperparameters,
            "features" => $features,
            "training_data_time_start" => $training_start,
            "training_data_time_end" => $training_end
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function create_ranking_plot($model_names, $model_scores){

        $ch = curl_init($this->url."/plot/ranking");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            "model_names" => $model_names,
            "model_scores" => $model_scores
        ]));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }



}
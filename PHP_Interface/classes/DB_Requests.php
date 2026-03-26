<?php

class DB_Requests{

    private $db;

    function __construct(){
        try{
            $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PW);
        }catch(PDOException $e){
            echo "Verbindung fehlgeschlagen: ".$e;
            die();
        }
    }

    public function get_model_id($model_name){
        $stmt = $this->db->prepare("SELECT model_id FROM model WHERE model_name = :model_name");
        $stmt->bindParam(':model_name', $model_name);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insert_model($model_name, $model_creator, $model_type, $hyperparameters, $features, $training_start, $training_end, $score)
    {
        $this->db->beginTransaction();
        try {
            //Insert model
            $stmt = $this->db->prepare("INSERT INTO model 
                                                (model_name, model_creator)
                                                VALUES (:model_name, :model_creator)");
            $stmt->bindValue(':model_name', $model_name);
            $stmt->bindValue(':model_creator', $model_creator);

            $stmt->execute();

            //Get auto_incremented model_id to create the rest of the rows
            $result = $this->get_model_id($model_name);
            $model_id = $result['model_id'];

            //Insert model_type
            $stmt = $this->db->prepare("INSERT INTO model_type 
                                                (model_id, model_type)
                                                VALUES (:model_id, :model_type)");
            $stmt->bindValue(':model_id', $model_id);
            $stmt->bindValue(':model_type', $model_type);

            $stmt->execute();


            //Insert Hyperparameters
            foreach ($hyperparameters as $key => $value) {
                $stmt = $this->db->prepare("INSERT INTO model_hyperparameters
                                                    (model_id, hyperparameter, value)
                                                    VALUES (:model_id, :key, :value)");
                $stmt->bindValue(':model_id', $model_id);
                $stmt->bindValue(':key', $key);
                $stmt->bindValue(':value', $value);

                $stmt->execute();
            }

            //Insert Features
            foreach ($features as $feature) {
                $stmt = $this->db->prepare("INSERT INTO model_features
                                                    (model_id, feature_name)
                                                    VALUES (:model_id, :feature)");
                $stmt->bindValue(':model_id', $model_id);
                $stmt->bindValue(':feature', $feature);

                $stmt->execute();
            }

            //Insert Training Data Timeframe
            $stmt = $this->db->prepare("INSERT INTO model_training_data
                                                (model_id, training_start, training_end)
                                                VALUES (:model_id, :training_start, :training_end)");
            $stmt->bindValue(':model_id', $model_id);
            $stmt->bindValue(':training_start', $training_start);
            $stmt->bindValue(':training_end', $training_end);

            $stmt->execute();

            //Insert Score
            $stmt = $this->db->prepare("INSERT INTO model_score
                                                (model_id, score)
                                                VALUES (:model_id, :score)");
            $stmt->bindValue(':model_id', $model_id);
            $stmt->bindValue(':score', $score);

            $stmt->execute();
            $this->db->commit();
            return "Model saved in Database";
        }catch(PDOException $e){
            $this->db->rollBack();
            return $e->getMessage();
        }
    }

    public function get_model_info($model_name){
        $stmt = $this->db->prepare("SELECT m.model_id, 
                                                m.model_name,
                                                m.model_creator, 
                                                m.model_creation,  
                                                GROUP_CONCAT(DISTINCT mf.feature_name) AS features,
                                                GROUP_CONCAT(DISTINCT CONCAT(mh.hyperparameter, ':' , mh.value)) AS hyperparameters,
                                                ms.score,
                                                mtd.training_start,
                                                mtd.training_end,
                                                mt.model_type
                                            FROM model m 
                                            LEFT JOIN `model_features` mf 
                                                ON m.model_id = mf.model_id
                                            LEFT JOIN `model_hyperparameters` mh
                                                ON m.model_id = mh.model_id
                                            LEFT JOIN `model_score` ms
                                                ON m.model_id = ms.model_id
                                            LEFT JOIN `model_training_data` mtd
                                                ON m.model_id = mtd.model_id
                                            LEFT JOIN `model_type` mt
                                                ON m.model_id = mt.model_id
                                            WHERE m.model_name = :model_name");
        $stmt->bindValue(':model_name', $model_name);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);

    }

    public function get_ranking(){
        $stmt = $this->db->prepare("SELECT m.model_name, ms.score
                                            FROM model m
                                            LEFT JOIN model_score ms
                                                ON m.model_id = ms.model_id
                                            ORDER BY ms.score DESC
                                            LIMIT 5");
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);

    }

    public function get_leaderboard(){
        $stmt = $this->db->prepare("SELECT m.model_name, ms.score, mt.model_type
                                            FROM model m
                                            LEFT JOIN model_score ms
                                                ON m.model_id = ms.model_id
                                            LEFT JOIN model_type mt
                                                ON m.model_id = mt.model_id
                                            ORDER BY ms.score ASC");
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    public function get_all_model_names(){
        $stmt = $this->db->prepare("SELECT model_name 
                                            FROM model m
                                            LEFT JOIN model_score ms
                                                ON m.model_id = ms.model_id
                                            ORDER BY ms.score DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function get_features($model_name){
        $stmt = $this->db->prepare("SELECT 
                                            DISTINCT mf.feature_name
                                            FROM model m 
                                            LEFT JOIN `model_features` mf
                                                ON m.model_id = mf.model_id
                                            WHERE m.model_name = :model_name");
        $stmt->bindValue(':model_name', $model_name);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }


}
<?php
require_once("config_inc.php");
echo("Hallo Georgius!");
$blub = new DB_Requests();
$res = $blub->get_all_models();

foreach($res as $row){
    print("<br>");
    print("===========ROW!==================");
    print("<br>");
    foreach($row as $key => $value){
        print("$key: $value\n");
        print("<br>");
    }
}

$res = $blub->get_ranking();
foreach($res as $row){
    print("<br>");
    print_r($row);
}

$res = $blub->get_all_model_names();
foreach($res as $row){
    print("<br>");
    print_r($row);
}
print("<br>");

$res = $blub->get_features("Georg");
print_r($res);

$res = $blub->get_leaderboard();
foreach($res as $row){
    print("<br>");
    print_r($row);
}

$bleb = new API_Requests();

$response = $bleb->create_model("XGBoost", "Ginseng", array("learning_rate"=>0.05, "n_estimators"=>5, "max_depth"=>5, "subsample"=>0.8, "colsample_bytree"=>0.8), ["Friday", "Monday", "Saturday", "Sunday", "Thursday", "Tuesday", "Wednesday", "day", "hour", "month", "lag_1", "lag_24", "lag_168", "rolling_mean_24", "rolling_std_24", "rolling_mean_168", "rolling_std_168", "is_free_day", "ff", "rr", "so_h", "tl", "temp_24h", "temp_72h", "sun_24h", "hdg", "cdg"],"2019-02-02T00:00", "2022-02-02T00:00");
print($response);
print("<br>");
$res = $bleb->get_prediction("Ginseng", "2020-02-02T00:00", "2020-02-04T00:00");

?>
<img style="display:block; width:100px; height:100px;" id="base64image"
     src="data:image/png;base64,<?php echo $res; ?>" />
<?php



//$res = $bleb->create_ranking_plot(["Georg", "Mike"], [6,5]);
?>

<img style="display:block; width:100px; height:100px;" id="base64image"
     src="data:image/png;base64,<?php echo $res; ?>" />
<?php
//$res = $blub->insert_model("Blub", "Mike", "The Greatest", ["kek"=>17, "blub"=>17], ["desdo", "dingsso"], "2019-05-05T13:00", "2024-06-05T00:00", 3.5);
//print_r($res);

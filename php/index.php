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
$res = $bleb->create_ranking_plot(array("Georg", "Mike"), array(2,5));

$base64 = base64_encode($res);
?>

<img style="display:block; width:100px; height:100px;" id="base64image"
     src="data:image/png;base64,<?php echo $base64; ?>" />
<?php
//$res = $blub->insert_model("Blub", "Mike", "The Greatest", ["kek"=>17, "blub"=>17], ["desdo", "dingsso"], "2019-05-05T13:00", "2024-06-05T00:00", 3.5);
//print_r($res);
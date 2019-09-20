<?php

/*
Resource: [swift-bic-codes]
https://github.com/lstrihic/swift-bic-codes/tree/master/countries#json
*/

$dirCodes = "swift-bic-codes-master/swift-bic-codes-master/countries/";
$files1 = scandir($dirCodes);
//print_r($files1);
$arData = array();
foreach($files1 as $file){
    // Read JSON file
    $json = file_get_contents($dirCodes . $file);
    //Decode JSON
    $json_data = json_decode($json,true);
    foreach($json_data["banks"] as $key => $jdata){
        foreach($jdata["branches"] as $key2 => $jdata2){
            $arData[] =  array(
              "country_iso_code2" => str_replace(".json","",$file),
              "bic" => $jdata2["swift_code"],
              "bankname" => $jdata["bank_name"]." - ".$jdata2["branch_name"],
              "city" => $jdata2["city"],
            );
        }
    }
}
print_r($arData[0]);
echo count($arData);

// add into JSON
$fp = fopen('AllCountries.json', 'w');
fwrite($fp, json_encode($arData));
fclose($fp);

// add into CSV
$fp = fopen('AllCountries.csv', 'w');
foreach ($arData as $fields) {
    fputcsv($fp, $fields);
}
fclose($fp);








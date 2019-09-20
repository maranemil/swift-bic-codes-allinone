<?php


/*
Resource: [swift-bic-codes]
https://github.com/PeterNotenboom/SwiftCodes/tree/master/AllCountries#json
https://github.com/Thomanphan/swiftcode/tree/master/AllCountries#json
*/

$dirCodes = "swiftcode-master/swiftcode-master/AllCountries/";
$dirCodes = "SwiftCodes-master/SwiftCodes-master/AllCountries/";

$files1 = scandir($dirCodes);
//print_r($files1);
$arData = array();
foreach($files1 as $file){
    // Read JSON file
    $json = file_get_contents($dirCodes . $file);
    //Decode JSON
    $json_data = json_decode($json,true);
    foreach($json_data["list"] as $key => $jdata){
        $arData[] =  array(
          "country_iso_code2" => str_replace(".json","",$file),
          "bic" => $jdata["swift_code"],
          "bankname" => $jdata["bank"],
        );
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



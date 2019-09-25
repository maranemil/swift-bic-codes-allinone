<?php

// https://sourceforge.net/projects/simplehtmldom/
// https://github.com/samacs/simple_html_dom
// https://github.com/sunra/php-simple-html-dom-parser

$directory = ".";
$scanned_directory = array_diff(scandir($directory), array('..', '.', '.idea'));
// print_r($scanned_directory);

foreach ($scanned_directory as $rootdir) {
    if (is_dir($rootdir)) {
        $scanned_directory_lv2[$rootdir][] = array_diff(
            scandir($rootdir),
            array('..', '.', 'index.html', 'vendor'));
    }
}

//print_r($scanned_directory_lv2);
libxml_use_internal_errors(true);
$arrCodes = array();

//$rootUrl = "http://192.168.100.79/wwweb/scrap_bic/";

foreach ($scanned_directory_lv2 as $key => $htmlPage) {
    foreach ($htmlPage[0] as $page) {
        $urlToParse = "/home/emil/wweb/scrap_bic/" . $key . "/" . $page;

        if (file_exists($urlToParse)) {
            echo $urlToParse . PHP_EOL;

            /*
            #$htmlStr = file_get_contents($urlToParse);
            $dom = new DOMDocument;
            $dom->loadHTMLFile($urlToParse );
            $links = $dom->getElementsByTagName( 'a' );
            foreach (links as $book) {
            #echo $book->nodeValue, PHP_EOL;
            }
            print_r($links);
            $dom->saveHTML();*/

            $dom = new DomDocument;
            $dom->validateOnParse = true;
            $dom->loadHTMLFile($urlToParse);
            $dom->saveHTML();
            $DomNodeList = $dom->getElementById('swift');
            $strNode = $DomNodeList->nodeValue;
            #print_r($strNode);

            $arrElem = explode("\n", $strNode);
            #$arrElem =  preg_split ('/\n/', $strNode);
            #print_r($arrElem);

            /*
            [0] => Item
            [1] =>     Description
            [2] =>     SWIFT Code
            [3] =>     AFGBAFKA
            [4] =>     Bank
            [5] =>     DA AFGHANISTAN BANK
            [6] =>     Branch Name
            [7] =>
            [8] =>     Address
            [9] =>     DA AFGHANISTAN BANK
            [10] =>     City
            [11] =>     KABUL
            [12] =>     Postcode
            [13] =>
            [14] =>     Country
            [15] =>      Afghanistan
            [16] =>
            )
             */

            foreach ($arrElem as $keyElem => $txtElem) {
                if (trim($txtElem) == "SWIFT Code") {
                    $arrCodes[$key][$page]["SWIFTCode"] = trim($arrElem[$keyElem + 1]);
                }
                if (trim($txtElem) == "Bank") {
                    $arrCodes[$key][$page]["Bank"] = trim($arrElem[$keyElem + 1]);
                }
                if (trim($txtElem) == "City") {
                    $arrCodes[$key][$page]["City"] = trim($arrElem[$keyElem + 1]);
                }
                if (trim($txtElem) == "Postcode") {
                    $arrCodes[$key][$page]["Postcode"] = trim($arrElem[$keyElem + 1]);
                }
                if (trim($txtElem) == "Country") {
                    $arrCodes[$key][$page]["Country"] = trim($arrElem[$keyElem + 1]);
                }
            }

            #print_r($arrCodes);
            /*
            $Dom = @DOMDocument::loadHTMLFile($urlToParse );
            $DomNodeList = @$Dom->getElementById( 'h2' );
            foreach ($DomNodeList as $key => $book) {
            #if($key==4){ // bic
            echo $book->nodeValue, PHP_EOL;
            #$strCode = $book->nodeValue;
            #break;
            #}
            }
             */
            echo '---------------------------' . PHP_EOL;
        }

        #die();
        #break;

    }
}

// add into CSV
$fp = fopen('AllCountries4.csv', 'w');
foreach ($arrCodes as $key => $arrCodes2) {
    foreach ($arrCodes2 as $key => $fields) {
        fputcsv($fp, $fields);
    }
}
fclose($fp);

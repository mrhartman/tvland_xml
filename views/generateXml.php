<?php

$dayData = $data["days"];
$timeData = $data["times"];
$modData = $data["mods"];
$channels = $data["channelNumbers"]["yes"];
$modifierSource = $modData['ai_source_layer']; 
$modifierReplace = $modData['replacement_text']; 

if (count($channels) <= 0) {
    $channels = $data["channelNumbers"]["no"];
}

//$xml = new SimpleXMLElement('<Job />');
$xml = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?><Job />');

foreach($channels as $channel){
    foreach($timeData as $timeRow){
        foreach($dayData as $dayRow){
			foreach($modData as $modRow){
				$comp = $xml->addChild('Comp');
				$comp->addChild('Template', $data['templateName']);
				if ($channel > 0) {
					$showChannel = "CHANNEL ".$channel;
				} else {
					$showChannel = "";
				}
				if($modRow['name'] == "None"){
				  $comp->addChild('NewName', $data['dupeName'].' '.$dayRow['day']['ai_source_layer'].' '.$timeRow['ai_source_layer'].' '.$showChannel);
				} else {
				  $comp->addChild('NewName', $data['dupeName'].' '.$modRow['ai_source_layer'].' '.$dayRow['day']['ai_source_layer'].' '.$timeRow['ai_source_layer'].' '.$showChannel);
				}
				$sourceReplacements = $comp->addChild('SourceReplacements');
				$Replace = $sourceReplacements->addChild('Replace');
				$Replace->addChild('Layer', 'EP TUNEIN DAY');
				$Replace->addChild('Source', 'EP_'.$dayRow['day']['ai_source_layer'].'/tuneins.ai');
				$Replace2 = $sourceReplacements->addChild('Replace');
				$Replace2->addChild('Layer', 'EP TUNEIN TIME');
				if ($dayRow['time'] == 'yes') {
					$Replace2->addChild('Source', 'EP_'.$timeRow['ai_source_layer'].'/tuneins.ai');
				} else {
					$Replace2->addChild('Source');
				}
				$Replace3 = $sourceReplacements->addChild('Replace');
				$Replace3->addChild('Layer', 'EP MODIFIER');
				//check if user doesn't want a modifier, and if they don't leave field blank
				if ($modRow['name'] == "None") {
					$Replace3->addChild('Source');
				} else {
					$Replace3->addChild('Source', 'EP_'.$modRow['ai_source_layer'].'/tuneins.ai');
				}
				$Replace4 = $sourceReplacements->addChild('Replace');
				$Replace4->addChild('Layer', 'INT TUNEIN DAY');
				$Replace4->addChild('Source', 'INT_'.$dayRow['day']['ai_source_layer'].'/tuneins.ai');
				$Replace5 = $sourceReplacements->addChild('Replace');
				$Replace5->addChild('Layer', 'INT TUNEIN TIME');
				if ($dayRow['time'] == 'yes') {
					$Replace5->addChild('Source', 'INT_'.$timeRow['ai_source_layer'].'/tuneins.ai');
				} else {
					$Replace5->addChild('Source');
				}
				$Replace6 = $sourceReplacements->addChild('Replace');
				$Replace6->addChild('Layer', 'INT MODIFIER');
				//check if user doesn't want a modifier, and if they don't leave field blank
				if ($modRow['name'] == "None") {
					$Replace6->addChild('Source');
				} else {
					$Replace6->addChild('Source', 'INT_'.$modRow['ai_source_layer'].'/tuneins.ai');
				}
				$textReplacements = $comp->addChild('TextReplacements');
				$Replace7 = $textReplacements->addChild('Replace');
				$Replace7->addChild('Layer', 'L3 TAG');
				//user wants time and modifier
				if ($dayRow['time'] == 'yes' and $modRow['name'] != 'None') {
					$Replace7->addChild('Text', $modRow['replacement_text'].' '.$dayRow['day']['replacement_text'].' '.$timeRow['replacement_text']);
				//user wants time does not want modifier
				} elseif ($dayRow['time'] == 'yes' and $modRow['name'] == 'None') {
					$Replace7->addChild('Text', $dayRow['day']['replacement_text'].' '.$timeRow['replacement_text']);
				//user does not want time does want modifier
				} elseif ($dayRow['time'] != 'yes' and $modRow['name'] != 'None') {
					$Replace7->addChild('Text', $modRow['replacement_text'].' '.$dayRow['day']['replacement_text']);
				//user does not want time or modifier
				} else {
					$Replace7->addChild('Text', $dayRow['day']['replacement_text']);	
				}
				$Replace8 = $textReplacements->addChild('Replace');
				$Replace8->addChild('Layer', 'L3 CHANNEL');
				$Replace8->addChild('Text', $showChannel);
				$Replace8->addChild('MaintainSpacing', 'L3 TAG');
				$Replace9 = $textReplacements->addChild('Replace');
				$Replace9->addChild('Layer', 'EP CHANNEL');
				$Replace9->addChild('Text', $showChannel);
			}
        }
    }
}

header('Content-Description: File Transfer');
header('Content-type: text/xml');
header("Content-disposition: attachment; filename=comps.xml");

$dom = dom_import_simplexml($xml)->ownerDocument;
$dom->formatOutput = true;
echo $dom->saveXML();
?>

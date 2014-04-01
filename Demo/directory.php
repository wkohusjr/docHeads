<?php

	echo("Departments...");
	
								$departments = "Data/departments.xml";
							$xml = simplexml_load_file($departments);
							foreach($xml as $department){
								echo '<option value=\"' . $department->name .'\">' . $department->name . '</option>';
							}
	
	/*
	
	$departments = "Data/departments.xml";
	//$departments = "Data/test.xml";
	
	if (file_exists($departments)) {
//		echo("<br>loading xml file: " . $departments);
		$xml = simplexml_load_file($departments);
//		echo("<br>here they come:");
//		var_dump($xml);
		
//		echo '<br />Displaying contents of XML file...<br />';
		foreach($xml as $department){
			echo '<option value=\"' . $department->name .'\">' . $department->name . '</option>';
		}
//		echo("<br />There they were.");

//		echo("<br />errors?");
//	    $errors = libxml_get_errors();
//		foreach ($errors as $error) {
//			echo display_xml_error($error, $xml);
//		}
		
	} else {
		echo('<br />simplexml_load_file(): Error.');
	}
	
	//$xml = simplexml_load_file("Data/departments.xml");

	//echo $xml->getName() . "<br>";

	//foreach($xml->children() as $child) {
	//	echo $child->getName() . ": " . $child->name . "<br>";
	//}
*/

?> 
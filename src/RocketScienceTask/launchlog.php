<?php

namespace Clearcode\RocketScienceTask;

function openFile($file)
{
    $document = file($file) or die('File open failed.');

    return $document;
}

// return sum of missions group by term(month or year)

function groupBy($path, $term, $isMissionSuccessed = null)
{
    $term = ($term == 'month') ? 'M' : ($term == 'year') ? 'Y' : die('Wrong param!');
    if($isMissionSuccessed === true){
    	$isMissionSuccessed = 'S';
    } elseif ($isMissionSuccessed === false) {
    	$isMissionSuccessed = 'F';
    }
	$launchlogArray = openFile($path);
    $firstRow = $launchlogArray[0];
    $launchDatePosition = strpos($firstRow, 'Launch Date');
    $dateLength = strlen('1900 Jan 01');
    $successPosition = strpos($firstRow, 'Suc');
    $launch = [];
    $output = [];
    foreach ($launchlogArray as $key => $row) {
// skip 2 rows  with header of "table"
        if ($key < 2) continue;
        $launch[$key]['term'] = !empty(trim(substr($row, $launchDatePosition, $dateLength))) ? DateTime::createFromFormat('Y M d' , substr($row, $launchDatePosition, $dateLength)) : $launch[$key-1]['term'];
        $launch[$key]['success'] = is_string(substr($row,$successPosition, 1)) ? substr($row, $successPosition, 1) : $launch[$key-1]['success'];
        if(!isset($output[$launch[$key]['term']->format($term)])) $output[$launch[$key]['term']->format($term)] = 0;
        $output[$launch[$key]['term']->format($term)] +=  is_null($isMissionSuccessed) ? 1 : ($launch[$key]['success']=== $isMissionSuccessed) ? 1 : 0;
	}
	return $output;
}

echo '<pre>';
var_dump(groupBy('http://planet4589.org/space/log/launchlog.txt', 'year', false)); 
echo '</pre>';
//var_dump(groupBy('launchlog.txt', 'month', false));
//var_dump(groupBy('launchlog.txt', 'year', false));

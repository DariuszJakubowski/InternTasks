<?php

namespace Clearcode\RocketScienceTask;

use Exception;

function openFile($file): array
{
    try {

        if (!file_exists($file)) {
            throw new Exception('File not found.');
        }

        $document = file($file);
        if (!$document) {
            throw new Exception('File open failed.');
        }

    } catch (Exception $e) {
        exit($e->getMessage());
    }
    return $document;
}



function groupBy(string $path, string $term, bool $isMissionSuccessed = null): array
{
    try {

        if (!preg_match('/^(month)|(year)$/', $term)) {
            throw new Exception('Wrong param.');
        }

    } catch (Exception $e) {
        exit($e->getMessage());
    }

    $launchlogArray = openFile($path);
    $firstRow = $launchlogArray[0];
    $launchDatePosition = strpos($firstRow, 'Launch Date');
    $successPosition = strpos($firstRow, 'Suc');

    foreach ($launchlogArray as $key => $row) {
// skip 2 rows  with header of "table"
        if ($key < 2) {
            continue;
        }

        switch ($term) {

            case 'year':
                if (!is_numeric(substr($row, $launchDatePosition, 1))) {
                    $missions[$year][$success]++;
                } else {
                    $year = substr($row, $launchDatePosition, 4);
                    $success = substr($row, $successPosition, 1);

                    $missions[$year][$success] = isset($missions[$year][$success]) ? ++$missions[$year][$success] : 1;
                }
                break;

            case 'month':
                if (!is_numeric(substr($row, $launchDatePosition, 1))) {
                    $missions[$month][$success]++;
                } else {
                    $month = substr($row, $launchDatePosition + 5, 3);
                    $success = substr($row, $successPosition, 1);
                    $missions[$month][$success] = isset($missions[$month][$success]) ? ++$missions[$month][$success] : 1;
                }
                break;
        }

    }

    foreach ($missions as $key => $value) {

        if ($isMissionSuccessed === true) {

            $missions[$key] = $value['S'];
        } elseif ($isMissionSuccessed === false) {
            $missions[$key] = $value['F'];
        } else {
            $missions[$key] = array_sum($value);
        }
    }

    return $missions;
}
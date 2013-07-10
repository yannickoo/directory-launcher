<?php

/**
 * @file
 * Update launcher.json file.
 */

$information = array(
  'foo' => array(
    'title' => 'The title',
    'description' => 'A description',
    'date' => '07/2013',
  ),
  'bar' => array(
    'title' => 'Another title',
    'description' => 'And another description',
    'date' => '07/2013',
  ),
 );

$information = json_encode($information);
$handler = fopen('launcher.json', 'w');
fwrite($handler, $information);
fclose($handler);

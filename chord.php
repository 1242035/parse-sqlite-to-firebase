<?php
set_time_limit(0);
require 'vendor/autoload.php';
require 'SQLiteDatabase.php';

const DEFAULT_PATH = '/songs';
$dbPath = __DIR__ . '/guitarchords.db';

 /*
apiKey: "AIzaSyBRObg4fAZinERURrKQktMi2A_Uz6XNIfk",
authDomain: "chord-71480.firebaseapp.com",
databaseURL: "https://chord-71480.firebaseio.com",
storageBucket: "chord-71480.appspot.com",
messagingSenderId: "876934751830"
*/
$db = new SQLiteDatabase($dbPath);
$rows = $db->get_rows(
	'select * from gc_song'
);
$firebase = Firebase::fromServiceAccount(__DIR__.'/google-services.json');

$database = $firebase->getDatabase();

$root = $database->getReference(DEFAULT_PATH);

foreach( $rows as $row) {
	echo 'Row: '.$row->id .PHP_EOL;
	$now = microtime(true)*10000;
	$row->created = $row->modified = $now;
	try{
		$root->push($row);
		
	} catch(Exception $e ){
		var_dump( $e->getMessage() );
	}
}
die('finish');

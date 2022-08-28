<?php

require './Helpers/ApiHelper.php';
use Helpers\ApiHelper;

if (
    array_key_exists('api-name', $_GET) &&
    is_string($_GET['api-name'])
) {
    $api = new ApiHelper();
    switch ($_GET['api-name']) {
        case 'email':
            $api->send()->output()->save();
            break;
        case 'review':
            $api->output()->save();
            break;
        case 'get-all':
            $api->getAll()->output();    
    }
}









// $result = $mysqli->query("SELECT * FROM emails");
// while ($row=$result->fetch_object()){
//     $results[] = $row; 
// }

// print_r($results);



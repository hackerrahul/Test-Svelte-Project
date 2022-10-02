<?php
header('Content-Type: application/json');

include_once("include/config.php");
include_once("include/functions.php");


if(isset($_SERVER['HTTP_X_AUTH_TOKEN'])){

    $access_token = $_SERVER['HTTP_X_AUTH_TOKEN'];

    $id = decrypt($access_token, ENCRYPTION_KEY);

    

    $db->join("users u", "at.user_id_fk=u.id", "LEFT");
    $db->where("at.token", $access_token);
    $db->where("u.is_active", 1);
    $db->where("at.is_active", 1);
    $user = $db->getOne("access_tokens at", "u.name,u.email");

    if($user){
        $return['status'] = "success";
        $return['message'] = "Successfully Fetched";
        $return['data'] = $user;
    }else{
        $return['status'] = 'unauthorized';
        $return['message'] = "Invalid Request";
    }


}else{
    $return['status'] = 'unauthorized';
    $return['message'] = "Invalid Request";
}

echo json_encode($return);
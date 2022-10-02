<?php
header('Content-Type: application/json');

include_once("include/config.php");
include_once("include/functions.php");

if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password']) ){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $db->where ("email", $email);
    $db->where ("is_active", 1);
    $user = $db->getOne("users");
    if($user){

        if($user['password'] == md5($password)){

            
            $token = encrypt($user['id'], ENCRYPTION_KEY);
            // add access token to user
            $payload = array(
                'token' => $token,
                'user_id_fk' => $user['id']
            );
            $id = $db->insert('access_tokens', $payload);
            if($id){

                $return['status'] = 'success';
                $return['message'] = "Successfully Logged in.";
                $return['access_token'] = $token;
 
            }else{
                $return['status'] = 'error';
                $return['message'] = "Unable to log you in, Please try again later.".$db->getLastError();
            }

        }else{
            $return['status'] = 'error';
            $return['message'] = "Invalid Email/Password";
        }

    }else{
        $return['status'] = 'error';
        $return['message'] = "Email/Password is not correct";
    }

}else{
    $return['status'] = 'error';
    $return['message'] = "Email/Password cannot be Empty";
}

echo json_encode($return);
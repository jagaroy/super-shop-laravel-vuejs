<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

function naming ($key){

    $array = [
        'bill_notice_advance_time' => ' + 1 month',
    ];

    $value = $array[$key];
    
    return $value;
}

function getConstant($str){
    $array = [
        'payment_category_id' => 17,
        'particular_id' => 5,
    ];
    if(!isset($array[$str])){
        throw new Exception("Constant $str not fount!");
    }
    $str = $array[$str];
    return $str;
}

function TrimTrailingZeroes($nbr) {
	$nbr = rtrim($nbr, 'M');
    $nbr = strpos($nbr,'.')!==false ? rtrim(rtrim($nbr,'0'),'.') : $nbr;
    $real = $nbr . 'M';
    return $real;
}

function moduleExist($role_permissions, $module)
{
    $status = false;
    foreach ($role_permissions as $key => $value) {
        if ($value['permi_module'] == $module) {
            $status = true;
            break;
        }
    }

    return $status;
}

function actionExist($role_permissions, $module, $action)
{
    $status = false;
    foreach ($role_permissions as $key => $value) {
        if ( $value['permi_module'] == $module) {

            $permi_desc = json_decode($value['permi_desc'], true);
            
            if(is_array($permi_desc) && $permi_desc){
                
                if(in_array($action, $permi_desc)){
                    
                    $status = true;
                    break;
                }
            }
        }
    }
    return $status;
}

function hasPermission($auth_user, $controller, $action)
{
    if ( $auth_user->type == 'superadmin') {
        return true;
    }

    $set = false;

    $role_permissions = \App\Models\Role::join('permissions', 'permissions.role_id', '=', 'roles.id')->whereRaw('permissions.deleted_at is null')->get()->toArray();

    $controller = str_replace('Controller', '', $controller);
    
    if ($role_permissions) {
        
        foreach ($role_permissions as $key => $value) {

            $db_controller = $value['permi_module'];
            
            $db_controller = str_replace('Api', '', $db_controller);
            $db_controller = stripslashes($db_controller);

            if (($db_controller== $controller) && strpos($value['permi_desc'], $action) !== false) {

                $set = true;
                break;
            }
        }
    }
    
	return $set;
}

function getAuthUser($request) {

    $token= $request->header('Authorization');
    $token = PersonalAccessToken::findToken($token);
    $auth_user = $token ? $token->tokenable : null;

    if( ! $auth_user){
        return ['status'=>'error', 'message'=>'Authorization token is missing!', 'reload_for_token_mismatch'=>1];
    }

    return $auth_user;
}

function active_sms_sending($number, $text, $request){

    // API Response Code
    $status_list = [
        '1000' => 'Invalid user or Password',
        '1002' => 'Empty Number',
        '1003' => 'Invalid message or empty message',
        '1004' => 'Invalid number',
        '1005' => 'All Number is Invalid ',
        '1006' => 'insufficient Balance ',
        '1009' => 'Inactive Account',
        '1010' => 'Max number limit exceeded',
        '1101' => 'Success',
    ];

    $result = array();

    $messageEnable = env('MESSAGE_SEND_ENABLE');
    if($messageEnable){
        $data = array(
            'username'=>'',
            'password'=>'', 
        );

        if(strlen($number) == '11'){
            $number = '88'.$number;
        }else{
            $number = $number;
        }    

        $data['number'] = $number;
        $data['message'] = $text;

        $url = "http://66.45.237.70/api.php";    

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $response = explode("|",$smsresult);
        $sendstatus = $response[0];

        DB::table('sms_records')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'mobile_numbers' => $number,
            'message' => $text,
            'response_code' => $response[0],
            'status' => strtolower($status_list[$response[0]]),
            'authored_by' => getAuthUser($request)->id,
        ]);
    }

    $result['message'] = !empty($response[0]) ? $status_list[$response[0]] : 'message inactive!';

    return $result;
}




















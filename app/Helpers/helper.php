<?php

use App\Models\ErrorLog;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

function successResponse($message = null, $data = null)
{
    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => $data,
    ], 200);
}

function errorResponse($message = null, $code = 400)
{
    return response()->json([
        'success' => false,
        'message' => $message
    ], $code);
}

function validationResonse($errors, $statusCode = 422)
{
    return response()->json([
        'success' => false,
        'message' => 'Validation Error',
        'errors' => $errors,
    ], $statusCode);
}



function is_phone_number_pk($phone_number): bool
{
    if (\preg_match(get_pk_phone_number_regex(), $phone_number)) {
        return true;
    }

    return false;
}
function get_pk_phone_number_regex()
{
    return '/^(\+92\d{10}|03\d{2}-\d{7})$/';
    // return '/^(?:(?:\+|00)92[- ]?\(?3[0-9]{2}\)?[- ]?[0-9]{3}[- ]?[0-9]{4}|0?3[0-9]{2}[- ]?[0-9]{3}[- ]?[0-9]{4})$/';
}



if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('creaete_error_log')) {
    function create_error_log($module, $exception)
    {
        $generate_error_log = new ErrorLog();
        $generate_error_log->error_log_module = $module;
        $generate_error_log->error_log_action_url = URL::current();
        $generate_error_log->error_log_current_url = URL::previous();
        $generate_error_log->error_log_message = $exception->getMessage() . ' On line no : ' . $exception->getLine() . ' file name : ' . $exception->getFile();
        $generate_error_log->error_log_generated_by_id = Auth::user()?->id;
        $generate_error_log->save();
    }
}

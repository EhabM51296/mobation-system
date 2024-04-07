<?php
function isRequired($value) {
    return trim($value) !== "";
}

function isRequiredAllowSpaces($value) {
    return $value !== "";
}
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isValidPassword($value) {
    $formula = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';
    return preg_match($formula, $value);
}

function positiveInteger($value) {
    $formula = '/^[0-9]\d*$/';
    return preg_match($formula, $value);
}

function positiveNumber($value) {
    $formula = '/^[0-9]+(?:\.[0-9]+)?$/';
    return preg_match($formula, $value);
}


function returnJsonObject($status, $data)
{
    return json_encode(
        array("status"=> $status,"data"=> $data)
    );
}
function returnArrayResponse($status, $data)
{
    return array("status"=> $status,"data"=> $data);
}
function executeValidationFunctions(array $validations) {
    $errorMessages = [];

    foreach ($validations as $identifier => $function) {
        $result = $function;
        if ($result === false) {
            $errorMessages[$identifier] = 'Error occurred in ' . $identifier;
        }
    }
    if(!empty($errorMessages))
        return returnArrayResponse(-1, $errorMessages);
    return returnArrayResponse(1, "validation success");
}
?>
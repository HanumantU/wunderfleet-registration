<?php
namespace app\controller;
require '../model/UserModel.php';
require '../model/PaymentInfoModel.php';
//use app\model;
class UserController {
    public $requestMethod = null;
    protected $userModel = null;
    protected $paymentModel = null;

    function __construct()
    {
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
        $this->paymentModel = new \PaymentInfoModel();
        $this->userModel = new \UserModel();
        $this->process_request();
    }

    public function process_request()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->createUserFromRequest();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    public function createUserFromRequest()
    {
        #validating Personal information
        if (! $this->validatePerson($_POST['personal_info'])) {
            return $this->unprocessableEntityResponse();
        }
        #validating Address information
        if (! $this->validateAddress($_POST['address_info'])) {
            return $this->unprocessableEntityResponse();
        }
        
        #firstly insert user data to user table and get method should return newly generated user_id which pass to payment_info controller.
        $user_id = $this->userModel->insert($_POST);
        
        #passing user to Payment info controller
        $this->paymentModel->insert($_POST['payment_info'], $user_id);

        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode([
            'user_id' => $user_id
        ]);
        return $response;
    }

    private function validatePerson($input)
    {
        if (! isset($input['firstName'])) {
            return false;
        }
        if (! isset($input['lastName'])) {
            return false;
        }
        if (! isset($input['telephone'])) {
            return false;
        }
        return true;
    }

    private function validateAddress($input)
    {
        if (! isset($input['addressLine'])) {
            return false;
        }
        if (! isset($input['houseNo'])) {
            return false;
        }
        if (! isset($input['zipCode'])) {
            return false;
        }
        if (! isset($input['city'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}

// pass the request method and user ID to the PersonController and process the HTTP request:
$controller = new UserController();
//$controller->processRequest();
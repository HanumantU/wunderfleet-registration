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
//            case 'GET':
//                if ($this->userId) {
//                    $response = $this->getUser($this->userId);
//                } else {
//                    $response = $this->getAllUsers();
//                };
//                break;
            case 'POST':
                $response = $this->createUserFromRequest();
                break;
//            case 'PUT':
//                $response = $this->updateUserFromRequest($this->userId);
//                break;
//            case 'DELETE':
//                $response = $this->deleteUser($this->userId);
//                break;
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
        $input = array();
//        print_r($_POST);
//        exit;
//        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $input = $_POST;
//        echo $input;
//        exit;
        if (! $this->validatePerson($input)) {
            return $this->unprocessableEntityResponse();
        }
        #getting user id then inserting to payment
        print_r($this->userModel->getUserId());
        exit;
        #firstly insert user data to user table and get method should return newly generated user_id which pass to payment_info controller.
//        $user_id = $this->userModel->insert($input);
        #passing user to Payment info controller
//        $this->paymentModel->insert($input, "1");

        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        print_r($response);
        return $response;
    }

    private function validatePerson($input)
    {
        if (! isset($input['owner_name'])) {
            return false;
        }
        if (! isset($input['iban_no'])) {
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
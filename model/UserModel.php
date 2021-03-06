<?php
require '../config/Database.php';
class UserModel {
    private $conn;
    public $first_name;
    public $last_name;
    public $telephone;
    public $address_line;
    public $house_no;
    public $zip_code;
    public $city;

    public function __construct()
    {   
        $this->conn = (new Database())->getConnection();
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getAddressLine()
    {
        return $this->address_line;
    }

    /**
     * @param mixed $address_line
     */
    public function setAddressLine($address_line)
    {
        $this->address_line = $address_line;
    }

    /**
     * @return mixed
     */
    public function getHouseNo()
    {
        return $this->house_no;
    }

    /**
     * @param mixed $house_no
     */
    public function setHouseNo($house_no)
    {
        $this->house_no = $house_no;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * @param mixed $zip_code
     */
    public function setZipCode($zip_code)
    {
        $this->zip_code = $zip_code;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    public function insert($input) 
    {
        $statement = "
            INSERT INTO users
                (first_name, last_name, telephone, address_line, house_no, zip_code, city, created_at)
            VALUES
                (:firstName, :lastName, :telephone, :addressLine, :houseNo, :zipCode, :city, :created_at);
        ";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'firstName' => $input['personal_info']['firstName'],
                'lastName'  => $input['personal_info']['lastName'],
                'telephone' => $input['personal_info']['telephone'],
                'addressLine' => $input['address_info']['addressLine'],
                'houseNo' => $input['address_info']['houseNo'],
                'zipCode' => $input['address_info']['zipCode'],
                'city' => $input['address_info']['city'],
                'created_at' => date("Y-m-d H:m:s"),
            ));
            return $this->conn->lastInsertId();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getUserId()
    {
        $statement = "
            SELECT 
                user_id
            FROM
                users
            ORDER BY user_id LIMIT 1
        ";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
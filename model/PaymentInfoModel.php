<?php
class PaymentInfoModel {
    private $conn;
    public $owner_name;
    public $iban_no;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    /**
     * @return mixed
     */
    public function getIbanNo()
    {
        return $this->iban_no;
    }

    /**
     * @param mixed $iban_no
     */
    public function setIbanNo($iban_no)
    {
        $this->iban_no = $iban_no;
    }

    /**
     * @return mixed
     */
    public function getOwnerName()
    {
        return $this->owner_name;
    }

    /**
     * @param mixed $owner_name
     */
    public function setOwnerName($owner_name)
    {
        $this->owner_name = $owner_name;
    }

    public function insert($input, $id) {
        $statement = "
            INSERT INTO payment_info
                (payment_info_id, account_owner, iban_no, user_id, created_at)
            VALUES
                (:id, :accountOwner, :ibanNo, :userId, :created_at);
        ";
        echo $statement;
        echo "<pre>";
        print_r($input);
        echo $id;
//        exit;
        try {
            $statement = $this->conn->prepare($statement);
            $status = $statement->execute(array(
                'id' => "default",
                'accountOwner' => $input['owner_name'],
                'ibanNo'  => $input['iban_no'],
                'userId' => $id,
                'created_at' => date("Y-m-d H:m:s")
            ));
            var_dump($statement->rowCount());
            var_dump($status);
            exit;
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
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

    public function insert($input, $user_id) 
    {
        $statement = "
            INSERT INTO payment_info
                (account_owner, iban_no, user_id, created_at)
            VALUES
                (:accountOwner, :ibanNo, :userId, :created_at);
        ";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'accountOwner' => $input['ownerName'],
                'ibanNo'  => $input['ibanNo'],
                'userId' => $user_id,
                'created_at' => date("Y-m-d H:m:s"),
            ));
            return $this->conn->lastInsertId();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
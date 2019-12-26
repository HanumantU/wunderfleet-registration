<?php
class PaymentInfoModel {
    public $owner_name;
    public $iban_no;

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


}
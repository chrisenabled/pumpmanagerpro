<?php


class SubscribeForm extends CFormModel
{
    public $customer;
    public $amountPaid;
    public $adminPassword;
    public $rate = 335;
    public $discount = 0;

    public function rules()
    {
        return array(
            // username and password are required
            array('customer, adminPassword, amountPaid', 'required'),
            array('amountPaid, discount', 'isNumeric'),
            array('amountPaid', 'length', 'max'=>7),
            array('adminPassword', 'authenticate'),
            array('customer','isCustomer'),
        );
    }



    public function isNumeric($attribute){
        $input = str_replace(',', '', $this->$attribute);
        if(!is_numeric($input)){
            $this->addError($attribute, 'Amount must be numeric.');
        }
    }

    public function getCustomer(){
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(username)',strtolower($this->customer),true);
        return $customer = User::Model()->find($criteria);
    }
    public function isCustomer($attribute){
        $customer = $this->getCustomer();
        if($customer === null){
            $this->addError($attribute, 'Customer '. $this->$attribute . ' does not exist.');
        }
    }
    public function authenticate($attribute)
    {
        $admin = Admin::model()->findByAttributes(array('username'=>Yii::app()->user->name));
        if(!$admin->validate_password($this->$attribute, $admin->password)){
            $this->addError($attribute,'The password you entered is wrong.');
        }

    }

    public function getNoOfDays(){

        $rate = $this->rate;
        $paid = (int) str_replace(',', '', $this->amountPaid);
        if($this->discount > 0){
            $rate = $rate - ($rate * ($this->discount/100));
        }
        return $noOfDays = ceil($paid/$rate);

    }
    public function creditCustomer(){

        $customer = $this->getCustomer();
        $noOfDays = $this->getNoOfDays();
        $customer->resetSubscription($noOfDays);

    }

    public function issueOrderInvoice(){

        $orderId = $this->setOrderId();
        $user = $this->getCustomer();
        $userId = $user->id;
        $noOfDays = $this->getNoOfDays();
        $sql = "INSERT INTO tbl_order (order_id, user_id, subscription_price, number_of_days, discount, amount_paid)
                    VALUES (:order_id, :user_id, :price, :nod, :discount, :total)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":order_id", $orderId, PDO::PARAM_STR);
        $command->bindValue(":user_id", $userId, PDO::PARAM_STR);
        $command->bindValue(":price",$this->rate , PDO::PARAM_INT);
        $command->bindValue(":nod",$noOfDays , PDO::PARAM_INT);
        $command->bindValue(":discount",$this->discount , PDO::PARAM_INT);
        $command->bindValue(":total",$this->amountPaid , PDO::PARAM_INT);
        $command->execute();
    }

    private function getOrderId($id){

        $sql = "SELECT order_id FROM tbl_order WHERE order_id = :id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":id", $id, PDO::PARAM_STR);
        $hasOrder =  $command->queryRow();
        return $hasOrder['order_id'];
    }

    private function setOrderId(){
        $customer = $this->getCustomer();
        $counter = 1;
        $concat = $customer->id . $counter;
        while($this->getOrderId($concat) !== null){
            $counter += 1;
            $concat = $customer->id . $counter;
        }
        return $concat;
    }

}

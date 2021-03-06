<?php
/**
 * Created by PhpStorm.
 * User: dino
 * Date: 12/11/14
 * Time: 3:41 PM
 */

namespace dnocode\awsddb\ddb\processors;

use Aws\CloudFront\Exception\Exception;
use dnocode\awsddb\ddb\inputs\AWSInput;
use Guzzle\Service\Resource\Model;
use Item;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\UnknownPropertyException;


abstract class Command extends Component
{
    /**
     * @var Connection the DB connection that this command is associated with
     */
    public $db;
    /** @var  Model */
    public $result;
    /**
     * @var AWSInput
     */
    public $amz_input;
    public $params;
    public $uid;

    protected function beforeExecute(){}

    protected function afterExecute(){}


    abstract function execute();


    abstract function toAmazonRequestArray();

    public function validate(){

        try{
                if($this->db==null){ throw new InvalidConfigException();}

             } catch(Exception $e){ throw $e;}
        }

    public function doIt(){

        $this->beforeExecute();
        Yii::info("executing command uid: $this->uid");
        $this->execute();
        Yii::info("command uid: $this->uid executed" );
        $this->afterExecute();
    }

    public function pullOutOne(){}
    public function pullOutAll(){}

    /**
     * @return \Aws\DynamoDb\DynamoDbClient
     */
    public function aws(){ return $this->db->aws();}




}
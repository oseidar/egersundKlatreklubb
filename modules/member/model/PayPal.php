<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PayPal
 *
 * @author idar
 */
class PayPal {
    
     const USER = "oseidar_api1.gmail.com";
     const PWD = "6FJA4JVLGYDTK543";
     const SIGNATURE = "AmH7yHP1SJA3gijDtVsCEbv7dtinAqJYJw8jvhaVFBjWoitU8wfVq15i";
     public $METHOD ,$VERSION,$amount,$token,$payerId,$itemName;
     public $returnUrl = "http://mccbase.dwk.no/paypalSuccess.php";
     public $cancelUrl = "http://mccbase.dwk.no/paypalCancel.php";
     
    
     
     
     function __construct() {
         
     }
     public function getMETHOD() {
         return $this->METHOD;
     }

     public function setMETHOD($METHOD) {
         $this->METHOD = $METHOD;
     }

     public function getVERSION() {
         return $this->VERSION;
     }

     public function setVERSION($VERSION) {
         $this->VERSION = $VERSION;
     }

     public function getAmount() {
         return $this->amount;
     }

     public function setAmount($amount) {
         $this->amount = $amount;
     }

     public function getReturnUrl() {
         return $this->returnUrl;
     }

     public function setReturnUrl($returnUrl) {
         $this->returnUrl = $returnUrl;
     }

     public function getCancelUrl() {
         return $this->cancelUrl;
     }

     public function setCancelUrl($cancelUrl) {
         $this->cancelUrl = $cancelUrl;
     }
     
     

     public function getToken(){
         $postArray = array(
                           "USER"=>  self::USER,
                           "PWD"=>self::PWD,
                           "SIGNATURE"=>self::SIGNATURE,
                           "METHOD"=>"SetExpressCheckout",
                           "VERSION"=>"86",
                           "LOCALECODE"=>"no_NO",
                           "PAYMENTREQUEST_0_DESC"=>"Betalingen gjelder: ".$this->itemName,
                           "PAYMENTREQUEST_0_PAYMENTACTION"=>"Sale",
                           "PAYMENTREQUEST_0_AMT"=>$this->amount,
                           "PAYMENTREQUEST_0_CURRENCYCODE"=>"NOK",
                           "cancelUrl" =>$this->cancelUrl,
                           "returnUrl" =>$this->returnUrl
                           
                       );
                       $poststring = "";
                        foreach($postArray as $key => $value){
                            $poststring .= "$key=$value&";
                        }
                        
                        $poststring = substr($poststring, 0,  strlen($poststring)-1);
                        
                        $req = curl_init("https://api-3t.sandbox.paypal.com/nvp");
                       
                       
                       
                       curl_setopt($req, CURLOPT_POST, 1);
                       curl_setopt($req, CURLOPT_POSTFIELDS, $poststring);
                       curl_setopt($req, CURLOPT_RETURNTRANSFER,1);
                       
                       $ret = curl_exec($req);
                       curl_close($req);
                       
                       //echo $ret;
                       
                       $tmp = explode("&", $ret);
                       //print_r($tmp);
                       $token = $tmp[0];
                       $tmpToken = explode("=", $token);
                       return $tmpToken[1];
                      
         
     }
     
     public function getPaymentDetails(){
         $postArray = array(
                           "USER"=>  self::USER,
                           "PWD"=>self::PWD,
                           "SIGNATURE"=>self::SIGNATURE,
                           "METHOD"=>"GetExpressCheckoutDetails",
                           "VERSION"=>"86",
                           "LOCALECODE"=>"no_NO",
                           "PAYMENTREQUEST_0_PAYMENTACTION"=>"Sale",
                          
                           "PAYMENTREQUEST_0_AMT"=>$this->amount,
                           "PAYMENTREQUEST_0_CURRENCYCODE"=>"NOK",
                           "TOKEN"=>$this->token
                           
                       );
                       $poststring = "";
                        foreach($postArray as $key => $value){
                            $poststring .= "$key=$value&";
                        }
                        
                        $poststring = substr($poststring, 0,  strlen($poststring)-1);
                        
                        $req = curl_init("https://api-3t.sandbox.paypal.com/nvp");
                       
                       
                       
                       curl_setopt($req, CURLOPT_POST, 1);
                       curl_setopt($req, CURLOPT_POSTFIELDS, $poststring);
                       curl_setopt($req, CURLOPT_RETURNTRANSFER,1);
                       
                       $ret = curl_exec($req);
                       curl_close($req);
                       
                       //echo $ret;
                       
                       $tmp = explode("&", $ret);
                       $array = array();
                       foreach ($tmp as $pair){
                           $p = explode("=", $pair);
                           $array[$p[0]] = $p[1];
                       }
                       
                       return $array;

         
     }
     
     public function doExpressCheckout(){
        

         
             
             $postArray = array(
                           "USER"=>  self::USER,
                           "PWD"=>self::PWD,
                           "SIGNATURE"=>self::SIGNATURE,
                           "METHOD"=>"DoExpressCheckoutPayment",
                           "VERSION"=>"86",
                           "LOCALECODE"=>"no_NO",
                           "PAYMENTREQUEST_0_PAYMENTACTION"=>"Sale",
                            "PAYERID"=>$this->payerId,
                           "PAYMENTREQUEST_0_AMT"=>$this->amount,
                           "PAYMENTREQUEST_0_CURRENCYCODE"=>"NOK",
                           "TOKEN"=>$this->token
                           
                       );
                       $poststring = "";
                        foreach($postArray as $key => $value){
                            $poststring .= "$key=$value&";
                        }
                        
                        $poststring = substr($poststring, 0,  strlen($poststring)-1);
                        
                        $req = curl_init("https://api-3t.sandbox.paypal.com/nvp");
                       
                       
                       
                       curl_setopt($req, CURLOPT_POST, 1);
                       curl_setopt($req, CURLOPT_POSTFIELDS, $poststring);
                       curl_setopt($req, CURLOPT_RETURNTRANSFER,1);
                       
                       $ret = curl_exec($req);
                       curl_close($req);
                       
                       //echo $ret;
                       
                       $tmp = explode("&", $ret);
                       $array = array();
                       foreach ($tmp as $pair){
                           $p = explode("=", $pair);
                           $array[$p[0]] = $p[1];
                       }
                       
                       return $array;
             
     }

    
    
}

?>

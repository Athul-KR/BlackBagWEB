<?php
namespace App\customclasses;
use DB;
use PDO;
use Mail;
use Session;
use Carbon;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\Token;
use Illuminate\Support\Facades\Redirect;

class StripePayment {


	 public function __construct(){
        \Stripe\Stripe::setApiKey(env('SECRET_KEY'));
    //    Stripe::setApiKey(env('SES_SECRET'));
        // \Stripe\Stripe::setApiKey("sk_test_FESlQvBRNHk8IVIhPLYtQRzd");
    }

   /* Create Customer r*/
  public function createCustomer($stripetoken,$email,$user_info) {
    try{
      $customer =  Customer::create(array(
        'email' => $email,
        'metadata' => $user_info,
        "source" => $stripetoken // obtained with Stripe.js
      ));
      $arr['response']=$customer;
      $arr['success']=1;
      return $arr;
      }

        catch(\Stripe\Exception\CardException $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        }catch (\Stripe\Error\Card $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\Authentication $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\ApiConnection $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\Base $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        } catch (Exception $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        }

  }



  /* Retrieve a Specified Customer*/

  public function retreiveCustomerDetail($customerid){
    $customerDetail = \Stripe\Customer::retrieve($customerid);
    return $customerDetail;
  }


   public function retreiveCardDetails($cusId) {
     $cardDet =  \Stripe\Customer::retrieve($cusId)->sources->all(array(
    'object' => 'card'));
     return $cardDet;
  }

  public function createCard($cusId,$card_Info) {
     try{
            $customer = \Stripe\Customer::retrieve($cusId);

            $arr['response']=$customer->sources->create(array('source'=>$card_Info['source']));
            $arr['success']=1;
            return $arr;
        }
        catch(\Stripe\Exception\CardException $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        }catch (\Stripe\Error\Card $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\Authentication $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\ApiConnection $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\Base $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        } catch (Exception $e) {
            $arr['response']=$e->getMessage();
            $arr['error']=1;
            return $arr;
        }


  }

  public function createToken($cardinfo){
    try{
  $token =  Token::create( array( "card" => array(
            "number" => $cardinfo['card_number'],
            "exp_month" => $cardinfo['expiry_month'],
            "exp_year" => $cardinfo['expiry_year'],
            "cvc" => $cardinfo['cvv']
        )
    )
  );
  $arr['response']=$token;  
  $arr['success']=1;
  return $arr;
  }
   catch (\Stripe\Error\Card $e) {

        $arr['response']=$e->getMessage();  
        $arr['error']=1;  
        return $arr;
    } catch (\Stripe\Error\InvalidRequest $e) {
        $arr['response']=$e->getMessage();  
        $arr['error']=1;  
        return $arr;
    } catch (\Stripe\Error\Authentication $e) {
        $arr['response']=$e->getMessage();  
        $arr['error']=1;  
        return $arr;
    } catch (\Stripe\Error\ApiConnection $e) {
        $arr['response']=$e->getMessage();  
        $arr['error']=1;  
        return $arr;
    } catch (\Stripe\Error\Base $e) {
        $arr['response']=$e->getMessage();  
        $arr['error']=1;  
        return $arr;
    } catch (\Exception $e) {
        $arr['response']=$e->getMessage();  
        $arr['error']=1;  
        return $arr;
    }
}

  public function cardByCardKey($cusId,$stripe_cardid) {
    $customer = \Stripe\Customer::retrieve($cusId);
    $card = $customer->sources->retrieve($stripe_cardid);
    return $card;

  }


  /*create Stripe Charge for specific customer*/
  public function chargeCreateForCustomer($itemPrice,$currency,$itemName,$customerid){
    try{
      $charge = \Stripe\Charge::create(array(
            'customer' => $customerid,
            'amount'   => $itemPrice,
            'currency' => 'usd',
           // "source" => "tok_amex",
            'description' => $itemName,
      ));
            $arr['response']=$charge;
            $arr['success']=1;
            return $arr;
      }
       catch (\Stripe\Error\Card $e) {
            $e_json = $e->getJsonBody();
            $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        }catch(\Stripe\Exception\CardException $e) {
            $e_json = $e->getJsonBody();
            $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\Authentication $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\ApiConnection $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\Base $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (Exception $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        }
  }
public function chargeCreateForCustomerByCardid($itemPrice,$currency,$itemName,$customerid,$cardid){
    try{
      $charge = \Stripe\Charge::create(array(
            'customer' => $customerid,
            'amount'   => $itemPrice,
            'currency' => 'usd',
            "source" => $cardid,
            'description' => $itemName,
      ));
            $arr['response']=$charge;
            $arr['success']=1;
            return $arr;
      }
       catch (\Stripe\Error\Card $e) {
           $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        }catch(\Stripe\Exception\CardException $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\Authentication $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\ApiConnection $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\Base $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (Exception $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        }
  }


   /*create Stripe Charge for specific customer*/
  public function chargeCreateWithToken($itemPrice,$token,$description,$metadata){


    try{

      $charge = \Stripe\Charge::create(array(
          "amount" => $itemPrice, // amount in cents
          "currency" => "usd",
          "source" => $token,
          "description" => $description,
          "metadata" => $metadata
      ));



            $arr['response']=$charge;
            $arr['success']=1;
            return $arr;
      }
       catch (\Stripe\Error\Card $e) {
           $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;

        }catch(\Stripe\Exception\CardException $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\Authentication $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\ApiConnection $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (\Stripe\Error\Base $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        } catch (Exception $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];

            $arr['response']=$error;
            $arr['error']=1;
            return $arr;
        }
  }

  public function chargeCreateWithTocken($itemPrice,$token,$description,$metadata){
    try{
     
      $charge = \Stripe\Charge::create(array(
          "amount" => $itemPrice, // amount in cents
          "currency" => "usd",
          "source" => $token,
          "description" => $description,
          "metadata" => $metadata
      ));



            $arr['response']=$charge;  
            $arr['success']=1;
            return $arr;
      }
       catch (\Stripe\Error\Card $e) {
           $e_json = $e->getJsonBody();
           $error = $e_json['error'];
    
            $arr['response']=$error;  
            $arr['error']=1;  
            return $arr;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];
    
            $arr['response']=$error;  
            $arr['error']=1;  
            return $arr;
        } catch (\Stripe\Error\Authentication $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];
    
            $arr['response']=$error;  
            $arr['error']=1;  
            return $arr;
        } catch (\Stripe\Error\ApiConnection $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];
    
            $arr['response']=$error;   
            $arr['error']=1;  
            return $arr;
        } catch (\Stripe\Error\Base $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];
    
            $arr['response']=$error;  
            $arr['error']=1;  
            return $arr;
        } catch (\Exception $e) {
            $e_json = $e->getJsonBody();
           $error = $e_json['error'];
    
            $arr['response']=$error;    
            $arr['error']=1;  
            return $arr;
        }
  }

    function setupPaymentIntentOnbehalf($appoinmentData){
        try {
            // Amount in cents
            $amountToPay = $appoinmentData['amount'];
            $transferAmount = $appoinmentData['transferAmount'];
            $paymentMethodId = $appoinmentData['paymentMethodId'];
            if($appoinmentData['stripe_customer_id']!=''){
                $customerID = $appoinmentData['stripe_customer_id'];
                $address = [
                    'line1' => $appoinmentData['metaData']['Address'],
                    'city' => $appoinmentData['metaData']['City'],
                    'state' => $appoinmentData['metaData']['state'],
                    'postal_code' => $appoinmentData['metaData']['postal_code'],
                    'country' => 'US',
                ];
                $customerDetails = $this->updateStripeCustomerAddress($appoinmentData['stripe_customer_id'],$address);
            }else{
                $customer = Customer::create([
                    'email' => $appoinmentData['email'], // You can also include other parameters like name, address, etc.
                    'name' => $appoinmentData['name'],
                    'address' => [
                        'line1' => $appoinmentData['metaData']['Address'],
                        'city' => $appoinmentData['metaData']['City'],
                        'state' => $appoinmentData['metaData']['state'],
                        'postal_code' => $appoinmentData['metaData']['postal_code'],
                        'country' => 'US',
                    ],
                ]);
                $customerID = $customer->id;
            }
            $metaData = $appoinmentData['metaData'];
            // Create PaymentIntent
            try {
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => $amountToPay,
                    'currency' => 'usd',
                    'description' => $appoinmentData['description'],
                    'customer' => $customerID,
                    'payment_method' => $paymentMethodId,
                    'off_session' => true,
                    'confirm' => true,
                    'metadata' => $metaData,
                    'on_behalf_of' => $appoinmentData['stripe_user_id'],
                    'transfer_data' => [
                        'destination' => $appoinmentData['stripe_user_id'],
                    ],
                    'application_fee_amount' => $transferAmount, // your platform fee (optional)
                ]);
                $arr['status'] = 1;
                $arr['response'] = $paymentIntent->client_secret;
                $arr['customerID'] = $customerID;
                $arr['payment_intent_id'] = $paymentIntent->id;
                $arr['paymentstatus'] = $paymentIntent->status;
                return $arr;
                
            } catch (\Stripe\Exception\CardException $e) {
                return [
                    'status' => 0,
                    'message' =>  $e->getError()->message,
                ];
            }
            
            
//            $paymentIntent = \Stripe\PaymentIntent::create([
//                'amount' => $amountToPay, // Amount in cents
//                'currency' => 'usd',
//                'description' => $appoinmentData['description'],
//                'payment_method' => $paymentMethodId,
//                'customer' => $customerID,
//                'confirmation_method' => 'automatic', // Automatically confirms the payment
//                'metadata' => $metaData,
//                'confirm' => true, // Automatically confirms the PaymentIntent
//                'return_url' => url('stripe/webhooks/3dsecureauthentication'), // Replace with your URL
//                'application_fee_amount' => $transferAmount, // Fee in cents (ensure it's an integer)
//                'shipping' => [
//                    'name' => $metaData['Name'], // Customer name
//                    'address' => [
//                        'line1' =>$metaData['Address'], // First line of the address
//                        'city' => $metaData['City'], // City
//                        'state' => $metaData['state'], // State
//                        'postal_code' => $metaData['postal_code'], // Postal code
//                        'country' => 'IN',
//                    ],
//                ],
//            ], [
//                'stripe_account' => $appoinmentData['stripe_user_id'],  // Use the connected account
//            ]);
          
          
           
        } catch (Error $e) {
            print_r('error');die;
            $arr['status'] = 0;
            $arr['message'] = $e->getMessage();
            return $arr;
        }
    }

    function setupPaymentIntent($appoinmentData){
        try {
            // Amount in cents
            $amountToPay = $appoinmentData['amount'];
            $paymentMethodId = $appoinmentData['paymentMethodId'];
            if($appoinmentData['stripe_customer_id']!=''){
                try {
                    $customerID = \Stripe\Customer::retrieve($appoinmentData['stripe_customer_id']);
                } catch (\Throwable $e) {
                    $customer = \Stripe\Customer::create([
                        'email' => $appoinmentData['email'],
                        'name' => $appoinmentData['name'],
                    ]);
                    $customerID = $customer->id;
                }
            }else{
                $customer = Customer::create([
                    'email' => $appoinmentData['email'], // You can also include other parameters like name, address, etc.
                    'name' => $appoinmentData['name'],
                ]);
                $customerID = $customer->id;
            }
            
            $metaData = $appoinmentData['metaData'];
            //print_r($metaData);die;
            // Create PaymentIntent
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amountToPay, // Amount in cents
                'currency' => 'usd',
                'description' => $appoinmentData['description'],
                'payment_method' => $paymentMethodId,
                'customer' => $customerID,
                'confirmation_method' => 'automatic', // Automatically confirms the payment
                'metadata' => $metaData,
                'transfer_data' => [
                    'destination' => $appoinmentData['stripe_user_id'],
                ],
                'confirm' => true, // Automatically confirms the PaymentIntent
                'return_url' => url('stripe/webhooks/3dsecureauthentication'), // Replace with your URL
            ]);
            //print_r($paymentIntent);die;
            $arr['status'] = 1;
            $arr['response'] = $paymentIntent->client_secret;
            $arr['customerID'] = $customerID;
            $arr['payment_intent_id'] = $paymentIntent->id;
            $arr['paymentstatus'] = $paymentIntent->status;
            return $arr;
            
           
        } catch (Error $e) {
            $arr['status'] = 0;
            $arr['message'] = $e->getMessage();
            return $arr;
        }
    }

    function setupPaymentIntentNew($appoinmentData){
        try {
            // Amount in cents
            $amountToPay = $appoinmentData['amount'];
            $paymentMethodId = $appoinmentData['paymentMethodId'];
            if($appoinmentData['stripe_customer_id']!=''){
                try {
                    $customerID = \Stripe\Customer::retrieve($appoinmentData['stripe_customer_id']);
                } catch (\Throwable $e) {
                    $customer = \Stripe\Customer::create([
                        'email' => $appoinmentData['email'],
                        'name' => $appoinmentData['name'],
                    ]);
                    $customerID = $customer->id;
                }
            }else{
                $customer = Customer::create([
                    'email' => $appoinmentData['email'], // You can also include other parameters like name, address, etc.
                    'name' => $appoinmentData['name'],
                ]);
                $customerID = $customer->id;
            }
            
            $metaData = $appoinmentData['metaData'];
           
            // Create PaymentIntent
            try {
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => $amountToPay, // Amount in cents
                    'currency' => 'usd',
                    'description' => $appoinmentData['description'],
                    'payment_method' => $paymentMethodId,
                    'customer' => $customerID,
                    'confirmation_method' => 'automatic', // Automatically confirms the payment
                    'metadata' => $metaData,
                    'confirm' => true, // Automatically confirms the PaymentIntent
                    'return_url' => url('stripe/webhooks/3dsecureauthentication'), // Replace with your URL
                ]);
                // print_r($paymentIntent);die;
                $arr['status'] = 1;
                $arr['response'] = $paymentIntent->client_secret;
                $arr['customerID'] = $customerID;
                $arr['payment_intent_id'] = $paymentIntent->id;
                $arr['paymentstatus'] = $paymentIntent->status;
                return $arr;
            } catch (\Throwable $e) {
                // Stripe-specific error (card declined, wrong params, etc.)
                return [
                    'status'      => 0,
                    'message'     => $e->getError()->message, // "The PaymentMethod pm_… does not belong …"
                    'stripe_type' => $e->getError()->type,    // e.g. invalid_request_error
                    'stripe_code' => $e->getError()->code,    // e.g. payment_method_unexpected_state
                ];
            
            }
           
        } catch (Error $e) {
            $arr['status'] = 0;
            $arr['message'] = $e->getMessage();
            return $arr;
        }
    }


    function retrievePaymentMethod($pmToken,$stripeAccount){
        try {
          
            $paymentMethodDetails = \Stripe\PaymentMethod::retrieve($pmToken,[
                'stripe_account'=>$stripeAccount
            ]);
               
            $arr['status'] = 1;
            $arr['response'] = $paymentMethodDetails;
            return $arr;
        } catch (Error $e) {
            $arr['status'] = 0;
            $arr['response'] = $e->getMessage();
            return $arr;
        }
    }

    function retrievePaymentMethodNew($pmToken){
        try {
            $paymentMethodDetails = \Stripe\PaymentMethod::retrieve($pmToken);

            $arr['status'] = 1;
            $arr['response'] = $paymentMethodDetails;
            return $arr;
        } catch (Error $e) {
            $arr['status'] = 0;
            $arr['response'] = $e->getMessage();
            return $arr;
        }
    }
    
    function retrieveSetupIntent($intentID){
        try {
            $setupIntentDetails = \Stripe\SetupIntent::retrieve($intentID);

            $arr['status'] = 1;
            $arr['response'] = $setupIntentDetails;
            return $arr;
        } catch (Error $e) {
            $arr['status'] = 0;
            $arr['response'] = $e->getMessage();
            return $arr;
        }
    }
    
    function updateSetupIntent($intentID,$metadata){
        try {
            $setupIntentDetails = \Stripe\SetupIntent::update($intentID,['metadata' => $metadata]);

            $arr['status'] = 1;
            $arr['response'] = $setupIntentDetails;
            return $arr;
        } catch (Error $e) {
            $arr['status'] = 0;
            $arr['response'] = $e->getMessage();
            return $arr;
        }
    }
    
    function updateCustomerBack14thMarch($customerID,$email,$metadata,$pmToken){
        try {
            $customerDetails = \Stripe\Customer::update($customerID,['email'=>$email,'metadata' => $metadata,'invoice_settings'=>array('default_payment_method'=>$pmToken)]);

            $arr['status'] = 1;
            $arr['response'] = $customerDetails;
            return $arr;
        } catch (Error $e) {
            $arr['status'] = 0;
            $arr['response'] = $e->getMessage();
            return $arr;
        }
    }

    function createPaymentIntent($amount,$customer,$payment_method,$description, $metaData = array() ){
        try {
            $intentDetails = \Stripe\PaymentIntent::create(array(
                'amount' => $amount, // amount in cents
                'currency' => 'usd',
                'customer' => $customer,
                'description' => $description,
                'payment_method' => $payment_method, // Payment Method ID obtained from frontend
                'metadata' => $metaData,
                'confirm' => true,
                //'setup_future_usage' => 'off_session',
                'return_url' => url('stripe/webhooks/3dsecureauthentication'),
                //'mandate' => 'mandate_1P6dOVSEzgQksl07aXadz2Up',
                /*'automatic_payment_methods' => array(
                      'enabled' => true,
                      'allow_redirects' => 'never'
                )*/
              )
            );
            
           /* $confirmIntentDetails = \Stripe\PaymentIntent::retrieve($intentDetails->id);
            $confirmIntentDetails->confirm([
                'payment_method' => $payment_method,
                'return_url' => 'https://support.consult-ic.com',
            ]);*/

            $arr['status'] = 1;
            $arr['response'] = $intentDetails;
            //$arr['confirm_response'] = $confirmIntentDetails;
            return $arr;
        } catch (\Throwable  $e) {
            $arr['status'] = 0;
            $arr['response'] = $e->getMessage();
            return $arr;
        }
    }
    
        
    function updateCustomer($customerID,$email,$metadata,$pmToken){
          $update_params = array(
           // 'email' => $email,
           // 'name' => $metadata['Name'],
            'address'           => array(
                'line1'         => $metadata['Address'],
                'city'          => (isset($metadata['City']) && $metadata['City'] != '') ? $metadata['City'] : '',
                //'state'       => 'New State',
                'postal_code'   => (isset($metadata['City']) && $metadata['City'] != '') ? $metadata['Zip Code'] : '',
               // 'country'     => 'New Country',
            )
        );

        try {
            $customerDetails = \Stripe\Customer::update($customerID,[$update_params , 'metadata' => $metadata,'invoice_settings'=>array('default_payment_method'=>$pmToken)]);

            $arr['status'] = 1;
            $arr['response'] = $customerDetails;
            return $arr;
        } catch (Error $e) {
            $arr['status'] = 0;
            $arr['response'] = $e->getMessage();
            return $arr;
        }
    }
    
    function setupPaymentIntentWithCustomer($userDetails){
        try {
           
            if($userDetails['stripe_customer_id']!=''){
                $customerID = $userDetails['stripe_customer_id'];
            }else{
                $customer = Customer::create([
                    'email' => $userDetails['email'], // You can also include other parameters like name, address, etc.
                    'name' => $userDetails['name'],
                    //'id' => $teamDetails['id'], // Specify the desired customer ID
                ]);
           
                $customerID = $customer->id;
            }
           
            $intent =  \Stripe\SetupIntent::create([
                'payment_method_types' => ['card'],
                'customer' => $customerID,
                'usage' => 'off_session'
            ]);
        
            $output = [
                'clientSecret' => $intent->client_secret,
            ];

            $arr['status'] = 1;
            $arr['response'] = $intent->client_secret;
            $arr['payment_intent_id'] = $intent->id;
            $arr['paymentstatus'] = $intent->status;
            $arr['customerID'] = $customerID;
            return $arr;
        } catch (Error $e) {
            $arr['status'] = 0;
            $arr['response'] = $e->getMessage();
            return $arr;
        }
    }

    function setupPaymentIntentWithMandate($teamDetails,$email,$mandateInfo){
        try {
           
            if($teamDetails['stripe_customer_id']!=''){
                $customerID = $teamDetails['stripe_customer_id'];
            }else{
                
                 $customer = Customer::create([
                    'email' => $email, // You can also include other parameters like name, address, etc.
                    'name' => $teamDetails['team_name'],
                    //'id' => $teamDetails['id'], // Specify the desired customer ID
                ]);
           
                $customerID = $customer->id;
            }
            
            
            $intent =  \Stripe\SetupIntent::create([
                'payment_method_types' => ['card'],
                'customer' => $customerID,
                'usage' => 'off_session',
                'payment_method_options' => [
                    'card' => [
                        'mandate_options' => [
                            'reference' => $mandateInfo['reference'],
                            'description' => $mandateInfo['description'],
                            'amount' => $mandateInfo['amount'],
                            'currency' => 'inr',
                            'amount_type' => $mandateInfo['amount_type'],
                            'start_date' => time(),
                            'interval' => $mandateInfo['interval'],
                            'interval_count' => 1,
                            'supported_types' => array(
                                'india'
                            )
                        ],
                    ],
                ],
              
            ]);
           
            $output = [
                'clientSecret' => $intent->client_secret,
            ];

            $arr['status'] = 1;
            $arr['response'] = $intent->client_secret;
            $arr['customerID'] = $customerID;
            return $arr;
        } catch (Error $e) {
            $arr['status'] = 0;
            $arr['response'] = $e->getMessage();
            return $arr;
        }
    }
    public function retrievePaymentIntent($intentID,$stripeAccount){
          try {
                $response = \Stripe\PaymentIntent::retrieve($intentID,[
                    'stripe_account'=>$stripeAccount
                    ]);
                $arr['response']= $response;  
                $arr['success']=1;
                return $arr;
              } catch (\Exception $e) {
                    $arr['status'] = 0;
            $arr['response'] = $e->getMessage();
            return $arr;
         }
    }
    
    public function updateStripeCustomerAddress($customerId, $address) {
        try {
            $customer = \Stripe\Customer::update($customerId, [
                'address' => $address
            ]);
    
            $arr['response'] = $customer;
            $arr['success'] = 1;
            return $arr;
        } catch (\Stripe\Exception\CardException $e) {
            $arr['response'] = $e->getMessage();
            $arr['error'] = 1;
            return $arr;
        } catch (\Stripe\Error\Card $e) {
            $arr['response'] = $e->getMessage();
            $arr['error'] = 1;
            return $arr;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $arr['response'] = $e->getMessage();
            $arr['error'] = 1;
            return $arr;
        } catch (\Stripe\Error\Authentication $e) {
            $arr['response'] = $e->getMessage();
            $arr['error'] = 1;
            return $arr;
        } catch (\Stripe\Error\ApiConnection $e) {
            $arr['response'] = $e->getMessage();
            $arr['error'] = 1;
            return $arr;
        } catch (\Stripe\Error\Base $e) {
            $arr['response'] = $e->getMessage();
            $arr['error'] = 1;
            return $arr;
        } catch (Exception $e) {
            $arr['response'] = $e->getMessage();
            $arr['error'] = 1;
            return $arr;
        }
    }


    public function connectStripeAccount( $accountcode ){

        try {
   
           $response = \Stripe\OAuth::token([
             'grant_type' => 'authorization_code',
             'country' => 'US',
             'type' => 'custom',
             'code' => $accountcode,
           ]);
   
           
   
          
           $arr['response']= $response;  
           $arr['success']=1;
           return $arr;
       } catch (\Exception $e) {
            $e_json = $e->getJsonBody();
            $error = $e_json['error'];
   
           $arr['response']=$error;    
           $arr['error']=1;  
           return $arr;
         }
     }
      
   
   
       public function disConnectStripeAccount( $stripe_connection_id ){
       
        try {
   
          $response = \Stripe\OAuth::deauthorize([
             'client_id' => env('CLIENT_ID'),
             'stripe_user_id' => $stripe_connection_id,
           ]);
   
          
           $arr['response']= $response;  
           $arr['success']=1;
           return $arr;
       } catch (\Exception $e) {
            $e_json = $e->getJsonBody();
            $error = $e_json['error'];
            $arr['response']=$error;    
            $arr['error']=1;  
            return $arr;
         }
     }

    
}
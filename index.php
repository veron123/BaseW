
<?php
require './libs/Slim/Slim.php';


/* FILE CONTAINING the CONTROLLER CLASS */

require_once (__DIR__ . '/controller/controller1.php');
//require_once (__DIR__ . '/controller/customercontroller.php'); 
require_once './controller/customercontroller.php';

\Slim\Slim::registerAutoloader();
 
$app = new \Slim\Slim();
 


/**
 * Echoing error response to client
 * @param String $status_code Http response code
 */
function echoError($status_code) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
 }

/**
 * Verifying required params posted or not
 */
 /**
Verify required Headers
*/	
function verifyHeaders($required_fields)
{
	$error = false;
	$error_fields = "";
	$request_params = array();
	$app = \Slim\Slim::getInstance();
	$request_params = $app->request->headers->all();
	
	foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
	}
	
	if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/// FUNCTION that sends HTTP response code and JSON DATA ///

function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
 
    // setting response content type to json
    $app->contentType('application/json');
 
    echo json_encode($response);
}

///////////////////////////////BASE CODE///////////////////////////////////////////////

		/**
 * Merchant restaurant ID query
 * url - /merchant
 * method - GET
 * params - username, password
 */
        $app->get('/merchant', function() use ($app){
            // check for required params
            
        $request = array();
	    $response = array();
	    $userName = array();
	    $password = array();
		
		$headers = $app->request->headers->all();
		// verifyHeaders(array('Key'));
		
            // reading request params
        $userName = $headers['Username'];
        $password = $headers['Password'];
            
        $request['userName'] = $userName;
	    $request['password'] = $password;
	
        $controller = new ApiController();

	    // Call controller function
	    $response = $controller->login($request); 
		
		// echo json response
        echoRespnse(200, $response);
        });


        /* GET PRODUCTS, CATEGORY, SUBCATEGORY INFORMATION ABOUT SPECIFIC RESTAURANT
        * RESPONSE AND VALIDATION CODE SHOULD BE MADE 
        */
        $app->get('/merchant/:id/products', function($id) use ($app){
            // check for required params
            
        $request = array();
	    $response = array();
	    $apiKey = array();
	    		
		$headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
	    $request['restaurantID'] = $id;
		
		$controller = new ApiController();

	    // Call controller function
	    $response = $controller->getProd($request); 
		
		// echo json response
        echoRespnse(200, $response);
        });

        /* GET RESTAURANT
        * REINFORCE VALIDATIONS IN CASE OF WRONG DETAILS 
        */

        $app->get('/merchant/:id/detail', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->getRest($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
		
        /* GET OPENING TIMINGS OF RESTAURANT */
        $app->get('/merchant/:id/openingtimes', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->getOpenTime($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
        
        /* GET CLOSING TIMINGS OF RESTAURANT */
        $app->get('/merchant/:id/closingtimes', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->getCloseTime($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
        
        /* GET OFFICIAL TIMINGS OF RESTAURANT */
        $app->get('/merchant/:id/officialtimes', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->getOffTimes($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
        

        /* GET DATA corresponding to a merchant */
        $app->get('/merchant/:id/data', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
			
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->getData($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
        

        /* GET USERS corresponding to a merchant */
		$app->get('/merchant/:id/users', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->getUsers($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
        
        /* GET TAXES corresponding to a merchant */
        $app->get('/merchant/:id/tax', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->getTax($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });


        /* GET DISCOUNT corresponing to a merchant */
        $app->get('/merchant/:id/discount', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->getDiscounts($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });

        /* GET ADDITIONAL CHARGES corresponding to a merchant */
        $app->get('/merchant/:id/charges', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->getACharges($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
        

        /* GET MASTER DATA CORRESPONDING to a restaurant */
        $app->get('/merchant/:id/master', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->Master($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
        
        /////////////////////////////////////////////////// CUSTOMER API /////////////////////////////////////

        /* GET ALL CUSTOMERS DETAILS CORRESPONDING to a restaurant */
        $app->get('/merchant/:id/customers', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new CustomerController();

        // Call controller function
        $response = $controller->getAllCustomers($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });


        /* GET CUSTOMER DETAIL CORRESPONDING to a restaurantID and customerID*/
        $app->get('/merchant/:id/customer/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        $request["customerID"] = $id2;
        
        $controller = new CustomerController();

        // Call controller function
        $response = $controller->getCustomers($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
        

        /* GET CUSTOMER PHONE DETAIL CORRESPONDING to a restaurantID and customerID*/
        $app->get('/merchant/:id/customerphone/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        $request["customerID"] = $id2;
        
        $controller = new CustomerController();

        // Call controller function
        $response = $controller->getCustomerPhone($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });


        /* GET CUSTOMER EMAIL CORRESPONDING to a restaurantID and customerID*/
        $app->get('/merchant/:id/customermail/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        $request["customerID"] = $id2;
        
        $controller = new CustomerController();

        // Call controller function
        $response = $controller->getMail($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });


        /* GET CUSTOMER ADDRESS CORRESPONDING to a restaurantID and customerID */
        $app->get('/merchant/:id/customeradd/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        $request["customerID"] = $id2;
        
        $controller = new CustomerController();

        // Call controller function
        $response = $controller->getAddress($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });


        // POST  : INSERT CUSTOMER DETAILS 
        $app->post('/merchant/:id/customer', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
        $dataJSON = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];

        // echo json_encode($headers);
        $dataJSON =$headers['Datajson'];
            
        $request['apiKey'] = $apiKey;
         $request['dataJSON'] = $dataJSON ;
        $request['restaurantID'] = $id;
        
        $controller = new CustomerController();

        // Call controller function
        //echo json_encode($request) ;
        $response = $controller->postCustomer($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });

        // POST : UPDATE DETAILS OF A CUSTOMER
        $app->post('/merchant/:id/customer/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
        $dataJSON = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];

        // echo json_encode($headers);
        $dataJSON =$headers['Datajson'];
            
        $request['apiKey'] = $apiKey;
        $request['dataJSON'] = $dataJSON ;
        $request['restaurantID'] = $id;
        $request['customerID'] = $id2 ;
        
        $controller = new CustomerController();

        // Call controller function
        //echo json_encode($request) ;
        $response = $controller->putCustomer($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });


        // UPDATE PHONE DETAILS OF A CUSTOMER
        $app->post('/merchant/:id/customerphone/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
        $dataJSON = array();
                
        $headers = $app->request->headers->all();
        $phone = $headers["Phone"] ;

            // reading request params
        $apiKey = $headers['Key'];
		verifyHeaders(array('Key'));
		
        // echo json_encode($headers);
 
            
        $request['apiKey'] = $apiKey;
        $request['phone'] = $phone ;
        $request['restaurantID'] = $id;
        $request['customerID'] = $id2 ;
        
        $controller = new CustomerController();

        // Call controller function
        //echo json_encode($request) ;
        $response = $controller->postCustomerPh($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });

        
        // UPDATE PHONE DETAILS OF A CUSTOMER
        $app->post('/merchant/:id/customeremail/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
        $dataJSON = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
        $phone = $headers["Email"] ;

            // reading request params
        $apiKey = $headers['Key'];

        // echo json_encode($headers);
 
            
        $request['apiKey'] = $apiKey;
        $request['email'] = $phone ;
        $request['restaurantID'] = $id;
        $request['customerID'] = $id2 ;
        
        $controller = new CustomerController();

        // Call controller function
        //echo json_encode($request) ;
        $response = $controller->postCustomerEmail($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });

        // DELETE PHONE DETAILS OF A CUSTOMER
        $app->delete('/merchant/:id/customerphone/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
        $dataJSON = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
        // $phone = $headers["Email"] ;

            // reading request params
        $apiKey = $headers['Key'];

        // echo json_encode($headers);
 
            
        $request['apiKey'] = $apiKey;
        // $request['email'] = $phone ;
        $request['restaurantID'] = $id;
        $request['customerID'] = $id2 ;
        
        $controller = new CustomerController();

        // Call controller function
        //echo json_encode($request) ;
        $response = $controller->resetCustomerPh($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });

        // DELETE EMAIL OF A CUSTOMER
        $app->delete('/merchant/:id/customeremail/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
        $dataJSON = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
        // $phone = $headers["Email"] ;

            // reading request params
        $apiKey = $headers['Key'];

        // echo json_encode($headers);
 
            
        $request['apiKey'] = $apiKey;
        // $request['email'] = $phone ;
        $request['restaurantID'] = $id;
        $request['customerID'] = $id2 ;
        
        $controller = new CustomerController();

        // Call controller function
        //echo json_encode($request) ;
        $response = $controller->resetCustomerEmail($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
        
        // GET Request for all employees pertaining to a restaurant 
        $app->get('/merchant/:id/employees/', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->getEmp($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
        
        // GET Request pertaining to restaurant and employee id
        $app->get('/merchant/:id/employee/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        $request["empId"] = $id2;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->getEmpById($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });


        $app->post('/merchant/:id/employees/', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
        $dataJSON = $headers["Datajson"];
            
        $request['apiKey'] = $apiKey;
        $request['dataJSON'] = $dataJSON ;
        $request['restaurantID'] = $id;
        
        $controller = new ApiController();

        // Call controller function
        $response = $controller->postEmp($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });

        $app->delete('/merchant/:id/empdelete/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
        // $dataJSON = array();
                
        $headers = $app->request->headers->all();
        verifyHeaders(array('Key'));
		
		// $phone = $headers["Email"] ;

            // reading request params
        $apiKey = $headers['Key'];

        // echo json_encode($headers);
 
            
        $request['apiKey'] = $apiKey;
        // $request['email'] = $phone ;
        $request['restaurantID'] = $id;
        $request['empid'] = $id2 ;
        
        $controller = new ApiController();

        // Call controller function
        //echo json_encode($request) ;
        $response = $controller->resetEmp($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
//////////////////////////////ORDER APIs/////////////////////////////////////////
        

        $app->get('/merchant/:id/order/:id2/products', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        $request["orderID"] = $id2;
        
        $controller = new CustomerController();

        // Call controller function
        $response = $controller->getOrderProducts($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
		
		
		$app->get('/merchant/:id/order/:id2', function($id,$id2) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();
		verifyHeaders(array('Key'));
		
            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        $request["orderID"] = $id2;
        
        $controller = new CustomerController();

        // Call controller function
        $response = $controller->getOrder($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
/////////////////////////////////////////////////////////////////////////////////
        /* Should return CSV. Write a function that returns CSV instead of JSON
        $app->get('/merchant/:id/customersCSV', function($id) use ($app){
            // check for required params
            
        $request = array();
        $response = array();
        $apiKey = array();
                
        $headers = $app->request->headers->all();

            // reading request params
        $apiKey = $headers['Key'];
            
        $request['apiKey'] = $apiKey;
        $request['restaurantID'] = $id;
        
        $controller = new CustomerController();

        // Call controller function
        $response = $controller->getCustomersCSV($request); 
        
        // echo json response
        echoRespnse(200, $response);
        });
        */ 
//////////////////////////////////////////BASE CODE ENDS/////////////////////////////////////////////////
		
$app->run();

?>


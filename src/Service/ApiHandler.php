<?php 

namespace App\Service;

use Exception;

Class ApiHandler extends Exception
{
    private string $url;

    public function processApiRequest(string $url){
        
        $this->url = $url;

        $curl = curl_init($this->url);

        // Set cURL options
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it
        // Add more options as needed (e.g., CURLOPT_POST for POST requests, CURLOPT_POSTFIELDS for request body)

        // Execute cURL request
        try {

            $response = curl_exec($curl);

        } catch (Exception $e) {
            // Handle basic exceptions
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
        }
    
        // Close cURL session
        curl_close($curl);
    }


    public function jsonHttpResponse($httpCode, $data) : void
    {
        // remove any string that could create an invalid JSON 
        // such as PHP Notice, Warning, logs...
        ob_start();
        ob_clean();

        // this will clean up any previously added headers, to start clean
        header_remove(); 

        // Set the content type to JSON and charset 
        // (charset can be set to something else)
        // add any other header you may need, gzip, auth...
        header("Content-type: application/json; charset=utf-8");

        // Set your HTTP response code, refer to HTTP documentation
        http_response_code($httpCode);
        
        
        // encode your PHP Object or Array into a JSON string.
        // stdClass or array
        echo json_encode($data);

        // making sure nothing is added
        exit();
    }
    
    




    
}
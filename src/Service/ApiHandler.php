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
    
    




    
}
<?php

namespace App\Service;

use App\Entity\User;
use DateTimeImmutable;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthHandler
{

    private ?array $payload;
    private $token;

    const ALOGORITHM = 'HS512';
    const API_KEY = 'd53e9f7d-81d9-4f2c-8190-14bf78bba4fe';

    public function __construct()
    {
        $this->token = '';
        $this->payload = [];
    }

    function generateJWT(User $user): string 
    {
        global $secret_key;
        
        $date   = new DateTimeImmutable();
        $this->payload = [
            'iss' => 'http://localhost', // Issuer (your API domain)
            'exp' => time() + 3600, // Expiration time (1 hour from now)
            'uid' => $user->getId(), // User ID claim
            'username' => $user->getUsername(),
            'nbf' => $date->getTimestamp()
        ];
      
        $this->token = JWT::encode($this->payload, self::API_KEY, Self::ALOGORITHM);
        return $this->token;
    }


    public function decodeJWT($token)
    {
        try {

            return JWT::decode($token, Self::API_KEY, [Self::ALOGORITHM]);

        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            http_response_code(401); // Unauthorized
            header('Location: /security/login/user');
        }
    }

    public function setJwtTokenCookie(string $token): void {
        setcookie('jwt_token', $token, [
          'expires' => time() + 3600, // Adjust expiration time as needed
          'path' => '/',
          'httpOnly' => true,
          'secure' => true, // Recommended for HTTPS connections
        ]);
    }


    public function getToken()
    {
        $this->token = $_COOKIE['jwt_token'];
        return $this->token;
    }
}

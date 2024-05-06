<?php

namespace App\Controllers;

use App\Service\ApiHandler;
use App\Service\AuthHandler;
use App\Service\RouterService;
use App\Service\TaskManager;
use App\Service\UserManager;

class SecurityController extends AbstractController
{

    private UserManager $userManager;
    private AuthHandler $authHandler;
    private ApiHandler $apiHandler;
    
    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
        $this->authHandler = new AuthHandler();
        $this->apiHandler = new ApiHandler();
    }

    public function login(){

        $formErrors = [];
        if(isset($_POST['username']) && isset($_POST['password'])){
            $inputUsername = $_POST['username'];
            $inputPassword = md5($_POST['password']);
            $user = $this->userManager->getUserByUsername($inputUsername);
            if($user->getPassword() === $inputPassword){
                // api create token
                $token = $this->authHandler->generateJWT($user);
                $this->authHandler->setJwtTokenCookie($token);
                $this->apiHandler->setToken($token);

                // redirect to home
                header('Location: /home/index');
                
            } else 
                $formErrors[] = 'Check username and password';
        } else 
            $formErrors[] = 'Please fill username and password';

        $this->render('login.html.twig', [
            'formErrors' => $formErrors
        ]);
    }

    public function logout(){

        $token = '';
        $this->authHandler->setJwtTokenCookie($token);
        $this->apiHandler->setToken($token);
        // redirect to home
        header('Location: /security/login/user');


    }
    
}

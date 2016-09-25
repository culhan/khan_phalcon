<?php

use \Firebase\JWT\JWT;

/**
 * AuthController
 */
class AuthController extends Phalcon\Mvc\Controller{  

  /**
   * [authenticaste user based on JWT Auth]
   * @return [type] [description]
   */
  public function store(){
    
    $params = $this->request->getPost();    

    if( !empty($params) ){
      
      if($params['email'] == 'amalsholihan@gmail.com' && $params['password'] == '123456'){
        
        $user = (object) array(
          "iat" => time(),
          "nbf" => time()+$this->config->token->expiredTime // 5 minuts active
        );
        
        // user param
        $user->name = 'amalsholihan';
        $user->email = 'amalsholihan@gmail.com';
        
        $token = JWT::encode($user, $this->jwt->secret);
        
        $data = array('token'=> $token);
        
        $this->storage->save( $token, $user, $this->config->token->expiredTime);

        return ResponseHelper::printResult($data);

      }

    }
    else
    {

      return ResponseHelper::unauthorized('Email or Password not match');

    }
  }

}

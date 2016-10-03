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
      
      $user = Users::findFirstByName( $this->request->getPost('name') );

      if ($user) {

          if ($this->security->checkHash( $this->request->getPost('password'), $user->password )) {
              
              // user param                          
              $dataJwt['iat'] = time();
              $dataJwt['nbf'] = time()+$this->config->token->expiredTime;
              $dataJwt['name'] = $user->name;
              $dataJwt['email'] = $user->email;
              $dataJwt = (object) $dataJwt;

              $token = JWT::encode($dataJwt, $this->jwt->secret);
              
              $data = array('token'=> $token);

              $this->storage->save( $token, $dataJwt, $this->config->token->expiredTime);

              return ResponseHelper::printResult($data);

          }

      } else {
          // To protect against timing attacks. Regardless of whether a user exists or not, the script will take roughly the same amount as it will always be computing a hash.
          $this->security->hash(rand());
      }

    }

    return ResponseHelper::unauthorized('Email or Password not match');
  }

}

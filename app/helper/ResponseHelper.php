<?php

use Phalcon\Http\Response;

/**
 * Class Formatted Response
 */
class ResponseHelper{

  const ERROR_MAL_FORMATED_STRING = 306;
  const ERROR_GLOBAL = 300;
  const NO_ERROR = 0;

  // print result
  public static function printResult($data=null){

    header("Content-type: application/json");

    try{

      echo json_encode(array(
        "result"=>$data,
        "msg" => "Data Result",
        "error"=>self::NO_ERROR
      ));
    }catch(Exception $e){
      
      http_response_code(self::ERROR_MAL_FORMATED_STRING);

      echo json_encode(array(
        "result"=>$data,
        "msg" => "Malformed String",
        "error"=>self::ERROR_MAL_FORMATED_STRING
      ));

    }

  }

  // print error mensage
  public static function printError($msg='An unexpected error occurred, please try again.', $no = 500){

    header("Content-type: application/json");
    
    http_response_code($no);

    echo json_encode(
      array(
        "result" => null,
        "msg" => $msg,
        "error" => $no
      )
    );

  }

  // Unauthorized response
  public static function unauthorized($msg){
    
    header("Content-type: application/json");
    http_response_code(401);

    echo json_encode(
      array(
        "msg"=>$msg,
        "error"=>401
      )
    );
  }

}

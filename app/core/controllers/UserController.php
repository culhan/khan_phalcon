<?php

/**
 * UserController
 */
class UserController extends Phalcon\Mvc\Controller{  

  public function index(){
    
    $phql = "SELECT * FROM users ORDER BY name";

    $robots = $this->modelsManager->executeQuery($phql);

    $data = [];

    foreach ($robots as $robot) {
        $data[] = [
            "id"   => $robot->id,
            "name" => $robot->name,
        ];
    }

    echo json_encode($data);

  }

  /**
   * [authenticaste user based on JWT Auth]
   * @return [type] [description]
   */
  public function store(){
    
    $params = $this->request->getPost();    

    ResponseHelper::printError("a","aasds2e3");
  }

}

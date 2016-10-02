<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

/**
 * UserController
 */
class UserController extends Phalcon\Mvc\Controller{  

  public function index(){
    
    $users = Users::find();

    // Create a Model paginator, show 10 rows by page starting from $currentPage
    $paginator = new PaginatorModel(
        [
            "data"  => $users,
            "limit" => 10,
            "page"  => $this->request->getQuery("page", "int"),
        ]
    );

    // Get the paginated results
    $data = $paginator->getPaginate();

    return ResponseHelper::printResult($data);

  }

  /**
   * [authenticaste user based on JWT Auth]
   * @return [type] [description]
   */
  public function store(){

    $data = new Users();

    if( $data->save( $this->request->getPost(), $data->getFillable() ) === false)
    {
        // Send errors to the client
        $errors = [];

        foreach ($data->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        return ResponseHelper::printError( $errors, 409 );
        
    }

    return ResponseHelper::printResult( $data );
  }
}

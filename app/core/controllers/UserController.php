<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

/**
 * UserController
 */
class UserController extends Phalcon\Mvc\Controller{  

  /**
   * [return all data based on page]
   * @return [json] [msg]
   */
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
   * [return all data based on page]
   * @return [json] [msg]
   */
  public function show($id){
    
    $data = Users::findFirst($id);

    if( empty($data) )
    {
      return ResponseHelper::printError( 'No Data Found', 404 );      
    }

    return ResponseHelper::printResult($data);

  }

  /**
   * [store data]
   * @return [json] [msg]
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

  /**
   * [update data]
   * @return [json] [msg]
   */
  public function update($id){

    $data = Users::findFirst("id = $id");

    if( empty($data) )
    {
      return ResponseHelper::printError( 'No Data Found', 404 );      
    }

    if( $data->save( $this->request->getPut(), $data->getFillable() ) === false)
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

  /**
   * [destroy data]
   * @return [json] [msg]
   */
  public function destroy($id){

    $data = Users::findFirst("id = $id");
    
    if( empty($data) )
    {
      return ResponseHelper::printError( 'No Data Found', 404 );      
    }

    if( $data->delete() )
    {
      return ResponseHelper::printResult( $data );
    }

  }

  
}

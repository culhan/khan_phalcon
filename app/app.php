<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

/**
 * Not found handler
 */
$app->notFound(function () use ($app){      
  return ResponseHelper::printError('Not Found',404);
});

/**
 * version
 */
$app->get('/version', function() use ($app){
  $app->response->setJsonContent(array('version'=> '0.1'));
  return $app->response;
});

// $app->before(function() use ( $app ) {  
  
//   if( isset( $app->routerignore[$app->router->getRewriteUri()] ) ){
//     return true;
//   }   

//   if(!$app->request->getHeader('Authorization')){

//     ResponseHelper::unauthorized('Access is not authorized');
//     return false;
    
//   }
//   else
//   {

//       // improvise Bearer token scheme
//       $parts = explode(" ", $app->request->getHeader('Authorization'));
//       if(trim($parts[0]) === 'Bearer'){      

//         if($app->storage->get($parts[1]) === null)
//         {
//           ResponseHelper::unauthorized('Expired Authorization');
//           return false;          
//         }

//         $app->storage->save($parts[1], $app->storage->get($parts[1]), $app->config->token->expiredTime);

//       }else{

//         ResponseHelper::unauthorized('Invalid token format');
//         return false;

//       }
//   }

//   return true;
// });

// same prefix will not loaded, be carefull
$utilRoute = new RouteHelper;

$app = $utilRoute->loadRouteDynamic( 'AuthController', 'auth', 'post', '/', 'store', $app );
$app = $utilRoute->loadRoute( 'UserController', 'users', $app);
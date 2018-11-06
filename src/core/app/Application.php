<?php
namespace App;
use App\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Main functions
 */

/**
 * Prcess request
 */
class Application{

function process_request() {
  
  $request = Request::createFromGlobals();

  // PARSE REQUEST
  // Get request string as pattern: /controller/action/param1/param2
  $requesturiInfo = parse_url($request->server->get('REQUEST_URI'));
  $requestPaths = explode('/', $requesturiInfo['path']);
  // Get controller name
  if (empty($requestPaths[1])) {
    $controllerName = MVC_DEFAULT_CONTROLLER;
  } else {
    $controllerName = ucfirst($requestPaths[1]);
  }
  // Get action name
  if (empty($requestPaths[2])) {
    $actionName = MVC_DEFAULT_ACTION;
  } else {
    $actionName = $requestPaths[2];
  }
  // Get Path params
  if (count($requestPaths) >= 3) {
    $request->attributes->add(array_slice($requestPaths, 3));
    $pathParams = array_slice($requestPaths, 3);
  } else {
    $pathParams = [];
    $request->attributes = [];
  }

  // GET AND CALL ACTION

  // $controllerPath = SITE_PATH . '/controllers/' . $controllerName . '.controller.php';
  // // $controllerFunctionName = 'action_' . $controllerName . '_' . $actionName;
  // if (!file_exists($controllerPath)) {
  //   exit('No such controller "' . $controllerName . '".'); //ToDo: make proper low-level error handling
  // }
  // require_once $controllerPath;
  // if (!function_exists($controllerFunctionName)) {
  //   exit('No such action "' . $actionName . '".'); //ToDo: make proper low-level error handling
  // }
  $controllerName= "Controller\\".$controllerName."Controller";
  $u = new $controllerName($request);
  $responseData = $u->$actionName();
  // $responseData = call_user_func_array($controllerName."::".$actionName, $pathParams);
  //var_dump($responseData);
  $responseData->send();
  if( !isset($responseData['view']) || !isset($responseData['data']) ){
    if(!isset($responseData['redirect'])){
      exit('Action "' . $actionName . '" doesn\'t return proper response!.'); //ToDo: make proper low-level error handling
    }
    else{
      header('Location:'.$responseData['redirect']);
      exit();
    }
  }
  }
  //Application::load_view($responseData['view'], $responseData['data']);


/**
 * Makes scope for view data, shows base template frame
 * and adds globals view variables (for all actions).
 * 
 * @param string $view_name
 * @param array $data
 */
function load_view($view_name, $data) {
  /* ? Check $view_name ? */
  if (file_exists(SITE_PATH . '/views/' . $view_name . '.inc.php')) {
    // Add global view variabls to this scope
    $user = Service::get_authorized_user();
    // Make response
     ob_start();
    require SITE_PATH . '/views/_blocks/header.inc.php'; 
    require SITE_PATH . '/views/' . $view_name . '.inc.php';
    require SITE_PATH . '/views/_blocks/footer.inc.php';
    // var_dump(ob_get_contents());    
     return ob_get_clean();
  } else {
    // In more complex system better use exceptions.
    exit('No such template: ' . $view_name . '.inc.php');
  }
}

/**
 * Shows 403 page
 */
function error403() {
  // Site has to have this template!
  return [ 'view' => 'error_403', 'data' => []];;
}

/**
 * Shows 404 page for concrete thing that wasn't found.
 * 
 * @param string $entity
 */
function error404($entity = 'page') {
  // Site has to have this template!
  return [ 'view' => 'error_404', 'data' => ['entity' => $entity]];
}
}
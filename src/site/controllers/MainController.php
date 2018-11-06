<?php
namespace Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Application;
/**
* 
*/
class MainController{
  
  protected $request;
  public function __construct($request){
    $this->request=$request;
  }

  function render($view, $data){
    $app = new Application();
    return new Response(
      $app->load_view($view, $data),
      Response::HTTP_OK,
      array('content-type' => 'text/html')
    );  
  }
  function redirect($path){
    return new RedirectResponse($path);
  }
}

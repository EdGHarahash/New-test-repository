<?php
namespace Controller;
use Model\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends MainController{
/**
 * Show all users.
 * 
 * @return array Response data
 */
function list() {
  // Process request with using of models
  $user = new User();
  $profiles = $user->get_profile_list();
  $message = '';
  if(isset($_GET['status']) && $_GET['status'] === 'registered'){
    $message = 'You has been registered!';
  }
  // Make Response Data
  $view = 'user/list'; 
  $data = ['profiles' => $profiles,'message' => $message];
  return $this->render($view, $data);
}

/**
 * Show user profile.
 * 
 * @param int $id Id user to show.
 * @return array Response data.
 */
function show() {
  // Process request with using of models
  $user = new User();
  $id = (int) $this->request->attributes->get(0);
  $profile = $user->get_profile_data($id);
  // Make Response Data
  if ($profile !== NULL) {
    $data = [
        'profile' => $profile,
    ];
    return $this->render('user/show',$data);
  } else {
    return error404('user');
  }
}
}

<?php
namespace Controller;
use Symfony\Component\HttpFoundation\Response;

class CokRegController extends MainController{
/**
 * Show all users.
 * 
 * @return array Response data
 */
function auth() {
  $id = NULL;
  $data = [];
  $pwd = $this->request->get('password');
  $email = $this->request->get('email');  
  //setcookie('login', '0', 1, "/");
  if (($email=='admin@a.a') && ($pwd=='qwerty007')) {
    setcookie('login', $email, 0, "/", "");
    setcookie('token', password_hash($email, PASSWORD_DEFAULT));
    setcookie('token2', password_hash($email, PASSWORD_DEFAULT));

  }
  // Make Response Data
  if (empty($id)) {
    $view ='cokreg/auth';
    return $this->render($view, $data);
  } else {
    return ['redirect' => '/profile/show'];
  }
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

<?php
namespace Controller;
use DB\DbManagerImpl;
use Model\User;
use App\Service;


class SecurityController extends MainController{

  private $db;
  private $user;

  function __construct(){
    $this->db = new DbManagerImpl();
    $this->user = new User();
  }

  function auth() {
    $id = NULL;
    $data = [];
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
      $authorized = Service::authorize($_POST['email'], $_POST['password']);
      if ($authorized) {
        $id = Service::get_authorized_user()['id'];
      } else {
        $data['notices'] = [
            'Wrong email-password pair!',
        ];
      }
    }
    if (empty($id)) {
      $view ='security/auth';
      return $this->render($view, $data);
    } else {
      return $this->redirect('/profile/show');
    }
  }

  function logout() {
    Service::logout();
    return $this->redirect('/');
  }

  function reg(){
    $notices = [];
    $generalNotice = '';
  // Entity array
    $user = Service::fill_entity(Service::get_user_schema(), []);
  // The best way to check if form has been submited 
  // is check var connected to button
    if(isset($_POST['submitted'])){
    // Validation
      $user = Service::fill_entity(Service::get_user_schema(), $_POST['reg']);
    // It's better to fill entity array with all data - 
    // it should be connected to form for easier proccessing
      $user['password-repeat'] = $_POST['reg']['password-repeat'];
      $user['terms'] = isset($_POST['reg']['terms'])?true:false;
    // In real project that would be moved to some special validation module
      if(!strlen($user['name'])){
        $notices['name'] = 'You must fill this field.';
      }
      elseif(!filter_var($user['name'], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z0-9\-_\s]{2,16}$/']])){
        $notices['name'] = 'Name may contain only alphanumerical symbols, digits or dash or space.';
      }
      if(!strlen($user['email'])){
        $notices['email'] = 'You must fill this field.';
      }
      elseif(!filter_var($user['email'], FILTER_VALIDATE_EMAIL)){
        $notices['email'] = 'Email has incorrect format.';
      }
      if(!strlen($user['password'])){
        $notices['password'] = 'You must fill this field.';
      }
      elseif(strlen($user['password'])<2){
        $notices['password'] = 'Password\'s length must be greater than 2 symbols.';
      }
      if(!strlen($user['password-repeat'])){
        $notices['password-repeat'] = 'You must fill this field.';
      }
      elseif($user['password-repeat'] !== $user['password']){
        $notices['password-repeat'] = 'Password Repeat must be the same as Password.';
      }
      if(!strlen($user['birthday'])){
        $notices['birthday'] = 'You must fill this field.';
      }
      elseif(!filter_var($user['birthday'], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/']])){
      $notices['birthday'] = 'Birthday has incorrect format.';
      }
      else{
        try{
          new \DateTimeImmutable($user['birthday']);
        }
        catch(Exception $e){
          $notices['birthday'] = 'Birthday has incorrect format.';
        }
      }
      if(!strlen($user['avatar'])){
        $notices['avatar'] = 'You must fill this field.';
      }
      elseif(!filter_var($user['avatar'], FILTER_VALIDATE_URL)){
        $notices['avatar'] = 'Avatar has incorrect format.';
      }
      if(!strlen($user['terms'])){
        $notices['terms'] = 'You must check this field.';
      }
    // Validated?
      if(!count($notices)){
        if($this->user->find_user_by_email($user['email'])){
          $generalNotice = 'User with such email already exists.';
        }
      else{
        $this->user->add_user($user);//Here we also have to check for errors
        header('Location:/?status=registered');//Here it's better to use flash session variable
        exit();
      }
    }
  }
  $view = 'security/reg'; 
  $data = [
          'user' => $user,
          'notices' => $notices,
          'generalNotice' => $generalNotice,
          ];
  return $this->render($view, $data);
  }
}

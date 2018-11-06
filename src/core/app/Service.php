<?php
namespace App;
use Model\User;
/**
 * Core functions: helpers, view generating, authorization etc.
 */

/**
 * Shows variable info with nice view even on webpages.
 * 
 * @param mixed $var
 */
class Service{

 public static function dump($var){
  echo '<pre>';
  var_dump($var);
  echo '</pre>';
}



/**
 * Shows variable info with nice view even on webpages and exit.
 * 
 * @param mixed $var
 */
public static function dumpe($var = NULL){
  dump($var);
  exit();
}

/**
 * Creates password hash.
 * 
 * @param string $password
 * @return string
 */
public static function get_password_hash($password){
  return md5($password); // Better to use newer algorythms with salt!
}

/**
 * Tries to authorize user.
 * 
 * @param string $email
 * @param string $passsword
 * @return boolean
 */
public static function authorize($email, $passsword){
  // Site has to have this function!
  // Framework doesn't know from where user data comes.
  // So just it asks site model.
  $user = new User();
  $user = $user->check_user($email, $passsword);
  if($user !== NULL){
    $_SESSION['user'] = $user;
    return TRUE;
  }
  else{
    return FALSE;// In more complex system better to use exceptions.
  }
}

/**
 * Tries to log out user.
 */
public static function logout(){
  if(isset($_SESSION['user'])){
    unset($_SESSION['user']);
  }
}

/**
 * Gets current user.
 * 
 * @return mixed
 */
public static function get_authorized_user(){
  if(!empty($_SESSION['user'])){
    return $_SESSION['user'];
  }
  return NULL;
}

public static function get_user_schema(){
  return ['email', 'password', 'name', 'birthday', 'city', 'avatar'];
}

/**
 * Fill associated array with given $data by $schema.
 * 
 * @param array $schema
 * @param array $data
 * 
 * @return array
 */
public static function fill_entity($schema, $data){
  $result = [];
  foreach($schema as $name){
    $result[$name] = isset($data[$name])?$data[$name]:'';
  }
  return $result;
}
}
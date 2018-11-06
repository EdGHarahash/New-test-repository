<?php
namespace Model;
use DB\DbManagerImpl;
use App\Service;

/**
 * Model functions
 */

/**
* 
*/
class User
{

private $db;
public function __construct(){
  $this->db = new DbManagerImpl();
}
function get_profile_data($id){
  return $this->db->find('user', Service::get_user_schema(), $id);
}
function find_user_by_email($email){
  return $this->db->find_by('user', Service::get_user_schema(), ['email' => $email]);
}
function get_profile_list(){
  $profiles = $this->db->select_all('user', Service::get_user_schema());
  // Remove credentials
  foreach ($profiles as $id => $profile) {
    unset($profile['password']);
    $profiles[$id] = $profile;
  }
  return $profiles;
}
function check_user($email, $password){
  $user = $this->db->find_by(
          'user',
          Service::get_user_schema(),
          [
              'email' => $email,
              'password' => Service::get_password_hash($password)
              ]
          );
  return $user;
}
function add_user($user){
  $user['password'] = Service::get_password_hash($user['password']);
  $user['birthday'] = strtotime($user['birthday']);
  return $this->db->add('user', Service::get_user_schema(), $user);
}

}



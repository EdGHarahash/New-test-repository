<?php
namespace Controller;
use App\Application;
use App\Service;

class ProfileController extends MainController{

/**
 * Show current user's profile
 * 
 * @return array Response data
 */
function show() {
  // Process request with using of models
  $user = Service::get_authorized_user();
  // Make Response Data
  if ($user !== NULL) {
    $data = [
        'profile' => $user,
    ];
    $view = 'user/show';
    return $this->render($view, $data);
  } else {
    return Application::error403();
  }
}
}

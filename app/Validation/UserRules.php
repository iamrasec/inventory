<?php
namespace App\Validation;
use App\Models\UserModel;

class UserRules {

  public function validateUser(string $str, string $fields, array $data) {
    $model = new UserModel();
    // $user = $model->where('email', $data['email'])->first();
    $user = $model->where('username', $data['username'])->first();  // Use username instead of email

    if(!$user) {
      return false;
    }

    return password_verify($data['password'], $user['password']);
  }
}
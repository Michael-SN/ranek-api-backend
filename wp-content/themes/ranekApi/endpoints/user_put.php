<?php

function api_user_put($request)
{
  $user = wp_get_current_user();
  $user_id = $user->ID;

  if ($user_id > 0) {
    $email = sanitize_email($request['email']);
    $name = sanitize_text_field($request['name']);
    $password = $request['password'];
    $cep = sanitize_text_field($request['cep']);
    $street = sanitize_text_field($request['street']);
    $number = sanitize_text_field($request['number']);
    $district = sanitize_text_field($request['district']);
    $city = sanitize_text_field($request['city']);
    $state = sanitize_text_field($request['state']);


    $email_exisits = email_exists($email);

    if (!$email_exisits || $email_exisits === $user_id) {

      $response = array(
        'ID' => $user_id,
        'user_pass' => $password,
        'user_email' => $email,
        'display_name' => $name,
        'first_name' => $name,
      );

      wp_update_user($response);

      update_user_meta($user_id, 'cep', $cep);
      update_user_meta($user_id, 'street', $street);
      update_user_meta($user_id, 'district', $district);
      update_user_meta($user_id, 'number', $number);
      update_user_meta($user_id, 'city', $city);
      update_user_meta($user_id, 'state', $state);
      // 
    } else {
      $response = new WP_Error('email', 'Email já cadastrado', array('status' => 403));
    }
  } else {

    $response = new WP_Error('permission denied', 'Usuário não possui permissão', array('status' => 401));
  }






  // // Checando apenas pelo eamail se o usar existe ou não

  return rest_ensure_response($response);
}


function register_api_user_put()
{
  register_rest_route('api', '/user', array(
    array(
      'methods' => WP_REST_Server::EDITABLE,
      'callback' => 'api_user_put'
    )
  ));
};


add_action('rest_api_init', 'register_api_user_put');

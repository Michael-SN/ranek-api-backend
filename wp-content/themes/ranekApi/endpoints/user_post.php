<?php

function api_user_post($request)
{
  $email = sanitize_email($request['email']);
  $name = sanitize_text_field($request['name']);
  $password = $request['password'];
  $cep = sanitize_text_field($request['cep']);
  $street = sanitize_text_field($request['street']);
  $district = sanitize_text_field($request['district']);
  $number = sanitize_text_field($request['number']);
  $city = sanitize_text_field($request['city']);
  $state = sanitize_text_field($request['state']);


  $user_exists = username_exists($email);
  $email_exisits = email_exists($email);

  // Checando apenas pelo eamail se o usar existe ou não
  if (!$user_exists) {
    $user_id = wp_create_user(
      $email,
      $password,
      $email
    );

    $response = array(
      'ID' => $user_id,
      'display_name' => $name,
      'first_name' => $name,
      'role' => 'subscriber',
    );

    wp_update_user($response);

    update_user_meta($user_id, 'cep', $cep);
    update_user_meta($user_id, 'street', $street);
    update_user_meta($user_id, 'district', $district);
    update_user_meta($user_id, 'number', $number);
    update_user_meta($user_id, 'city', $city);
    update_user_meta($user_id, 'state', $state);
  } else {
    $response = new WP_Error('eamil', 'Email já cadastrado', array('status' => 403));
  }

  return rest_ensure_response($response);
}


function register_api_user_post()
{
  register_rest_route('api', '/user', array(
    array(
      'methods' => WP_REST_Server::CREATABLE,
      'callback' => 'api_user_post'
    )
  ));
};


add_action('rest_api_init', 'register_api_user_post');

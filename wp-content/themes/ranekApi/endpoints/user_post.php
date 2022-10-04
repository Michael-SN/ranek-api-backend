<?php

function api_user_post($request)
{
  $user_email = $request['email'];

  $response = array(
    'name' => 'Michael',
    // 'email' => 'michael.dev.nascimento@gmail.com'
    'email' => $user_email
  );

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

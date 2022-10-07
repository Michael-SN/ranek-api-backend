<?php

$template_directory = get_template_directory();

require_once($template_directory . "/custom-post-type/product.php");
require_once($template_directory . "/custom-post-type/transaction.php");

require_once($template_directory . "/endpoints/user_post.php");
require_once($template_directory . "/endpoints/user_get.php");
require_once($template_directory . "/endpoints/user_put.php");


function expire_token()
{
  return time() * 86400;
}

add_action('jwt_auth_expire', 'expire_token');

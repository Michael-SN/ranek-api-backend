<?php

$template_directory = get_template_directory();

require_once($template_directory . "/custom-post-type/product.php");
require_once($template_directory . "/custom-post-type/transaction.php");
// Usuario
require_once($template_directory . "/endpoints/user_post.php");
require_once($template_directory . "/endpoints/user_get.php");
require_once($template_directory . "/endpoints/user_put.php");
// Produto
require_once($template_directory . "/endpoints/product_post.php");
require_once($template_directory . "/endpoints/product_get.php");
require_once($template_directory . "/endpoints/product_delete.php");


require_once($template_directory . "/endpoints/transaction_post.php");
require_once($template_directory . "/endpoints/transaction_get.php");


function get_product_id_by_slug($slug)
{
  $query = new WP_Query(array(
    'name' => $slug,
    'post_type' => 'product',
    'numberposts' => 1,
    'fields' => 'ids',
  ));

  $posts = $query->get_posts();

  return array_shift($posts);
}

add_action('rest_pre_serve_request', function () {
  header('Access-Control-Expose-Headers: X-Total-Count');
});

function expire_token()
{
  return time() * 86400; // 60 * 60 * 24 = 86400
}

add_action('jwt_auth_expire', 'expire_token');

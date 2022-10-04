<?php

function register_cpt_transaction()
{
  register_post_type('transaction', array(
    'label' => 'Transaction',
    'description' => 'Transaction',
    'public' => true,
    'show_ui' => true,
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'transaction', 'with_front' => true),
    'query_var' => true,
    'supports' => array('custom-fields', 'author', 'title'),
    'publicly_queryable' => true
  ));
}

add_action('init', 'register_cpt_transaction');

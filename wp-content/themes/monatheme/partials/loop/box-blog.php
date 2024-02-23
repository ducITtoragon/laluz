<?php

global $post;
$post_object = $post;


$post_title         =   get_the_title($post_object);
$post_thumbnail     =   get_the_post_thumbnail($post_object, 'full');
$post_permalink     =   get_the_permalink($post_object);
$post_excerpt       =   get_the_excerpt($post_object);
?>

<a href="<?php echo get_the_permalink($post_object->ID); ?>" class="blog-img">
    <?php echo get_the_post_thumbnail($post_object->ID, 'full'); ?>
</a>
<div class="blog-txt">
    <h3 class="tt-bl">
        <a class="tt-bl-link" href="<?php echo get_the_permalink($post_object->ID); ?>">
            <?php echo $post_object->post_title; ?>
        </a>
    </h3>
    <p class="desc">
        <?php echo get_the_excerpt($post_object); ?>
    </p>
</div>
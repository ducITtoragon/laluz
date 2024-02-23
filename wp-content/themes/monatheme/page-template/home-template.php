<?php

/**
 * Template name: Trang chủ
 * @author : MONA.Media / Website
 */
get_header();
while (have_posts()) :
    the_post();
?>

    <main class="main spc-hd spc-hd-2">
<?php
    $title_seo_mona_mkt = get_field('title_seo_mona_mkt');
    if($title_seo_mona_mkt){
?>
<h1 class="mona-hidden-tt"><?php echo $title_seo_mona_mkt; ?></h1>
<?php
    }
?>
        <?php $mona_sc_1_group = get_field('mona_sc_1_group');
        if (!empty($mona_sc_1_group) || isset($mona_sc_1_group)) {
            $banner = $mona_sc_1_group['banner'];
            $tieu_de = $mona_sc_1_group['tieu_de'];
            $select = $mona_sc_1_group['select'];
            $tax = $mona_sc_1_group['tax'];
            $tax_2 = $mona_sc_1_group['tax_2'];
            $relationship = $mona_sc_1_group['relationship'];
        }
        ?>
        <section class="banner-section">
            <div class="bg">
                <?php echo wp_get_attachment_image($banner, 'full'); ?>
            </div>
        </section>

        <?php if ($select == 2) {
            $args = [
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => 10,
                'tax_query' => [
                    'relation' => 'AND',
                ],
            ];
            $args['orderby'] = 'post__in';
            $args['post__in'] = $relationship;
        } elseif ($select == 1) {
            $parent_cat_gioi_tinh = get_term_by('slug', $tax->slug, 'category_thuong_hieu');
            if ($parent_cat_gioi_tinh) {
                $args = array(
                    'post_type'      => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => 10,
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'category_thuong_hieu',
                            'field'    => 'term_id',
                            'terms'    => $parent_cat_gioi_tinh->term_id,
                        ),
                    ),
                );
            }
        } else {
            $parent_cat_nuoc_hoa = get_term_by('slug', $tax_2->slug, 'category_nuoc_hoa');
            if ($parent_cat_nuoc_hoa) {
                $args = array(
                    'post_type'      => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => 10,
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'category_nuoc_hoa',
                            'field'    => 'term_id',
                            'terms'    => $parent_cat_nuoc_hoa->term_id,
                        ),
                    ),
                );
            }
        }

        $products = new WP_Query($args);

        if ($products->have_posts()) { ?>

            <section class="prods-home">
                <h2 class="tt-sec"><?php echo $tieu_de; ?></h2>
                <div class="wr-prods-home">
                    <div class="swiper swiper-prod-home unisex">
                        <div class="swiper-wrapper">

                            <?php while ($products->have_posts()) {
                                $products->the_post(); ?>

                                <div class="swiper-slide">
                                    <div class="prod-it">
                                        <?php get_template_part('partials/product/item_home');  ?>
                                    </div>
                                </div>

                            <?php }
                            wp_reset_postdata(); ?>

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </section>

        <?php } ?>


        <?php $mona_sc_2_group = get_field('mona_sc_2_group');
        if (!empty($mona_sc_2_group) || isset($mona_sc_2_group)) {
            $banner_2 = $mona_sc_2_group['banner'];
            $tieu_de_2 = $mona_sc_2_group['tieu_de'];
            $select_2 = $mona_sc_2_group['select'];
            $tax = $mona_sc_2_group['tax'];
            $tax_2 = $mona_sc_2_group['tax_2'];
            $relationship_2 = $mona_sc_2_group['relationship'];
        }
        ?>

        <section class="banner-section">
            <div class="bg">
                <?php echo wp_get_attachment_image($banner_2, 'full'); ?>
            </div>
        </section>


        <?php if ($select_2 == 2) {
            $args = [
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => 10,
                'tax_query' => [
                    'relation' => 'AND',
                ],
            ];
            $args['orderby'] = 'post__in';
            $args['post__in'] = $relationship_2;
        } elseif ($select_2 == 1) {
            $parent_cat_gioi_tinh = get_term_by('slug', $tax->slug, 'category_thuong_hieu');
            if ($parent_cat_gioi_tinh) {
                $args = array(
                    'post_type'      => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => 10,
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'category_thuong_hieu',
                            'field'    => 'term_id',
                            'terms'    => $parent_cat_gioi_tinh->term_id,
                        ),
                    ),
                );
            }
        } else {
            $parent_cat_nuoc_hoa = get_term_by('slug', $tax_2->slug, 'category_nuoc_hoa');
            if ($parent_cat_nuoc_hoa) {
                $args = array(
                    'post_type'      => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => 10,
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'category_nuoc_hoa',
                            'field'    => 'term_id',
                            'terms'    => $parent_cat_nuoc_hoa->term_id,
                        ),
                    ),
                );
            }
        }

        $products = new WP_Query($args);

        if ($products->have_posts()) { ?>

            <section class="prods-home">
                <h2 class="tt-sec"><?php echo $tieu_de_2 ?></h2>
                <div class="wr-prods-home">
                    <div class="swiper swiper-prod-home male">
                        <div class="swiper-wrapper">

                            <?php while ($products->have_posts()) {
                                $products->the_post(); ?>

                                <div class="swiper-slide">
                                    <div class="prod-it">
                                        <?php get_template_part('partials/product/item_home');  ?>
                                    </div>
                                </div>

                            <?php }
                            wp_reset_postdata(); ?>

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </section>

        <?php } ?>

        <?php $mona_sc_3_group = get_field('mona_sc_3_group');
        if (!empty($mona_sc_3_group) || isset($mona_sc_3_group)) {
            $banner_3 = $mona_sc_3_group['banner'];
            $tieu_de_3 = $mona_sc_3_group['tieu_de'];
            $select_3 = $mona_sc_3_group['select'];
            $tax_3 = $mona_sc_3_group['tax'];
            $tax_3_3 = $mona_sc_3_group['tax_2'];
            $relationship_3 = $mona_sc_3_group['relationship'];
        }
        ?>

        <section class="banner-section">
            <div class="bg"><?php echo wp_get_attachment_image($banner_3, 'full'); ?>
            </div>
        </section>

        <?php if ($select_3 == 2) {
            $args = [
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => 10,
                'tax_query' => [
                    'relation' => 'AND',
                ],
            ];
            $args['orderby'] = 'post__in';
            $args['post__in'] = $relationship_3;
        } elseif ($select_2 == 1) {
            $parent_cat_gioi_tinh = get_term_by('slug', $tax_3->slug, 'category_thuong_hieu');
            if ($parent_cat_gioi_tinh) {
                $args = array(
                    'post_type'      => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => 10,
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'category_thuong_hieu',
                            'field'    => 'term_id',
                            'terms'    => $parent_cat_gioi_tinh->term_id,
                        ),
                    ),
                );
            }
        } else {
            $parent_cat_nuoc_hoa = get_term_by('slug', $tax_3_3->slug, 'category_nuoc_hoa');
            if ($parent_cat_nuoc_hoa) {
                $args = array(
                    'post_type'      => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => 10,
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'category_nuoc_hoa',
                            'field'    => 'term_id',
                            'terms'    => $parent_cat_nuoc_hoa->term_id,
                        ),
                    ),
                );
            }
        }

        $products = new WP_Query($args);

        if ($products->have_posts()) { ?>

            <section class="prods-home">
                <h2 class="tt-sec"><?php echo $tieu_de_3 ?></h2>
                <div class="wr-prods-home">
                    <div class="swiper swiper-prod-home female">
                        <div class="swiper-wrapper">


                            <?php while ($products->have_posts()) {
                                $products->the_post(); ?>

                                <div class="swiper-slide">
                                    <div class="prod-it">
                                        <?php get_template_part('partials/product/item_home');  ?>
                                    </div>
                                </div>

                            <?php }
                            wp_reset_postdata(); ?>

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </section>

        <?php } ?>


        <?php $mona_sc_4_group = get_field('mona_sc_4_group');
        if (!empty($mona_sc_4_group) || isset($mona_sc_4_group)) {
            $tieu_de = $mona_sc_4_group['tieu_de'];
            $link = $mona_sc_4_group['link'];
            $tieu_de_2 = $mona_sc_4_group['tieu_de_2'];
            $rp = $mona_sc_4_group['rp'];
        }
        ?>
        <section class="signa-us">
            <div class="container">
                <div class="tt-sec"><?php echo $tieu_de; ?></div>
                <?php if (!empty($link)) : ?>
                    <div class="wr-vd-signa">
                        <iframe allowfullscreen="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" frameborder="0" title="YouTube video player" src="<?php echo esc_url($link); ?>" height="" width=""></iframe>
                    </div>
                <?php endif; ?>
                <div class="why-choose">
                    <div class="tt-sec"><?php echo $tieu_de_2; ?></div>

                    <?php if (!empty($rp) || isset($rp)) : ?>

                        <div class="wr-reasons">
                            <ul class="reason-list row">

                                <?php foreach ($rp as $key => $item) : ?>

                                    <li class="reason-it col col-md-3"><?php echo wp_get_attachment_image($item['icon'], 'full'); ?>
                                        <div class="tt-reason"><?php echo $item['tieu_de']; ?></div>
                                        <p class="desc"><?php echo $item['noi_dung']; ?>
                                        </p>
                                    </li>

                                <?php endforeach; ?>

                            </ul>
                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </section>

        <?php
        $mona_product = get_field('mona_product');

        $count = 10;
        $arg_posts = [
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $count,
            'tax_query' => [
                'relation' => 'AND',
            ],
        ];

        if (!empty($mona_product)) {
            $arg_posts['orderby'] = 'post__in';
            $arg_posts['post__in'] = $mona_product;
        } else {
            $arg_posts['order'] = 'desc';
        }
        $loop_posts = new WP_Query($arg_posts);
        if ($loop_posts->have_posts()) :
            $count = 0;
        ?>

            <section class="studio signa-us">
                <div class="tt-sec center"><?php _e('STUDIO', 'monamedia'); ?></div>
                <div class="wr-studio" data-aos="fade-up" style="padding-bottom: 0;">
                    <div class="swiper swiper-studio">
                        <div class="swiper-wrapper">

                            <?php
                            while ($loop_posts->have_posts()) :
                                $loop_posts->the_post();
                                global $post;
                                $mona_anh_studio = get_field('mona_anh_studio', $post->ID);
                            ?>

                                <div class="swiper-slide">
                                    <a href="<?php echo get_the_permalink($post->ID); ?>" class="img">
                                        <?php
                                        if (!empty($mona_anh_studio)) {
                                            echo wp_get_attachment_image($mona_anh_studio, 'full');
                                        } else {
                                            echo get_the_post_thumbnail($post->ID, 'full');
                                        }
                                        ?>

                                        <span class="content"><?php the_title(); ?> </span>
                                    </a>
                                </div>

                            <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>

                        </div>
                    </div>
                </div>
            </section>

        <?php endif; ?>


    </main>

<?php
endwhile;
get_footer();

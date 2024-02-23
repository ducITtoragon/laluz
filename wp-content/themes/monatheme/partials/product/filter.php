<?php

$parent_cat_gioi_tinh = get_term_by('slug', 'gioi-tinh', 'product_cat');
$parent_cat_mua = get_term_by('slug', 'mua', 'product_cat');
$parent_cat_nhom_huong = get_term_by('slug', 'nhom-huong', 'product_cat');
$parent_cat_nong_do = get_term_by('slug', 'nong-do', 'product_cat');
$parent_cat_dung_tich = get_term_by('slug', 'dung-tich', 'product_cat');
$parent_cat_theo_gia = get_term_by('slug', 'theo-gia', 'product_cat');

$product_cat = get_terms([
    'taxonomy' => 'product_cat',
    'parent'    => 0,
    'hide_empty' => false,
]);

$current_cat = get_queried_object();

?>

<div class="form-filter">

    <!-- giới tính  -->
    <?php $parent_categories = get_terms(array(
        'taxonomy' => 'category_gioi_tinh',
        'parent' => 0,
        'hide_empty' => false,
    ));

    if (!empty($parent_categories) || isset($parent_categories)) { ?>
    <div class="form-filter-inner">
        <div class="tt-filter">
            <?php _e('Giới tính', 'monamedia'); ?>
            <span class="ic-angle">
                <i class="fa-solid fa-angle-down"></i>
            </span>
        </div>

        <div class="filter-list row">

            <?php foreach ($parent_categories as $child_cat) { ?>

            <div class="filter-item col-6">

                <label for="<?php echo $child_cat->slug; ?>">

                    <input type="checkbox" name="taxonomy[<?php echo $child_cat->taxonomy ?>][]"
                        id="<?php echo $child_cat->slug; ?>" class="input-check monaFilterJS"
                        value="<?php echo $child_cat->slug ?>" hidden>

                    <div class="box-check"></div><span class="txt"><?php echo $child_cat->name; ?></span>
                </label>
            </div>

            <?php } ?>

        </div>

    </div>

    <?php } ?>

    <!-- mùa  -->
    <?php if (!empty($parent_cat_mua) || isset($parent_cat_mua)) {
        $child_cats_mua = get_terms([
            'taxonomy'   => 'product_cat',
            'parent'     => $parent_cat_mua->term_id,
            'hide_empty' => false,
        ]);

        if (!empty($child_cats_mua) || isset($child_cats_mua)) { ?>
    <!-- <div class="form-filter-inner">
        <div class="tt-filter">
            <?php echo $parent_cat_mua->name; ?>
            <span class="ic-angle"> <i class="fa-solid fa-angle-down"></i></span>
        </div>
        <div class="filter-list row">

            <?php foreach ($child_cats_mua as $child_cat) { ?>

            <div class="filter-item col-6">
                <label for="<?php echo $child_cat->slug; ?>">

                    <input type="checkbox" name="taxonomy_mua[<?php echo $child_cat->taxonomy ?>][]"
                        id="<?php echo $child_cat->slug; ?>" class="input-check monaFilterJS"
                        value="<?php echo $child_cat->slug ?>" hidden>

                    <div class="box-check"></div><span class="txt"><?php echo $child_cat->name; ?></span>
                </label>
            </div>

            <?php } ?>

        </div>
    </div> -->

    <?php }
    } ?>

    <!-- nhóm hương  -->
    <?php $parent_categories = get_terms(array(
        'taxonomy' => 'category_nhom_huong',
        'parent' => 0,
        'hide_empty' => false,
    ));

    if (!empty($parent_categories) || isset($parent_categories)) { ?>
    <!-- <div class="form-filter-inner">
        <div class="tt-filter">
            <?php _e('Nhóm hương', 'monamedia'); ?>
            <span class="ic-angle">
                <i class="fa-solid fa-angle-down"></i>
            </span>
        </div>

        <div class="filter-list row">

            <?php foreach ($parent_categories as $child_cat) { ?>

            <div class="filter-item col-6">

                <label for="<?php echo $child_cat->slug; ?>">

                    <input type="checkbox" name="taxonomy[<?php echo $child_cat->taxonomy ?>][]"
                        id="<?php echo $child_cat->slug; ?>" class="input-check monaFilterJS"
                        value="<?php echo $child_cat->slug ?>" hidden>

                    <div class="box-check"></div><span class="txt"><?php echo $child_cat->name; ?></span>
                </label>
            </div>

            <?php } ?>

        </div>

    </div> -->

    <?php } ?>

    <!-- nồng độ  -->
    <?php $parent_categories = get_terms(array(
        'taxonomy' => 'category_nong_do',
        'parent' => 0,
        'hide_empty' => false,
    ));

    if (!empty($parent_categories) || isset($parent_categories)) { ?>
    <div class="form-filter-inner">
        <div class="tt-filter">
            <?php _e('Nồng độ', 'monamedia'); ?>
            <span class="ic-angle">
                <i class="fa-solid fa-angle-down"></i>
            </span>
        </div>

        <div class="filter-list row">

            <?php foreach ($parent_categories as $child_cat) { ?>

            <div class="filter-item col-6">

                <label for="<?php echo $child_cat->slug; ?>">

                    <input type="checkbox" name="taxonomy[<?php echo $child_cat->taxonomy ?>][]"
                        id="<?php echo $child_cat->slug; ?>" class="input-check monaFilterJS"
                        value="<?php echo $child_cat->slug ?>" hidden>

                    <div class="box-check"></div><span class="txt"><?php echo $child_cat->name; ?></span>
                </label>
            </div>

            <?php } ?>

        </div>

    </div>

    <?php } ?>

    <!-- dung tích  -->
    <?php $parent_categories = get_terms(array(
        'taxonomy' => 'category_dung_tich',
        'parent' => 0,
        'hide_empty' => false,
    ));

    if (!empty($parent_categories) || isset($parent_categories)) { ?>
    <div class="form-filter-inner">
        <div class="tt-filter">
            <?php _e('Dung tích', 'monamedia'); ?>
            <span class="ic-angle">
                <i class="fa-solid fa-angle-down"></i>
            </span>
        </div>

        <div class="filter-list row">

            <?php foreach ($parent_categories as $child_cat) { ?>

            <div class="filter-item col-6">

                <label for="<?php echo $child_cat->slug; ?>">

                    <input type="checkbox" name="taxonomy[<?php echo $child_cat->taxonomy ?>][]"
                        id="<?php echo $child_cat->slug; ?>" class="input-check monaFilterJS"
                        value="<?php echo $child_cat->slug ?>" hidden>

                    <div class="box-check"></div><span class="txt"><?php echo $child_cat->name; ?></span>
                </label>
            </div>

            <?php } ?>

        </div>

    </div>

    <?php } ?>

    <!-- theo giá  -->
    <?php if (!empty($parent_cat_theo_gia) || isset($parent_cat_theo_gia)) {
        $child_cats_theo_gia = get_terms([
            'taxonomy'   => 'product_cat',
            'oder'   => 'asc',
            'parent'     => $parent_cat_theo_gia->term_id,
            'hide_empty' => false,
        ]);

        if (!empty($child_cats_theo_gia) || isset($child_cats_theo_gia)) { ?>

    <div class="form-filter-inner">
        <div class="tt-filter">
            <?php echo $parent_cat_theo_gia->name; ?><span class="ic-angle"> <i
                    class="fa-solid fa-angle-down"></i></span>
        </div>
        <div class="filter-list row">

            <?php foreach ($child_cats_theo_gia as $child_cat) { ?>

            <div class="filter-item col">
                <label for="<?php echo $child_cat->slug; ?>">

                    <input type="checkbox" name="taxonomy_theo_gia[<?php echo $child_cat->taxonomy ?>][]"
                        id="<?php echo $child_cat->slug; ?>" class="input-check monaFilterJS"
                        value="<?php echo $child_cat->slug ?>" hidden>

                    <div class="box-check"></div><span class="txt"><?php echo $child_cat->name; ?></span>
                </label>
            </div>

            <?php } ?>

        </div>
    </div>

    <?php }
    } ?>

</div>
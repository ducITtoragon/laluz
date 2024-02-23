<?php
class Mona_Walker_Nav_Menu extends Walker_Nav_Menu
{

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class='menu-list'>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $object = $item->object;
        $type = $item->type;
        $title = $item->title;
        $description = $item->description;
        $permalink = $item->url;

        $mona_sc_1_group = get_field('mona_sc_1_group', $item);
        if (!empty($mona_sc_1_group) || isset($mona_sc_1_group)) {
            $select = $mona_sc_1_group['select'];
        }

        $output .= "<li class='menu-item parent fz16 fw6 dropdown" .  implode(" ", $item->classes) . "'>";

        //Add SPAN if no Permalink
        if ($permalink && $permalink != '#') {
            $output .= '<a class="menu-link txt-mn" href="' . $permalink . '">';
        } else {
            $output .= '<a class="menu-link" href="javascript:;">';
        }

        $output .= $title;

        if ($select == '2') {
            $output .= '<span class="ic-angle"> <i class="fa-solid fa-caret-down"></i></span>';
        }
        if ($select == '3') {
            $output .= '<span class="ic-angle"> <i class="fa-solid fa-caret-down"></i></span>';
        }

        if ($permalink && $permalink != '#') {
            $output .= '</a>';
        } else {
            $output .= '</a>';
        }

        if ($select == '2') {
            $output .= self::MenuMegaContent($item);
        }

        if ($select == '3') {
            $output .= self::MenuMegaContent_2($item);
        }
    }

    function MenuMegaContent($item)
    {
        ob_start();
        $mona_sc_1_group = get_field('mona_sc_1_group', $item);
        if (isset($mona_sc_1_group) || !empty($mona_sc_1_group)) {
            $tieu_de_select_2 = $mona_sc_1_group['tieu_de_select_2'];
            $tax_2 = $mona_sc_1_group['tax_2'];
        }
        ?>
        <div class="menu-mega">
            <div class="menu-mega-left">
                <div class="menu-mega-item">
                    <div class="tt-mg"><?php echo $tieu_de_select_2; ?></div>
                    <?php
                    if ($tax_2) {
                    ?>
                    <ul class="menu-list">
                        <?php
                        foreach ($tax_2 as $key => $item) {
                            $link_term = get_term_link($item);
                        ?>
                        <li class="menu-item">
                            <a class="menu-link" href="<?php echo esc_url($link_term); ?>">
                                <?php echo $item->name; ?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </div>
            </div>
            <?php $parent_categories = get_terms(array(
                'taxonomy' => 'category_thuong_hieu',
                'parent' => 0,
                'hide_empty' => false,
            ));
            if ($parent_categories) : ?>

                <div class="menu-mega-right">
                    <div class="tt-mg"><?php _e('Thương hiệu nước hoa', 'monamedia'); ?></div>
                    <div class="word-nav">
                        <ul class="word-list">
                            <li class="word-it" data-tab="all">
                                <label for="w-all">
                                    <input type="radio" id="w-all" value="" checked>
                                    <div class="box"> <span class="txt">All</span></div>
                                </label>
                            </li>
                            <?php $alphabet = range('A', 'Z');
                            foreach ($alphabet as $letter) { ?>
                                <li class="word-it" data-tab="<?php echo $letter; ?>">
                                    <label for="w-<?php echo $letter; ?>">
                                        <input type="radio" id="w-<?php echo $letter; ?>" value="<?php echo $letter; ?>">
                                        <div class="box is-loading-group"> <span class="txt"><?php echo $letter; ?></span></div>
                                    </label>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <!-- All  -->
                    <ul class="brand-list row" id="tab-all">
                        <?php
                        $parent_cat_thuong_hieu = get_terms(array(
                            'taxonomy' => 'category_thuong_hieu',
                            'parent' => 0,
                            'hide_empty' => false,
                        ));

                        $args = array(
                            'taxonomy'   => 'category_thuong_hieu',
                            'hide_empty' => false,
                            //'parent'     => $parent_cat_thuong_hieu->term_id,
                        );

                        $child_cats_thuong_hieu = get_terms($args);
                        ?>
                        <?php if (!empty($child_cats_thuong_hieu)) { ?>
                            <?php foreach ($child_cats_thuong_hieu as $child_cat) {
                                $category_link_parent_category = get_term_link($child_cat); ?>
                                <li class="brand-it col-4"> <a class="brand-link" href="<?php echo esc_url($category_link_parent_category); ?>"><?php echo $child_cat->name; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>

                    <!-- Alphabet  -->
                    <?php $alphabet = range('A', 'Z');
                    if (isset($alphabet) || !empty($alphabet)) {
                        foreach ($alphabet as $letter) { ?>
                            <ul class="brand-list row" id="tab-<?php echo $letter; ?>">
                                <?php
                                $parent_cat_thuong_hieu = get_terms(array(
                                    'taxonomy' => 'category_thuong_hieu',
                                    'parent' => 0,
                                    'hide_empty' => false,
                                ));

                                $args = array(
                                    'taxonomy'   => 'category_thuong_hieu',
                                    'hide_empty' => false,
                                    //'parent'     => $parent_cat_thuong_hieu->term_id,
                                );

                                $child_cats_thuong_hieu = get_terms($args);
                                $filtered_cats = array_filter($child_cats_thuong_hieu, function ($cat) use ($letter) {
                                    return empty($letter) || strpos(strtolower($cat->name), strtolower($letter[0])) === 0;
                                });

                                ?>
                                <?php if (!empty($filtered_cats)) { ?>
                                    <?php foreach ($filtered_cats as $child_cat) {
                                        $category_link_parent_category = get_term_link($child_cat); ?>
                                        <li class="brand-it col-4"> <a class="brand-link" href="<?php echo esc_url($category_link_parent_category); ?>"><?php echo $child_cat->name; ?></a></li>
                                    <?php } ?>
                                <?php } else { ?>
                                    <span class="brand-item">
                                        <label class="brand-link txt-brand" style="text-align: center;">
                                            <?php echo "Thương hiệu đang được cập nhật" ?>
                                        </label>
                                    </span>
                                <?php } ?>
                            </ul>
                    <?php }
                    } ?>

                </div>


            <?php endif; ?>

        </div>
        <?php
        return ob_get_clean();
    }

    function MenuMegaContent_2($item)
    {
        ob_start();

    ?>
        <div class="menu-mega">

            <!-- nước hoa  -->
            <?php $parent_categories = get_terms(array(
                'taxonomy' => 'category_nuoc_hoa',
                'parent' => 0,
                'hide_empty' => false,
            ));

            if ($parent_categories) :
                foreach ($parent_categories as $parent_category) {
                    $link_parent_category = get_term_link($parent_category);

                    $child_categories = get_terms(array(
                        'taxonomy' => 'category_nuoc_hoa',
                        'order' => 'DESC',
                        'parent' => $parent_category->term_id,
                        'hide_empty' => false,
                    ));
            ?>

                    <div class="menu-mega-item">
                        <a href="<?php echo esc_url($link_parent_category); ?>" class="tt-mg"><?php echo $parent_category->name; ?></a>

                        <?php if ($child_categories) : ?>
                            <ul class="menu-list">


                                <?php foreach ($child_categories as $child_category) {
                                    $category_link = get_term_link($child_category); ?>

                                    <li class="menu-item">
                                        <a class="menu-link" href="<?php echo esc_url($category_link); ?>"><?php echo $child_category->name; ?></a>
                                    </li>

                                <?php } ?>
                            </ul>
                        <?php endif; ?>

                    </div>

            <?php }
            endif; ?>

            <!-- nhóm hương  -->
            <?php $parent_categories = get_terms(array(
                'taxonomy' => 'category_nhom_huong',
                'parent' => 0,
                'hide_empty' => false,
            ));
            ?>
            <?php if ($parent_categories) : ?>
                <div class="menu-mega-item">
                    <div class="tt-mg"><?php _e('NHÓM HƯƠNG', 'monamedia'); ?></div>

                    <ul class="menu-list">

                        <?php foreach ($parent_categories as $child_category) {
                            $category_link = get_term_link($child_category); ?>

                            <li class="menu-item">
                                <a class="menu-link" href="<?php echo esc_url($category_link); ?>"><?php echo $child_category->name; ?></a>
                            </li>

                        <?php } ?>
                    </ul>

                </div>

            <?php endif; ?>
            <!-- nồng độ  -->
            <?php $parent_categories = get_terms(array(
                'taxonomy' => 'category_nong_do',
                'parent' => 0,
                'hide_empty' => false,
            ));

            if ($parent_categories) : ?>

                <div class="menu-mega-item">
                    <div class="tt-mg"><?php _e('Nồng độ', 'monamedia'); ?></div>

                    <ul class="menu-list">

                        <?php foreach ($parent_categories as $child_category) {
                            $category_link = get_term_link($child_category->term_id); ?>

                            <li class="menu-item">
                                <a class="menu-link" href="<?php echo esc_url($category_link); ?>"><?php echo $child_category->name; ?></a>
                            </li>

                        <?php } ?>
                    </ul>


                </div>
            <?php endif; ?>


            <!-- dung tích  -->
            <?php $parent_categories = get_terms(array(
                'taxonomy' => 'category_dung_tich',
                'parent' => 0,
                'hide_empty' => false,
            ));

            if ($parent_categories) : ?>

                <div class="menu-mega-item">
                    <div class="tt-mg"><?php _e('DUNG TÍCH', 'monamedia'); ?></div>

                    <ul class="menu-list">

                        <?php foreach ($parent_categories as $child_category) {
                            $category_link = get_term_link($child_category); ?>

                            <li class="menu-item">
                                <a class="menu-link" href="<?php echo esc_url($category_link); ?>"><?php echo $child_category->name; ?></a>
                            </li>

                        <?php } ?>
                    </ul>


                </div>
            <?php endif; ?>

        </div>

    <?php
        return ob_get_clean();
    }
}


class Mona_Walker_Nav_Menu_Footer extends Walker_Nav_Menu
{

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class='menu-list'>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $object = $item->object;
        $type = $item->type;
        $title = $item->title;
        $description = $item->description;
        $permalink = $item->url;

        $output .= "<li class='menu-item parent fz16 fw6 dropdown" .  implode(" ", $item->classes) . "'>";

        //Add SPAN if no Permalink
        if ($permalink && $permalink != '#') {
            $output .= '<a class="menu-link txt-mn-ft" href="' . $permalink . '">';
        } else {
            $output .= '<a class="menu-link" href="javascript:;">';
        }

        $output .= $title;

        if ($permalink && $permalink != '#') {
            $output .= '</a>';
        } else {
            $output .= '</a>';
        }
    }
}


class Mona_Walker_Nav_Menu_Mobile extends Walker_Nav_Menu
{

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class='menu-list'>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $object = $item->object;
        $type = $item->type;
        $title = $item->title;
        $description = $item->description;
        $permalink = $item->url;

        $mona_sc_1_group = get_field('mona_sc_1_group', $item);
        if (!empty($mona_sc_1_group) || isset($mona_sc_1_group)) {
            $select = $mona_sc_1_group['select'];
        }

        $output .= "<li class='menu-item parent fz16 fw6 dropdown" .  implode(" ", $item->classes) . "'>";

        //Add SPAN if no Permalink
        if ($permalink && $permalink != '#') {
            $output .= '<a class="menu-link txt-mn dropdown-mb" href="' . $permalink . '">';
        } else {
            $output .= '<a class="menu-link" href="javascript:;">';
        }

        $output .= $title;

        if ($select == '2') {
            $output .= '<span class="ic-angle"> <i class="fa-solid fa-caret-down"></i></span>';
        }
        if ($select == '3') {
            $output .= '<span class="ic-angle"> <i class="fa-solid fa-caret-down"></i></span>';
        }

        if ($permalink && $permalink != '#') {
            $output .= '</a>';
        } else {
            $output .= '</a>';
        }

        if ($select == '2') {
            $output .= self::MenuMegaContent($item);
        }

        if ($select == '3') {
            $output .= self::MenuMegaContent_2($item);
        }
    }

    function MenuMegaContent($item)
    {
        ob_start();
        $mona_sc_1_group = get_field('mona_sc_1_group', $item);
        if (isset($mona_sc_1_group) || !empty($mona_sc_1_group)) {
            $tieu_de_select_2 = $mona_sc_1_group['tieu_de_select_2'];
            $tax_2 = $mona_sc_1_group['tax_2'];
        }
    ?>

        <div class="menu-mega-mb">
            <div class="menu-mega-item">
                <div class="tt-mg">
                    <?php echo $tieu_de_select_2; ?>
                    <span class="ic-angle"> <i class="fa-solid fa-caret-down"></i></span>
                </div>
                <?php if ($tax_2) { ?>

                    <ul class="menu-list">

                        <?php
                        foreach ($tax_2 as $key => $item) {
                            $link_term = get_term_link($item);
                        ?>

                            <li class="menu-item"> <a class="menu-link" href="<?php echo esc_url($link_term); ?>">
                                    <?php echo $item->name; ?></a></li>

                        <?php
                        }
                        ?>

                    </ul>

                <?php } ?>

            </div>

            <div class="menu-mega-item">
                <div class="tt-mg">
                    <?php _e('Thương hiệu nước hoa', 'monamedia') ?>
                    <span class="ic-angle">
                        <i class="fa-solid fa-caret-down"></i></span>
                </div>

                <?php $parent_categories = get_terms(array(
                    'taxonomy' => 'category_thuong_hieu',
                    'parent' => 0,
                    'hide_empty' => false,
                ));
                if ($parent_categories) : ?>

                    <div class="wr-mega">
                        <ul class="menu-list">

                            <?php foreach ($parent_categories as $parent_category) {
                                $term_link = get_term_link($parent_category);

                            ?>

                                <li class="menu-item"> <a class="menu-link" href="<?php echo esc_url($term_link); ?>"><?php echo $parent_category->name; ?></a></li>

                            <?php
                            } ?>


                        </ul>
                    </div>

                <?php endif; ?>

            </div>
        </div>

    <?php
        return ob_get_clean();
    }

    function MenuMegaContent_2($item)
    {

        ob_start();

    ?>
        <div class="menu-mega-mb">

            <!-- nước hoa  -->
            <?php $parent_categories = get_terms(array(
                'taxonomy' => 'category_nuoc_hoa',
                'parent' => 0,
                'hide_empty' => false,
            ));

            if ($parent_categories) :
                foreach ($parent_categories as $parent_category) {
                    $child_categories = get_terms(array(
                        'taxonomy' => 'category_nuoc_hoa',
                        'order' => 'DESC',
                        'parent' => $parent_category->term_id,
                        'hide_empty' => false,
                    ));
            ?>

                    <div class="menu-mega-item">
                        <div class="tt-mg"><?php echo $parent_category->name; ?><span class="ic-angle"> <i class="fa-solid fa-caret-down"></i></span></div>

                        <?php if ($child_categories) : ?>
                            <ul class="menu-list">


                                <?php foreach ($child_categories as $child_category) {
                                    $category_link = get_term_link($child_category); ?>

                                    <li class="menu-item">
                                        <a class="menu-link" href="<?php echo esc_url($category_link); ?>"><?php echo $child_category->name; ?></a>
                                    </li>

                                <?php } ?>
                            </ul>
                        <?php endif; ?>

                    </div>

            <?php }
            endif; ?>

            <!-- nhóm hương  -->
            <?php $parent_cat_nhom_huong = get_terms(array(
                'taxonomy' => 'category_nhom_huong',
                'parent' => 0,
                'hide_empty' => false,
            ));
            ?>
            <?php if ($parent_cat_nhom_huong) : ?>
                <div class="menu-mega-item">
                    <div class="tt-mg"><?php _e('Nhóm hương', 'monamedia') ?><span class="ic-angle"> <i class="fa-solid fa-caret-down"></i></span></div>


                    <ul class="menu-list">


                        <?php foreach ($parent_cat_nhom_huong as $child_category) {
                            $category_link = get_term_link($child_category); ?>

                            <li class="menu-item">
                                <a class="menu-link" href="<?php echo esc_url($category_link); ?>"><?php echo $child_category->name; ?></a>
                            </li>

                        <?php } ?>
                    </ul>

                </div>
            <?php endif; ?>
            <!-- nồng độ  -->
            <?php $parent_categories = get_terms(array(
                'taxonomy' => 'category_nong_do',
                'parent' => 0,
                'hide_empty' => false,
            ));

            ?>
            <?php if ($parent_categories) : ?>
                <div class="menu-mega-item">

                    <div class="tt-mg">
                        <span><?php _e('Nồng độ', 'monamedia') ?></span>
                        <span class="ic-angle">
                            <i class="fa-solid fa-caret-down"></i></span>
                    </div>


                    <ul class="menu-list">

                        <?php foreach ($parent_categories as $child_category) {
                            $category_link = get_term_link($child_category); ?>

                            <li class="menu-item">
                                <a class="menu-link" href="<?php echo esc_url($category_link); ?>"><?php echo $child_category->name; ?></a>
                            </li>

                        <?php } ?>
                    </ul>

                </div>
            <?php endif; ?>
            <?php
            //  }
            // endif; 
            ?>

            <!-- dung tích  -->
            <?php $parent_categories = get_terms(array(
                'taxonomy' => 'category_dung_tich',
                'parent' => 0,
                'hide_empty' => false,
            ));

            if (!empty($parent_categories) || isset($parent_categories)) {  ?>

                <div class="menu-mega-item">
                    <div class="tt-mg"><?php _e('Dung tích', 'monamedia') ?><span class="ic-angle"> <i class="fa-solid fa-caret-down"></i></span></div>
                    <ul class="menu-list">

                        <?php foreach ($parent_categories as $child_cat) {
                            $term_link = get_term_link($child_cat); ?>

                            <li class="menu-item">
                                <a class="menu-link" href="<?php echo esc_url($term_link); ?>">
                                    <?php echo $child_cat->name; ?>
                                </a>
                            </li>

                        <?php } ?>

                    </ul>
                </div>

            <?php } ?>

        </div>

<?php
        return ob_get_clean();
    }
}

<?php

/**
 * Undocumented class
 * Create widget
 */
class M_Widget_Culture extends WP_Widget
{

    /**
     * Undocumented function
     */
    function __construct()
    {
        parent::__construct(
            'm_default_culture',
            __('Mona - Dịch Vụ', 'mona-admin'),
            [
                'description' => __('Hiển Thị Bài Viết', 'mona-admin'),
            ]
        );
    }

    /**
     * Undocumented function
     *
     * @param [type] $args
     * @param [type] $instance
     * @return void
     */
    public function widget($args, $instance)
    {
        $widget_id = $args['widget_id'];
        $title = isset($instance['title']) ? $instance['title'] : '';
        $news_list = isset($instance['news_list']) ? $instance['news_list'] : '';
?>
<?php if (!empty($news_list)) {
        ?>

<?php foreach ($news_list as $key => $news_item) {
                $news_id = $news_item['consumables_item'];

                $is_current = is_single($news_id) || (is_archive() && $news_id == get_option('page_for_posts')) || is_page($news_id);
            ?>

<li class="footer-item menu-item <?php echo $is_current ? 'current-menu-item' : ''; ?>">
    <a href="<?php echo get_the_permalink($news_id) ?>" class="menu-link txt-mn-ft">
        <?php echo get_the_title($news_id) ?>
    </a>
</li>

<?php } ?>

<?php  } ?>
<?php
    }

    /**
     * Undocumented function
     *
     * Widget Backend
     * @param [type] $instance
     * @return void
     */
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = '';
        }

        if (class_exists('Mona_Widgets')) {
            Mona_Widgets::create_field(
                [
                    'type'        => 'text',
                    'name'        => $this->get_field_name('title'),
                    'id'          => $this->get_field_id('title'),
                    'value'       => $title,
                    'title'       => __('Text', 'mona-admin'),
                    'placeholder' => __('Title', 'mona-admin'),
                    'docs'        => false,
                ]
            );
        }

        // ----------------------List bài viết -------------------------
        $obj_id = get_the_ID();
        $args = [
            'post_type' => 'mona_policy',
            'posts_per_page' => 99,
            'post__not_in' => array($obj_id),
            'post_status'    => 'publish',
        ];
        $Results = new WP_Query($args);
        $news_list_offcial_array = [];

        if ($Results) {
            while ($Results->have_posts()) :
                $Results->the_post();
                global $post;
                $news_list_offcial_array[$post->ID] = get_the_title($post->ID);
            endwhile;
            wp_reset_query();
        }

        if (isset($instance['news_list'])) {
            $news_list = $instance['news_list'];
        } else {
            $news_list = '';
        }

        Mona_Widgets::create_field(
            [
                'type'   => 'repeater',
                'name'   => $this->get_field_name('news_list'),
                'id'     => $this->get_field_id('news_list'),
                'value'  => $news_list,
                'title'  => __('Danh Sách Bài Viết', 'monamedia'),
                'fields' => [
                    'consumables_item' => [
                        'type'   => 'select', 'title'  => __('Dịch Vụ', 'monamedia'),
                        'select' => $news_list_offcial_array,
                    ]
                ],
                'docs'   => false,
            ]
        );
    }

    /**
     * Undocumented function
     *
     * Updating widget replacing old instances with new
     * @param [type] $new_instance
     * @param [type] $old_instance
     * @return void
     */
    public function update($new_instance, $old_instance)
    {
        $instance = [];
        if (class_exists('Mona_Widgets')) {
            $instance['title'] = Mona_Widgets::update_field($new_instance['title']);
            $instance['news_list'] = Mona_Widgets::update_field($new_instance['news_list']);
        }
        return $instance;
    }
}

/**
 * Undocumented function
 *
 * Register and load the widget
 * @return void
 */
function Register_Widget_Default_Culture()
{
    register_widget('M_Widget_Culture');
}
add_action('widgets_init', 'Register_Widget_Default_Culture');
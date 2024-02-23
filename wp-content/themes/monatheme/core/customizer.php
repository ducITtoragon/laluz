<?php
if (class_exists('Kirki')) {

    function kirki_demo_scripts()
    {
        wp_enqueue_style('kirki-demo', get_stylesheet_uri(), array(), time());
    }

    add_action('wp_enqueue_scripts', 'kirki_demo_scripts');

    $priority = 1;
    /**
     * Add panel
     */
    Kirki::add_panel(
        'panel_site',
        [
            'title'     => sprintf(__('%s SITE', 'mona-admin'), get_bloginfo()),
            'priority'   => $priority++,
            'capability' => 'edit_theme_options',
        ]
    );
    /**
     * Add section
     */
    Kirki::add_section(
        'section_default',
        [
            'title'      => __('Thông tin', 'mona-admin'),
            'priority'   => $priority++,
            'capability' => 'edit_theme_options',
            'panel'      => 'panel_site'
        ]
    );
    /**
     * Add field
     */
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'image',
            'settings'    => 'mona_thumbnail_default',
            'label'       => __('Thumbnail Default', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_default',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'image',
            'settings'    => 'mona_thumbnail_default_square',
            'label'       => __('Thumbnail Default [square]', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_default',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    /**
     * Add panel
     */
    // Kirki::add_panel( 'panel_contacts', 
    //     [
    //         'title'     => __( 'Liên hệ', 'mona-admin' ),
    //         'priority'   => $priority++,
    //         'capability' => 'edit_theme_options',
    //     ]
    // );

    /**
     * Add section
     */
    // Kirki::add_section(
    //     'section_default',
    //     [
    //         'title'      => __('Thông tin liên hệ', 'mona-admin'),
    //         'priority'   => $priority++,
    //         'capability' => 'edit_theme_options',
    //     ]
    // );

    /**
     * Add field
     */
    // Kirki::add_field( 'mona_setting', 
    //     [
    //         'type'        => 'text',
    //         'settings'    => 'section_default_text',
    //         'label'       => __( 'Shortcode from single product', 'mona-admin' ),
    //         'description' => '',
    //         'help'        => '',
    //         'section'     => 'section_default',
    //         'default'     => '',
    //         'priority'    => $priority++,
    //     ]
    // );

    /**
     * Add field 
     */
    // kirki::add_field( 'mona_setting', [
    //     'type'        => 'repeater',
    //     'label'       => __( 'Danh sách liên kết', 'mona-admin' ),
    //     'section'     => 'section_contact_socials',
    //     'priority'    =>  $priority++,
    //     'row_label' => [
    //         'type'  => 'text',
    //         'value' => __( 'Liên kết', 'mona-admin' ),

    //     ],
    //     'button_label' => __( 'Thêm mới', 'mona-admin' ),
    //     'settings'     => 'contact_social_items',
    //     'fields' => [
    //         'icon' => [
    //             'type'        => 'image',
    //             'label'       => __( 'Icon', 'mona-admin' ),
    //             'description' => '',
    //             'default'     => '',
    //         ],
    //         'link' => [
    //             'type'        => 'text',
    //             'label'       => __( 'Link', 'mona-admin' ),
    //             'description' => '',
    //             'default'     => '',
    //         ],
    //     ]
    // ]);
    /**
     * Add section
     */
    Kirki::add_section(
        'section_header',
        [
            'title'      => __('Header', 'mona-admin'),
            'priority'   => $priority++,
            'capability' => 'edit_theme_options',
            'panel'      => 'panel_site'
        ]
    );

    //title 1
    /**
     * Add field 
     */
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'header_title_1',
            'label'       => __('Title (1)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_header',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );


    /**
     * Add section footer
     */
    Kirki::add_section(
        'section_footer',
        [
            'title'      => __('Footer', 'mona-admin'),
            'priority'   => $priority++,
            'capability' => 'edit_theme_options',
            'panel'      => 'panel_site'
        ]
    );

    //  tiêu đề 1
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_1',
            'label'       => __('Tiêu đề (1)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    //  short code
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_shortcode_1',
            'label'       => __('Shortcode', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    //  nội dung
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_des_1',
            'label'       => __('Nội dung (1)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    //Mạng xã hội
    /**
     * Add field 
     */

    kirki::add_field('mona_setting', [
        'type'        => 'repeater',
        'label'       => __('Danh sách mạng xã hội', 'mona-admin'),
        'section'     => 'section_footer',
        'priority'    =>  $priority++,
        'row_label' => [
            'type'  => 'text',
            'value' => __('Mãng xã hội', 'mona-admin'),

        ],
        'button_label' => __('Add new', 'mona-admin'),
        'settings'     => 'contact_social_items',
        'fields' => [
            'icon' => [
                'type'        => 'image',
                'label'       => __('Icon', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
            'link' => [
                'type'        => 'text',
                'label'       => __('Link', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
        ]
    ]);

    //  tiêu đề 2
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_2',
            'label'       => __('Tiêu đề (2)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    //  tiêu đề 3
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_3',
            'label'       => __('Tiêu đề (3)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    //  tiêu đề 4
    Kirki::add_field(
        'mona_setting',
        [
            'type'        => 'text',
            'settings'    => 'footer_title_4',
            'label'       => __('Tiêu đề (4)', 'mona-admin'),
            'description' => '',
            'help'        => '',
            'section'     => 'section_footer',
            'default'     => '',
            'priority'    => $priority++,
        ]
    );

    //Địa chỉ 
    /**
     * Add field 
     */

    kirki::add_field('mona_setting', [
        'type'        => 'repeater',
        'label'       => __('Danh sách địa chỉ', 'mona-admin'),
        'section'     => 'section_footer',
        'priority'    =>  $priority++,
        'row_label' => [
            'type'  => 'text',
            'value' => __('Địa chỉ', 'mona-admin'),

        ],
        'button_label' => __('Add new', 'mona-admin'),
        'settings'     => 'contact_dia_chi_items',
        'fields' => [
            'icon' => [
                'type'        => 'image',
                'label'       => __('Icon', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
            'text' => [
                'type'        => 'text',
                'label'       => __('Địa chỉ', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
            'link' => [
                'type'        => 'text',
                'label'       => __('Link', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
        ]
    ]);

    //Side bar
    /**
     * Add field 
     */

    kirki::add_field('mona_setting', [
        'type'        => 'repeater',
        'label'       => __('Liên hệ back to top', 'mona-admin'),
        'section'     => 'section_footer',
        'priority'    =>  $priority++,
        'row_label' => [
            'type'  => 'text',
            'value' => __('Địa chỉ', 'mona-admin'),

        ],
        'button_label' => __('Add new', 'mona-admin'),
        'settings'     => 'contact_back_to_top_items',
        'fields' => [
            'text-icon' => [
                'type'        => 'text',
                'label'       => __('Icon', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
            'link' => [
                'type'        => 'text',
                'label'       => __('Link', 'mona-admin'),
                'description' => '',
                'default'     => '',
            ],
        ]
    ]);
}

if (!function_exists('mona_option')) {

    function mona_option($setting, $default = '')
    {
        echo mona_get_option($setting, $default);
    }

    function mona_get_option($setting, $default = '')
    {
        if (class_exists('Kirki')) {
            $value = $default;
            $options = get_option('option_name', array());
            $options = get_theme_mod($setting, $default);
            if (isset($options)) {
                $value = $options;
            }
            return $value;
        }
        return $default;
    }
}

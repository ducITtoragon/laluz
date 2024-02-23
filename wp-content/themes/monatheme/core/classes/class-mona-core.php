<?php

/**
 * Undocumented class
 */
class MonaCore extends Setup_Theme
{

    public function load_core()
    {
        parent::__construct();
        $this->include_files();
    }

    public function supports()
    {
        return [
            'account' => [
                'fields' => [
                    'display_name',
                    'user_login',
                    'user_email',
                    'billing_email',
                    'billing_phone',
                    'billing_address_1',
                ],
                'validate' => [
                    'display_name'      => 'string|required',
                    'billing_email'     => 'email|required',
                    'billing_phone'     => 'string|required',
                    'billing_address_1' => 'string|required',
                ]
            ],
        ];
    }

    public function include_files()
    {
        $regsiter_load_files = [
            'app/controllers' => [
                'method'   => '',
                'autoload' => array(
                    'class-mona-notice.php',
                    'class-mona-elements.php',
                    'class-mona-account.php',
                    'class-mona-product.php',
                    'class-mona-product-attributes-acf.php',
                    'class-mona-product-variations.php',
                ),
            ],
            'app/ajax' => [
                'method'   => '',
                'autoload' => array(
                    'default-ajax.php',
                    'CartAjax.php',
                    'account-ajax.php',
                    'cart-ajax.php',
                    'default-ajax.php',
                    'evaluate-ajax.php',
                    'filter-ajax.php',
                    'product-ajax.php',
                ),
            ],
            'app/modules/comments' => [
                'method'   => '',
                'autoload' => '',
            ],
            'app/modules/login' => [
                'method'   => '',
                'autoload' => '',
            ],
            'app/modules/widgets' => [
                'method'   => '',
                'autoload' => array(
                    'class.callback.php',
                    'class.widget.php'
                ),
            ],
            'app/modules/widgets/admin' => [
                'method'   => '',
                'autoload' => array(
                    'widget-default-policy.php',
                    'widget-default-text.php',
                    'widget-info.php',
                    'widget-socials.php',
                    'widget-default-dich-vu.php',
                ),
            ],
            'core' => [
                'method'   => '',
                'autoload' => [
                    'walker-menu.php',
                    'regsiter-post-type.php',
                    'customizer.php',
                    'hooks.php',
                    'functions.php',
                ],
            ],
        ];

        if (is_array($regsiter_load_files)) {
            foreach ($regsiter_load_files as $path => $file) {
                $filePath = $path;
                // auto load file
                $autoladFiles = $file['autoload'];
                if (!empty($autoladFiles)) {
                    foreach ($autoladFiles as $loadFile) {
                        $file_path = get_template_directory() . '/' . $filePath . '/' . $loadFile;
                        if (file_exists($file_path)) {
                            require_once($file_path);
                        }
                    }
                }
            }
        }
    }
}

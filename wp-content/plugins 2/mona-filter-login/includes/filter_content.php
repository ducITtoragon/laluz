<?php

class Mona_filter_content {

    private $setting;

    public function __construct() {
        if (is_admin()) {
            return;
        }
//        add_filter('the_content', array($this, 'filter'), 99);
//        add_filter('term_description', array($this, 'filter'), 99);
//        add_filter('the_excerpt', array($this, 'filter'), 99);
//        add_filter('the_content_feed', array($this, 'filter'), 99);
//        add_filter('the_content_rss', array($this, 'filter'), 99);
    }
    public function filter($content) {
       
        if(is_admin()|| is_user_logged_in()){
            return $content;
        }
        // $pattern = '/\< *[a][^\>]*[href] *= *[\"\']{0,1}([^\"\'\ >]*)/m';
        $pattern = '/<\s*a[^>]*>(.*?)<\s*\/s*a>/m';
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER, 0);
        $attrs = array();
        foreach ($matches as $mt) {
            
            if ($mt[0] != '') {
                $filter = $this->filter_a_tag($mt[0]);

                if ($filter) {
                    $attrs[$filter['key']] = 'class="mona-action-login" href="'.$filter['val'].'"';
                }
            }
        }
       
        $return = str_replace(array_keys($attrs), array_values($attrs), $content);
        return $return;
    }

    public function filter_a_tag($atag) {
        $pattern = '/[href]*= *[\"\']{0,1}([^\"\'\ >]*)[\"\']/';
        preg_match_all($pattern, $atag, $matches, PREG_SET_ORDER, 0);
        if (count($matches) == 0) {
            return false;
        }
        $matches = $matches[0];
        $server = str_replace(array('https://','http://','www.'), array('','',''), get_site_url());
        $check = str_replace(array('https://','http://','www.'), array('','',''), $matches[1]);
        if(strpos($check,$server) !== false ){
            return false;
        }
        
        return array('key' => $matches[0], 'val' => 'javascript:;');
    }


    public function parser($item) {
        $get = $this->filter_url($item);
        if ($get) {
            $parse = parse_url($item);
            $method = trim(str_replace('www.', '', $parse['host']));
            $option_setting = array();
            if (isset($this->setting[$method])) {
                $option = $this->setting[$method]['value'];
                $option_setting = $this->setting[$method];
            } else {
                foreach ($this->setting as $key => $value) {
                    if (strpos($method, $key) > 0) {
                        $option = $value['value'];
                        $option_setting = $value;
                        break;
                    }
                }
            }
            return $this->filter_mark($get, $option_setting);
        }
        return false;
    }
}

new Mona_filter_content();

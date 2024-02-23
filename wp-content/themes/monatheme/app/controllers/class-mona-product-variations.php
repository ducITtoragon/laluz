<?php
class MonaProductVariations
{
    protected static $proId;
    protected static $product = [];
    protected static $available_variations = [];
    protected static $default_variation = '';

    public static function Variations_html($attribute_primary_taxonomy = '',  $attribute_primary_first_slug = '')
    {
        $productId       = intval(self::$proId);
        if (!isset($productId) || $productId <= 0) {
            return;
        }
        ob_start();
        $mona_1_repeater = get_field('mona_1_repeater', $productId);
        $product         = self::$product;
        $variations = self::Variations($productId);
        $variation_first_attributes = self::Variation_first_attributes();

        if (!empty($variations) && empty($attribute_primary_taxonomy) && empty($attribute_primary_first_slug)) {
            $first = true;
            foreach ($variations as $variation_attributes => $attributes_array) {
                foreach ($attributes_array as $key_attribute_slug => $attribute_item) {
                    if (!empty($attribute_item['parent']) && $first) {
                        $attribute_primary_taxonomy = $variation_attributes;
                        $attribute_primary_first_slug = $key_attribute_slug;
                        $first = false;
                    }
                }
            }
        }

        if (!empty($variations) && !empty($attribute_primary_taxonomy) && !empty($attribute_primary_first_slug)) {
            if (!empty($variations[$attribute_primary_taxonomy])) {
                $taxonomy_primary = str_replace('attribute_', '', $attribute_primary_taxonomy);
                $first = true;
                $attribute_label_name = wc_attribute_label($taxonomy_primary);
?>

                <div class="form_data recheck-block taxonomy-<?php echo $taxonomy_primary; ?>" id="taxonomy-<?php echo $taxonomy_primary ?>">
                    <p class="tt-option form_label"> <?php echo !empty($attribute_label_name) ? $attribute_label_name : '' ?></p>
                    <div class="flex-box">
                        <?php
                        $child = 0;
                        foreach ($variations[$attribute_primary_taxonomy] as $attribute_primary_slug => $attribute_primary_item) {
                            $term_item = get_term_by('slug', $attribute_primary_slug, $taxonomy_primary);
                            $flagChecked = false;
                            if ($attribute_primary_item['default']) {
                                $flagChecked = true;
                            }
                            ?>
                            <?php $key = mona_check_by_args($mona_1_repeater, $term_item->term_id);
                            if (!empty($key) && isset($mona_1_repeater[$key])) {
                            ?>
                            <div class="box-op-it checkbox_item mona-variation-item <?php echo !empty($mona_1_repeater[$key]['img']) ? 'mona-img-attr' : 'mona-name-attr' ?> <?php echo $flagChecked ? 'active' : 'normal'; ?> <?php echo 'checkbox-item-' . $term_item->slug ?>" 
                                data-taxonomy="<?php echo $taxonomy_primary; ?>" 
                                data-slug="<?php echo $term_item->slug; ?>" 
                                data-product_id="<?php echo $productId; ?>">
                                <input type="radio" id="<?php echo $term_item->slug; ?>" value="<?php echo $term_item->slug; ?>" name="<?php echo $taxonomy_primary; ?>" />
                                <label for="<?php echo $term_item->slug; ?>">
                                    <?php echo !empty($mona_1_repeater[$key]['img']) ? wp_get_attachment_image($mona_1_repeater[$key]['img']) :  $term_item->name; ?>
                                </label>
                            </div>
                            <?php } else { ?>
                            <div class="box-op-it checkbox_item mona-variation-item mona-name-attr  <?php echo $flagChecked ? 'active' : 'normal'; ?> <?php echo 'checkbox-item-' . $term_item->slug ?> is-loading-group"
                                data-taxonomy="<?php echo $taxonomy_primary; ?>" 
                                data-slug="<?php echo $term_item->slug; ?>" 
                                data-product_id="<?php echo $productId; ?>">
                                <input type="radio" id="<?php echo $term_item->slug; ?>" value="<?php echo $term_item->slug; ?>" name="<?php echo $taxonomy_primary; ?>" <?php echo $flagChecked ? 'checked' : ''; ?> />
                                <label for="<?php echo $term_item->slug; ?>">
                                    <?php echo $term_item->name; ?>
                                </label>
                            </div>
                            <?php } ?>
                            <?php 
                            if ( $child <= 0 ) {
                                ?>
                                <script type="text/javascript">
                                    jQuery(document).ready(function($) {
                                        jQuery('.checkbox-item-<?php echo $term_item->slug; ?> input').trigger('click');
                                    });
                                </script>
                                <?php 
                            }
                            ?>
                        <?php 
                        $child++;
                        } ?>
                    </div>
                </div>
        <?php }
        } ?>
        <?php
        if (!empty($variations[$attribute_primary_taxonomy][$attribute_primary_first_slug]['relationship'])) {
            foreach ($variations[$attribute_primary_taxonomy][$attribute_primary_first_slug]['relationship'] as $attribute_relationship_name => $attribute_relationship_array) {
                $taxonomy_primary = str_replace('attribute_', '', $attribute_relationship_name);
        ?>
                <div id="taxonomy-<?php echo $taxonomy_primary ?>" class="product-attributes  taxonomy-<?php echo $taxonomy_primary; ?>">

                    <div class="form_data recheck-block">
                        <p class="form_label ">
                            <?php $attribute_label_name = wc_attribute_label($taxonomy_primary);
                            if (!empty($attribute_label_name)) {
                                echo $attribute_label_name;
                            } ?>
                        </p>
                        <div class="checkbox_list">
                            <?php
                            foreach ($attribute_relationship_array as $attribute_relationship_slug => $attribute_relationship_item) {
                                $term_item = get_term_by('slug', $attribute_relationship_slug, $taxonomy_primary);
                                $mona_taxonomy_color_avatar = get_field('mona_taxonomy_color_avatar', $term_item);
                                $flagChecked = false;
                                // check default attribute
                                $default_attributes = $product->get_default_attributes();
                                if (!empty($default_attributes)) {
                                    if ($default_attributes[$taxonomy_primary] === $attribute_relationship_slug) {
                                        $flagChecked = true;
                                    }
                                }
                            ?>
                                <label class="checkbox_item recheck-item mona-variation-item <?php echo $flagChecked ? 'checked' : ''; ?>" data-taxonomy="<?php echo $taxonomy_primary; ?>" data-slug="<?php echo $term_item->slug; ?>" data-product_id="<?php echo $productId; ?>">
                                    <input type="radio" value="<?php echo $term_item->slug; ?>" name="<?php echo $taxonomy_primary; ?>" <?php echo $flagChecked ? 'checked' : ''; ?> />
                                    <span class="checkbox_text">
                                        <?php echo $term_item->name; ?>
                                    </span>
                                </label>
                            <?php } ?>
                        </div>
                    </div>
                </div>
<?php }
        }

        return ob_get_clean();
    }
    public static function setProId(int $productId)
    {
        self::$product              = wp_cache_get('get_product_data');
        self::$available_variations = wp_cache_get('get_available_variations');
        if (!empty($productId)) {
            self::$proId   = intval($productId);
            if (!self::$product) {
                self::$product = wc_get_product($productId);
                wp_cache_set('get_product_data', self::$product, '', 3600);
                if (!self::$available_variations) {
                    if (self::$product->is_type('variable')) {
                        self::$available_variations = self::$product->get_available_variations();
                        wp_cache_set('get_available_variations', self::$available_variations, '', 3600);
                    }
                }
            }
        } else {
            self::$proId   = 0;
            self::$product = [];
            self::$available_variations = [];
        }
        return new self;
    }

    public static function Variation_first_id()
    {
        $productId            = intval(self::$proId);
        $variation_first_attributes = self::Variation_first_attributes();
        $data_store  = WC_Data_Store::load('product');
        $variation_first_id = $data_store->find_matching_product_variation(new \WC_Product($productId), $variation_first_attributes);
        return  $variation_first_id;
    }

    public static function Variation_first_attributes()
    {
        $firstAttributes = [];
        $findAttributes  = wp_cache_get('find_first_attribute');
        if (!$findAttributes) {
            $productId       = intval(self::$proId);
            if (!isset($productId) || $productId <= 0) {
                return;
            }
            // get product
            $product = self::$product;
            if (!empty($product) && $product->get_type() == 'variable') {
                $variations           = self::Variations($productId);
                $typeVariation = count($product->get_attributes()) > 1 ? 'multiple' : 'single';
                if ($typeVariation == 'single') {
                    if (!empty($variations)) {
                        $first = true;
                        foreach ($variations as $attribute_name => $items) {
                            foreach ($items as $item_slug => $item) {
                                if ($first) {
                                    if (!empty($item['slug'])) {
                                        $variation_first_attributes[$attribute_name] = $item['slug'];
                                        $first = false;
                                    }
                                }
                            }
                        }
                    }
                } elseif ($typeVariation == 'multiple') {
                    if (!empty($variations)) {
                        $first = true;
                        foreach ($variations as $variation_attributes => $attributes_array) {
                            foreach ($attributes_array as $key_attribute_slug => $attribute_item) {
                                if (!empty($attribute_item['parent']) && $first) {
                                    if (!empty($attribute_item['relationship'])) {
                                        foreach ($attribute_item['relationship'] as $key_relationship_slug => $relationship_items) {
                                            if (!empty($relationship_items)) {
                                                foreach ($relationship_items as $relationship_item_slug => $relationship_item) {
                                                    if ($first && $relationship_item['disabled'] == 'no' && $relationship_item['variation_id'] != 0 && $relationship_item['variation_id'] > 0) {
                                                        $variation_first_attributes = $relationship_item['variation_attributes'];
                                                        $first = false;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            wp_cache_set('find_first_attribute', $variation_first_attributes, '', 3600);
        }
        return  $variation_first_attributes;
    }

    public static function Variations()
    {
        $productId            = intval(self::$proId);

        if (!isset($productId) || $productId <= 0) {
            return;
        }
        $variation_attributes = [];
        $product = self::$product;
        $product_type = '';
        $product_type = $product->get_type();
        if ($product_type == 'variable') {
            $variations           = $product->get_available_variations();
            $count                = 0;
            foreach ($product->get_attributes() as $attribute_name  => $attribute) {
                if ($attribute['variation']) {
                    if (!empty($product->get_variation_attributes()[$attribute_name])) {
                        $childItemVariations = $product->get_variation_attributes()[$attribute_name];
                        if (!empty($childItemVariations)) {
                            foreach ($childItemVariations as $varChildKey => $varChildValue) {
                                $varChildTerm = get_term_by('slug', $varChildValue, str_replace('attribute_', '', $attribute_name));
                                if (!empty($varChildTerm)) {
                                    $variation_attributes['attribute_' . $attribute_name][$varChildValue] = [
                                        'term_id' => $varChildTerm->term_id,
                                        'name'    => $varChildTerm->name,
                                        'slug'    => $varChildTerm->slug,
                                    ];
                                    if ($count == 0) {
                                        $variation_attributes['attribute_' . $attribute_name][$varChildValue]['parent'] = true;
                                    }
                                    // check default attribute
                                    $variation_attributes['attribute_' . $attribute_name][$varChildValue]['default'] = 0;
                                    $default_attributes = $product->get_default_attributes();
                                    if (!empty($default_attributes)) {
                                        if ($default_attributes[$attribute_name] === $varChildTerm->slug) {
                                            $variation_attributes['attribute_' . $attribute_name][$varChildValue]['default'] = 1;
                                        }
                                    }
                                    // relation
                                    $listAttributeRelations = self::getAttributeRelation($attribute_name, $varChildValue);
                                    if (!empty($listAttributeRelations)) {
                                        $variation_attributes['attribute_' . $attribute_name][$varChildValue]['relationship'] = $listAttributeRelations;
                                    } else {
                                        $variation_attributes['attribute_' . $attribute_name][$varChildValue]['variation_id'] = self::findVariationId($productId, ['attribute_' . $attribute_name => $varChildTerm->slug]);
                                    }
                                }
                            }
                        }
                        $count++;
                    }
                }
            }
        }
        return  $variation_attributes;
    }

    public static function getAttributeRelation($attributUnset = '', $attributValue = '')
    {
        if (empty($attributUnset) || empty($attributValue)) {
            return false;
        }
        $productId            = intval(self::$proId);
        if (!isset($productId) || $productId <= 0) {
            return;
        }
        $findAttributes       = [];
        $variation_attributes = [];
        $product = self::$product;
        $variations           = $product->get_available_variations();
        foreach ($product->get_attributes() as $attribute_name  => $attribute) {
            if ($attribute['variation']) {
                $childItemVariations = $product->get_variation_attributes()[$attribute_name];
                if (!empty($childItemVariations) && $attribute_name != $attributUnset) {
                    foreach ($childItemVariations as $varChildKey => $varChildValue) {
                        $varChildTerm = get_term_by('slug', $varChildValue, str_replace('attribute_', '', $attribute_name));
                        if (!empty($varChildTerm)) {
                            $variation_attributes['attribute_' . $attribute_name][$varChildValue] = [
                                'term_id' => $varChildTerm->term_id,
                                'name'    => $varChildTerm->name,
                            ];
                            // array
                            $totalCheck     = 0;
                            $listCheckItems = self::checkAttributeRelation($attributUnset, $attributValue);
                            if (!empty($listCheckItems)) {
                                $totalCheck = count($listCheckItems);
                                if (count($listCheckItems) >= 2) {
                                    unset($listCheckItems['attribute_' . $attribute_name]);
                                }
                                // check
                                if ($totalCheck <= 1) {
                                    foreach ($listCheckItems as $checkkey => $subCheckItems) {
                                        if (!empty($subCheckItems)) {
                                            $count = 0;
                                            foreach ($subCheckItems as $subCheckKey => $subCheckValue) {
                                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'][$count]['attribute_' . $attributUnset] = $attributValue;
                                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'][$count]['attribute_' . $attribute_name] = $varChildValue;
                                                $count++;
                                            }
                                        }
                                    }
                                } else {
                                    foreach ($listCheckItems as $checkkey => $subCheckItems) {
                                        if (!empty($subCheckItems)) {
                                            $count = 0;
                                            foreach ($subCheckItems as $subCheckKey => $subCheckValue) {
                                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'][$count]['attribute_' . $attributUnset] = $attributValue;
                                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'][$count]['attribute_' . $attribute_name] = $varChildValue;
                                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'][$count][$checkkey] = $subCheckValue['slug'];
                                                $count++;
                                            }
                                        }
                                    }
                                }
                            } else {
                                $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'] = [];
                            }
                            //check disabled
                            $disabled     = 'yes';
                            $variation_id = 0;
                            $checkListCompare = $variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare'];
                            if (!empty($checkListCompare)) {
                                foreach ($checkListCompare as $comKey => $comAttrbutes) {
                                    $findVariationId = self::findVariationId($productId, $comAttrbutes);
                                    if (!empty($findVariationId) && $findVariationId > 0) {
                                        $disabled     = 'no';
                                        $variation_id = $findVariationId;
                                        $variation_attributes['attribute_' . $attribute_name][$varChildValue]['variation_attributes'] = $comAttrbutes;
                                        continue;
                                    }
                                }
                            }
                            // result status 
                            $variation_attributes['attribute_' . $attribute_name][$varChildValue]['disabled'] = $disabled;
                            $variation_attributes['attribute_' . $attribute_name][$varChildValue]['variation_id'] = $variation_id;
                            // unset 
                            unset($variation_attributes['attribute_' . $attribute_name][$varChildValue]['compare']);
                        }
                    }
                }
            }
        }
        return  $variation_attributes;
    }

    public static function checkAttributeRelation($attributUnset = '', $attributValue = '')
    {
        if (empty($attributUnset) || empty($attributValue)) {
            return false;
        }


        $findAttributes       = [];
        $variation_attributes = [];
        $productId            = intval(self::$proId);
        if (!isset($productId) || $productId <= 0) {
            return;
        }
        $product = self::$product;
        // $variations           = $product->get_available_variations();
        foreach ($product->get_attributes() as $attribute_name  => $attribute) {
            if ($attribute['variation']) {
                $childItemVariations = $product->get_variation_attributes()[$attribute_name];
                if (!empty($childItemVariations) && $attribute_name != $attributUnset) {
                    foreach ($childItemVariations as $varChildKey => $varChildValue) {
                        $varChildTerm = get_term_by('slug', $varChildValue, str_replace('attribute_', '', $attribute_name));
                        if (!empty($varChildTerm)) {
                            $variation_attributes['attribute_' . $attribute_name][$varChildValue] = [
                                'term_id' => $varChildTerm->term_id,
                                'name'    => $varChildTerm->name,
                                'slug'    => $varChildTerm->slug,
                            ];
                        }
                    }
                }
            }
        }
        return  $variation_attributes;
    }

    public static function findVariationId($productId = [], $attributes = [])
    {
        $variationId = wp_cache_get('find_matching_product_variation');
        if (!$variationId) {
            $data_store  = WC_Data_Store::load('product');
            $variationId = $data_store->find_matching_product_variation(new \WC_Product($productId), $attributes);
            wp_cache_set('find_matching_product_variation', $variationId, '', 3600);
        }
        return $variationId;
    }
}

jQuery(document).ready(function ($) {
  $("#woocommerce-product-data").on(
    "woocommerce_variations_loaded",
    function () {
      acf.doAction("ready");
    }
  );
});

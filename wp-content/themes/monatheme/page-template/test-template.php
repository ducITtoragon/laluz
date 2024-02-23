<?php

/**
 * Template name: Test Page
 * @author : MONA.Media / Website
 */
get_header();
while (have_posts()) :
    the_post();
    $sheet_url = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRAI-32atSpiEhBs9mUJcbD6kBIhVxzrW0addxdEDElw4OJAdxtQHwlKAyqwFeWcQ/pubhtml';
    $sheets    = new SheetsController( $sheet_url );
    ?>
    <main class="main spc-hd spc-hd-2">
        <div class="container">
            <?php show( $sheets->getSheets() ); ?>
        </div>
    </main>
    <?php
endwhile;
get_footer();

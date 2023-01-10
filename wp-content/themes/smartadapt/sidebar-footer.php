<div class="row sidebar-footer">
    <ul class="block-grid four-up mobile">
        <?php
        if (is_front_page()) {
            dynamic_sidebar('sidebar-2');
        } else {
            dynamic_sidebar('sidebar-3');
        }


        ?>
    </ul>
</div>

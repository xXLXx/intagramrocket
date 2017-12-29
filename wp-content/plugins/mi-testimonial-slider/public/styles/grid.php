<div class="<?php echo $mi_testimonial_main_class_default; ?>" >
    <div class="<?php echo $mi_testimonial_wrap_class_default . $mi_testimonial_grid_wrapper; ?>">
        <?php foreach ($mi_testimonial_testimonials as $testimonial): ?>
            <div
                class="<?php echo $mi_testimonial_grid_classes;?> mi-testimonial-col--masonry mi-testimonial-m-b-60">

                <?php include($this->mi_get_plugin_style_path('display_mode/style_one')); ?>

            </div><!-- /.mi-testimonial-col-md-2 mi-testimonial-col-sm-2 -->
        <?php endforeach; ?>

    </div><!-- /.mi-testimonial-row -->
</div>
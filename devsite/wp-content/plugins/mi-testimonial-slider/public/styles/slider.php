<div class="<?php echo $mi_testimonial_main_class_default; ?>">
    <div class="<?php echo $mi_testimonial_wrap_class_default . $mi_testimonial_slider_wrapper; ?>"
         data-owl-options='{"margin":20,"loop":true,"nav":<?php echo $mi_testimonial_has_nav; ?>,"dots":<?php echo $mi_testimonial_has_dot; ?>,"responsiveClass":true,"responsive":{"0":{"items":<?php echo $mi_testimonial_small_mobile_number_of_grid; ?>},"480":{"items":<?php echo $mi_testimonial_mobile_number_of_grid; ?>},"768":{"items":<?php echo $mi_testimonial_tab_number_of_grid; ?>},"992":{"items":<?php echo $mi_testimonial_desktop_number_of_grid; ?>},"1200":{"items":<?php echo $mi_testimonial_large_desktop_number_of_grid; ?>}}}'>

        <?php foreach ($mi_testimonial_testimonials as $testimonial): ?>

            <?php include($this->mi_get_plugin_style_path('display_mode/style_one')); ?>

        <?php endforeach; ?>

    </div><!-- /.mi-testimonial-owl-carousel -->
</div>
<div class="<?php echo $mi_testimonial_default_block;?>">
    <div class="<?php echo $mi_testimonial_block_quote; ?>">
        <p class="<?php echo $mi_testimonial_block_para; ?>">
            “<?php echo $testimonial->description; ?>”
        </p>
    </div>
    <div class="<?php echo $mi_testimonial_default_media_block; ?>">
        <div class="mi-testimonial-block__media-left">
            <a href="#">
                <img class="mi-testimonial-block__media-object" src="<?php echo $testimonial->author_image; ?>" alt="<?php echo $testimonial->author_name; ?>">
            </a>
        </div>
        <div class="mi-testimonial-block__media-body">
            <h4 class="mi-testimonial-block__heading"><?php echo $testimonial->author_name; ?></h4>

            <?php if ($mi_testimonial_author_designation=='yes'): ?>
                <h5 class="mi-testimonial-block__subheading"><?php echo $testimonial->designation; ?></h5>
            <?php endif;?>

        </div>
    </div>
</div><!-- /.mi-testimonial-block -->

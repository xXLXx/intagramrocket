if (!Array.isArray) {
    Array.isArray = function(arg) {
        return Object.prototype.toString.call(arg) === '[object Array]';
    };
}

(function ($) {
    'use strict';

    function removeHTML(text) {
        return text
            .replace(/&/g, "")
            .replace(/</g, "")
            .replace(/>/g, "")
            .replace(/"/g, "")
            .replace(/'/g, "");
    };


    //id generator
    function getRandId() {
        return ("0000" + (Math.random()*Math.pow(36,4) << 0).toString(36)).slice(-4)
    };


    (function( $ ) {

        var mi_tab_defaults = {
            activeLinkClass		: 'tab-current',
            activeSectionClass	: 'content-current'
        };

        var MI_Testimonial_Tab = function( $element, options ) {
            this.$element 		= $element;
            this.config 		= $.extend({}, mi_tab_defaults, options);
            this.tabs 			= this.$element.find( this.config.tabLinksSelector ).find('a');
            this.tabConWrap 	= this.$element.find( this.config.tabContentSelector );

            this.initialize();
        };

        MI_Testimonial_Tab.prototype.initialize = function() {

            var that = this;

            this.tabs.on('click', function(e){

                if ( e ) {
                    e.preventDefault();
                }

                if ( $(this).parent().hasClass( that.config.activeLinkClass ) ) { return }

                $(this).parent().addClass( that.config.activeLinkClass ).siblings().removeClass( that.config.activeLinkClass );

                that.tabConWrap.find( $(this).attr('href') ).addClass( that.config.activeSectionClass ).siblings().removeClass( that.config.activeSectionClass );

            });

        };

        $.fn.miTestimonialTab = function( options ) {
            $(this).each(function(){
                new MI_Testimonial_Tab( $(this), options );
            });
        }

    })( jQuery );



    jQuery(document).ready(function ($) {

        $('#mi-plugin-add-more-slide').on('click', function(){
            alert('This is premium feature, if you need to add more please purchase the premium plugin.');
        });


        /*For Style One*/
        var $style_one_slider_style_view = $('.style-one-slider-style-view');
        var $style_one_layouts = $('.style-one-layouts');
        var $style_one_nav_position = $('.style_one_nav_position');

        function changeStateOne(val) {
            if( val == 'combo_slider_one' || val == 'combo_slider_two' ) {
                $style_one_slider_style_view.find('option[value=dot]').hide();
                $style_one_slider_style_view.find('option[value=both]').hide();
                $style_one_nav_position.find('option[value=center]').hide();
            } else {
                $style_one_slider_style_view.find('option[value=dot]').show();
                $style_one_slider_style_view.find('option[value=both]').show();
            }
        }

        $style_one_layouts.on('change', function (e) {
            changeStateOne( $(this).val() );
        });
        changeStateOne( $style_one_layouts.val() );



        var $testimonial_data = $('.mi_testimonial_data'); // image hidden field value

        var categories = []; // categories array
        var data;




        function get_the_testimonial_data() {
            var testimonials = $testimonial_data.val();
            if( testimonials ) {
                testimonials = JSON.parse(testimonials);
            }
            return testimonials;

        } // save all value in logos variable

        get_the_testimonial_data();

        // Uploading files
        var file_frame;
        var wp_media_post_id = '';
        if(!wp.media )return;
        wp_media_post_id = wp.media.model.settings.post.id;

        // Store the old id
        //var set_to_post_id = <?php //echo $my_saved_attachment_post_id; ?>; // Set this

        jQuery('#image-list').delegate('.upload_image_button, .mi-testimonial-thumb-change', 'click', function (event) {

            event.preventDefault();

            var $this = $(this);
            var $parent = $this.closest('td');
            var $parent_tr = $this.closest('tr');


            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Select a image to upload',
                button: {
                    text: 'Use this image',
                },
                multiple: false, // Set to true to allow multiple files to be selected
                library: { type : 'image' }
            });

            // When an image is selected, run a callback.
            file_frame.on('select', function () {


                // We set multiple true
                var attachment = file_frame.state().get('selection').toJSON()[0];
                var $image_wrapper = "<div class='thumb-wrapper-div'><img src='"+attachment.url+"' alt='"+attachment.alt+"' title='"+attachment.title+"' width='40px' height='40px' /><a href='#' class='mi-testimonial-thumb-change'>Change</a></div>";

                $parent.find('.mi_testimonial_author_image').val(attachment.url);

                $parent.find('.thumb-wrapper-div').remove();
                $parent.prepend($image_wrapper);
                $this.remove();

                //Update The ID
                if( !$parent_tr.data('testimonial-id') ) {
                    $parent_tr.data('testimonial-id', getRandId());
                }
                $parent_tr.find('.mi_testimonial_id').val( $parent_tr.data('testimonial-id') );


                // Restore the main post ID
                // wp.media.model.settings.post.id = wp_media_post_id;
            });
            // Finally, open the modal
            file_frame.open();
        });

        // Restore the main ID when the add media button is pressed
        jQuery('a.add_media').on('click', function () {
            wp.media.model.settings.post.id = wp_media_post_id;
        });


        $('.image-preview-wrapper').delegate('.mi-testimonial-single input,.mi-testimonial-single textarea, .mi-testimonial-single select', 'change', function () {

            var $this = $(this);
            var $parent = $this.closest('tr.mi-testimonial-single');

            // Update The ID
            if( !$parent.data('testimonial-id') ) {
                $parent.data('testimonial-id', getRandId());
            }
            $parent.find('.mi_testimonial_id').val( $parent.data('testimonial-id') );

            // Update The All Tetimonial values
            var testimonial_add_new_data = $('.testimonial_repeater').repeaterVal()['add_more_testimonial'];
            $testimonial_data.val(JSON.stringify(testimonial_add_new_data));

        });


        $('.image-preview-wrapper').delegate('.mi-testimonial-remove', 'click', function (e) {
            e.preventDefault();

            var $this = $(this);

            if (typeof data == 'undefined') {
                data = $testimonial_data.val();

                data = JSON.parse(data);
            }

            var id = $(this).closest('.mi-testimonial-single').remove().data('testimonial-id');

            data.forEach(function (item) {
                if (item.id == id) {
                    var index = data.indexOf(item);

                    if (index > -1) {
                        data.splice(index, 1);
                    }

                    $testimonial_data.val(JSON.stringify(data));
                }
            });


        });

        $('.testimonial_repeater').repeater(
            {
                defaultValues: {
                    'id': 0,
                },
                show: function () {
                    $(this).slideDown();
                    var id = getRandId();

                    if( $(this).hasClass('mi-testimonial-single') ) {
                        $(this).find('.br-widget').remove();
                        $(this).find('.column-thumb .thumb-wrapper-div').remove();
                        $(this).find('.column-thumb .upload_image_button').show();
                        update_rating();
                    }

                },
                hide: function (deleteElement) {

                    if(confirm('Are you sure you want to delete this element?')) {

                        $(this).slideUp(deleteElement);
                        var mi_cat = $('.testimonial_repeater').repeaterVal()['category-group'];
                        var id_value = $(this).closest('tr').children('td.column-id').find('input').val();

                        mi_cat.forEach(function (item) {
                            if (item.id == id_value) {
                                var index = mi_cat.indexOf(item);


                                if (index > -1) {
                                    mi_cat.splice(index, 1);
                                }



                            }
                        });
                    }
                }

            }
        );


        $(window).on('load', function () {
            $('.mi-tab-testimonial').miTestimonialTab({
                tabLinksSelector	: '.mi-testimonial-tabs-control',
                tabContentSelector	: '.mi-testimonial-tabs-content'
            });

        });


        /*dependancy function*/
        function input_field_swapping(inputClass, inputValue, targatedDiv, inverse) {

            var obtain_value;

            obtain_value = $(inputClass).val();

            var $tgDiv = $(targatedDiv);

            var valueTypeArray = Array.isArray(inputValue);

            $tgDiv.hide();

            if (inverse && obtain_value !== '') {
                $tgDiv.show();
            }

            function div_calculate() {
                obtain_value = $(inputClass).val();

                $tgDiv.hide();

                if (inverse) {
                    $tgDiv.show();
                }

                if (valueTypeArray) {

                    inputValue.forEach(function (element) {

                        if (obtain_value === element) {
                            if ($tgDiv.is(':hidden')) {
                                $tgDiv.show();
                            }

                            if (inverse) {
                                $tgDiv.hide();
                            }
                        }
                    })

                } else {

                    if (obtain_value === inputValue) {
                        $tgDiv.show();

                        if (inverse) {
                            $tgDiv.hide();
                        }
                    }
                }
            }


            $(inputClass).on('change', function () {

                div_calculate()
            });

            $(window).on('load', function () {
                div_calculate()
            })

        }

        $('.color-field').wpColorPicker();


        /*For Style One*/
        input_field_swapping('#display_mode', 'style_one', '.style-one');



        /*For Style One*/
        input_field_swapping('.style-one-layouts', ['slider','combo_slider_one','combo_slider_two'], '.style-one-show-slider-option');
        input_field_swapping('.style-one-layouts', 'slider', '.style-one-both-show-slider-option');
        input_field_swapping('.style-one-layouts', ['combo_slider_one','combo_slider_two'], '.style-one-combo-slider-position,.hide-dot-combo');
        input_field_swapping('.style-one-layouts', 'filter', '.style-one-show-filter-option');
        input_field_swapping('.style-one-slider-style-view', 'dot', '.style-one-dot-position, .style-one-dot-color');
        input_field_swapping('.style-one-slider-style-view', 'nav', '.style-one-nav-position, .style-one-nav-color');
        input_field_swapping('.style-one-slider-style-view', 'both', '.style-one-slider-both-view');

        /*Common Styles*/
        input_field_swapping('.author-designation', 'yes', '.show-author-designation');



    });

})(jQuery);
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="wrap mi-plugin-wrapper mi-plugin-display-main">
	<div class="mi-plugin-container">

		<h1 class="mi-plugin-page-title">
			<?php echo esc_html__( 'MI Testimonial &amp; Settings', 'mi_testimonial' ); ?>
		</h1>
		<?php




		$created_row_values = get_option('_mi_testimonial_items');
		if(gettype($created_row_values) === 'array'):
		?>
		<table class="wp-list-table widefat fixed striped mi-plugin-table">
			<thead>
			<tr>
				<th scope="col" class="column-title"><?php esc_html_e('Title', 'mi_testimonial'); ?></th>
				<th scope="col" class="column-shortcode"><?php esc_html_e('Shortcode', 'mi_testimonial'); ?></th>
				<th scope="col" class="column-action"><?php esc_html_e('Edit', 'mi_testimonial'); ?></th>
			</tr>
			</thead>

			<?php foreach ($created_row_values as $created_row_value):?>



			<?php
			$id			=	array_search($created_row_value, $created_row_values);
			$title		=	$created_row_values[$id]['title'];
			$shortcode	=	$created_row_values[$id]['shortcode'];

			?>

			<tbody id="the-list">
			<tr>
				<td class="column-title" data-colname="Title">
					<strong><a class="row-title" href="?page=mi-testimonial&new_testimonial_id=<?php echo $id ;?>&action=edit" aria-label="“<?php echo $title ?>” (Edit)"><?php echo $title; ?></a></strong>
				</td>
				<td class="column-shortcode">
					<input type="text" onfocus="this.select();" readonly="readonly" value="<?php  echo $shortcode; ?>" class="mi-plugin-shortcode">
				</td>
				<td class="column-action" align="center">
					<a href="?page=mi-testimonial&new_testimonial_id=<?php echo $id; ?>&action=edit" class=""><span class="dashicons dashicons-edit"></span></a>

				</td>
			</tr>
			<?php
			endforeach;
			endif;
			?>
			</tbody>
		</table>

		<br>

		<a id="mi-plugin-add-more-slide" href="#" class="button-primary"><?php esc_html_e('Add New', 'mi_testimonial'); ?></a>


	</div>


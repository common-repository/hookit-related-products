<div class="wrap">
	<?php require __DIR__ . '/header.php'; ?>

	<form method="post" action="options.php" novalidate="novalidate">
		<?php settings_fields( 'hookit-recommended-products' ); ?>

		<table class="form-table">
			<tr>
				<th scope="row">
					<label for=view-title"><?php _e( 'Title', 'hookit-recommended-products' ) ?></label>
				</th>
				<td>
					<input 
						name="hookit_recommended_products_viewtitle" 
						type="text" 
						id="viewtitle" 
						aria-describedby="view-title-description" 
						value="<?php form_option( 'hookit_recommended_products_viewtitle' ); ?>" 
						class="regular-text" 
					/>
					<p class="description" id="view-title-description">
						<?php _e( 'Title of the product list on the post page', 'hookit-recommended-products' ) ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for=view-title"><?php _e( 'Products', 'hookit-recommended-products' ) ?></label>
				</th>
				<td>
					<select id="viewproducts" name="hookit_recommended_products_viewproducts" aria-describedby="view-products-description">
						<?php 
							$values = array( 4, 8 );
							$selected = hookit_recommended_products_get_viewproducts();
							foreach ( $values as $value  ) :
						?>
						<option value="<?php echo $value ?>" <?php if( $selected == $value ) : ?>selected="selected"<?php endif; ?>>
							<?php echo $value ?>
						</option>
						<?php endforeach; ?>
					</select>
					<p class="description" id="view-products-description">
						<?php _e( 'The number of products to show on the post page', 'hookit-recommended-products' ) ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for=view-title"><?php _e( 'Token', 'hookit-recommended-products' ) ?></label>
				</th>
				<td>
					<input 
						name="hookit_recommended_products_token" 
						type="text" 
						id="token" 
						aria-describedby="view-title-description" 
						value="<?php form_option( 'hookit_recommended_products_token' ); ?>" 
						class="regular-text" 
					/>
					<p class="description" id="token-description">
						<?php echo sprintf( __( 'Fill with your Hookit token. Not yet registered? <a href="%s" target="_blank">Register here</a>.<br />To discover what is your token, go to your profile on Hookit. The token is a sequence of numbers and letters next to your username.', 'hookit-recommended-products' ), 'http://hookit.cc/join/default' ) ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for=view-title"><?php _e( 'Categories', 'hookit-recommended-products' ) ?></label>
				</th>
				<td>
					<select multiple="multiple" id="categories" name="hookit_recommended_products_categories[]">
						<?php 
							foreach ( get_categories() as $category ) : 
								$selected = hookit_recommended_products_is_active_category( $category ) ? ' selected="selected"' : '';
						?>
						<option value="<?php echo $category->term_id ?>"<?php echo $selected ?>><?php echo $category->name ?></option>
						<?php endforeach; ?>
    				</select>
					<p class="description" id="categories-description">
						<?php _e( 'Select the categories inwhich want the recommended products are displayed.', 'hookit-recommended-products' ) ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for=view-title"><?php _e( 'Signature', 'hookit-recommended-products' ) ?></label>
				</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php _e( 'Signature', 'hookit-recommended-products' ) ?></span>
						</legend>
						<label for="hookit_recommended_products_sign"> 
							<input 
								name="hookit_recommended_products_sign"
								id="hookit_recommended_products_sign" 
								value="1"
								<?php echo hookit_recommended_products_get_sign() ? 'checked="checked"' : '' ?>
								type="checkbox">
								<?php _e( 'Add Hookit signature in the recommended products list.', 'hookit-recommended-products' ) ?>
						</label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for=view-title"><?php _e( 'Gender', 'hookit-recommended-products' ) ?></label>
				</th>
				<td>
					<select id="viewproducts" name="hookit_recommended_products_gender" aria-describedby="view-products-description">
						<?php 
							$values = array( 
								'Both' => __( 'Both', 'hookit-recommended-products' ),
								'Female' => __( 'Female', 'hookit-recommended-products' ),
								'Male' => __( 'Male', 'hookit-recommended-products' ),
							);
							$selected = hookit_recommended_products_get_gender();
							foreach ( $values as $value => $label  ) :
						?>
						<option value="<?php echo $value ?>" <?php if( $selected == $value ) : ?>selected="selected"<?php endif; ?>>
							<?php echo $label ?>
						</option>
						<?php endforeach; ?>
					</select>
					<p class="description" id="view-products-description">
						<?php _e( 'The gender of recommended products.', 'hookit-recommended-products' ) ?>
					</p>
				</td>
			</tr>
		</table>
		
		<?php do_settings_sections( 'hookit-recommended-products' ); ?>
		
		<?php submit_button(); ?>
	</form>
</div>

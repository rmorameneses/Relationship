<?php
$type = str_replace( 'mojo-', '', sanitize_title_for_query( wp_unslash( $_GET['page'] ) ) );
$query = array(
	'category' => 'wordpress',
	'type'     => $type,
	'count'    => 20,
	'order'     => 'sales',
);
if ( isset( $_GET['paged'] ) && is_numeric( $_GET['paged'] ) ) {
	$query['page'] = (int) $_GET['paged'];
} else {
	$query['page'] = 1;
}

if ( 'services' == $type || 'graphics' == $type ) {
	unset( $query['category'] );
}

if ( isset( $_GET['items'] ) ) {
	if ( 'recent' == $_GET['items'] || 'popular' == $_GET['items'] ) {
		$query['order'] = sanitize_title_for_query( $_GET['items'] );
	} else {
		$query['itemcategory'] = sanitize_title_for_query( $_GET['items'] );
	}
}
if ( isset( $_GET['sort'] ) ) {
	if ( 'recent' == $_GET['sort'] || 'popular' == $_GET['sort'] ) {
		$query['order'] = sanitize_title_for_query( $_GET['sort'] );
	}
}

if ( 'graphics' == $type && isset( $query['itemcategory'] ) ) {
	$query['category'] = $query['itemcategory'];
	unset( $query['itemcategory'] );
}

$api_url = add_query_arg( $query, 'https://api.mojomarketplace.com/api/v2/items' );
$response = mm_api_cache( $api_url );
if ( ! is_wp_error( $response ) ) {
	if ( isset( $_GET['items'] ) && 'security-1' == $_GET['items'] ) {
		$_GET['items'] = 'security';
	}
	$api = json_decode( $response['body'] );
	$items = $api->items;

?>
<div id="mojo-wrapper">
	<?php mm_require( MM_BASE_DIR . 'pages/header.php' ); ?>
	<main id="main">
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 col-sm-8">
							<ol class="breadcrumb">

							<?php if ( ! isset( $_GET['items'] ) && $type !== 'graphics' ) {
								echo '<li>WordPress ' . ucfirst( $type ) . '</li>';
							} ?>

							<?php if ( ! isset( $_GET['items'] ) && $type == 'graphics' ) {
								echo '<li>' . ucfirst( $type ) . '</li>';
							} ?>

							<?php if ( isset( $_GET['items'] ) && $type !== 'graphics' ) : ?>
								<li><a href="<?php echo esc_url( add_query_arg( array( 'page' => 'mojo-' . $type ), admin_url( 'admin.php' ) ) ); ?>">WordPress <?php echo ucfirst( $type ); ?></a></li>
							<?php endif; ?>

							<?php if ( isset( $_GET['items'] ) && $type == 'graphics' ) : ?>
								<li><a href="<?php echo esc_url( add_query_arg( array( 'page' => 'mojo-' . $type ), admin_url( 'admin.php' ) ) ); ?>"><?php echo ucfirst( $type ); ?></a></li>
							<?php endif; ?>
								<?php
								if ( isset( $_GET['items'] ) ) {
									?>
									<li class="active"><?php echo mm_slug_to_title( $_GET['items'] ); ?></li>
									<?php
								}
								?>
							</ol>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="list-group">
					<?php
					foreach ( $items as $item ) {
						if ( '0' == $item->prices->single_domain_license ) { continue; }
						?>
						<div class="list-group-item theme-item">
							<div class="row">
								<div class="col-xs-12 col-sm-4 col-md-5">
									<?php
									if ( 'themes' == $type ) {
										if ( isset( $_GET['items'] ) ) {
											$items = sanitize_title_for_query( $_GET['items'] );
										} else {
											$items = 'popular';
										}
										$link = add_query_arg( array( 'page' => 'mojo-theme-preview', 'id' => $item->id, 'items' => $items ), admin_url( 'admin.php' ) );
									} else {
										$link = add_query_arg( array( 'page' => 'mojo-single-item', 'item_id' => $item->id ), admin_url( 'admin.php' ) );
									}
									?>
									<a href="<?php echo $link; ?>">
										<img class="img-responsive" src="<?php echo $item->images->preview_url; ?>" alt="image description" width="367" height="205">
									</a>
								</div>
								<div class="col-xs-12 col-sm-5 col-md-5">
									<div class="description-box">
										<h2><a href="<?php echo $link; ?>"><?php echo apply_filters( 'mm_item_name', $item->name ); ?></a></h2>
										<?php if ( isset( $item->short_description ) ) { echo $item->short_description; } ?>
										<p><?php if ( isset( $item->tags ) ) { echo '<strong>Tags: </strong>' . substr( $item->tags, 0, 120 ) . '&hellip;'; } ?></p>
										<?php mm_stars( $item->rating, $item->sales_count ); ?>
									</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-2">
									<div class="text-center info-box">
										<div class="price">
											<span class="currency">USD</span>
											<span class="price-number">$<span><?php echo number_format( $item->prices->single_domain_license ); ?></span></span>
										</div>
										<div class="btn-group-vertical" role="group">
											<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'mojo-single-item', 'item_id' => $item->id ), admin_url( 'admin.php' ) ) ); ?>" class="btn btn-primary btn-lg">Details</a>
											<a href="<?php echo mm_build_link( add_query_arg( array( 'item_id' => $item->id ), 'https://www.mojomarketplace.com/cart' ), array( 'utm_medium' => 'plugin_admin', 'utm_content' => 'buy_now_list' ) ); ?>" class="btn btn-success btn-lg">Buy Now</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
					?>
					</div>
				</div>
			</div>
			<?php mm_pagination( $api->page, $api->pageCount ); ?>
		</div>
	</main>
</div>
	<?php
}

<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package haaja
 */

$search_query = $_GET['s'];

get_header(); ?>

	<div class="page-hero">

	</div>

	<?php mikkeli_breadcrumbs(); ?>

	<div id="content" class="site-content cf">
		<div class="container">
			<main class="site-main">

			<h1><?php _e('Haku', 'mikkeli'); ?></h1>

			<div class="search-form">
				<form role="search" <?php echo $mikkeli_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?> method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label for="<?php echo esc_attr( $mikkeli_unique_id ); ?>"><?php _e( 'Haku', 'mikkeli' ); // phpcs:ignore: WordPress.Security.EscapeOutput.UnsafePrintingFunction -- core trusts translations ?></label>
					<input type="search" id="<?php echo esc_attr( $mikkeli_unique_id ); ?>" class="search-field" value="<?php echo get_search_query(); ?>" name="s" />
					<button value="<?php echo esc_attr_x( 'Hae', 'submit button', 'mikkeli' ); ?>"><?php echo esc_attr_x( 'Hae', 'mikkeli' ); ?></button>
				</form>
			</div>

			<div role="group" class="results-filters" style="margin-bottom: 20px;">
				<button id="page" class="filter-tab current" tabindex="0" type="button"><span class="label"><?php _e('Sivut', 'mikkeli'); ?></span></button><button id="post" class="filter-tab" tabindex="0" type="button"><span class="label"><?php _e('Uutiset', 'mikkeli'); ?></span></button><button id="attachment" class="filter-tab" tabindex="0" type="button"><span class="label"><?php _e('Tiedostot', 'mikkeli'); ?></span></button><button id="oppiminen" class="filter-tab" tabindex="0" type="button"><span class="label"><?php _e('Oppiminen.fi', 'mikkeli'); ?></span></button>
			</div>

			<?php
			use Metatavu\Mikkeli\Theme\Elastic\ResultLoader;
			$resultLoader = new ResultLoader();
			$pages = $resultLoader->load_from_elastic($search_query, "page", 1);
			$posts = $resultLoader->load_from_elastic($search_query, "post", 1);
			$attachments = $resultLoader->load_from_elastic($search_query, "attachment", 1);
			$oppiminen = $resultLoader->load_from_elastic($search_query, "oppiminen", 1);

			?>
			<div class="results">
				<div id="page" class="results-tab-container">
					<div id="displayResults">
					<?php foreach($pages["results"] as $page): ?>
						<div class="item">
							<a title="<?php echo $page["title"]; ?>" href="<?php echo $page["url"]; ?>"><img src="<?php echo $page["image_url"]; ?>" alt="<?php echo $page["title"]; ?>" width="120" height="60" /></a>
							<div>
								<p><?php echo date('d.m.Y', strtotime($page["date"])); ?> - <a title="<?php echo $page["title"]; ?>" href="<?php echo $page["url"]; ?>"><?php echo $page["title"]; ?></a></p>
								<p><?php echo $page["summary"]; ?></p>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
					<?php if($pages["number_of_pages"] > 1): ?>
					<div class="page-navigation">
						<span class="prevpage">Edellinen sivu</span> <span class="page-number"><?php _e('Sivu', 'mikkeli'); ?> <span>1</span></span> <span class="nextpage"><a href="">Seuraava sivu</a></span>
						<span class="number-of-pages"><?php echo $pages["number_of_pages"]; ?></span>
					</div>
					<?php endif; ?>
				</div>

				<div id="post" class="results-tab-container">
					<div id="displayResults">
					<?php foreach($posts["results"] as $post): ?>
						<div class="item">
							<a title="<?php echo $post["title"]; ?>" href="<?php echo $post["url"]; ?>"><img src="<?php echo $post["image_url"]; ?>" alt="<?php echo $post["title"]; ?>" width="120" height="60" /></a>
							<div>
								<p><?php echo date('d.m.Y', strtotime($post["date"])); ?> - <a title="<?php echo $post["title"]; ?>" href="<?php echo $post["url"]; ?>"><?php echo $post["title"]; ?></a></p>
								<p><?php echo $post["summary"]; ?></p>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
					<?php if($posts["number_of_pages"] > 1): ?>
					<div class="page-navigation">
						<span class="prevpage">Edellinen sivu</span> <span class="page-number"><?php _e('Sivu', 'mikkeli'); ?> <span>1</span></span> <span class="nextpage"><a href="">Seuraava sivu</a></span>
						<span class="number-of-pages"><?php echo $posts["number_of_pages"]; ?></span>
					</div>
					<?php endif; ?>
				</div>

				<div id="attachment" class="results-tab-container">
					<div id="displayResults">
					<?php foreach($attachments["results"] as $attachment): ?>
						<div class="item">
							<a title="<?php echo $attachment["title"]; ?>" href="<?php echo $attachment["url"]; ?>"><img src="<?php echo $attachment["image_url"]; ?>" alt="<?php echo $attachment["title"]; ?>" width="120" height="60" /></a>
							<div>
								<p><?php echo date('d.m.Y', strtotime($attachment["date"])); ?> - <a title="<?php echo $attachment["title"]; ?>" href="<?php echo $attachment["url"]; ?>"><?php echo $attachment["title"]; ?></a></p>
								<p><?php echo $attachment["summary"]; ?></p>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
					<?php if($attachments["number_of_pages"] > 1): ?>
					<div class="page-navigation">
						<span class="prevpage">Edellinen sivu</span> <span class="page-number"><?php _e('Sivu', 'mikkeli'); ?> <span>1</span></span> <span class="nextpage"><a href="">Seuraava sivu</a></span>
						<span class="number-of-pages"><?php echo $attachments["number_of_pages"]; ?></span>
					</div>
					<?php endif; ?>
				</div>

				<div id="oppiminen" class="results-tab-container">
					<div id="displayResults">
					<?php foreach($oppiminen["results"] as $oppiminen_page): ?>
						<div class="item">
							<a title="<?php echo $oppiminen_page["title"]; ?>" href="<?php echo $oppiminen_page["url"]; ?>"><img src="<?php echo $oppiminen_page["image_url"]; ?>" alt="<?php echo $oppiminen_page["title"]; ?>" width="120" height="60" /></a>
							<div>
								<p><?php echo date('d.m.Y', strtotime($oppiminen_page["date"])); ?> - <a title="<?php echo $oppiminen_page["title"]; ?>" href="<?php echo $oppiminen_page["url"]; ?>"><?php echo $oppiminen_page["title"]; ?></a></p>
								<p><?php echo $oppiminen_page["summary"]; ?></p>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
					<?php if($oppiminen["number_of_pages"] > 1): ?>
					<div class="page-navigation">
						<span class="prevpage">Edellinen sivu</span> <span class="page-number"><?php _e('Sivu', 'mikkeli'); ?> <span>1</span></span> <span class="nextpage"><a href="">Seuraava sivu</a></span>
						<span class="number-of-pages"><?php echo $oppiminen["number_of_pages"]; ?></span>
					</div>
					<?php endif; ?>
				</div>
			</div>

			</main>
		</div>
	</div>

<?php
get_footer();

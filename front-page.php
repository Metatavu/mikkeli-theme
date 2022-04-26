<?php
/**
	
 Template Name: Etusivu

 * The template for displaying front page.
 *
 * Contains the closing of the #content div and all content after.
 * Initial styles for front page template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/template-partials
 *
 * @package haaja
 */

get_header(); ?>

	<div class="hero-slides">
		<div class="slide">
			<div class="hero__content">
				<h1>Live like<br />Mikkeli.</h1>
			</div>
			<img src="<?php echo IMAGES; ?>/hero.jpg" alt="" />
		</div>
	</div>

	<section id="content" class="front-content">
		<div class="container">
			<div class="left-side">
				<div class="articles-container">
				<?php
				global $post;
				$myposts = get_posts( array(
					'posts_per_page' => 4,
					'post_type' => 'post'
				) );
				
				if ( $myposts ):
					foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
					<article class="post">
							<a href="<?php the_permalink(); ?>">
								<div class="post-thumb">
									<?php the_post_thumbnail('post'); ?>
									<span class="entry-time">
										<time datetime="<?php the_time('c'); ?>">
											<?php the_time('j.n.Y'); ?>
										</time>
									</span>
								</div>
							</a>
							<span class="title"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
					</article>
				<?php
						endforeach;
						wp_reset_postdata();
					endif;
				?>
				</div>
				<?php
				global $post;
				$myposts = get_posts( array(
					'offset' => 4,
					'posts_per_page' => 3,
					'post_type' => 'post'
				) );
				
				if ( $myposts ): ?>
				<div class="text-articles">
				<?php	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
					<div class="text-article">
						<div class="date">
							<time datetime="<?php the_time('c'); ?>">
								<?php the_time('j.n.Y'); ?>
							</time>
						</div>
						<div class="title"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
					</div>
				<?php
					endforeach;
					wp_reset_postdata(); ?>
				</div>
				<?php	endif; ?>
				<a class="all-news-link" title="<?php _e('Katso kaikki uutiset', 'mikkeli'); ?>" href="<?php echo get_permalink( get_option('page_for_posts') ); ?>">&rsaquo; <?php _e('Katso kaikki uutiset', 'mikkeli'); ?></a>
			</div>
			<div class="right-side">
				<?php if ( have_rows( 'nostolaatikot' ) ) : ?>
				<div class="tiles">
					<?php while ( have_rows( 'nostolaatikot' ) ) : the_row();
						$bg_image = get_sub_field('taustakuva');
						$link = get_sub_field('linkki');
						$link_url = $link['url'];
						$link_title = $link['title'];
						$link_target = $link['target'] ? $link['target'] : '_self';
					?>
					<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
						<div class="tile"<?php if($bg_image): ?> style="background-image: url(<?php echo $bg_image; ?>);"<?php endif; ?>>
							<h2><?php the_sub_field('otsikko'); ?></h2>
							<div class="tile-text">
								<p><?php echo esc_html( $link_title ); ?></p>
								<span class="fa fa-angle-right"></span>
							</div>
						</div>
					</a>
					<?php endwhile; ?>
				</div>
				<?php endif; ?>
				<?php $urls = get_field('suosituimmat'); if ( $urls ) : ?>
				<div class="menu-most-popular">
					<h3><?php _e('Suosituimmat', 'mikkeli'); ?></h3>
					<ul>
					<?php foreach( $urls as $url ): 
					$permalink = get_permalink( $url->ID );
					$title = get_the_title( $url->ID );	
					?>
						<li class="nav-item">
							<a class="nav-link" title="<?php echo esc_html( $title ); ?>" href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?> <span class="fa fa-angle-right"></span></a>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="fp-blocks">
	  <div class="container">
			<div class="col info-block">
				<div class="icon"></div>
				<?php the_field('osallistu_ja_vaikuta'); ?>
				<?php if(get_field('osallistu_ja_vaikuta-linkki')):
					$link = get_field('osallistu_ja_vaikuta-linkki');
					$link_url = $link['url'];
					$link_title = $link['title'];
				?>
				<p><a title="<?php echo esc_html( $link_title ); ?>" class="all-link" href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_title ); ?></a></p>
				<?php endif; ?>
			</div>
			<div class="col jobs-block">
				<div class="icon"></div>
				<h4><?php _e('Avoimet työpaikat', 'mikkeli'); ?></h4>
				<?php
					$feed = implode(file('https://www.kuntarekry.fi/fi/tyopaikat/?&organisation=3677&lang=fi_FI,sv_SE&sort=-changetime&limit=500&format=xml'));
					$xml = simplexml_load_string($feed);
					$json = json_encode($xml);
					$array = json_decode($json,TRUE);
					$i = 0;
					foreach ($array["job"] as $job) {
						if(++$i <= 5) {
							$jobtitle = $job["jobtitle"];
							$link = $job["url"];
							$description = $job["employmenttype"];
							$title = $job["taskarea"];
							echo '<p><a title="'.$jobtitle.'" href="'.$link.'">'.$job["jobtitle"] . '</a><br /><span>'.$description.', '.$title.'</span></p>';
						}
					}
				?>
				<p><a title="<?php _e('Katso kaikki', 'mikkeli'); ?>" class="all-link" href="<?php echo home_url( '/' ); ?>tyot"><?php _e('Katso kaikki', 'mikkeli'); ?></a></p>
			</div>
			<div class="col announcements-block">
			  <div class="icon"></div>
				<h4><?php _e('Kuulutukset', 'mikkeli'); ?></h4>
				<p>[feed]</p>
				<p><a title="<?php _e('Katso kaikki', 'mikkeli'); ?>" class="all-link" href="<?php echo home_url( '/' ); ?>kuulutukset"><?php _e('Katso kaikki', 'mikkeli'); ?></a></p>
			</div>
		</div>
	</section>
	
<?php
get_footer();

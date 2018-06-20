<?php
/*
Template Name: Web/UI Dev
*/
get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>
    <div class="main-container">
        <div class="main-grid">
            <main class="main-content-full-width">
                <?php
                // Retrieve Web Projects
                $webargs = array(
                    'post_type' => 'web_development',
                        //,
                    'order'=>'ASC',
                    'posts_per_page'=>-1,
                    'meta_query'=> array(
                         array(
                            'key'=>'web_demo_or_live',
                            'value'=>'live',
                        ),
                        // Imag check
                        array(
                            'key'		=>'web_image_1'
                        ) // If the entry doesn't have a main image loaded, then don't include in slides
                    )
                );

                $webloop = new WP_Query( $webargs );
                $webthumbs = array();


                while ( $webloop->have_posts() ) : $webloop->the_post();
                    //Full description text -- Should probably be project description text
                    //echo the_content();

                    // Retrieve ID
                    $t = get_post_custom($post->ID);

                    // Img request Produces this code:
                    #  <img src="http://localhost/Visuale/Site2013/wp-content/uploads/rafo-190x115.jpg" class="attachment-thumbnail" />


                    $thumbnail_array[] =  array(
                    'thumb'             =>wp_get_attachment_image($t['web_image_1'][0], 'thumb',false, array('data-id'=>$post->ID)),
                    'medium'            =>wp_get_attachment_image($t['web_image_1'][0], 'medium',false, array('data-id'=>$post->ID)),
                    'title'             =>get_the_title(),
                    'id'                =>$post->ID,
                    'in_brief'          =>$post->web_client_notes,
                    'vis_notes'         =>$post->web_project_notes,
                    'programming_langs' =>$post->web_programming_languages,

                    );

                endwhile;


                $slide_tray_count = 9;

                // Remove any values from array that prevent the total count from being evenly divided according to the
                // the requested slide tray count. Function located in theme/functions.php
                $thumbnail_array = array_pop_n($thumbnail_array,$slide_tray_count);

                // Grouping
                $thumb_trays = array_chunk($thumbnail_array,ceil($slide_tray_count),true);

                // Place vals into "trays"
                foreach($thumb_trays as $tray) {
                    ?>
                <div class="slide-tray grid-container fluid" style="border:1px solid red;">
                    <div class="grid-x grid-margin-x align-stretch grid-slideshow">
                    <?php
                    foreach($tray as $k=>$v) {
                        ?>
                        <div class="slide cell small-4">
                            <div class="cell-img">
                                <?php echo $v['medium']; ?>
                            </div>
                            <div class="cell-title">
                                <?php echo $v['title']; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    </div><!-- / .grid-x .grid-margin-x -->
                </div><!-- / .grid-container -->

                    <?php
                }
                ?>

                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content', 'page' ); ?>
                    <?php comments_template(); ?>
                <?php endwhile; ?>
            </main>
        </div>
    </div>
<?php get_footer();

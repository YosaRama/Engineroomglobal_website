<?php
    $pixe_section_title_img = get_post_meta( get_queried_object_id(), 'pixe_section_title_img', true );
    if($pixe_section_title_img =='')
    $pixe_section_title_img = get_theme_mod( 'heading_img','');
    $text_alignment = get_theme_mod( 'aling_titles', 'center' );
    $pixe_page_title_hr = get_theme_mod( 'show_hr_divider', false );
    $pixe_section_title = get_post_meta( get_queried_object_id(), 'pixe_section_title', true );
	if ( ( get_theme_mod( 'show_section_title', true ) || $pixe_section_title === 'enable') && $pixe_section_title != 'disable' && !is_singular( 'post' )) {
?>

<?php 
    if(get_post_type() == 'service'){
        if(get_the_post_thumbnail_url(get_queried_object_id())){
            $pixe_section_title_img = esc_url(get_the_post_thumbnail_url(get_queried_object_id()));
        }
    }

    $page_title = wp_kses_post( pixe_title() );
    if(get_field('subtitle', get_queried_object_id()) && get_field('subtitle', get_queried_object_id()) != '') $page_subtitle = get_field('subtitle', get_queried_object_id());
    else $page_subtitle = '';
    if(is_post_type_archive('portfolio')){
        $page_title = 'Portfolio';
        $page_subtitle = 'End to End Marketing Service';
        $pixe_section_title_img = '/wp-content/uploads/2020/07/er-portfolio-header-3.jpg';
    }
?>


<div class="section-title thumbnail-bg <?php echo esc_attr($text_alignment); ?>" <?php if($pixe_section_title_img ){ ?> style="background-image: url('<?php echo esc_url( $pixe_section_title_img ); ?>')"<?php }?> >

    <div class="uk-container">
        <div class="inner page-title-inner">
            <?php if( $pixe_page_title_hr == true ){?>
                <hr class="pr-page-title-hr">
            <?php } ?>
            <h1 class="entry-title"><?php echo $page_title; ?></h1>

            <?php if($page_subtitle != ''): ?>
                <h2 class="page-subtitle"><?php echo $page_subtitle; ?></h2>
            <?php endif; ?>

            <?php
                $pixe_breadcrumbs = get_post_meta( get_queried_object_id(), "pixe_breadcrumbs_show", true );
                if ( ( true == get_theme_mod( 'show_breadcrumbs', false ) || $pixe_breadcrumbs === 'enable') && $pixe_breadcrumbs != 'disable' && !is_front_page()) {
            
                    get_template_part('components/navigation/breadcrumbs');
                }
            ?>
        </div>
    </div>
</div>
<?php } ?>

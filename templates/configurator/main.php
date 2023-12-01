<h1 class="color-primary margin-bottom-md text-center">Der ErgoPack Konfigurator</h1>

<div class="grid gap-lg">
    <?php if( $lines ): ?>
        <?php foreach( $lines as $line ): ?>
        <div class="col-6@lg text-center">
            <h1 class="text-lg"><a href="<?php echo esc_url($url . $line->slug) ?>"><?php echo esc_html($line->name) ?></a></h1>

            <?php
            $image_id = get_term_meta( $line->term_id, 'epp_line_image', true );
            $image = wp_get_attachment_url( $thumbnail_id );
            $image_attributes = wp_get_attachment_image_src( $image_id, 'medium' );
            if ( $image_attributes ) : ?>
                <a href="<?php echo esc_url($url . $line->slug) ?>"><img src="<?php echo $image_attributes[0]; ?>" /></a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
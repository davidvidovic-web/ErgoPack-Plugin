<h1 class="color-primary margin-bottom-md text-center"><?php echo esc_html__('Der ErgoPack Konfigurator','ergo'); ?></h1>

<div class="grid gap-lg">
    <div class="col-3@lg">
        <div class="tabs js-tabs">
            <div class="js-tabs__panels">
                <section id="tab1Panel11" class="padding-top-md js-tabs__panel">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/machine.png" class="block margin-auto">
                </section>
            </div>
            <ul class="flex flex-wrap gap-sm js-tabs__controls" aria-label="Tabs Interface">
                <li><a href="#tab1Panel11" class="tabs__control" aria-selected="true">Tab 1</a></li>
            </ul>
        </div>

    </div>
    <div class="col-9@lg">
        <h2 class="margin-bottom-sm"><?php echo esc_html($line->name) ?></h2>
        <p><?php echo $line->description ?></p>

        <?php if( $products ): ?>
            <form action="#" method="post" id="eppConfForm">
                <div id="eppProductModel">
                    <p class="margin-top-sm"><strong>Modelle</strong></p>
                    <div class="choice-checkbox__wrapper margin-top-xs">
                        <?php foreach( $products as $product ): ?>
                        <input id="eppConfModel<?php echo $product->ID ?>" type="radio" name="epp_conf_model" value="<?php echo $product->ID ?>" class="choice-checkbox">
                        <label for="eppConfModel<?php echo $product->ID ?>"><?php echo $product->post_title ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="circle-loader circle-loader--v1" role="alert">
                    <p class="circle-loader__label"><?php echo esc_html__('Content is loading...','ergo'); ?></p>
                    <div id="eppFeedbackLoader" aria-hidden="true">
                        <div class="circle-loader__circle"></div>
                    </div>
                </div>
                
                <div id="eppProductError" class="is-hidden"></div>
                <div id="eppProductFeedback"></div>

                <button type="button" id="eppConfSubmit" class="btn btn--primary margin-top-lg"><?php echo esc_html__('Angebot erstellen','ergo'); ?></button>
                <input type="hidden" name="action" value="epp_save_configuration">
            </form>
         <?php endif; ?>
    </div>
</div>
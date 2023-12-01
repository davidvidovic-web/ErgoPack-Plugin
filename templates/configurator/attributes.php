<ul class="accordion  js-accordion" data-animation="on" data-multi-items="on">

    <?php if( $attributes ):
    foreach( $attributes as $attribute_key => $attribute ):
        $suffix_term_name = 'epp_conf_options['.$attribute->get_taxonomy().']';
        ?>
    <li class="accordion__item js-accordion__item">
        <button class="reset accordion__header padding-y-sm js-tab-focus"
                type="button">
            <span class="text-md"><?php echo wc_attribute_label($attribute->get_taxonomy()) ?></span>

            <svg class="icon accordion__icon-arrow no-js:is-hidden" viewBox="0 0 16 16"
                 aria-hidden="true">
                <g class="icon__group" fill="none" stroke="currentColor" stroke-linecap="square"
                   stroke-miterlimit="10">
                    <path d="M2 2l12 12"/>
                    <path d="M14 2L2 14"/>
                </g>
            </svg>
        </button>

        <div class="accordion__panel js-accordion__panel">
            <div class="text-component padding-top-xxxs  padding-bottom-md">
                <div class="choice-checkbox__wrapper margin-top-xs">
                    <?php foreach( $this->get_attribute_options($attribute->get_options(), $attribute->get_taxonomy()) as $term ): ?>
                        <?php if(is_array($term->opts)): ?>
                            <!-- Opts -->
                            <?php foreach($term->opts as $opt): ?>
                            <input id="eppChoice<?php echo $term->term_id . sanitize_title($opt) ?>" type="radio" name="<?php echo esc_attr($suffix_term_name) ?>[<?php echo $term->term_id ?>][opts]" value="<?php echo esc_attr($opt) ?>" class="choice-checkbox choice-checkbox--small epp-conf-choice">
                            <label for="eppChoice<?php echo $term->term_id . sanitize_title($opt) ?>"><?php echo esc_html($term->name . ' ' . $opt) ?></label>
                        <?php endforeach; else: ?>
                            <?php $has_children = is_array($term->children) && count($term->children) > 0; ?>
                            <!-- Parent -->
                            <input id="eppChoice<?php echo $term->term_id ?>" type="checkbox" name="<?php echo esc_attr($suffix_term_name) ?>[<?php echo $term->term_id ?>]" value="<?php echo $term->term_id ?>" class="choice-checkbox choice-checkbox--small epp-conf-choice<?php echo $has_children ? ' epp-conf-has-children' : '' ?>" <?php echo sprintf('data-tid="%d"',$term->term_id) ?>>
                            <label for="eppChoice<?php echo $term->term_id ?>"><?php echo $term->name ?></label>
                            <?php if(is_array($term->children)): ?>
                                <!-- Children -->
                                <?php foreach($term->children as $child): ?>
                                <input id="eppChoice<?php echo $term->term_id ?>_child<?php echo $child->term_id ?>" type="checkbox" name="<?php echo esc_attr($suffix_term_name) ?>[<?php echo $term->term_id ?>][childs][<?php echo $child->term_id ?>]" value="<?php echo $child->term_id ?>" class="choice-checkbox choice-checkbox--small epp-conf-choice epp-conf-child epp-conf-child-<?php echo $term->term_id ?>">
                                <label for="eppChoice<?php echo $term->term_id ?>_child<?php echo $child->term_id ?>" class="is-hidden"><?php echo $child->name ?></label>
                            <?php endforeach; endif; ?>
                        <?php endif ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </li>
    <?php endforeach; endif ?>
</ul>
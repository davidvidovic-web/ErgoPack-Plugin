<h3><?php echo esc_html__('Zusätzlicher Ansprechpartner','ergo'); ?></h3>
<div class="grid gap-md">
    <div class="col-3">
        <?php
        woocommerce_form_field( 'epp_second_contact_salutation', array(
            'type'	=> 'select',
            'required' => false,
            'label'	=> __('Anrede','ergo'),
            'options' => $salutations
        ) );
        ?>
    </div>
    <div class="col-3">
        <?php
        woocommerce_form_field( 'epp_second_contact_title', array(
            'type'	=> 'select',
            'required' => false,
            'label'	=> __('Titel','ergo'),
            'options' => $titles
        ) );
        ?>
    </div>
    <div class="col-3">
        <?php
        woocommerce_form_field( 'epp_second_contact_firstname', array(
            'type'	=> 'text',
            'required' => false,
            'label'	=> __('Vorname','ergo')
        ) );
        ?>
    </div>
    <div class="col-3">
        <?php
        woocommerce_form_field( 'epp_second_contact_lastname', array(
            'type'	=> 'text',
            'required' => false,
            'label'	=> __('Nachname','ergo')
        ) );
        ?>
    </div>
</div>
<div class="grid gap-md">
    <div class="col-6">
        <?php
        woocommerce_form_field( 'epp_second_contact_email', array(
            'type'	=> 'text',
            'required' => false,
            'label'	=> __('E-Mail-Adresse','ergo')
        ) );
        ?>
    </div>
</div>

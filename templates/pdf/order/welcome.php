<p></p>
<p></p>

<h4><?php echo esc_html__('Ihr persönliches Angebot für Ihr ErgoPack Umreifungssystem','ergo'); ?></h4>

<p></p>
<p></p>
<p><?php echo $new_salutation ?> <?php echo $title ?> <?php echo $billing_lastname ?>,</p>
<?php if( !empty($customer_second_contact_lastname) ): ?>
    <p><?php echo esc_html($new_second_salutation) ?> <?php echo esc_html($customer_second_contact_title) ?> <?php echo esc_html($customer_second_contact_lastname) ?>,</p>
<?php endif ?>

<p></p>

<p><?php echo esc_html__('vielen Dank für Ihr Interesse an unseren ErgoPack Systemen sowie für die wertvollen Einblicke in Ihr Unternehmen.','ergo'); ?><?php echo esc_html__('Basierend auf Ihren Informationen und Anforderungen konnte ich mir ein klares Bild davon machen, welches ErgoPack System am hilfreichsten für Ihre Anwendung ist.', 'ergo'); ?></p>

<p><?php echo esc_html__('Auf den nächsten Seiten biete ich Ihnen, wie besprochen, das für Ihr Unternehmen empfohlene ErgoPack System an.','ergo'); ?></p>

<p></p>

<p><?php echo esc_html__('Bei eventuellen Fragen können Sie mich sehr gerne telefonisch unter','ergo'); ?> <?php echo $seller_phone ?><?php echo esc_html__(' oder per E-Mail unter','ergo'); ?>  <?php echo $seller_email ?><?php echo esc_html__(' jederzeit kontaktieren.','ergo'); ?> </p>

<p></p>
<p></p>

<p><?php echo esc_html__('Herzliche Grüße','ergo'); ?></p>

<p></p>

<p>
<?php echo esc_html__('i. A.','ergo'); ?> <?php echo $seller_fullname ?><br>
<?php echo esc_html('ErgoPack Deutschland GmbH','ergo'); ?>
</p>

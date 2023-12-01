<?php echo esc_html($customer_salutation) ?> <?php echo esc_html($customer_title) ?> <?php echo esc_html($customer_lastname) ?>,
<?php if( !empty($customer_second_contact_lastname) ): ?>
<br>
<?php echo esc_html($customer_second_contact_salutation) ?> <?php echo esc_html($customer_second_contact_title) ?> <?php echo esc_html($customer_second_contact_lastname) ?>,
<?php endif ?>
<br/>
<p><?php echo esc_html__('vielen Dank für Ihre Zeit und Ihr Interesse an unseren ErgoPack Systemen.','ergo'); ?></p>
<p><?php echo esc_html__('Wie vereinbart finden Sie anbei das gemeinsam erarbeitete Angebot.','ergo'); ?></p>

<p><?php echo esc_html__('Sind Sie bereit, den Grundstein für ein EFFIZIENTES und ERGONOMISCHES Arbeitsumfeld zu legen? ','ergo'); ?><br/>
    <?php echo esc_html__('Dann profitieren Sie von unseren ausgezeichneten Systemen und den drei Hauptvorteilen:','ergo'); ?>
<br/>
<ul>
<li><?php echo esc_html__('Ergonomisch','ergo'); ?></li>
<li><?php echo esc_html__('Einfach','ergo'); ?></li>
<li><?php echo esc_html__('Effizient','ergo'); ?></li>
</ul>
</p>
<?php echo esc_html__('Bei eventuellen Fragen können Sie mich sehr gerne telefonisch unter ','ergo'); ?> <?php echo esc_html($phone) ?><?php echo esc_html__('oder per E-Mail unter ','ergo'); ?>  <?php echo esc_html($email) ?><?php echo esc_html__(' erreichen.','ergo'); ?>
<br/>
<br/>
<?php echo esc_html__('Ich freue mich, von Ihnen zu hören.','ergo'); ?>
<br/>
<br/>

<div class="grid gap-md">
    <div class="col-6">
        <?php if( $customers ): ?>
        <div id="eppCustomerSelectWrapper">
            <h3><?php echo esc_html__('Firma auswählen','ergo'); ?></h3>
            <select name="epp_customer_id" id="eppCustomerSelect">
                <option value="">--</option>
                <?php foreach( $customers as $cid => $customer ): ?>
                <option value="<?php echo esc_attr($cid)?>"><?php echo esc_html($customer) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
    </div>
    <div class="col-6">
        <div id="eppVorgangsnummerWrapper">
            <h3><?php echo esc_html__('Vorgangsnummer *','ergo'); ?></h3>
            <input type="number" class="input-text" name="epp_vorgangsnummer" id="eppVorgangsnummer" style="width: 100%">
        </div>
    </div>
</div>

import App from './../App';

/**
 * Class Checkout
 */
class Checkout extends App {
    /**
     * Constructor
     */
    constructor() {
        super();

        this.customerSelect         = document.getElementById('eppCustomerSelect');
        this.customerSelectWrapper  = document.getElementById('eppCustomerSelectWrapper');
        this.customerDetailsWrapper = document.getElementById('customer_details');

        this.billing_shipping_names = ['billing_first_name','billing_last_name','billing_company','billing_address_1','billing_address_2','billing_postcode','billing_city','billing_country','billing_phone','billing_email','shipping_first_name','shipping_last_name','shipping_company','shipping_address_1','shipping_address_2','shipping_postcode','shipping_city','shipping_country', 'epp_customer_title', 'epp_customer_salutation'];

        this.billing_shipping = {
            'billing_first_name': document.getElementById('billing_first_name'),
            'billing_last_name': document.getElementById('billing_last_name'),
            'billing_company': document.getElementById('billing_company'),
            'billing_address_1': document.getElementById('billing_address_1'),
            'billing_address_2': document.getElementById('billing_address_2'),
            'billing_postcode': document.getElementById('billing_postcode'),
            'billing_city': document.getElementById('billing_city'),
            'billing_country': document.getElementById('billing_country'),
            'billing_phone': document.getElementById('billing_phone'),
            'billing_email': document.getElementById('billing_email'),

            'shipping_first_name': document.getElementById('shipping_first_name'),
            'shipping_last_name': document.getElementById('shipping_last_name'),
            'shipping_company': document.getElementById('shipping_company'),
            'shipping_address_1': document.getElementById('shipping_address_1'),
            'shipping_address_2': document.getElementById('shipping_address_2'),
            'shipping_postcode': document.getElementById('shipping_postcode'),
            'shipping_city': document.getElementById('shipping_city'),
            'shipping_country': document.getElementById('shipping_country'),

            'epp_customer_title': document.getElementById('epp_customer_title'),
            'epp_customer_salutation': jQuery('#epp_customer_salutation option:selected'),
        };
    }

    loaderStart() {
        this.customerSelectWrapper.classList.add('loading');
        this.customerSelectWrapper.setAttribute("aria-hidden", 'false');
    }

    loaderEnd() {
        this.customerSelectWrapper.classList.remove('loading');
        this.customerSelectWrapper.setAttribute("aria-hidden", 'true');
    }

    cleanUpForm() {
        for(let idx in this.billing_shipping_names) {
            if( this.billing_shipping[this.billing_shipping_names[idx]] ) {
                this.billing_shipping[this.billing_shipping_names[idx]].value = null;
            }
        }
    }

    fillBillingShippingFields(data) {
        for(let idx in this.billing_shipping_names) {
            if( this.billing_shipping[this.billing_shipping_names[idx]] && data[this.billing_shipping_names[idx]] ) {
                if( this.billing_shipping_names[idx] === 'title' || this.billing_shipping_names[idx] === 'salutation' || this.billing_shipping_names[idx] === 'billing_country' ) {
                    jQuery('#'+this.billing_shipping_names[idx]).val(data[this.billing_shipping_names[idx]]).trigger('change');
                } else {
                    this.billing_shipping[this.billing_shipping_names[idx]].value = data[this.billing_shipping_names[idx]];
                }
            }
        }
    }

    loadCustomerData(cid) {
        const t = this;
        const data = [];

        data.push('action=epp_load_customer_data');
        data.push('cid='+cid);
        data.push('nonce='+epp.nonce);

        const $form = jQuery('form[name=checkout]');
        $form.addClass('processing').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });

        t.ajax(epp.ajax_url, data.join('&'), (response) => {
            $form.removeClass('processing').unblock();

            const json = JSON.parse(response);

            t.cleanUpForm();

            if( json && json.success == 'ok' ) {
                t.fillBillingShippingFields(json.data);
            }

        });
    }

    /**
     * Run
     */
    run() {
        const t = this;
        const $ = jQuery;

        t.ready(() => {
            const $select = $('#eppCustomerSelect');

            if( $select.length ) {
                $select.select2({
                    minimumInputLength: 3
                });
                $select.on('change', (e) => {
                    e.preventDefault();

                    t.loadCustomerData(e.target.value);
                });
            }

            const $quotationHidden = $('#is_order_quotation');
            $quotationHidden.val('');

            $(document).on('click', '#place_order_quotation', (e) => {
                $quotationHidden.val('1');

                $('#place_order').trigger('click');
            });

            $(document).on('click', '#place_order_trig', (e) => {
                $quotationHidden.val('');

                $('#place_order').trigger('click');
            });
        });
    }
}

export default Checkout;
import App from './App';

/**
 * Class Configurator
 */
class Configurator extends App {
    /**
     * Constructor
     */
    constructor() {
        super();
        this.radioLastState  = {};
        this.confForm        = document.getElementById('eppConfForm');
        this.confSubmit      = document.getElementById('eppConfSubmit');
        this.modelWrapper    = document.getElementById('eppProductModel');
        this.feedbackWrapper = document.getElementById('eppProductFeedback');
        this.feedbackError   = document.getElementById('eppProductError');
        this.feedbackLoader  = document.getElementById('eppFeedbackLoader');
    }

    loaderStart() {
        this.feedbackWrapper.classList.add('loading');
        this.feedbackLoader.setAttribute("aria-hidden", 'false');
    }

    loaderEnd() {
        this.feedbackWrapper.classList.remove('loading');
        this.feedbackLoader.setAttribute("aria-hidden", 'true');
    }

    /**
     * Load attributes via AJAX
     *
     * @param pid
     */
    attributesLoad(pid) {
        const t = this;
        const data = [];
        data.push('action=epp_load_attributes');
        data.push('pid='+pid);

        t.loaderStart();

        t.ajax(epp.ajax_url, data.join('&'), function(response){
            t.feedbackWrapper.innerHTML = response;
            t.feedbackError.classList.add('is-hidden');
            t.loaderEnd();
            t.refreshCodyhouseComponenets();
            t.attributesEvents();
        });
    }

    /**
     * Add attribute events
     */
    attributesEvents() {
        const t = this;

        // parents
        document.querySelectorAll('.epp-conf-choice').forEach(parent => {
            parent.addEventListener('click', function () {
                // has children
                if( parent.classList.contains('epp-conf-has-children') ) {
                    const tid = parent.getAttribute('data-tid');
                    document.querySelectorAll('.epp-conf-child-'+tid).forEach(child => {
                        let label = child.nextElementSibling;
                        if( parent.checked ) {
                            label.classList.remove('is-hidden');
                        } else {
                            label.classList.add('is-hidden');
                            child.checked = 0;
                        }
                    });
                // no children
                } else {
                    // allow to check/uncheck radio
                    if( 'radio' === parent.type ) {
                        if (parent.checked && (t.radioLastState.hasOwnProperty(parent.name) && t.radioLastState[parent.name] == parent.value) ) {
                            parent.checked = 0;
                            t.radioLastState[parent.name] = null;
                        } else {
                            t.radioLastState[parent.name] = parent.value;
                        }
                    }
                }
            });
        });
    }

    /**
     *
     * @param e
     */
    submitForm() {
        const t = this;
        const params = [].filter.call(t.confForm.elements, el => {
            return el.type == 'hidden' || el.checked;
        })
            .filter(el => { return !!el.name; })
            .filter(el => { return !el.disabled; })
            .map(el => {
                return encodeURIComponent(el.name) + '=' + encodeURIComponent(el.value);
            }).join('&');

        t.loaderStart();

        t.ajax(epp.ajax_url, params, function(response){
            const json = JSON.parse(response);

            if( json.status == 'success' ) {
                const html = json.message + '<br>' + json.order_preview_link;

                // display response
                t.feedbackWrapper.innerHTML = html;

                // hide elements
                t.modelWrapper.classList.add('is-hidden');
                t.confSubmit.classList.add('is-hidden');
                t.feedbackError.classList.add('is-hidden');
            } else {
                console.log(t.feedbackError);
                t.feedbackError.innerHTML = json.message;
                t.feedbackError.classList.remove('is-hidden');
            }
            t.loaderEnd();
            //t.refreshCodyhouseComponenets();
            t.attributesEvents();
        });
    }

    /**
     * Run
     */
    run() {
        const t = this;

        t.ready(() => {
            document.querySelectorAll('input[name=epp_conf_model]').forEach(item => {
                item.addEventListener('change', (e) => {
                    t.attributesLoad(e.target.value);
                });
            });

            if( t.confSubmit ) {
                t.confSubmit.addEventListener('click', (e) => {
                    e.preventDefault();
                    t.submitForm(e.target);
                });
            }
        });
    }
}

export default Configurator;
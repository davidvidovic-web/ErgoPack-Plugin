/**
 * App
 */
class App {
    constructor() {
    }

    loaderStart() {
    }

    loaderEnd() {
    }

    /**
     * Refresh CodyHouse components
     */
    refreshCodyhouseComponenets() {
        // Accordion
        if( typeof Accordion == 'function' ) {
            var accordions = document.getElementsByClassName('js-accordion');
            if (accordions.length > 0) {
                for (var i = 0; i < accordions.length; i++) {
                    (function (i) {
                        new Accordion(accordions[i]);
                    })(i);
                }
            }
        }

        // Tabs
        if( typeof Tab == 'function' ) {
            var tabs = document.getElementsByClassName('js-tabs');
            if (tabs.length > 0) {
                for (var i = 0; i < tabs.length; i++) {
                    (function (i) {
                        new Tab(tabs[i]);
                    })(i);
                }
            }
        }

        // Modal
        if( typeof Modal == 'function' ) {
            var modals = document.getElementsByClassName('js-modal');
            // generic focusable elements string selector
            var focusableElString = '[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary';
            if (modals.length > 0) {
                var modalArrays = [];
                for (var i = 0; i < modals.length; i++) {
                    (function (i) {
                        modalArrays.push(new Modal(modals[i]));
                    })(i);
                }

                window.addEventListener('keydown', function (event) { //close modal window on esc
                    if (event.keyCode && event.keyCode == 27 || event.key && event.key.toLowerCase() == 'escape') {
                        for (var i = 0; i < modalArrays.length; i++) {
                            (function (i) {
                                modalArrays[i].closeModal();
                            })(i);
                        }
                        ;
                    }
                });
            }
        }
    }

    /**
     * AJAX request
     *
     * @param url
     * @param data
     * @param success
     */
    ajax(url, data, success) {
        const request = new XMLHttpRequest();
        request.open('POST', url, true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.onload = function() {
            if (this.status >= 200 && this.status < 400) {
                success(this.response);
            }
        };
        request.onerror = function() {
        };
        request.send(data);
    }

    /**
     * AJAX request
     *
     * @param url
     * @param data
     * @param success
     */
    ajaxJson(url, data, success) {
        const request = new XMLHttpRequest();
        request.open('POST', url, true);
        request.setRequestHeader('Content-Type', 'application/json');
        request.onload = function() {
            if (this.status >= 200 && this.status < 400) {
                success(this.response);
            }
        };
        request.onerror = function() {
        };
        request.send(data);
    }

    /**
     * Ready (similar to jQuery .ready)
     *
     * @param fn
     */
    ready(fn) {
        if (document.readyState != 'loading'){
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }
}

export default App;
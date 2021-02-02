define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'dvCampusPersonalDiscountForm'
], function ($, ko, Component, customerData) {
    'use strict';

    return Component.extend({
        defaults: {
            requestAlreadySent: false,
            template: 'DVCampus_PersonalDiscount/button',
            personalDiscount: customerData.get('personal-discount'),
            listens: {
                personalDiscount: 'checkRequestAlreadySent'
            }
        },

        /**
         * @returns {*}
         */
        initObservable: function () {
            this._super().observe(['requestAlreadySent']);

            return this;
        },

        initLinks: function () {
            this._super();

            this.checkRequestAlreadySent(this.personalDiscount());

            return this;
        },

        /**
         * Generate event to open the form
         */
        openRequestForm: function () {
            $(document).trigger('dv_campus_personal_discount_form_open');
        },

        /**
         * Check if the product has already been requested by the customer
         */
        checkRequestAlreadySent: function (personalDiscountData) {
            if (personalDiscountData.hasOwnProperty('productIds') &&
                personalDiscountData.productIds.indexOf(this.productId) !== -1
            ) {
                this.requestAlreadySent(true);
            }
        }
    });
});

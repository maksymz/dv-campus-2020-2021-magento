define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function ($, ko, Component, customerData) {
    'use strict';

    return Component.extend({
        defaults: {
            productId: 0,
            requestAlreadySent: false,
            template: 'DVCampus_PersonalDiscount/button'
        },

        /**
         * @returns {*}
         */
        initObservable: function () {
            this._super().observe(['requestAlreadySent']);

            this.checkRequestAlreadySent(customerData.get('personal-discount')());
            customerData.get('personal-discount').subscribe(this.checkRequestAlreadySent.bind(this));

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

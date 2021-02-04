define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'Magento_Customer/js/model/authentication-popup',
    'Magento_Customer/js/action/login',
    'dvCampusPersonalDiscountForm'
], function ($, ko, Component, customerData, authenticationPopup, loginAction) {
    'use strict';

    return Component.extend({
        defaults: {
            allowForGuests: false,
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
        initialize: function () {
            loginAction.registerLoginCallback(function () {
                customerData.invalidate(['*']);
            });

            this._super();

            return this;
        },

        /**
         * @returns {*}
         */
        initObservable: function () {
            this._super().observe(['requestAlreadySent']);

            return this;
        },

        /**
         * @returns {*}
         */
        initLinks: function () {
            this._super();

            this.checkRequestAlreadySent(this.personalDiscount());

            return this;
        },

        /**
         * Generate event to open the form
         */
        openRequestForm: function () {
            if (this.allowForGuests || !!this.personalDiscount().isLoggedIn) {
                $(document).trigger('dv_campus_personal_discount_form_open');
            } else {
                authenticationPopup.showModal();
            }
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

            return personalDiscountData;
        }
    });
});

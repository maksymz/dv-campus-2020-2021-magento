define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal',
    'mage/translate',
    'mage/cookies'
], function ($, ko, Component, customerData, alert) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'DVCampus_PersonalDiscount/form',
            customerName: '',
            customerEmail: '',
            customerMessage: ''
        },

        /**
         *
         * @returns {*}
         */
        initObservable: function () {
            this._super()
                .observe(['customerName', 'customerEmail', 'customerMessage']);
            this.customerName.subscribe(function (newValue) {
                console.log(newValue);
            });

            return this;
        },

        /**
         * Send form data to the server
         */
        sendPersonalDiscountRequest: function () {
            console.log('Going to submit the form');
        }
    });
});

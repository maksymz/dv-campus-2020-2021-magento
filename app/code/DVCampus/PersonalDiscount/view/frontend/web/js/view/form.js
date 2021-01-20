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
            template: 'DVCampus_PersonalDiscount/form'
        },

        customerName: ko.observable(),
        customerEmail: ko.observable(),
        customerMessage: ko.observable(),

        initObservable: function () {
            this._super();
            this.customerName.subscribe(function (newValue) {
                console.log(newValue);
            });

            return this;
        }
    });
});

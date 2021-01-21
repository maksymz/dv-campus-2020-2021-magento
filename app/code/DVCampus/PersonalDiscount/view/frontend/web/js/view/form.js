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
            customerName: '',
            customerEmail: '',
            customerMessage: '',
            template: 'DVCampus_PersonalDiscount/form'
        },

        initObservable: function () {
            this._super();
            this.observe(['customerName', 'customerEmail', 'customerMessage']);

            this.customerName.subscribe(function (newValue) {
                console.log(newValue);
            });

            return this;
        }
    });

    $.widget('dvCampus.personalDiscountForm', {
        options: {
            action: '',
            productId: ''
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).modal({
                buttons: []
            });

            $(document).on('dv_campus_personal_discount_form_open', this.openModal.bind(this));
            $(this.element).on('submit.dv_campus_personal_discount_form', this.sendRequest.bind(this));

            // @TODO: hide or disable email field for logged in customer
            // @TODO: hide button if this product has already been requested
            console.log(customerData.get('personal-discount')());
            customerData.get('personal-discount').subscribe(function (value) {
                console.log(value);
            });
        },

        /**
         * Open modal dialog
         */
        openModal: function () {
            $(this.element).modal('openModal');
        },

        /**
         * Validate form and send request
         */
        sendRequest: function () {
            if (!this.validateForm()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            let formData = new FormData($(this.element).get(0));

            formData.append('product_id', this.options.productId);
            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);

            $.ajax({
                url: this.options.action,
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /** @inheritdoc */
                success: function (response) {
                    $(this.element).modal('closeModal');
                    alert({
                        title: $.mage.__('Success'),
                        content: response.message
                    });
                },

                /** @inheritdoc */
                error: function () {
                    alert({
                        title: $.mage.__('Error'),
                        /*eslint max-len: ["error", { "ignoreStrings": true }]*/
                        content: $.mage.__('Your request can\'t be sent. Please, contact us if you see this message.')
                    });
                },

                /** @inheritdoc */
                complete: function () {
                    $('body').trigger('processStop');
                }
            });
        }
    });
});

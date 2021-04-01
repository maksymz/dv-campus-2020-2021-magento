define([
    'Magento_Checkout/js/view/summary/abstract-total',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/totals'
], function (Component, quote, totals) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'DVCampus_PersonalDiscount/cart/personal-discount',
            title: ''
        },
        totals: quote.getTotals(),

        /**
         * @return {*|Boolean}
         */
        isDisplayed: function () {
            return this.isFullMode() && this.getPureValue() !== 0.00;
        },

        /**
         * Get pure value.
         *
         * @return {*}
         */
        getPureValue: function () {
            let price = 0;

            if (quote.getTotals()()) {
                price = totals.getSegment('personal_discount').value;
            }

            return parseFloat(price);
        },

        /**
         * @return {*|String}
         */
        getValue: function () {
            return this.getFormattedPrice(this.getPureValue());
        }
    });
});

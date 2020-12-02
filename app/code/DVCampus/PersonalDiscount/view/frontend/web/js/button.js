define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('dvCampusPersonalDiscount.button', {
        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(this.element).click(this.openRequestForm.bind(this));
        },

        /**
         * Generate event to open the form
         */
        openRequestForm: function () {
            console.log(this);
            alert('Click event works fine');
        }
    });

    return $.dvCampusPersonalDiscount.button;
});

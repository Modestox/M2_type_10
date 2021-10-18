
define([
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'mage/mage',
    'mage/translate'
], function (Component, customerData) {
    'use strict';

    return Component.extend({
        /** @inheritdoc */
        initialize: function () {
            this._super();
            this.customerstatusData = customerData.get('customerstatus');
        }
    });
});

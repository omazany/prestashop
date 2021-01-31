// naming convention: PacketerCheckoutModule + moduleId (first letter in upper case)

var PacketeryCheckoutModuleStandard = {

    getSelectedInput: function () {
        return $('.delivery-option input:checked');
    },

    findDeliveryOptions: function () {
        return $('.delivery-option input');
    },

    getWidgetParent: function ($selectedInput) {
        return $selectedInput.closest('.delivery-option').next();
    },

    enableSubmitButton: function () {
        $('button[name="confirmDeliveryOption"]')
            .removeClass('disabled')
            .css("pointer-events", "auto");
    },

    disableSubmitButton: function () {
        $('button[name="confirmDeliveryOption"]')
            .addClass('disabled')
            .css("pointer-events", "none");
    },

    hideValidationErrors: function () {
    }
};
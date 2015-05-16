/**
 * DisallowPOBox js
 *
 * @category    Aydus
 * @package     Aydus_DisallowPOBox
 * @author      Aydus <davidt@aydus.com>
 */

function DisallowPOBox($)
{
    var validatePOBox = function (street)
    {
        var matched = POBOX_PATTERN.test(street);

        if (matched) {
            return false;
        }

        return true;
    };

    return {
        init: function ()
        {
            $(function () {

                if (typeof validatePOBoxSelectors != 'undefined' && validatePOBoxSelectors) {

                    Validation.add('validate-pobox', 'P.O. Boxes are not allowed.', validatePOBox);

                    for (var i = 0; i < validatePOBoxSelectors.length; i++) {

                        var addressFieldSelector = validatePOBoxSelectors[i];

                        $(addressFieldSelector).addClass('validate-pobox');
                    }

                } else {

                    if (typeof console == 'object') {

                        console.log('The template disallowpobox/script.phtml not loaded');
                    }
                }

            });

        }

    };

}

if (!window.jQuery) {

    document.write('<script src="//ajax.googleapis.com/ajax/libs/$/1.11.2/$.min.js">\x3C/script><script>jQuery.noConflict(); var disallowpobox = DisallowPOBox(jQuery); disallowpobox.init();</script>');

} else {

    var disallowpobox = DisallowPOBox(jQuery);
    disallowpobox.init();
}

(function ($) {
    var translation = {
        init: function Init() {
            var base = this
            base.container = $('body')
            base.current_page = base.getQueryVariable('page')
            base.translation = base.container.find('#translation')
            base.vp_textfield = base.translation.find('.vp-textbox > div.field > div.input')
            base.is_translation = (-1 !== base.current_page.indexOf('jnews_translation') && base.translation.length > 0)
            base.syncTranslationText()
        },
        syncTranslation: function syncTranslation() {
            var base = this
            var input = base.vp_textfield.find('input')
            if (base.is_translation && input.length > 0) {
                input.each(function (index, element) {
                    var $element = $(element)
                    var name = $element.attr('name')
                    var value = $element.val()
                    var check_data = base.vp_textfield.find('input[name="' + name + '"]')
                    if (check_data.length > 1 && value !== '') {
                        check_data.val($(this).val())
                    }
                });
            }
        },
        syncTranslationText: function syncTranslationText() {
            var base = this
            if (base.is_translation) {
                base.vp_textfield.find('input').on('change keyup paste', function (e) {
                    var $element = $(e.currentTarget)
                    var name = $element.attr('name')
                    var value = $element.val()
                    base.vp_textfield.find('input[name="' + name + '"]').val(value)
                }.bind(base.vp_textfield))
            }
        },
        getQueryVariable: function getQueryVariable(variable) {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                if (pair[0] == variable) {
                    return pair[1];
                }
            }
            return false;
        }
    }
    translation.init()
    translation.syncTranslation()
})(jQuery)
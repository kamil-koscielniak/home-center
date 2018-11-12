require('../css/app.css');
const $ = require('jQuery');

$(document).ready(function () {
    rowRepeaterInit();
});

function rowRepeaterInit() {
    if ($('.row-repeater').length > 0){
        $('.row-repeater').each(function() {
            rowRepeat($(this));
        });
    }
    $(document).on('click', '.row-repeater-trigger', function () {
        var source = $(this).closest('.row-to-repeat').data('repeater-source');
        rowRepeat($('#'+source+'.row-repeater'));
    });
    $(document).on('click', '.row-repeater-remove', function () {
        $(this).closest('.row-to-repeat').remove();
    });
}

function rowRepeat(rowRepeater) {
    var parent = rowRepeater.parent();
    var prototype = $(rowRepeater.data('prototype'));
    var prototypeCount = rowRepeater.parent().find('.row-to-repeat').length;
    var prototypeName = rowRepeater.closest('form').attr('name') + '['+ prototype.find('input').attr('name') +']['+ prototypeCount +']';
    prototype.find('input').attr('name', prototypeName);
    prototype.find('.row-to-repeat').attr('data-repeater-source', rowRepeater.attr('id'));
    prototype.removeClass('form-group');
    if (prototypeCount > 0)
        prototype.find('.row-repeater-remove').prop('disabled', false);
    parent.append(prototype);
}
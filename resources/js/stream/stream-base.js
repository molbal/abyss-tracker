require('../bootstrap');

function streamBaseInit() {
    $('[data-add-class]').each(function (index, value) {
        const element = $(value);
        const delay = element.data('delay');

        console.log('Adding class', element.data('add-class'), 'to', element,'in', delay);
        setTimeout(function () {
            console.log('Adding class', element.data('add-class'), 'to', element);
            element.addClass(element.data('add-class'));
        }, delay);

        console.log('Removing class', element.data('remove-class'), 'from', element,'in', delay);
        setTimeout(function () {
            console.log('Removing class', element.data('remove-class'), 'to', element);
            element.removeClass(element.data('remove-class'));
        }, delay);
    })
}

$(function () {
   console.log('Initializing Abyss Tracker stream-base');

   setTimeout(streamBaseInit, 333);
});

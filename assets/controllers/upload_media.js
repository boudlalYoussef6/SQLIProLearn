$(function () {
    let collectionHolder = $('div#course_medias');
    let addMediaButton = $('#add_new_attachment');
    let index = parseInt(collectionHolder.attr('data-index'));

    addMediaButton.on('click', function() {
        let prototype = collectionHolder.data('prototype');
        let newForm = prototype.replace(/__name__/g, index);
        collectionHolder.find('.media__container').append(newForm);
        index++;

        collectionHolder.attr('data-index', index)
    });

    // Use event delegation to handle click event for dynamically added remove buttons
    collectionHolder.on('click', '.remove-media', function(e) {
        e.preventDefault();
        $(this).closest('.row').remove();
    });
}) ();
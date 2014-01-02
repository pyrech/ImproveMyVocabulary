
Imv = {
    'addCollectionForm': function(collectionHolder, newLinkLi) {
        var prototype = collectionHolder.attr('data-prototype');
        // Replace '__name__' in HTML prototype with the current collection length
        var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);
        // Display the form in the li before the newlink container
        var newFormLi = $('<li></li>').append(newForm);
        newLinkLi.before(newFormLi);
    },

    'addCollectionFormDeleteLink': function(tagFormLi) {
        var removeFormA = $('<a href="#">Supprimer ce tag</a>');
        tagFormLi.append(removeFormA);

        removeFormA.on('click', function(e) {
            e.preventDefault();
            tagFormLi.remove();
        });
    }
};

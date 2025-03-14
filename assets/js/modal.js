// JavaScript to Populate Modals

var viewFlavorsModal = document.getElementById('viewFlavorsModal');
viewFlavorsModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var ID = button.getAttribute('data-ID');
    var Flavors = button.getAttribute('data-Flavors');
    var Sinkers = button.getAttribute('data-Sinkers');
    var Sizes = button.getAttribute('data-Sizes');
    var Price = button.getAttribute('data-Price');

    document.getElementById('view-ID').textContent = ID;
    document.getElementById('view-Flavors').textContent = Flavors;
    document.getElementById('view-Sinkers').textContent = Sinkers;
    document.getElementById('view-Sizes').textContent = Sizes;
    document.getElementById('view-Price').textContent = Price;
});

var editFlavorsModal = document.getElementById('editFlavorsModal');
editFlavorsModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var ID = button.getAttribute('data-ID');
    var Flavors = button.getAttribute('data-Flavors');
    var Sinkers = button.getAttribute('data-Sinkers');
    var Sizes = button.getAttribute('data-Sizes');
    var Price = button.getAttribute('data-Price');

    document.getElementById('edit-ID').value = ID;
    document.getElementById('edit-Flavors').value = Flavors;
    document.getElementById('edit-Sinkers').value = Sinkers;
    document.getElementById('edit-Sizes').value = Sizes;
    document.getElementById('edit-Price').value = Price;
});

var deleteFlavorsModal = document.getElementById('deleteFlavorsModal');
deleteFlavorsModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');
    document.getElementById('delete-id').value = id;
});

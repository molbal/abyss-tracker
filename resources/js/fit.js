
function editDescription() {
    $("#fit_new_description_modal").modal({});
}

$(function () {
    $("#editDescription").click(editDescription);

    var simplemde = new SimpleMDE({
        element: document.getElementById("description"),
        forceSync: true,
        spellChecker: false,
        status: false,
        hideIcons: ["guide"]
    });
});

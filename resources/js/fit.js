
function editDescription() {
    $("#fit_new_description_modal").modal({});
}
function editVideo() {
    $("#fit_new_video_modal").modal({});
}

$(function () {
    $("#editDescription").click(editDescription);
    $("#editVideo").click(editVideo);

    var simplemde = new SimpleMDE({
        element: document.getElementById("description"),
        forceSync: true,
        spellChecker: false,
        status: false,
        hideIcons: ["guide"]
    });
});

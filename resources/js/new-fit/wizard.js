$(function () {
    var simplemde = new SimpleMDE({
        element: document.getElementById("description"),
        forceSync: true,
        spellChecker: false,
        status: false,
        hideIcons: ["guide"]
    });
});

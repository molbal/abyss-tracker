function getTextAreaSelection(textarea) {
    var start = textarea.selectionStart, end = textarea.selectionEnd;
    return {
        start: start,
        end: end,
        length: end - start,
        text: textarea.value.slice(start, end)
    };
}

function detectPaste(textarea, callback) {
    textarea.onpaste = function () {
        var sel = getTextAreaSelection(textarea);
        var initialLength = textarea.value.length;
        window.setTimeout(function () {
            var val = textarea.value;
            var pastedTextLength = val.length - (initialLength - sel.length);
            var end = sel.start + pastedTextLength;
            callback({
                start: sel.start,
                end: end,
                length: pastedTextLength,
                text: val.slice(sel.start, end)
            });
        }, 1);
    };
}


$(function () {
    var textarea = document.getElementById("eft");
    detectPaste(textarea, function(pasteInfo) {
        console.log("Pasted!");
        $("#eft").blur();
    });

    window.addEventListener('step-change', event => {
        console.log('Name updated to: ' + event.detail.newstep);
        try {
            simplemde.toTextArea();
            simplemde = null;
        } catch (ignored) {

        }

        var simplemde = new SimpleMDE({
            element: document.getElementById("description"),
            forceSync: true,
            spellChecker: false,
            status: false,
            hideIcons: ["guide"]
        });
    })



});


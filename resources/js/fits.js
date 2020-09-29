
function filterList() {
    var filters = $("form#filters").serializeArray();
    $("#doFilter").attr("disabled", "disabled").addClass("disabled");
    $.post(window.fit_search_ajax, filters, function(a) {
        $("#results").css("opacity", "0.01").html(a).animate({opacity:1}, 250);
    })
        .fail(function() {
            alert("Sorry, something went wrong while searching");
        })
        .always(function() {
            $("#doFilter").removeAttr("disabled").removeClass("disabled");
        });
};


function formatState (state) {
    var $state = $(state);
    return $state;
};



function toggleTag(slot, value, ths) {
    var _this = $(ths);
    console.log(ths, _this);
    let input = $("#" + slot);
    var cv = input.val();

    _this.parent().find("span").removeClass("active");
    if (cv === "") {
        console.log("initial");
        input.val(value);
        _this.addClass('active');
    } else if (cv === value) {
        console.log("equals ", cv, value);
        input.val("");
        _this.removeClass('active');
    } else {
        console.log("different ", cv, value);
        input.val(value);
        _this.addClass('active');
    }
};

$(function () {
    $("#doFilter").click(filterList);

    $(".select2-character").select2({
        theme: 'bootstrap',
        templateResult: function (state) {
            if (!state.id) { return state.text; }
            if (state.element.value.toLowerCase() === "0") {
                return $('<span class="text-center">'+state.text+'</span>');
            }
            var $state = $(
                '<span><img style="width: 24px; height: 24px" src="https://images.evetech.net/characters/' +  state.element.value.toLowerCase() +
                '/portrait?size=32" class="rounded-circle shadow-sm movealilbitup" /> ' +
                state.text +     '</span>'
            );
            return $state;
        },
        width: '100%',
    });
});

jQuery(".selected-place").click(function () {
    var placeOptions = jQuery(this).siblings(".place-options");

    var icon = jQuery(this).find(".redi-place-dropdown-icon");

    icon.removeClass("icon-chevron-down");
    icon.removeClass("icon-chevron-up");

    // Toggle the icon based on the place-options visibility
    if (placeOptions.is(":visible")) {
        icon.addClass("icon-chevron-down");
    } else {
        icon.addClass("icon-chevron-up");
    }

    placeOptions.slideToggle();
});

jQuery(".place-options .redi-place").click(function () {
    var name = jQuery(this).find(".name").text();
    var address = jQuery(this).find(".address").text();
    var selectedPlace = jQuery(this).closest(".redi-places").find(".selected-place");

    selectedPlace.find(".name").text(name);
    selectedPlace.find(".address").text(address);
    selectedPlace.siblings(".place-options").slideUp();

    selectedPlace.find(".redi-place").removeClass("place-not-selected");
    selectedPlace.find(".redi-place").addClass("place-selected");

    var icon = selectedPlace.find(".redi-place-dropdown-icon");
    icon.addClass("icon-chevron-down");
    icon.removeClass("icon-chevron-up");

    selectedPlace.find(".select-place-icon").addClass("icon-check");
});

jQuery(document).on("click", function (event) {
    if (!jQuery(event.target).closest(".redi-places").length) {
        jQuery(".place-options").slideUp();

        jQuery(".redi-place-dropdown-icon").addClass("icon-chevron-down");
        jQuery(".redi-place-dropdown-icon").removeClass("icon-chevron-up");
    }
});
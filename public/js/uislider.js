$('#mySlider').slider({
    range: true,
    min: 10000,
    max: 10000000,
    values: [10000, 5000000],
    slide: function (event, ui) {
        $("#price").val("KSH" + ui.values[0] + " - KSH" + ui.values[1]);
    }
});

$("#price").val("KSH" + $("#mySlider").slider("values", 0) +
    " - $" + $("#mySlider").slider("values", 1));
$(document).ready(function () {
  $(".caja-btn").on("click", function () {
    $(".caja-btn").removeClass("active");
    $(this).addClass("active");
  });
});
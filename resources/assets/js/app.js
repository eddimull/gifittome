var input = $("#phone"),
  output = $("#output"),
  errorMsg = $("#error-msg"),
  validMsg = $("#valid-msg");

input.intlTelInput({
defaultCountry:"auto",
  nationalMode: true,
  geoIpLookup: function(callback) {
    $.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
      var countryCode = (resp && resp.country) ? resp.country : "";
      callback(countryCode);
    });
  },
  // utilsScript: "../../lib/libphonenumber/build/utils.js" // just for formatting/placeholders etc
});
// on blur: validate
telInput.blur(function() {
  if ($.trim(telInput.val())) {
    if (telInput.intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
    } else {
      telInput.addClass("error");
      errorMsg.removeClass("hide");
      validMsg.addClass("hide");
    }
  }
});

// on keydown: reset
telInput.keydown(function() {
  telInput.removeClass("error");
  errorMsg.addClass("hide");
  validMsg.addClass("hide");
});
// listen to "keyup", but also "change" to update when the user selects a country
input.on("keyup change", function() {
  var intlNumber = input.intlTelInput("getNumber");
  if (intlNumber) {
    output.text("International: " + intlNumber);
  } else {
    output.text("Please enter a number below");
  }
});
;jQuery(document).ready(function ($) {
  "use strict";
  var count = true;

  if (count) {
    agPasswordSendAjaxRequest();
    count = false;
  }

  $("#ag-pwdlength").on("change", function () {
    agPasswordSendAjaxRequest();
  });

  $('input[name="ag-characters"]').on("change", function () {
    agPasswordSendAjaxRequest();
  });

  $("#ag-regenerate-pwd").on("click", function () {
    agPasswordSendAjaxRequest();
  });

  // To display length value on the password slider
  var currentValue = $("#ag-pwdlength").val();
  console.log(currentValue);
  $("#ag-length").text(currentValue);

  // To update current value on change
  $("#ag-pwdlength").on("change", function () {
    var currentValue = $(this).val();
    $("#ag-length").text(currentValue);
    passwordStrengthIndicator(currentValue);
  });

  // To update current value on change
  $("#ag-pwdlength").on("init", function () {
    var currentValue = $(this).val();

    $("#ag-length").text(currentValue);
    passwordStrengthIndicator(currentValue);
  });

  // Copy the generated password to clipboard
  var $copyButton = document.getElementById("ag-generated-secure-pwd-copy");

  $copyButton.onclick = function () {
    // Get text field
    var $copyPwd = document.getElementById("ag-generated-secure-pwd");

    // Select it
    $copyPwd.select();

    // For mobile devices
    $copyPwd.setSelectionRange(0, 99999);

    // Copy the text inside the text field
    document.execCommand("copy");

    // Change tooltip text
    var $tooltip = document.getElementById(
      "ag-generated-secure-pwd-copy-tooltip"
    );

    $tooltip.innerText = "Copied: " + $copyPwd.value;
  };

  // Restore the original tooltip text after mouse leaves the area
  $copyButton.onmouseout = function () {
    var $tooltip = document.getElementById(
      "ag-generated-secure-pwd-copy-tooltip"
    );
    $tooltip.innerText = "Copy to clipboard";
  };

  function agPasswordSendAjaxRequest() {
    // only send AJAX request when the psswrd gen widget is added
    if ($("#ag-generated-secure-pwd").length > 0) {
      var selectedCharacters = new Array();

      $('input[name="ag-characters"]:checked').each(function () {
        selectedCharacters.push(this.value);
      });

      // by default, all checkboxes unchecked
      var lowercase = 0;
      var uppercase = 0;
      var numbers = 0;
      var symbols = 0;

      for (var i = 0; i < selectedCharacters.length; i++) {
        var current = selectedCharacters[i];
        switch (current) {
          case "lowercase":
            lowercase = 1;
            break;
          case "uppercase":
            uppercase = 1;
            break;
          case "numbers":
            numbers = 1;
            break;
          case "symbols":
            symbols = 1;
            break;
          default:
        }
      }

      if (
        lowercase === 0 &&
        uppercase === 0 &&
        numbers === 0 &&
        symbols === 0
      ) {
        console.log("Belép");
        $("#ag-generated-secure-pwd").val("Please check options below");
        return;
      }

      console.log(
        "l: " +
          lowercase +
          " u: " +
          uppercase +
          " n: " +
          numbers +
          " s: " +
          symbols
      );

      var pwdlength = $("#ag-pwdlength").val();
      console.log(pwdlength);

      var data = {
        action: "ag_generate_password_ajax_action",
        security: AGPasswordGeneratorAjax.security,
        pwd_length: pwdlength,
        lowercase: lowercase,
        uppercase: uppercase,
        numbers: numbers,
        symbols: symbols,
      };

      console.log(AGPasswordGeneratorAjax.ajax_url);

      $.ajax({
        type: "POST",
        url: AGPasswordGeneratorAjax.ajax_url,
        data: data,
        dataType: "json",
      })
        .done(function (response) {
          $("#ag-generated-secure-pwd").val(response.data);
        })
        .fail(function () {
          $("#ag-errorbox").text("Error.");
        })
        .always(function () {});
    }
  }

  // Set indicator bar classes based on the length of the password
  function passwordStrengthIndicator(currentValue) {
    // weak passwords: length < 10
    if (currentValue < 10) {
      $("#ag-strength-1")
        .removeClass("inactive weak medium strong perfect")
        .addClass("weak");
      $("#ag-strength-2")
        .removeClass("inactive weak medium strong perfect")
        .addClass("inactive");
      $("#ag-strength-3")
        .removeClass("inactive weak medium strong perfect")
        .addClass("inactive");
      $("#ag-strength-4")
        .removeClass("inactive weak medium strong perfect")
        .addClass("inactive");

      // medium passwords: length >= 10 && length <= 17
    } else if (currentValue >= 10 && currentValue <= 17) {
      $("#ag-strength-1")
        .removeClass("inactive weak medium strong perfect")
        .addClass("medium");
      $("#ag-strength-2")
        .removeClass("inactive weak medium strong perfect")
        .addClass("medium");
      $("#ag-strength-3")
        .removeClass("inactive weak medium strong perfect")
        .addClass("inactive");
      $("#ag-strength-4")
        .removeClass("inactive weak medium strong perfect")
        .addClass("inactive");

      // strong passwords: length >= 18
    } else if (currentValue >= 18 && currentValue < 25) {
      $("#ag-strength-1")
        .removeClass("inactive weak medium strong perfect")
        .addClass("strong");
      $("#ag-strength-2")
        .removeClass("inactive weak medium strong perfect")
        .addClass("strong");
      $("#ag-strength-3")
        .removeClass("inactive weak medium strong perfect")
        .addClass("strong");
      $("#ag-strength-4")
        .removeClass("inactive weak medium strong perfect")
        .addClass("inactive");

      // perfect passwords: length >= 18
    } else if (currentValue >= 25) {
      $("#ag-strength-1")
        .removeClass("inactive weak medium strong perfect")
        .addClass("perfect");
      $("#ag-strength-2")
        .removeClass("inactive weak medium strong perfect")
        .addClass("perfect");
      $("#ag-strength-3")
        .removeClass("inactive weak medium strong perfect")
        .addClass("perfect");
      $("#ag-strength-4")
        .removeClass("inactive weak medium strong perfect")
        .addClass("perfect");
    }
  }
});

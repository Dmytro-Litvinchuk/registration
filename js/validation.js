$(document).ready(function(){

  // disabled all submits.
  login = $("input[name=login]");
  submit = $("input[name=registration]");
  login.prop('disabled', true);
  login.addClass("passive");
  submit.prop('disabled', true);
  submit.addClass("passive");
  // hide log in.
  $("#log-in").css({
    "display": "none"
  });
  $("#reg").addClass("active");
  $("#log").addClass("passive");

  // hide sign up and show log in
  $("#log").click(function () {
    $("#log-in").css({
      "display": "block"
    });
    $("#sign-up").css({
      "display": "none"
    });
    $("#reg").removeClass("active").addClass("passive");
    $("#log").removeClass("passive").addClass("active");
  });

  // Show login after registration;
  if ($("input[name=log]").val() === "1") {
      $("#log-in").css({
        "display": "block"
      });
      $("#sign-up").css({
        "display": "none"
      });
      $("#reg").removeClass("active").addClass("passive");
      $("#log").removeClass("passive").addClass("active");
  }

  // hide log in and show sign up
  $("#reg").click(function () {
    $("#log-in").css({
      "display": "none"
    });
    $("#sign-up").css({
      "display": "block"
    });
    $("#log").removeClass("active").addClass("passive");
    $("#reg").removeClass("passive").addClass("active");
  });

  // valid sign up.
  $("#sign-up").keydown(function () {
    $(".valid").each(function () {
      var sign = $(this).val().trim();
      if (sign !== "") {
        submit.prop('disabled', false);
        submit.removeClass("passive").addClass("active");
      } else {
        submit.prop('disabled', true);
        submit.removeClass("active").addClass("passive");
      }
    });
  });

  // valid password.
  $("input[name=c-password]").keyup(function () {
    var confirm = $(this).val();
    var password = $("#password").val();
    if (confirm !== password) {
      $("#sign-up input:password").css({
        "border": "3px solid red"
      });
      submit.prop('disabled', true);
      submit.removeClass("active").addClass("passive");
    } else {
      $("#sign-up input:password").css({
        "border": "2px solid #73818a"
      });
      submit.prop('disabled', false);
      submit.removeClass("passive").addClass("active");
    }
  });

  // valid log in.
  $("#log-in").keyup(function () {
    $(".lvalid").each(function () {
      var log = $(this).val().trim();
      if (log !== "") {
        login.prop('disabled', false);
        login.removeClass("passive").addClass("active");
      } else {
        login.prop('disabled', true);
        login.removeClass("active").addClass("passive");
      }
    });
  });

});

jQuery(document).ready(function ($) {
  if (typeof localizedData !== "undefined") {
    if (localizedData.hasOwnProperty("run-script")) {
      $("section#banner #banner-slider").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        dots: true,
        prevArrow: `<button class="slick-prev slick-arrow" aria-label="Previous" type="button" style=""><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
    </svg></button>`,
        nextArrow: `<button class="slick-next slick-arrow" aria-label="Next" type="button" style=""><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi        bi-chevron-right" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
    </svg></button>`,
      });
      $(".content__booking-date").flatpickr({
        minDate: "today",
        mode: "range",
        dateFormat: "d-m-Y",
        onChange: function (selectedDates, dateStr, instance) {
          if (selectedDates.length === 2) {
            let check_in = selectedDates[0];
            let check_out = selectedDates[1];
            check_in = new Date(check_in);
            check_out = new Date(check_out);
            const estimated_days =
              (check_out - check_in) / (1000 * 60 * 60 * 24);
            check_in = check_in.toLocaleDateString("en-GB").replace(/\//g, "-");
            check_out = check_out
              .toLocaleDateString("en-GB")
              .replace(/\//g, "-");
            $("#check-in-time").html(check_in);
            $("#check-out-time").html(check_out);
            $("form#check-booking-time input[name=check-in]").val(check_in);
            $("form#check-booking-time input[name=check-out]").val(check_out);
            $("#estimated-days").html(
              `${estimated_days == 0 ? 1 : estimated_days} ngày`
            );
          }
        },
      });
    }
    if (localizedData.hasOwnProperty("run-select-location")) {
      $(".content__booking-branch-select").on("change", function () {
        let location_id = $(this).val();
        let location = locations.find((item) => item.id == location_id);
        if (location) {
          $("form#check-booking-time input[name=location]").val(location.id);
          if (location.hotels.length > 0) {
            if (localizedData.hasOwnProperty("reservation")) {
              var data = {
                action: "get_room_types",
                security: localizedData["nonce"],
                hotel_id: location.hotels[0].id,
              };
              $.get(localizedData["ajax_url"], data, function (response) {
                let room_types = response.data;
                let str = "";
                room_types.forEach((item) => {
                  str += `<option value="${item.ID}">${
                    item.post_title
                  } ${new Intl.NumberFormat({ style: "currency" }).format(
                    item.price
                  )}VNĐ+</option>`;
                });
                $("select[name=room_type]").html(str);
              }).fail(function () {
                alert("AJAX request failed!");
              });
            }
            $("form#check-booking-time input[name=hotel]").val(
              location.hotels[0].id
            );
          }
          let hotels = location.hotels;
          let str = "";
          hotels.forEach((item) => {
            str += `<option class="p-3" data-url="${item.permalink}" value="${item.id}">${item.name}</option>`;
          });
          $(".content__booking-hotel-name-select").html(str);
          $("form#check-booking-time").attr("action", hotels[0].permalink);
        }
      });
      $(document).on(
        "change",
        ".content__booking-hotel-name-select",
        function () {
          $("form#check-booking-time input[name=hotel]").val($(this).val());
          let selected = $(this).find(":selected");
          let url = $(selected).data("url");
          $("form#check-booking-time").attr("action", url);
        }
      );
    }
    if (localizedData.hasOwnProperty("reservation")) {
      flatpickr(".timepicker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
      });
      $("select[name=hotel]").on("change", function () {
        let hotel_id = $(this).val();
        var data = {
          action: "get_room_types",
          security: localizedData["nonce"],
          hotel_id: hotel_id,
        };
        $.get(localizedData["ajax_url"], data, function (response) {
          let room_types = response.data;
          let str = "";
          room_types.forEach((item) => {
            str += `<option value="${item.ID}">${
              item.post_title
            } ${new Intl.NumberFormat({ style: "currency" }).format(
              item.price
            )}VNĐ+</option>`;
          });
          $("select[name=room_type]").html(str);
        }).fail(function (err) {
          console.log(err);
        });
      });
      $("form#reservation-form").on("submit", function (e) {
        e.preventDefault();
        const form = $(this);
        $("input.timepicker").css("border-color", "#c5c5c5");
        $("#loadingOverlay").css("display", "flex");
        const formData = new FormData(this);
        formData.append("action", "reservation_submit");
        formData.append(
          "reservation_nonce",
          localizedData["reservation_nonce"]
        );
        $.ajax({
          url: localizedData["ajax_url"],
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            alert("Đặt phòng thành công, chúng tôi sẽ sớm liên hệ để xác nhận");
            form[0].reset();
          },
          error: function (err) {
            console.log(err);
            let errors = err.responseJSON.data;
            if (errors.hasOwnProperty("unavailable")) {
              return alert("Xin lỗi quý khách, đã hết phòng loại này!");
            } else if (errors.hasOwnProperty("error_nonce")) {
              return alert("Yêu cầu không hợp lệ");
            } else {
              alert("Có lỗi nhập dữ liệu, vui lòng kiểm tra lại!");
              for (const field in errors) {
                const str = errors[field];
                for (const x in str) {
                  if (field == "check-in-time" || field == "check-out-time") {
                    $(`input[name=${field}]`).css("border-color", "red");
                  } else {
                    $(`input[name=${field}]`).after(
                      `<span class="col-md-2 required__note">${str[x]}</span>`
                    );
                  }
                }
              }
            }
          },
          complete: function () {
            $("#loadingOverlay").css("display", "none");
          },
        });
      });
    }
  }

  $(window).on("scroll", function () {
    const $header = $("#masthead nav.navbar");
    if ($(this).scrollTop() > 50) {
      $header.addClass("scrolled");
    } else {
      $header.removeClass("scrolled");
    }
  });
});

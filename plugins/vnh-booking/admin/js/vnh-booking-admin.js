jQuery(document).ready(function ($) {
  $("#upload-gallery-btn").click(function (e) {
    e.preventDefault();
    var image = wp
      .media({
        title: "Upload Images",
        multiple: true,
      })
      .open()
      .on("select", function (e) {
        let selectedImages = image
          .state()
          .get("selection")
          .map((item) => {
            item.toJSON();
            return item;
          });

        selectedImages.map((image) => {
          $("#gallery").append(
            `<li>
        		<img style="width:100px;height:auto" src="${image.attributes.url}" alt="">
				  <span>
            		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
        		</span>
				<input id="gallery-item-${image.attributes.id}" type="hidden" name="gallery[]" value="${image.attributes.id}">
    		</li>
			`
          );
        });
      });
  });
  $("#gallery").sortable();
  $(document).on("click", "#gallery li span", function () {
    $(this).parent().remove();
  });
  $("#upload-room-type-floor-plan-btn").click(function (e) {
    e.preventDefault();
    var image = wp
      .media({
        title: "Upload Image",
        multiple: false,
      })
      .open()
      .on("select", function (e) {
        let selectedImage = image.state().get("selection").first();
        console.log(selectedImage);
        $("#floor-plan").html(
          `<img style="width:200px;height:auto" src="${selectedImage.attributes.url}" />
			<span>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
        	</span>
		  `
        );
        $("input[name=floor_plan]").val(selectedImage.id);
      });
  });
  $(document).on("click", "#floor-plan span", function () {
    $(this).parent().empty();
    $("input[name=floor_plan]").removeAttr("value");
  });

  if (typeof localizedData !== "undefined") {
    if (localizedData.hasOwnProperty("add_new_booking")) {
      $("input[name=check-in]").flatpickr({
        minDate: "today",
        dateFormat: "d-m-Y",
        onChange: function (selectedDate, dateStr, instance) {
          check_in = dateStr;
          check_out_date.clear();
          check_out_date.set("enable", [
            function (date) {
              return date >= selectedDate[0];
            },
          ]);
        },
      });
      const check_out_date = $("input[name=check-out]").flatpickr({
        minDate: "today",
        dateFormat: "d-m-Y",
        enable: [],
        onChange: function (selectedDate, dateStr, instance) {
          check_out = dateStr;
        },
      });
      flatpickr(".timepicker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
      });
      let hotel, check_in, check_out;
      $("#check-availability").on("click", function (event) {
        hotel = $("select[name=hotel]").val();
        if (!hotel || !check_in || !check_out) {
          return;
        }
        var data = {
          action: "check_availability",
          security: localizedData["nonce"],
          hotel: hotel,
          check_in: check_in,
          check_out: check_out,
        };
        const button = $(this);
        button.prop("disabled", true);
        button.next(".spinner").css("visibility", "visible");
        $.get(localizedData["ajax_url"], data, function (response) {
          let data = response.data;
          let available_rooms = data[0];
          let count = data[1];
          if (available_rooms.length > 0) {
            let str = `<tr id="room-types">
                        <th scope="row">
                            <label for="blogname">Available Room Types:</label>
                        </th>
                        <td>
                           <select name="room_type">
                              ${available_rooms
                                .map(function (item) {
                                  return `<option value="${
                                    item.ID
                                  }">${item.post_title} - ${new Intl.NumberFormat(
                                    {
                                      style: "currency",
                                    }
                                  ).format(
                                    item.meta.price
                                  )}vnđ+ (còn ${count[item.ID] ? parseInt(item.meta.quantity) - count[item.ID] : parseInt(item.meta.quantity)} phòng)</option>`;
                                })
                                .join("")}
                            </select>
                        </td>
                      </tr>`;
            if (!$("tr#room-types").length) {
              button.parent().parent().after(str);
            } else {
              $("tr#room-types").replaceWith(str);
            }
          } else {
            $("tr#room-types").remove();
            alert("No rooms available");
          }
        })
          .fail(function () {
            alert("AJAX request failed!");
          })
          .always(function () {
            button.prop("disabled", false);
            button.next(".spinner").css("visibility", "hidden");
          });
      });
    }
  }
});

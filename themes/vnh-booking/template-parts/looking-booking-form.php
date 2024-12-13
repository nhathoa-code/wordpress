<?php 
  $booking_date = checkBookingDate();
?>
<div class="is-sticky">
  <form id="check-booking-time" method="GET" action="<?php echo get_hotel_permalink() ?? $locations[0]["hotels"][0]["permalink"]; ?>">
    <div>
      <div class="content__booking">
        <div class="container">
          <div class="row gx-3 p-0 justify-content-center align-items-center">
            <div class="col-md-12 mb-3">
              <div class="content__booking-title">Đặt Phòng</div>
            </div>
              <div class="col-md-5 col-lg-4 mb-4 mb-md-0">
                <label id="label__booking-time" style="cursor:pointer;font-size:16px" class="d-flex flex-row justify-content-between align-items-center" for="booking-time">
                  <div class="d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                      <path d="M17.9984 5.30078H21.5984V23.3008H2.39844V5.30078H5.99844V4.10078C5.99844 3.60878 6.17844 3.18878 6.52644 2.82878C6.87444 2.48078 7.30644 2.30078 7.79844 2.30078C8.29044 2.30078 8.72244 2.48078 9.07044 2.82878C9.41844 3.18878 9.59844 3.60878 9.59844 4.10078V5.30078H14.3984V4.10078C14.3984 3.60878 14.5784 3.18878 14.9264 2.82878C15.2744 2.48078 15.7064 2.30078 16.1984 2.30078C16.6904 2.30078 17.1224 2.48078 17.4704 2.82878C17.8184 3.18878 17.9984 3.60878 17.9984 4.10078V5.30078ZM7.19844 4.10078V7.10078C7.19697 7.17998 7.21149 7.25866 7.24112 7.33211C7.27076 7.40557 7.3149 7.4723 7.37091 7.52831C7.42692 7.58432 7.49365 7.62846 7.56711 7.65809C7.64056 7.68773 7.71924 7.70225 7.79844 7.70078C7.87763 7.70225 7.95631 7.68773 8.02977 7.65809C8.10323 7.62846 8.16996 7.58432 8.22597 7.52831C8.28198 7.4723 8.32612 7.40557 8.35575 7.33211C8.38538 7.25866 8.3999 7.17998 8.39844 7.10078V4.10078C8.39844 3.93278 8.33844 3.78878 8.21844 3.68078C8.11044 3.56078 7.96644 3.50078 7.79844 3.50078C7.63044 3.50078 7.48644 3.56078 7.37844 3.68078C7.25844 3.78878 7.19844 3.93278 7.19844 4.10078ZM15.5984 4.10078V7.10078C15.5984 7.26878 15.6584 7.41278 15.7664 7.53278C15.8864 7.64078 16.0304 7.70078 16.1984 7.70078C16.3664 7.70078 16.5104 7.64078 16.6304 7.53278C16.7384 7.41278 16.7984 7.26878 16.7984 7.10078V4.10078C16.7999 4.02159 16.7854 3.94291 16.7558 3.86945C16.7261 3.79599 16.682 3.72926 16.626 3.67325C16.57 3.61724 16.5032 3.5731 16.4298 3.54347C16.3563 3.51383 16.2776 3.49932 16.1984 3.50078C16.1192 3.49932 16.0406 3.51383 15.9671 3.54347C15.8936 3.5731 15.8269 3.61724 15.7709 3.67325C15.7149 3.72926 15.6708 3.79599 15.6411 3.86945C15.6115 3.94291 15.597 4.02159 15.5984 4.10078ZM20.3984 22.1008V10.1008H3.59844V22.1008H20.3984ZM8.39844 11.3008V13.7008H5.99844V11.3008H8.39844ZM10.7984 11.3008H13.1984V13.7008H10.7984V11.3008ZM15.5984 13.7008V11.3008H17.9984V13.7008H15.5984ZM8.39844 14.9008V17.3008H5.99844V14.9008H8.39844ZM10.7984 14.9008H13.1984V17.3008H10.7984V14.9008ZM15.5984 17.3008V14.9008H17.9984V17.3008H15.5984ZM8.39844 18.5008V20.9008H5.99844V18.5008H8.39844ZM13.1984 20.9008H10.7984V18.5008H13.1984V20.9008ZM17.9984 20.9008H15.5984V18.5008H17.9984V20.9008Z" fill="#fff"/>
                    </svg>
                    <div class="d-flex flex-column">
                      <span>Nhận phòng</span>
                      <span id="check-in-time"><?php echo $booking_date ? $_GET['check-in'] : date("d-m-Y"); ?></span>
                    </div>
                  </div>
                  <div id="estimated-days">
                    <?php echo $booking_date ? $booking_date : 1 ?> ngày
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                      <path d="M17.9984 5.30078H21.5984V23.3008H2.39844V5.30078H5.99844V4.10078C5.99844 3.60878 6.17844 3.18878 6.52644 2.82878C6.87444 2.48078 7.30644 2.30078 7.79844 2.30078C8.29044 2.30078 8.72244 2.48078 9.07044 2.82878C9.41844 3.18878 9.59844 3.60878 9.59844 4.10078V5.30078H14.3984V4.10078C14.3984 3.60878 14.5784 3.18878 14.9264 2.82878C15.2744 2.48078 15.7064 2.30078 16.1984 2.30078C16.6904 2.30078 17.1224 2.48078 17.4704 2.82878C17.8184 3.18878 17.9984 3.60878 17.9984 4.10078V5.30078ZM7.19844 4.10078V7.10078C7.19697 7.17998 7.21149 7.25866 7.24112 7.33211C7.27076 7.40557 7.3149 7.4723 7.37091 7.52831C7.42692 7.58432 7.49365 7.62846 7.56711 7.65809C7.64056 7.68773 7.71924 7.70225 7.79844 7.70078C7.87763 7.70225 7.95631 7.68773 8.02977 7.65809C8.10323 7.62846 8.16996 7.58432 8.22597 7.52831C8.28198 7.4723 8.32612 7.40557 8.35575 7.33211C8.38538 7.25866 8.3999 7.17998 8.39844 7.10078V4.10078C8.39844 3.93278 8.33844 3.78878 8.21844 3.68078C8.11044 3.56078 7.96644 3.50078 7.79844 3.50078C7.63044 3.50078 7.48644 3.56078 7.37844 3.68078C7.25844 3.78878 7.19844 3.93278 7.19844 4.10078ZM15.5984 4.10078V7.10078C15.5984 7.26878 15.6584 7.41278 15.7664 7.53278C15.8864 7.64078 16.0304 7.70078 16.1984 7.70078C16.3664 7.70078 16.5104 7.64078 16.6304 7.53278C16.7384 7.41278 16.7984 7.26878 16.7984 7.10078V4.10078C16.7999 4.02159 16.7854 3.94291 16.7558 3.86945C16.7261 3.79599 16.682 3.72926 16.626 3.67325C16.57 3.61724 16.5032 3.5731 16.4298 3.54347C16.3563 3.51383 16.2776 3.49932 16.1984 3.50078C16.1192 3.49932 16.0406 3.51383 15.9671 3.54347C15.8936 3.5731 15.8269 3.61724 15.7709 3.67325C15.7149 3.72926 15.6708 3.79599 15.6411 3.86945C15.6115 3.94291 15.597 4.02159 15.5984 4.10078ZM20.3984 22.1008V10.1008H3.59844V22.1008H20.3984ZM8.39844 11.3008V13.7008H5.99844V11.3008H8.39844ZM10.7984 11.3008H13.1984V13.7008H10.7984V11.3008ZM15.5984 13.7008V11.3008H17.9984V13.7008H15.5984ZM8.39844 14.9008V17.3008H5.99844V14.9008H8.39844ZM10.7984 14.9008H13.1984V17.3008H10.7984V14.9008ZM15.5984 17.3008V14.9008H17.9984V17.3008H15.5984ZM8.39844 18.5008V20.9008H5.99844V18.5008H8.39844ZM13.1984 20.9008H10.7984V18.5008H13.1984V20.9008ZM17.9984 20.9008H15.5984V18.5008H17.9984V20.9008Z" fill="#fff"/>
                    </svg>
                    <div class="d-flex flex-column">
                      <span>Trả phòng</span>
                      <span id="check-out-time"><?php echo $booking_date ? $_GET['check-out'] : date("d-m-Y",strtotime("+1 day")); ?></span>
                    </div>
                  </div>
                  <input
                  class="col-md-12 content__booking-date"
                  type="text"
                  id="booking-time"
                  readonly="readonly"
                />
                </label>
              </div>
              <div class="col-md-2 mb-4 mb-md-0">
                <div class="content__booking-branch">
                  <select class="content__booking-branch-select">
                    <?php foreach($locations as $l): ?>
                      <option <?php selected($l["id"] == (isset($_GET["location"]) ? (int) $_GET["location"] : null)); ?> class="p-3" value="<?php echo $l["id"]; ?>"><?php echo $l["name"]; ?></option>	
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2 mb-4 mb-md-0">
                <div class="content__booking-hotel-select">
                  <select class="content__booking-hotel-name-select">
                    <?php 
                      global $location;
                      $hotels = $location->getHotels(isset($_GET["location"]) ? $_GET["location"] : null);
                    ?>
                    <?php foreach($hotels as $h): ?>
                      <option <?php selected($h["id"] == (isset($_GET["hotel"]) ? (int) $_GET["hotel"] : null)); ?> class="p-3" data-url="<?php echo $h["permalink"]; ?>" value="<?php echo $h["id"]; ?>">
                        <?php echo $h["name"]; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <button class="base__btn btn--mobile">
                  Kiểm tra phòng
                </button>
              </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="check-in" value="<?php echo date("d-m-Y"); ?>">
    <input type="hidden" name="check-out" value="<?php echo date("d-m-Y",strtotime("+1 day")); ?>">
    <input type="hidden" name="location" value="<?php echo $locations[0]["id"]; ?>">
    <input type="hidden" name="hotel" value="<?php echo $locations[0]["hotels"][0]["id"]; ?>">
  </form>
</div>
<script>  
  var locations = <?php echo json_encode($locations); ?>;
      console.log(locations);
</script>
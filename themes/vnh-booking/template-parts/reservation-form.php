<?php
  global $errors;
  $booking_date = checkBookingDate();
?>
<form method="POST" id="reservation-form">
  <div class="container">
    <div class="reservation__container">
      <div class="reserve-container">
        <div class="row">
          <div class="col-md-2 name__title">
            Ngày đặt phòng: <span class="required__note">*</span>
          </div>
          <div class="col-md-8 ps-0">
            <div class="col-md-12 col-lg-6">
                <label id="label__booking-time" style="cursor:pointer;font-size:16px;margin-left:0;margin-right:0;margin-bottom:20px" class="d-flex flex-row justify-content-between align-items-center" for="booking-time">
                  <div class="d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                      <path d="M17.9984 5.30078H21.5984V23.3008H2.39844V5.30078H5.99844V4.10078C5.99844 3.60878 6.17844 3.18878 6.52644 2.82878C6.87444 2.48078 7.30644 2.30078 7.79844 2.30078C8.29044 2.30078 8.72244 2.48078 9.07044 2.82878C9.41844 3.18878 9.59844 3.60878 9.59844 4.10078V5.30078H14.3984V4.10078C14.3984 3.60878 14.5784 3.18878 14.9264 2.82878C15.2744 2.48078 15.7064 2.30078 16.1984 2.30078C16.6904 2.30078 17.1224 2.48078 17.4704 2.82878C17.8184 3.18878 17.9984 3.60878 17.9984 4.10078V5.30078ZM7.19844 4.10078V7.10078C7.19697 7.17998 7.21149 7.25866 7.24112 7.33211C7.27076 7.40557 7.3149 7.4723 7.37091 7.52831C7.42692 7.58432 7.49365 7.62846 7.56711 7.65809C7.64056 7.68773 7.71924 7.70225 7.79844 7.70078C7.87763 7.70225 7.95631 7.68773 8.02977 7.65809C8.10323 7.62846 8.16996 7.58432 8.22597 7.52831C8.28198 7.4723 8.32612 7.40557 8.35575 7.33211C8.38538 7.25866 8.3999 7.17998 8.39844 7.10078V4.10078C8.39844 3.93278 8.33844 3.78878 8.21844 3.68078C8.11044 3.56078 7.96644 3.50078 7.79844 3.50078C7.63044 3.50078 7.48644 3.56078 7.37844 3.68078C7.25844 3.78878 7.19844 3.93278 7.19844 4.10078ZM15.5984 4.10078V7.10078C15.5984 7.26878 15.6584 7.41278 15.7664 7.53278C15.8864 7.64078 16.0304 7.70078 16.1984 7.70078C16.3664 7.70078 16.5104 7.64078 16.6304 7.53278C16.7384 7.41278 16.7984 7.26878 16.7984 7.10078V4.10078C16.7999 4.02159 16.7854 3.94291 16.7558 3.86945C16.7261 3.79599 16.682 3.72926 16.626 3.67325C16.57 3.61724 16.5032 3.5731 16.4298 3.54347C16.3563 3.51383 16.2776 3.49932 16.1984 3.50078C16.1192 3.49932 16.0406 3.51383 15.9671 3.54347C15.8936 3.5731 15.8269 3.61724 15.7709 3.67325C15.7149 3.72926 15.6708 3.79599 15.6411 3.86945C15.6115 3.94291 15.597 4.02159 15.5984 4.10078ZM20.3984 22.1008V10.1008H3.59844V22.1008H20.3984ZM8.39844 11.3008V13.7008H5.99844V11.3008H8.39844ZM10.7984 11.3008H13.1984V13.7008H10.7984V11.3008ZM15.5984 13.7008V11.3008H17.9984V13.7008H15.5984ZM8.39844 14.9008V17.3008H5.99844V14.9008H8.39844ZM10.7984 14.9008H13.1984V17.3008H10.7984V14.9008ZM15.5984 17.3008V14.9008H17.9984V17.3008H15.5984ZM8.39844 18.5008V20.9008H5.99844V18.5008H8.39844ZM13.1984 20.9008H10.7984V18.5008H13.1984V20.9008ZM17.9984 20.9008H15.5984V18.5008H17.9984V20.9008Z" fill="#000"/>
                    </svg>
                    <div class="d-flex flex-column">
                      <span>Nhận phòng</span>
                      <span id="check-in-time"><?php echo isset($_GET['check-in']) ? $_GET['check-in'] : date("d-m-Y"); ?></span>
                    </div>
                  </div>
                  <div id="estimated-days">
                    <?php 
                      if(isset($_GET['check-in']) && isset($_GET['check-out'])){
                          $date1 = new DateTime($_GET['check-in']);
                          $date2 = new DateTime($_GET['check-out']);
                          $interval = $date1->diff($date2);
                          $daysBetween = $interval->days;
                      } 
                   
                    ?>
                    <?php echo isset($daysBetween) ? $daysBetween : 1 ?> ngày
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                      <path d="M17.9984 5.30078H21.5984V23.3008H2.39844V5.30078H5.99844V4.10078C5.99844 3.60878 6.17844 3.18878 6.52644 2.82878C6.87444 2.48078 7.30644 2.30078 7.79844 2.30078C8.29044 2.30078 8.72244 2.48078 9.07044 2.82878C9.41844 3.18878 9.59844 3.60878 9.59844 4.10078V5.30078H14.3984V4.10078C14.3984 3.60878 14.5784 3.18878 14.9264 2.82878C15.2744 2.48078 15.7064 2.30078 16.1984 2.30078C16.6904 2.30078 17.1224 2.48078 17.4704 2.82878C17.8184 3.18878 17.9984 3.60878 17.9984 4.10078V5.30078ZM7.19844 4.10078V7.10078C7.19697 7.17998 7.21149 7.25866 7.24112 7.33211C7.27076 7.40557 7.3149 7.4723 7.37091 7.52831C7.42692 7.58432 7.49365 7.62846 7.56711 7.65809C7.64056 7.68773 7.71924 7.70225 7.79844 7.70078C7.87763 7.70225 7.95631 7.68773 8.02977 7.65809C8.10323 7.62846 8.16996 7.58432 8.22597 7.52831C8.28198 7.4723 8.32612 7.40557 8.35575 7.33211C8.38538 7.25866 8.3999 7.17998 8.39844 7.10078V4.10078C8.39844 3.93278 8.33844 3.78878 8.21844 3.68078C8.11044 3.56078 7.96644 3.50078 7.79844 3.50078C7.63044 3.50078 7.48644 3.56078 7.37844 3.68078C7.25844 3.78878 7.19844 3.93278 7.19844 4.10078ZM15.5984 4.10078V7.10078C15.5984 7.26878 15.6584 7.41278 15.7664 7.53278C15.8864 7.64078 16.0304 7.70078 16.1984 7.70078C16.3664 7.70078 16.5104 7.64078 16.6304 7.53278C16.7384 7.41278 16.7984 7.26878 16.7984 7.10078V4.10078C16.7999 4.02159 16.7854 3.94291 16.7558 3.86945C16.7261 3.79599 16.682 3.72926 16.626 3.67325C16.57 3.61724 16.5032 3.5731 16.4298 3.54347C16.3563 3.51383 16.2776 3.49932 16.1984 3.50078C16.1192 3.49932 16.0406 3.51383 15.9671 3.54347C15.8936 3.5731 15.8269 3.61724 15.7709 3.67325C15.7149 3.72926 15.6708 3.79599 15.6411 3.86945C15.6115 3.94291 15.597 4.02159 15.5984 4.10078ZM20.3984 22.1008V10.1008H3.59844V22.1008H20.3984ZM8.39844 11.3008V13.7008H5.99844V11.3008H8.39844ZM10.7984 11.3008H13.1984V13.7008H10.7984V11.3008ZM15.5984 13.7008V11.3008H17.9984V13.7008H15.5984ZM8.39844 14.9008V17.3008H5.99844V14.9008H8.39844ZM10.7984 14.9008H13.1984V17.3008H10.7984V14.9008ZM15.5984 17.3008V14.9008H17.9984V17.3008H15.5984ZM8.39844 18.5008V20.9008H5.99844V18.5008H8.39844ZM13.1984 20.9008H10.7984V18.5008H13.1984V20.9008ZM17.9984 20.9008H15.5984V18.5008H17.9984V20.9008Z" fill="#000"/>
                    </svg>
                    <div class="d-flex flex-column">
                      <span>Trả phòng</span>
                      <span id="check-out-time"><?php echo isset($_GET['check-out']) ? $_GET['check-out'] : date("d-m-Y",strtotime("+1 day")); ?></span>
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
          </div>
        
        </div>
        <div class="row">
          <div class="col-md-2 name__title">
            Lựa chọn chi nhánh: <span class="required__note">*</span>
          </div>
          <select class="col-md-4 col-lg-2 form__content content__booking-branch-select">
            <?php foreach($locations as $l): ?>
              <option <?php selected($l["id"] == (isset($_GET["location"]) ? $_GET["location"] : 0)); ?> class="p-3" value="<?php echo $l["id"]; ?>"><?php echo $l["name"]; ?></option>	
            <?php endforeach; ?>
          </select>
          <select name="hotel" class="col-md-4 col-lg-2 form__content content__booking-hotel-name-select">
            <?php 
                global $location;
                $hotels = $location->getHotels(isset($_GET["location"]) ? $_GET["location"] : null);
            ?>
            <?php foreach($hotels as $h): ?>
              <?php 
                if(isset($_GET["hotel"])){
                  if($h["id"] == $_GET["hotel"]){
                    $hotel_id = $h["id"];
                  }
                }  
              ?>
              <option <?php selected($h["id"] == (isset($_GET["hotel"]) ? $_GET["hotel"] : 0)); ?> class="p-3" data-url="<?php echo $h["permalink"]; ?>" value="<?php echo $h["id"]; ?>">
                <?php echo $h["name"]; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-4 col-lg-2 name__title">
            Thời gian nhận phòng:<small style="font-weight: 600"
              >(Thời gian check in bình thường: 3 giờ chiều)</small
            >
          </div>
          <input
            placeholder="Thời gian nhận phòng:"
            class="col-md-4 form__content timepicker"
            name="check-in-time"
            type="text"
          />
          <div class="col-12 d-md-block d-none"></div>
          <div class="col-md-4 col-lg-2 name__title check-out-time">
            Thời gian trả phòng:<small style="font-weight: 600"
              >(Thời gian check out bình thường: 12 giờ trưa)</small
            >
          </div>
          <input
            placeholder="Thời gian trả phòng:"
            class="col-md-4 form__content timepicker"
            name="check-out-time"
            type="text"
          />
        </div>
        <div class="row">
          <?php 
            if(isset($hotel_id)){
              $hotel->setId($hotel_id);
            }else{
              $hotel->setId($hotels[0]["id"]);
            }
            $room_types = $hotel->getRoomTypes();
          ?>
          <div class="col-md-4 col-lg-2 name__title">
            Hạng phòng:<span class="required__note">*</span>
          </div>
          <select name="room_type" class="col-md-4 form__content">
            <?php foreach($room_types as $rt): $meta = get_post_meta($rt->ID,"vnh_room_type_meta",true); ?>
              <option <?php selected($rt->ID == (isset($_GET["room_type"]) ? $_GET["room_type"] : 0)); ?> value="<?php echo $rt->ID; ?>"><?php echo $rt->post_title; ?> <?php echo number_format($meta["price"],0,".",".") ?>VNĐ+</option>
            <?php endforeach; ?> 
          </select>
        </div>
        <div class="row">
          <div class="col-md-4 col-lg-2 name__title">
            Số lượng phòng:<span class="required__note">*</span>
          </div>
          <select name="quantity" class="col-md-4 form__content" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
          <div class="col-12"></div>
          <div class="col-md-4 col-lg-2 name__title">
            Số lượng khách lưu trú trong phòng:<span class="required__note"
              >*</span
            >
          </div>
          <select name="guests" class="col-md-4 form__content">
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </div>
      </div>
      <div class="container p-0" data-rttabs="true">
        <div class="col-md-12 p-0" data-rttabs="true">
          <ul class="service__list mt-0" role="tablist">
          </ul>
          <div
            class="react-tabs__tab-panel react-tabs__tab-panel--selected"
            role="tabpanel"
            id="panel0"
            aria-labelledby="tab0"
          >
            <div class="guest-container">
              <div class="row">
                <div class="guest__information">
                  <div class="col-md-12 mb-5 guest__name-title">
                    Thông tin khách đại diện
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-2 name__title">
                      Tên khách:<span class="required__note">*</span
                      ><small
                        >(Xin vui lòng điền tên tất cả các khách lưu trú)</small
                      >
                    </div>
                    <input
                      placeholder="Họ"
                      type="text"
                      class="col-md-4 form__content"
                      name="g_firstName"
                      required
                    />
                    <input
                      placeholder="Tên riêng"
                      type="text"
                      name="g_lastName"
                      class="col-md-4 form__content"
                      required
                    />
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-2 name__title">
                      Giới Tính:<span class="required__note">*</span>
                    </div>
                    <div class="col-md-2 form__group">
                      <input
                        type="radio"
                        name="g_gender"
                        id="gMale"
                        value="Mr."
                        checked
                      /><label for="gMale">Nam</label>
                    </div>
                    <div class="col-md-2">
                      <input
                        type="radio"
                        name="g_gender"
                        id="gFemale"
                        value="Ms."
                      /><label for="gFemale">Nữ</label>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-2 name__title">
                      Địa chỉ E-mail<span class="col-md-2 required__note"
                        >*</span
                      >
                    </div>
                    <input
                      type="text"
                      class="col-md-4 form__content"
                      placeholder="Địa chỉ E-mail"
                      name="g_email"
                      required
                    />
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-2 name__title">
                      Số điện thoại:<span class="col-md-2 required__note"
                        >*</span
                      >
                    </div>
                    <input
                      type="text"
                      maxlength="12"
                      class="col-md-4 form__content"
                      placeholder="Số điện thoại:"
                      name="g_phone"
                      required
                    />
                  </div>
                  <div class="row">
                    <div class="col-md-2 name__title">
                      Hình thức thanh toán:
                    </div>
                    <select name="payment_method" class="col-md-2 form__content" style="width: 350px">
                      <option value="By cash at counter (VND/USD/JPY)">
                        Thanh toán bằng tiền mặt tại quầy (VND/USD/JPY)
                      </option>
                      <option value="By credit at counter (VND only)">
                        Thanh toán bằng thẻ tại quầy (chỉ tiền Việt)
                      </option>
                      <option value="By company transfer after check out">
                        Thanh toán công ty chuyển khoản trước ngày nhận phòng
                      </option>
                      <option value="Others">Khác</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="other-container">
        <div class="row">
          <div class="col-md-2 name__title">
            Yêu cầu đặc biệt khác:<br /><small
              >(Trả phòng muộn, đón sân bay,...)</small
            >
          </div>
          <div class="col-md-6">
             <textarea
              name="note"
              class="text-note"
              cols="40"
              rows="6"
              placeholder="Vui lòng cho chúng tôi biết nếu bạn có bất kỳ yêu cầu nào"
            ></textarea>
          </div>
        </div>
      
        <div class="row">
          <div class="col-md-12 offset-4">
            <button id="send" class="base__btn btn__send" type="submit" name="submit_make_reservation">
              Gửi
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" name="check-in" value="<?php echo $booking_date ? $_GET["check-in"] : date("d-m-Y"); ?>">
  <input type="hidden" name="check-out" value="<?php echo $booking_date ? $_GET["check-out"] : date("d-m-Y",strtotime("+1 day")); ?>">
</form>
<div class="loading-overlay" id="loadingOverlay">
  <div class="cls_loader" style="display: flex">
    <div class="sk-three-bounce">
      <div class="sk-child sk-bounce1"></div>
      <div class="sk-child sk-bounce2"></div>
      <div class="sk-child sk-bounce3"></div>
    </div>
  </div>
</div>
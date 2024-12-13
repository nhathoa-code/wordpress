<style>
    #label__booking-time input#booking-time {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
        display: inline-block;
        opacity: 0;
    }
    input{
      text-align: center;
    }
    #post-body-content{
      margin-bottom: 0;
    }
</style>
<table class="form-table">
    <tbody>
        <tr>
          <th scope="row">
              <label for="blogname">Khách sạn:</label>
          </th>
          <td>
              <select name="hotel">
                <?php foreach($hotels as $h): ?>
                  <option value="<?php echo $h->ID; ?>"><?php echo $h->post_title; ?></option>
                <?php endforeach; ?>
              </select>
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Ngày nhận phòng:</label>
          </th>
          <td>
              <input name="check-in" type="text">
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Ngày trả phòng:</label>
          </th>
          <td>
              <input name="check-out" type="text">
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Kiểm tra tình trạng phòng:</label>
          </th>
          <td>
            <button type="button" id="check-availability" class="button button-secondary">Kiểm tra</button>
            <span style="float:none" class="spinner"></span>
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Thời gian nhận phòng:</label>
          </th>
          <td>
              <input name="check-in-time" type="text" class="timepicker">
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Thời gian trả phòng:</label>
          </th>
          <td>
              <input name="check-out-time" type="text" class="timepicker">
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Số lượng phòng:</label>
          </th>
          <td>
              <select name="quantity">
                  <?php for($i=1;$i<=5;$i++): ?>
                    <option value="<?php echo $i ?>"><?php echo $i; ?></option>
                  <?php endfor; ?>
              </select>
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Số lượng khách:</label>
          </th>
          <td>
              <select name="guests">
                  <?php for($i=1;$i<=2;$i++): ?>
                    <option value="<?php echo $i ?>"><?php echo $i; ?></option>
                  <?php endfor; ?>
              </select>
          </td>
        </tr>
       
    </tbody>
</table>
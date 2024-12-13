<table class="form-table">
    <tbody>
        <tr>
          <th scope="row">
              <label for="blogname">First Name:</label>
          </th>
          <td>
             <input name="g_firstName" type="text">
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Last Name:</label>
          </th>
          <td>
             <input name="g_lastName" type="text">
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Giới tính:</label>
          </th>
          <td>
            <label>
                Nam
                <input type="radio" value="mr" name="g_gender">
            </label>
            <label>
                Nữ
                <input type="radio" value="mrs" name="g_gender">
            </label>
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Email:</label>
          </th>
          <td>
             <input type="text" name="g_email">
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Phone:</label>
          </th>
          <td>
             <input type="text" name="g_phone">
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Phương thức thanh toán:</label>
          </th>
          <td>
             <select name="payment_method">
                <option value="By cash at counter (VND/USD/JPY)">
                        Thanh toán bằng tiền mặt tại quầy (VND/USD/JPY)
                </option>
             </select>
          </td>
        </tr>
        <tr>
          <th scope="row">
              <label for="blogname">Ghi chú:</label>
          </th>
          <td>
             <textarea name="note" rows="4" cols="50"></textarea>
          </td>
        </tr>
    </tbody>
</table>
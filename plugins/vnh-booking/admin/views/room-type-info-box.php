<table class="form-table">
    <tbody>
        <tr>
            <th scope="row">
                <label for="blogname">Khách sạn:</label>
            </th>
            <td>
                <span> <?php echo sprintf('<strong><a class="row-title" href="%s" (Edit)">%s</a></strong>',get_edit_post_link($hotel->ID),$hotel->post_title); ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blogname">Loại phòng:</label>
            </th>
            <td>
                <span> <?php echo sprintf('<strong><a class="row-title" href="%s" (Edit)">%s</a></strong>',get_edit_post_link($room_type->ID),$room_type->post_title); ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blogname">Số lượng khách:</label>
            </th>
            <td>
               <span> <?php echo $meta["guests"]; ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blogname">Số lượng phòng:</label>
            </th>
            <td>
               <span> <?php echo $meta["quantity"]; ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blogname">Số phòng:</label>
            </th>
            <td>
                <ul style="margin:0">
                    <?php for($i=1;$i<=$meta["quantity"];$i++): ?>
                        <li>
                            <label for="">
                                Phòng <?php echo $i; ?>:
                                <input type="text" name="room-no-<?php echo $i; ?>" value="<?php echo isset($meta["room-no"][$i - 1]) ? $meta["room-no"][$i - 1] : "" ?>">
                            </label>
                        </li>
                    <?php endfor; ?>
                </ul>
            </td>
        </tr>
    </tbody>
</table>
<style>
    #post-body-content{
        margin-bottom: 0 !important;
    }
</style>
<table class="form-table">
    <tbody>
        <tr>
            <th scope="row">
                <label for="blogname">ID</label>
            </th>
            <td>
                <input readonly type="text" value="<?php echo $booking->ID; ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blogname">Thời gian nhận phòng</label>
            </th>
            <td>
                <input readonly type="text" value="<?php echo $check_in . " " . $meta["check_in_time"]; ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blogname">Thời gian trả phòng</label>
            </th>
            <td>
                <input readonly type="text" value="<?php echo $check_out . " " . $meta["check_out_time"]; ?>">
            </td>
        </tr>
    </tbody>
</table>
<table class="form-table">
    <tbody>
        <tr>
            <th scope="row">
                <label for="blogname">First Name</label>
            </th>
            <td>
                <input type="text" value="<?php echo $guest["g_firstName"]; ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blogname">Last Name</label>
            </th>
            <td>
                <input type="text" value="<?php echo $guest["g_lastName"]; ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blogname">Email</label>
            </th>
            <td>
                <input type="text" value="<?php echo $guest["g_email"]; ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blogname">Số điện thoại</label>
            </th>
            <td>
                <input type="text" value="<?php echo $guest["g_phone"]; ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blogname">Số chứng minh</label>
            </th>
            <td>
                <input type="text" value="<?php echo $guest["g_cccd"] ?? ""; ?>">
            </td>
        </tr>
    </tbody>
</table>
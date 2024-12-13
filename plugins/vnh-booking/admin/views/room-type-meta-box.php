<style>
    #floor-plan{
        position: relative;
        display: inline-block;
    }
    #floor-plan span{
        position: absolute;
        width: 15px;
        height: 15px;
        cursor: pointer;
        top: 2px;
        right:2px;
    }
</style>
<table class="form-table" role="presentation">
	<tbody>
        <tr>
            <th scope="row"><label>Hotel</label></th>
            <td>
               <select name="hotel">
                    <?php foreach($hotels as $h): ?>
                        <option <?php selected($h->ID,$hotel ?? 0); ?> value="<?php echo $h->ID; ?>"><?php echo $h->post_title; ?></option>
                    <?php endforeach; ?>
			    </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label>Bed type</label></th>
            <td>
               <select name="bed_type">
                    <?php foreach($bed_types as $b_t): ?>
                        <option <?php selected($b_t->ID,$bed_type ?? 0); ?> value="<?php echo $b_t->ID; ?>"><?php echo $b_t->post_title; ?></option>
                    <?php endforeach; ?>
			    </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label>Size</label>
            </th>
            <td>
                <input name="room_size" type="number" step="0.5" class="small-text" value="<?php echo $meta["room_size"] ?? ""; ?>">
                <span>m²</span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label>Opacity</label>
            </th>
            <td>
                <input name="opacity" type="number" class="small-text" value="<?php echo $meta["opacity"] ?? "" ?>">
                <span>people</span>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label>Price</label>
            </th>
            <td>
                <input name="price" type="number" value="<?php echo $meta["price"] ?? ""; ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label>Quantity</label>
            </th>
            <td>
                <input name="quantity" type="number" value="<?php echo $meta["quantity"] ?? ""; ?>">
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><label for="role">Available services</label></th>
            <td>
               <ul>
                    <?php foreach($services as $s): ?>
                        <li>
                            <label class="selectit">
                                <input <?php checked(in_array($s->ID,$room_type_services != "" ? $room_type_services : [])); ?> value="<?php echo $s->ID; ?>" type="checkbox" name="services[]" id="service-<?php echo $s->ID; ?>"><?php echo $s->post_title; ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
			    </ul>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="first_name">Floor plan</label>
            </th>
            <td>
                <div id="floor-plan">
                    <?php if($floor_plan): ?>
                        <img style="width:200px;height:auto" src="<?php echo $floor_plan->guid; ?>" />
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                        </span>
                    <?php endif; ?>
                </div>
                
                <div>
                    <button type="button" id="upload-room-type-floor-plan-btn" class="upload-button button-add-media button-add-site-icon" data-alt-classes="button">
                        Choose image
                    </button>
                </div>
                <input type="hidden" name="floor_plan" value="<?php echo $floor_plan->ID ?? 0; ?>">
            </td>
        </tr>
	</tbody>
</table>
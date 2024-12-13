<div class="submitbox" id="submitpost">
    <div style="display:flex;align-items:center">
        <label for="custom_status">Status:</label>
        <select name="status" style="flex:1">
            <?php foreach($status_arr as $item): ?>
                <option value="<?php echo $item; ?>" <?php selected($item, $status); ?>><?php echo $item; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="misc-pub-section curtime misc-pub-curtime">
        <span id="timestamp">
            Created on: <b><?php echo $booking->post_date; ?></b>				
        </span>
    </div>
    <div id="major-publishing-actions">
		<div id="delete-action">
			<a class="submitdelete deletion" href="<?php echo $delete_link; ?>">Move to Trash</a>
		</div>
        <div id="publishing-action">
            <span class="spinner"></span>
            <input name="original_publish" type="hidden" id="original_publish" value="Update">
            <input type="submit" name="save" id="publish" class="button button-primary button-large" value="Update">				
        </div>
	    <div class="clear"></div>
    </div>

</div>


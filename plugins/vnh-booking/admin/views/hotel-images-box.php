<style>
  #gallery{
    display: flex;
    gap:10px;
  }
  #gallery li{
    cursor: move;
    position: relative;
  }
  #gallery li span{
    position: absolute;
    width: 15px;
    height: 15px;
    cursor: pointer;
    top: 2px;
    right:2px;
  }
</style>
<ul id="gallery">  
    <?php foreach($urls as $u): ?>
        <li>
            <img style="width:100px;height:auto" src="<?php echo $u->guid; ?>" alt="">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
            </span>
            <input id="gallery-item-<?php echo $u->ID; ?>" type="hidden" name="gallery[]" value="<?php echo $u->ID; ?>">
        </li>
    <?php endforeach; ?>
</ul>
<button type="button" id="upload-gallery-btn" class="upload-button button-add-media button-add-site-icon" data-alt-classes="button">
    Choose images
</button>

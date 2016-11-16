<?php echo $header; ?>
<?php include('catalog/view/theme/'.$this->config->get('config_template').'/template/new_elements/wrapper_top.tpl'); ?>
  <?php if ($profiles) { ?>

    <table class="list">
        <thead>
        <tr>
            <td class="left"><?php echo $column_profile_id; ?></td>
            <td class="left"><?php echo $column_created; ?></td>
            <td class="left"><?php echo $column_status; ?></td>
            <td class="left"><?php echo $column_product; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
        </tr>
        </thead>
        <tbody>
        <?php if ($profiles) { ?>
        <?php foreach ($profiles as $profile) { ?>
        <tr>
            <td class="left">#<?php echo $profile['id']; ?></td>
            <td class="left"><?php echo $profile['created']; ?></td>
            <td class="left"><?php echo $status_types[$profile['status']]; ?></td>
            <td class="left"><?php echo $profile['name']; ?></td>
            <td class="right"><a href="<?php echo $profile['href']; ?>"><img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" /></a></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
            <td class="center" colspan="5"><?php echo $text_empty; ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>

  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
<?php include('catalog/view/theme/'.$this->config->get('config_template').'/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>
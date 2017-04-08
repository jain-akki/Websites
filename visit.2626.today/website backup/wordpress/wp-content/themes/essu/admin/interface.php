<?php
  get_template_part('/admin/js/main.js');
  if(!isset($page)) $page='main';
  $options = $this->validate_options($this->options[$page]);
?>

<div id="of_container" class="kktfwp-admin-wrap">
	<div class="of-save-popup" id="of-popup-save">
	<div class="of-save-save"><?php esc_html_e( 'Options Updated','essu' )?></div>
</div>


<div class="of-save-popup" id="of-popup-reset">
	<div class="of-save-reset"><?php esc_html_e( 'Options Reset','essu' )?></div>
</div>

<form id="ofform" enctype="multipart/form-data" action="" method="post">

	<div id="header">
	
		<div class="logo">
			<h1><?php echo esc_html( $options['title'] )?></h1>
		</div>
		
		<div class="icon-option"> </div>
		
		<div class="clear">&nbsp;</div>
		
	</div>

	<div id="main">
	
		<div id="of-nav">
			<ul>
			
				<?php $first=true;foreach($options as $group=>$data) if($group != "title"){?>
				
				<li <?php if( $first ){ echo 'class="first"';$first=false; }?>>
				
					<a href="#<?php echo str_replace(' ', '', $group);?>" title="<?php echo esc_attr( $group )?>">				
						<?php echo esc_html( $group ); ?>
					</a>
				
				</li>
				<?php }?>
				
			</ul>
			
			<div class="clear">&nbsp;</div>
		</div>

		<div id="content">
			<?php foreach($options as $group=>$gdata) if($group != "title"){?>
			
				<div id="<?php echo str_replace(' ', '', $group)?>" class="group" style="display: block;">
				
					<h2><?php echo esc_html( $group );?></h2>

					<?php foreach($gdata as $section=>$sdata){?>
					
					<div class="section <?php echo esc_attr( $section )?>">
					<h3 class="heading"><?php echo esc_html( $sdata['options']['title'] )?></h3>

					<?php foreach($sdata as $id=>$v) if($id != 'options'){?>
						<div class="option <?php echo esc_attr( $id )?>"><div class="controls">
						<?php $id=$this->name."_".$id;
						
						switch($v['type']){
						
							case 'text':?>
							<input type="text" class="regular-text" id="<?php echo esc_attr( $id )?>" name="<?php echo esc_attr( $id )?>" value="<?php echo stripslashes($v['val'])?>">
							<?php break;
							
							case "rangeslider":?>
							<div id="<?php echo esc_attr( $id )?>" class="range_slider_holder">
							
								<input type="text" class="kk_range_slider" data-slider-highlight="true" data-slider-step="<?php echo esc_attr( $v['step'] ) ?>" data-slider="true" data-slider-range="<?php echo esc_attr( $v['range'] ) ?>" value="<?php echo stripslashes($v['val'])?>" >
								
								<input type="text" class="regular-text" id="<?php echo esc_attr( $id )?>" name="<?php echo esc_attr( $id )?>" value="<?php echo stripslashes($v['val'])?>">
								
							</div>
							<?php break;
							
							case 'textarea':?>
							<textarea name="<?php echo esc_attr( $id )?>" type="<?php echo esc_attr( $v['type'] )?>" cols="" rows=""><?php echo esc_html(stripslashes($v['val']))?></textarea>
							<?php break;
							
							case 'select':?>
							
							<select name="<?php echo esc_attr( $id )?>" id="<?php echo esc_attr( $id )?>">
							
							<?php foreach($v['options'] as $value=>$text){
							
								if(is_array($text)){
									$select_opts=$text;
									$text=$select_opts['text'];
								}?>
								
								<option value="<?php echo esc_attr( $value )?>" 
								<?php if($value==$v['val']) echo 'selected="selected"'?>>
								<?php echo esc_html( $text )?>
								</option>
								
							<?php }?>
							
							</select>
							<?php break;
														
							case "checkbox":?>
							<label for="<?php echo esc_attr( $id )?>">
								<input type="checkbox" name="<?php echo esc_attr( $id )?>" id="<?php echo esc_attr( $id )?>" <?php if($v['val']=='true') echo 'checked="checked"'?>><?php echo $v['name']?>
							</label>
							<?php
							break;
							
							case "onoff":?>
							<?php $kktfwp_val = ( empty( $v['val'] ) ? $v['std'] : $v['val'] ); ?>
							<input type="checkbox" name="<?php echo esc_attr( $id )?>" class="kk-toggle kk-toggle-round" id="<?php echo esc_attr( $id )?>" <?php echo (( $kktfwp_val ==='true' ) ? 'checked="checked"' : '')?>>
							<label for="<?php echo esc_attr( $id )?>"></label>
							<span><?php echo esc_html( $v['name'] )?></span>
							<?php
							break;
							
							case "image":?>
							<?php siteoptions_uploader_function($id,$v['std'],null)?>
							<?php break;
							
							case "color":?>
							<div id="<?php echo esc_attr( $id )?>" class="color_picker">
								<input type="text" id="<?php echo esc_attr( $id )?>" name="<?php echo esc_attr( $id )?>" value="<?php echo esc_attr( $v['val'] )?>">
								<div class="preview"></div>
							</div>
							<?php break;
							
							case "wpeditor":
							wp_editor('', $id, array( 'media_buttons' => false )  );
							break;
					}?>
				</div>
				
				<div class="explain"><?php echo esc_html( $v['desc'] ); ?></div>
				<div class="clear">&nbsp;</div>
			</div>
				<?php }?>
				<div class="clear">&nbsp;</div>
				</div>
				<?php }?>
				<div class="clear">&nbsp;</div>
				</div>
			<?php }?>
			<div class="clear">&nbsp;</div>
		</div>
		<div class="clear">&nbsp;</div>
	</div>

	<div class="save_bar_top">
		<input type="hidden" name="type" value="save">
		<img alt="Saving..." class="ajax-loading-img ajax-loading-img-bottom" src="<?php echo $this->turl?>/admin/i/loading.gif" style="display:none">
		<input type="submit" class="button-primary" value="<?php esc_html_e( 'Save All Changes', 'essu' ) ?>">
	</div>
	
</form>

<form id="ofform-reset" method="post" action="">
	<span class="submit-footer-reset">
		<input type="hidden" name="type" value="reset">
		<input type="submit" onclick="return confirm('CAUTION: Any and all settings will be lost! Click OK to reset.');" class="button submit-button reset-button" value="<?php esc_html_e( 'Reset All Options', 'essu' ) ?>" name="reset">
	</span>
</form>
<div class="clear">&nbsp;</div>
</div>
<?php 
/*
Plugin Name: Filter Portfolio Gallery
Plugin URI: https://www.phoeniixx.com/
Description: By using this plugin you can create your own gallery
Version: 1.5
Text Domain: phoen_filter_gallery
Author: phoeniixx
Author URI: https://www.phoeniixx.com/
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );	

add_action('admin_head','phoen_filter_gallery_header_scripts');
//Enqueue Scripts For Backend
function phoen_filter_gallery_header_scripts(){
	
	wp_enqueue_style('phoen-bootstrap-iso',plugin_dir_url(__FILE__).'assets/css/phoe-filt-port-gall-admin.css');
	
	wp_enqueue_style('phoen-main-style',plugin_dir_url(__FILE__).'assets/css/style.css');
	
	wp_enqueue_script('first_li_active',plugin_dir_url(__FILE__).'assets/js/first_li_active.js'); 
	
	wp_enqueue_style('phoen-cat-custum-style',plugin_dir_url(__FILE__).'assets/css/phoen_style_for_cat_list.css');
	
	 wp_enqueue_script( 'bootstrap-js', plugin_dir_url(__FILE__).'assets/js/bootstrap.min.js', array('jquery'), 3.3, true); 
	 
	 wp_enqueue_style( 'bootstrap-style', plugin_dir_url(__FILE__).'assets/css/bootstrap.min.css', 3.3, true); 
	 
	 wp_enqueue_media();
	 
	wp_enqueue_style( 'phoen_font_awsome',plugin_dir_url(__FILE__).'assets/font-awesome/css/font-awesome.min.css' );
}
//Enqueue Scripts For front
function phoen_filter_gallery_front_design_enqueue_script() {
	
	wp_enqueue_script('jquery');
	
	wp_enqueue_style('phoen-front-page-custum-style',plugin_dir_url(__FILE__).'assets/css/front_page.css'); 
	
	wp_enqueue_style( 'bootstrap-front-style', plugin_dir_url(__FILE__).'assets/css/bootstrap.min.css', 3.3, true); 

	wp_enqueue_script( 'bootstrap-front-js', plugin_dir_url(__FILE__).'assets/js/bootstrap.min.js', array('jquery'), 3.3, true);
	
	wp_enqueue_script('phoen_add_lightBox_js',plugin_dir_url(__FILE__).'assets/js/lightbox.js'); 
	
	wp_enqueue_style('phoen_add_lightBox_css',plugin_dir_url(__FILE__).'assets/css/lightbox.css');
	
}
add_action( 'wp_enqueue_scripts', 'phoen_filter_gallery_front_design_enqueue_script' );


// For admin Menu
	
add_action('admin_menu', 'phoen_filter_gallery_header_scripts_add_menu');

function phoen_filter_gallery_header_scripts_add_menu(){
	
	add_menu_page('Filter Portfolio Gallery','Portfolio','manage_options','phoen_filter_gallery','',plugin_dir_url(__FILE__).'assets/images/aa2.png',23);
	
	add_submenu_page( 'phoen_filter_gallery','Filter Portfolio Gallery','Portfolio','manage_options','phoen_filter_gallery','phoen_all_portfolio');
	
	add_submenu_page( 'phoen_filter_gallery','Filter Portfolio Gallery','Add Portfolio','manage_options','phoen_add_new_portfolio','phoen_add_portfolio');
	
	add_submenu_page( 'phoen_filter_gallery','How to Install Plugin','How to Install Plugin','manage_options','phoen_how_to_install','how_to_install');
	
} 
	function phoen_all_portfolio() {	

		 require_once('wp_list_table_for_gallery.php'); 
	
		$phoen_filter_gallery_obj = new Phoen_Fil_Port_Gall_Table();
		?>
			<div class="wrap"> 
					<h2 class="wp-heading-inline">Gallery <a href="admin.php?page=phoen_add_new_portfolio" class="page-title-action">Add New</a></h2><hr class="wp-header-end">
				<?php
				$phoen_filter_gallery_obj->prepare_items(); ?>
				
				<form method="post">
				
					<input type="hidden" name="page" value="myListTable" />
					
					<p class="search-box">
						
						<label class="screen-reader-text" for="search_id-search-input">search:</label> 
						
						<input id="search_id-search-input" type="text" name="s" value="" /> 
						
						<input id="search-submit" class="button" type="submit" name="" value="search" />
					
					</p>
				
				</form>
			</div>
	
		<?php
		
		$phoen_filter_gallery_obj->display(); 
		
		echo '</div>'; 
		
		if(isset($_GET['delete_id'])){
			
			$id = $_GET['delete_id'];
			
			$row=(array)get_option('phoen_gallery_list_one');	
			
			foreach($row as $key=> $values){
				
				if($values['gallery_id']== $id){
					
					unset($row[$key]);
					
					$phoen_gal = array_values($row);
					
					update_option('phoen_gallery_list_one',$phoen_gal);
					
					echo "<script type='text/javascript'>
					window.location.reload();
					</script>";
				
				}
					
			}
			
		}
		
	}
	function phoen_add_portfolio(){
		//Edit Category Code
		if(isset($_GET['cat_edit_id'])){
			
			$cat_id=$_GET['cat_edit_id'];
			
			$phoen_data=(array)get_option('phoen_filter_gallery_test');
			
			if(!empty($phoen_data)){	
			
				foreach($phoen_data as $key=> $value)
				{
					if($value['cat_id'] ==$cat_id){	
						/* print_r($value);die(); */
						$cat_key=$key;
						
						$cat_name=$value['cat_name'];
						
						$cat_images=$value['cat_images'];
						
						$phoen_gal_id=$value['gallery_id'];
						
						$cat_position=$value['cat_position'];
					
						$cat_description=$value['cat_description'];
						
						?>
						<div class="wrap">		
						
							<h1 class="phoen_head_text">Add Category <a class="page-title-action" href="admin.php?page=phoen_add_new_portfolio&cat_view_id=<?php echo $phoen_gal_id;?>">Return To Category</a></h1>
							
							<form novalidate="novalidate" method="post" class="phoen_cat_edit_form">	
							
								<table class="form-table">
								
									<tbody>
									
										<tr>
										
											<th scope="row">
											
												<label for="blogname">Category Name</label>
												
											</th>
											
											<td>
												<?php wp_nonce_field( 'my_cat_edit', 'my_cat_edit_nonce' ); ?>
												
												<input type="hidden" name="id" value="<?php?>"/>	
												
												<input type="text" class="form-control" value="<?php echo $cat_name;?>" name="cat_name" id="exampleInputEmail1" placeholder="Enter category" required />	
												
											</td>
											
										</tr>
										
										<tr>
										
											<th scope="row">
											
												<label for="blogname">Description</label>
												
											</th>
											
											<td>

											<input type="text" name="cat_description" id="my_meta_box_text" value="<?php echo $cat_description;?>" required />
											
											</td>
											
										</tr>
										
										<tr>
										
											<th scope="row">
											
												<label for="blogname">Enter Position</label>
												
											</th>
											
											<td>
											
												<input type="number" min="0" name="cat_position" id="my_meta_box_text" value="<?php echo $cat_position;?>" required />
												
											</td>
											
										</tr>										
										
									</tbody>
									
								</table>
								
								<p class="submit">
								
									<input id="submit" class="button button-primary" type="submit" value="Submit" name="edit_cat" />
								
								</p>
								
							</form>
							
						</div>
					
						<?php	
						if(isset( $_POST['my_cat_edit_nonce'])  && wp_verify_nonce( $_POST['my_cat_edit_nonce'], 'my_cat_edit' ) )
						{
							
							$cat_name=sanitize_text_field($_POST['cat_name']);
							
							$cat_description=sanitize_text_field($_POST['cat_description']);
							
							$cat_position=sanitize_text_field($_POST['cat_position']);
							
							$phoen_finel_data=array($cat_key=>array(		
							'gallery_id'=>$phoen_gal_id,
							'cat_id'=>$cat_id,
							'cat_name'=>$cat_name,
							'cat_description'=>$cat_description,
							'cat_position'=>$cat_position,
							'cat_images'=>$cat_images,
							));
							
							$new_data=array_replace($phoen_data,$phoen_finel_data);
							
							update_option('phoen_filter_gallery_test',$new_data);
							
							echo "<script type='text/javascript'>
							window.location.reload();
							</script>";
						}
					}
								
				}
			}
							
			die();
		}elseif(isset($_GET['cat_view_id'])){	//View Category Code
		
			$gallery_id= $_GET['cat_view_id'];
			?>
			<div class="col sm-12 phoen_form">
			
				<button type="button" id="cat_id" class="btn btn-primary">Add Category</button>
				
				<form method="post" enctype="multipart/form-data" style="display: none;">
				
					<?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
					
					<div class="form-group">
					
						<label for="exampleInputEmail1">Category Name</label>
						
						<input type="text" class="form-control" name="cat_name" id="exampleInputEmail1" placeholder="Enter category" required />
						
					 </div>
					 
					<div class="form-group">
					
						<label for="exampleInputPassword1">Description</label>
						
						<textarea name="cat_description" class="form-control" rows="4" id="comment" required></textarea>
						
					</div>
					
					<div class="form-group">
					
						<label for="exampleSelect1">Enter Position</label>
						
						<input type="number" name="cat_position" min="0" class="form-control" id="exampleInputEmail1" placeholder="Position" required />
						
					</div>
					
					<button type="submit" class="btn btn-primary">Submit</button>
					
					<button type="button" id="cat_cancle_btn" class="btn btn-primary">Cancel</button>
					
				</form>
				
			</div>
			<?php
				if(isset( $_POST['my_image_upload_nonce'])  && wp_verify_nonce( $_POST['my_image_upload_nonce'], 'my_image_upload' ) )
				{
					
					$cat_name=sanitize_text_field($_POST['cat_name']);
					
					$cat_description=sanitize_text_field($_POST['cat_description']);
					
					$cat_position=sanitize_text_field($_POST['cat_position']);	
					
					$recive_data=(array)get_option('phoen_filter_gallery_test');
					
					$count = end($recive_data);
					/* print_r($recive_data);die(); */
					foreach($recive_data as $key =>$values){
						
						if($values['gallery_id']==$gallery_id){
							
							 $num[]= $key; 
						}
						
					}
					
					$gal_list= count($num);
					 
					if($count==''){
						
						$cat_id =$count['cat_id']='';
						
					}else{
						
						$cat_id = $count['cat_id'];
						
					}
					
					if($gal_list==0){
						
						$count_array = count($recive_data);
						
						if($count_array==0){
							$id=0;
							$phoen_finel_data=array($id=>array(		
							'gallery_id'=>$gallery_id,
							'cat_id'=>$cat_id+1,
							'cat_name'=>$cat_name,
							'cat_description'=>$cat_description,
							'cat_position'=>$cat_position,
							));
							
							update_option('phoen_filter_gallery_test',$phoen_finel_data);
							
							echo "<script type='text/javascript'>
							window.location.reload();
							</script>";
							
							$msg='';
							
						}else{
							
							$phoen_finel_data=array($count_array=>array(		
							'gallery_id'=>$gallery_id,
							'cat_id'=>$cat_id+1,
							'cat_name'=>$cat_name,
							'cat_description'=>$cat_description,
							'cat_position'=>$cat_position,
							));
							
							$phoen_fainaldata=array_merge($recive_data,$phoen_finel_data);
							
							update_option('phoen_filter_gallery_test',$phoen_fainaldata);
							
							echo "<script type='text/javascript'>
							window.location.reload();
							</script>";
							
							$msg='';
						
						}			 
					
					}elseif($gal_list >0 && $gal_list <= 3){
						
						$id=0;
						
						$phoen_finel_data=array($id=>array(		
							'gallery_id'=>$gallery_id,
							'cat_id'=>$cat_id+1,
							'cat_name'=>$cat_name,
							'cat_description'=>$cat_description,
							'cat_position'=>$cat_position,
						 ));
						 
						$phoen_fainaldata=array_merge($recive_data,$phoen_finel_data);

						update_option('phoen_filter_gallery_test',$phoen_fainaldata);	 

						echo "<script type='text/javascript'>
						window.location.reload();
						</script>";
						$msg='';
						
					}else{
						
						echo '<script>alert("More than 4 Categories  Not Allow for You"); window.location.reload(); </script>';
						
						die();
						
					}
							
				}
			
			$value=(array)get_option('phoen_filter_gallery_test');
				if(empty($value[0])){
				unset($value[0]);
				$value=array_values($value);	
				update_option('phoen_filter_gallery_test',$value);
			}else{}	
			 foreach ($value as $key => $row) {
					$cat_position[$key] = $row['cat_position'];
				}

			array_multisort($cat_position, SORT_ASC, $value);
			
			if(!empty($value)){	
			
				foreach($value as $ke=> $phorn_data_id)
				{
					if($phorn_data_id['gallery_id'] ==$gallery_id){	
				
						$cat_name[]=$phorn_data_id['cat_name'];
						
						$cat_images[]=$phorn_data_id['cat_images'];
						
						$phoen_cat_id[]=$phorn_data_id['cat_id'];
					
						$cat_description[]=$phorn_data_id['cat_description'];
												
					}
					
				}
				
				?>
				<div class="table_content" id="phoen_catlist_table">
					
					<ul  class="nav nav-tabs phoen_active_li">
						
						<?php
						
						$count_cat_name=count($cat_name);
						
						for($i=0;$i<=$count_cat_name-1;$i++){
						
							$cat_id=str_replace(' ','_',$cat_name[$i]);
 

							echo '<li><a href="admin.php?page=phoen_add_new_portfolio&cat_edit_id='.$phoen_cat_id[$i].'" name="edit" class="phoe_edit_btn"><i class="fa fa-pencil"></i></a><span class="cat_delete_button"><i class="fa fa-trash-o" ></i></span><input type="hidden" name="delete_cat" value="'.$phoen_cat_id[$i].'"><a class="phoe_gal_tab" data-toggle="tab" href="#'.$cat_id.'">'.$cat_name[$i].'</a></li>';

						
						}
						?>
					</ul>
					
					<div class="tab-content" >
						<?php
						for($i=0;$i<=$count_cat_name-1;$i++){

							$cat_id=str_replace(' ','_',$cat_name[$i]);
							
							echo '<div id="'.$cat_id.'" class="tab-pane fade in" >';
							
							echo '<input type="hidden" class="phoen_cat_id"  value="'.$phoen_cat_id[$i].'">';
							
							$img=$cat_images[$i];
								
							 $count_image=count($img);
							 
							 if($count_image<=19){
								 echo '<input class="btn btn-primary upload_image_button" type="button" value="Upload Image" />';
							}else{
								 echo '';
							}
				
							for($j=0;$j<=$count_image-1;$j++){
										
								echo '<div class="phoen_img" >';
								
								 echo'<input type="hidden" name="image_id" value="'.$j.'"/>'; 
								 
								 echo '<input type="hidden" name="phoen_cat_id"  value="'.$phoen_cat_id[$i].'">';
								
								echo '<input type="button" class="btn btn-primary phoen_del_btn" value=" X "/>';
								
								$attachment_id=$img[$j]['image_url'];
								
								$cat_description=$img[$j]['image_name'];

								echo '<p>'.$cat_description.'</p>';
								?>
								
								<div class="thumbnail">
									
									<div class="centered">
									
										<img alt="" draggable="false" src="<?php echo $attachment_id;?>">
										
									</div>
									
								</div>
				
								<?php
								echo'</div>';
				

							}
						
							echo'</div>';
				
						}
					
						?>
						
					</div>
					
					<th class="col-xs-2"></th>
					
				</div>	
				<?php
				
			}
			
		}else{    //Edit and add  Gallery Code
		
			$gal_id=$_GET['gal_edit_id'];
			$data=(array)get_option('phoen_gallery_list_one');	
			
				foreach($data as $key=>$value){
					
					if($value['gallery_id']==$gal_id){
						
						$gal_key=$key;
						
						$gallery_title=$value['gallery_title'];
						
						$descriptrion=$value['descriptrion'];
						
						$phoen_gal_slug1=$value['phoen_gal_slug'];
			
					}
				}
			
			
				?>
				<div class="wrap">			
				
					<h1>Edit Gallery  <a class="page-title-action" href="admin.php?page=phoen_filter_gallery">Return To Gallery</a></h1>
					
					
					<form novalidate="novalidate" method="post" >
							<h4><?php echo $msg;?></h4>
						<table class="form-table">
						
							<tbody>
							
								<tr>
								
									<th scope="row">
									
										<label for="blogname">Gallery Name</label>
										
									</th>
								
									<td>
									
										<?php wp_nonce_field( 'phoen_gal_insert', 'phoen_gal_add_table' ); ?>
										
										<input type="hidden" name="id" value="<?php if(isset($_GET['gal_edit_id'])){echo $gal_id;}else{echo '';}?>"/>	
										
										<input type="text" id="my_meta_box_check" name="gallery_title"  value="<?php if(isset($_GET['gal_edit_id'])){echo $gallery_title;}else{echo '';}?>" required />
										
									</td>
									
								</tr>
								
								<tr>
								
									<th scope="row">
									
										<label for="blogname">Description</label>
										
									</th>
									
									<td>
									
										<input type="text" name="descriptrion" id="my_meta_box_text" value="<?php if(isset($_GET['gal_edit_id'])){echo $descriptrion;}else{echo '';}?>" required />
										
									</td>
									
								</tr>
								
							</tbody>
							
						</table>
						
						<p class="submit">
						
							<input id="submit" class="button button-primary" type="submit" value="Submit" name="submit"/>
							
						</p>
						
					</form>	
					
				</div>
				
				<?php	
					if(isset( $_POST['phoen_gal_add_table'])  && wp_verify_nonce( $_POST['phoen_gal_add_table'], 'phoen_gal_insert' ) )	
					{
						
						$phoen_data=(array)get_option('phoen_gallery_list_one');
						
						$count = end($phoen_data);		
						
						$count_gal = count($phoen_data);					
						
						if($count==''){
							
							$gallery_id =$count['gallery_id']='';
						
						}else {
							
							$gallery_id = $count['gallery_id'];
						
						}
							
						$gal_id= sanitize_text_field($_POST['id']);
						
						$phoen_gallery_title= sanitize_text_field($_POST['gallery_title']);
						
						$phoen_descriptrion= sanitize_text_field($_POST['descriptrion']);
						
						if($gal_id==''){
							
							$phoen_gal_id=$gallery_id+1;
							
							$phoen_gal_slug='[Phoen-PF Gal='.$phoen_gal_id.']';
							
							$ids=0;
							
							if($count_gal==0){
								
								$newgallery=array($ids=>array(
								'gallery_id'=> $phoen_gal_id,
								'gallery_title'=> $phoen_gallery_title,
								'phoen_gal_slug'=> $phoen_gal_slug,
								'descriptrion'=> $phoen_descriptrion,
								));
								if(!empty($newgallery)){
									$val=update_option('phoen_gallery_list_one',$newgallery); 
								}	
								if($val==true){
								echo	$msg= 'Successfully Added';
									
								}else{
								echo	$msg= 'Error occured';
								}
					
							}else{
								
								$newgallery=array($ids=>array(
								'gallery_id'=> $phoen_gal_id,
								'gallery_title'=> $phoen_gallery_title,
								'phoen_gal_slug'=> $phoen_gal_slug,
								'descriptrion'=> $phoen_descriptrion,
								));
								
								$fainaldata=array_merge($phoen_data,$newgallery); 
								
								if(!empty($fainaldata)){
									$val= update_option('phoen_gallery_list_one',$fainaldata);
								}	
								if($val==true){
									echo $msg= 'Successfully Added';	
								}else{
									echo $msg= 'Error occured';
								}
					
							}		
							
						}else{
								$newGallery=array($gal_key=>array(
								'gallery_id'=> $gal_id,
								'gallery_title'=> $phoen_gallery_title,
								'phoen_gal_slug'=> $phoen_gal_slug1,
								'descriptrion'=> $phoen_descriptrion,
								));
							
								$fainaldata=array_replace($phoen_data,$newGallery); 
							
								$val=update_option('phoen_gallery_list_one',$fainaldata); 
								
								echo "<script type='text/javascript'>
								window.location.reload();
								</script>"; 
						
						}
						
					}
			
		} //Edit and add  Gallery Code End
	}//Function End
	// Front Shortcut Function
	function phoen_pf_shortcode_callback_function( $atts ) {
	
		 $gal_id=$atts['gal'];  
		 
		$value=(array)get_option('phoen_filter_gallery_test');
		
		 foreach ($value as $key => $row) {
			$cat_position[$key] = $row['cat_position'];
		}

		array_multisort($cat_position, SORT_ASC, $value);
							
		foreach($value as $ke=> $phorn_data_id)
		{
			
			if($phorn_data_id['gallery_id'] ==$gal_id)
			{	
				
				$cat_id[]=$phorn_data_id['cat_id']; 
				
				 $cat_name[]=$phorn_data_id['cat_name'];
				
				$cat_images[]=$phorn_data_id['cat_images'];
				
				$cat_description[]=$phorn_data_id['cat_description']; 
				
				
				
			}
			
		}
		
		?>
	
        <!-- Filter Controls - Simple Mode -->
        <div class="row">
		
            <ul class="simplefilter " id="phoe_gallry_item_list">
			
               <!-- <li class="active" data-filter="all">All</li>-->
				<script>
				var default_tab =<?php echo $cat_id[0];?>;
				</script>
				<?php $phoen_num=count($cat_name);
				
				for($i=0;$i<=$phoen_num-1;$i++){
					
					if($i==0):
					echo '<li class="active" data-filter="'.$cat_id[$i].'">'.$cat_name[$i].'</li>';
					else:
					echo '<li data-filter="'.$cat_id[$i].'">'.$cat_name[$i].'</li>';
					endif;
				}
				?>
            </ul>
			
        </div>

        <!-- Shuffle & Sort Controls -->
        <div class="row">
		
            <ul class="phoen_gall_list sortandshuffle">
			
                <!-- Basic shuffle control -->
                <li class="shuffle-btn" data-shuffle>Shuffle</li>
				
                <!-- Basic sort controls consisting of asc/desc button and a select -->
                <li class="sort-btn active" data-sortAsc>Asc</li>
				
                <li class="sort-btn" data-sortDesc>Desc</li>
				
                <select data-sortOrder>
				
                    <option value="domIndex">
                        Position
                    </option>
					
                    <option value="sortData">
                        Description
                    </option>
					
                </select>
				
            </ul>
			<!--Search control -->
        <div class="search-row phoen_search_ctrl">
           
            <input placeholder=" Search control:" type="text" class="filtr-search" name="filtr-search" data-search><span class="phoen_search_icon"></span>
        </div>
        </div>

        

		<div class="row">
		
				<!-- This is the set up of a basic gallery, your items must have the categories they belong to in a data-category
				attribute, which starts from the value 1 and goes up from there -->
				
			<div class="filtr-container phoe_gallery_type">
			
			<div class="phoen_filter_loader"> <img src="<?php echo plugin_dir_url(__FILE__).'assets/images/ajax-loader.gif';?>"></div>
			
				<?php	
				for($i=0;$i<=$phoen_num;$i++){
					
					$cat_img=$cat_images[$i];
					
					for($j=0;$j<=count($cat_img)-1;$j++){
						?>
							
						<div class="col-xs-6 col-sm-4 col-md-3 filtr-item" data-sort="<?php echo $cat_img[$j]['image_name'];?>" data-category="<?php echo $cat_id[$i];?>" >
						
								<a href="<?php echo $cat_img[$j]['image_url'];?>" data-lightbox="phoen_gallery">
								
									<img class="img-responsive" alt="sample image" src="<?php echo $cat_img[$j]['image_url'];?>" />
									
									<span class="item-desc"><?php echo $cat_img[$j]['image_name'];?></span>
									
								</a>	
						</div>
							
						<?php
					}
				}
				?>
				
			</div>
			
		</div	>
	
		<?php
		wp_enqueue_script('phoen-front-custum-secript',plugin_dir_url(__FILE__).'assets/js/jquery.filterizr.js'); 
		wp_enqueue_script('front_first_active',plugin_dir_url(__FILE__).'assets/js/front_first_active.js'); 
	}
	
	function how_to_install()
	{
		?>
		<div class="phoe_video_main">
			<h3>How to set up plugin</h3> 
			<iframe width="800" height="360"src="https://www.youtube.com/embed/UYDRdTa9_9s" allowfullscreen></iframe>
		</div>
		<style>
		.phoe_video_main {
				padding: 20px;
				text-align: center;
			}
			
		.phoe_video_main h3 {
				color: #02c277;
				font-size: 28px;
				font-weight: bolder;
				margin: 20px 0;
				text-transform: capitalize
				display: inline-block;
			}
		</style>
		<?php
	}
	
	
	
	
	
	add_shortcode( 'Phoen-PF', 'phoen_pf_shortcode_callback_function' );
	
	//Ajax action function for image Add
	add_action( 'wp_ajax_phoen_action', 'phoen_action' );
		
	function phoen_action(){
		
		$phoen_new_image=$_POST['url'];
		
		$phoen_cat_id=$_POST['cat_id'];
		
		$phoen_image_title=$_POST['image_name'];
	
		$recive_data=(array)get_option('phoen_filter_gallery_test');
		
		foreach($recive_data as $key => $value){
			
			if($value['cat_id']==$phoen_cat_id){
				
				$phoen_cat_key=$key;
				
			}
		}
		$gal_id=$recive_data[$phoen_cat_key]['gallery_id'];
		
		$cat_id=$recive_data[$phoen_cat_key]['cat_id'];
		
		$cat_name=$recive_data[$phoen_cat_key]['cat_name'];
		
		$cat_description=$recive_data[$phoen_cat_key]['cat_description'];
		
		$cat_position=$recive_data[$phoen_cat_key]['cat_position'];
		
		$recive_image=$recive_data[$phoen_cat_key]['cat_images'];	
		
		$count_image=count($recive_image);
		$id=0;
		$found_image=array($id=>array(
			'image_name'=>$phoen_image_title,
			'image_url'=>$phoen_new_image,
		)); 
		 
		if($count_image==""){
			
			$phoen_finel_array=array($phoen_cat_key=>array(
				'gallery_id'=>$gal_id,
				'cat_id'=>$cat_id,
				'cat_name'=>$cat_name,
				'cat_description'=>$cat_description,
				'cat_position'=>$cat_position,
				'cat_images'=>$found_image,
			));
			
			$new_array=array_replace( $recive_data,$phoen_finel_array );
			
			update_option('phoen_filter_gallery_test',$new_array);	  
			
			echo  $phoen_image_title.",".$phoen_new_image;
			
			die();
			
		}elseif($count_image > 0 && $count_image <= 19){
			
				$phoen_new_array=array_merge( $recive_image,$found_image );
				
				$phoen_finel_array_new=array($phoen_cat_key=>array(
					'gallery_id'=>$gal_id,
					'cat_id'=>$cat_id,
					'cat_name'=>$cat_name,
					'cat_description'=>$cat_description,
					'cat_position'=>$cat_position,
					'cat_images'=>$phoen_new_array,
				));
				
				$update_data=array_replace($recive_data,$phoen_finel_array_new);
			
			    update_option('phoen_filter_gallery_test',$update_data);	  
				
				echo  $phoen_image_title.",".$phoen_new_image;
				
				die();
				
		}else{
				
			echo '<script>alert("More than 20 Images are Not Allow for You"); window.location.reload(); </script>';
			
			die();
			
		}
		 
	}
	
	add_action( 'wp_ajax_phoen_del_btn_action', 'phoen_del_btn_action' );
	//Ajax action function for Image Delete
	function phoen_del_btn_action(){
		
		$phoen_img_key=$_POST['phoen_img_id'];
		
		$phoen_cat_id_del=$_POST['phoen_cat_key'];
		
		$phoen_data=(array)get_option('phoen_filter_gallery_test');
		
		foreach($phoen_data as $key => $value){
			
			if($value['cat_id']==$phoen_cat_id_del){
				
				$phoen_cat_key=$key;
			}
		}
		
		$gal_id=$phoen_data[$phoen_cat_key]['gallery_id'];
		
		$cat_id=$phoen_data[$phoen_cat_key]['cat_id'];
		
		$cat_name=$phoen_data[$phoen_cat_key]['cat_name'];
		
		$cat_description=$phoen_data[$phoen_cat_key]['cat_description'];
		
		$cat_position=$phoen_data[$phoen_cat_key]['cat_position'];
		
		$recive_image=$phoen_data[$phoen_cat_key]['cat_images'];
		
		unset($recive_image[$phoen_img_key]);
		
		$phoen_recive_image = array_values($recive_image);
		
		$phoen_finel_array=array($phoen_cat_key=>array(
			'gallery_id'=>$gal_id,
			'cat_id'=>$cat_id,
			'cat_name'=>$cat_name,
			'cat_description'=>$cat_description,
			'cat_position'=>$cat_position,
			'cat_images'=>$phoen_recive_image,
		));
			
		$update_data=array_replace($phoen_data,$phoen_finel_array);
		
		update_option('phoen_filter_gallery_test',$update_data); 
			
		die();
		
	}
	//Ajax action function for category delete
	function phoen_cat_del_action(){
		 $phoen_del_cat_id=$_POST['phoen_del_cat_id'];
		 
		$phoen_data=(array)get_option('phoen_filter_gallery_test');
		
		foreach($phoen_data as $key => $value){
			
			if($value['cat_id']==$phoen_del_cat_id){
				
				 $phoen_cat_key=$key;

				unset($phoen_data[$phoen_cat_key]);
			
				$phoen_finel = array_values($phoen_data);
			
				update_option('phoen_filter_gallery_test',$phoen_finel); 
				
				/* echo "<script type='text/javascript'>
					window.location.reload();
					</script>"; */
			}
		}
	
		die();
		
	} 
	 add_action( 'wp_ajax_phoen_cat_del_action', 'phoen_cat_del_action' ); 
	
	add_action('admin_footer','custom_append_secript');
	
	function custom_append_secript(){
		?>	
		
		<script type="text/javascript">
			jQuery(document).ready(function() {

				
				jQuery(document).on('click','#cat_id',function(){
					
					jQuery('.phoen_form form ').css({display: "block"});

					jQuery('#phoen_catlist_table').css({display: "none"});  
				 
				});
				
				jQuery(document).on('click','#cat_cancle_btn',function(){
					
					jQuery('#phoen_catlist_table').css({display: "block"});
					
					jQuery('.phoen_form form ').css({display: "none"});
					
				});
				  //-------------------////////////-------New Script Start---------------------///////-------------
				function get_the_extension(url) {
					var ext=(url = url.substr(1 + url.lastIndexOf("/")).split('?')[0]).substr(url.lastIndexOf("."));
					return ext;
				}
				
				var custom_uploader;
				
				var name_id = '';
				
				var cat_id = '';
				
				jQuery('.upload_image_button').click(function(e) {
					
					e.preventDefault();
					
					name_id = jQuery(this).parent().attr('id');	
					
					cat_id = jQuery(this).parent().find("input[type='hidden']").val();	
						 
					//If the uploader object has already been created, reopen the dialog
					if (custom_uploader) {
						
						custom_uploader.open();
						
						return;
						
					}
					
					//Extend the wp.media object
					custom_uploader = wp.media.frames.file_frame = wp.media({
						
						title: 'Choose Image',
						button: {
							text: 'Choose Image'
						},
						multiple: true
						
					});
					
					//When a file is selected, grab the URL and set it as the text field's value
					custom_uploader.on('select', function() {
						 /* attachment = custom_uploader.state().get('selection').first().toJSON();
						var we_value = attachment.url;	 
						var image_name = attachment.title;	 */ 
						var selection = custom_uploader.state().get('selection');
						
						selection.map( function( attachment ) {
							
						attachment = attachment.toJSON();
						
						var url = attachment.url;
						
						var title = attachment.title;
						
						/* var the_extension = get_the_extension(attachment.url).replace('.',''); */
						var phoen_music_newurl_favourite = '<?php echo admin_url('admin-ajax.php') ;?>';
						
						 jQuery.post(

							phoen_music_newurl_favourite,
							{
								'action'	:  'phoen_action',
								'url'		:	url,
								'cat_id'	:    cat_id,
								'image_name'	:  title,
							},
							function(response){
								
								var data = response.split(",");	
								
								jQuery('#'+name_id).append('<div class="phoen_img"><input class="btn btn-primary phoen_del_btn" type="button" value=" X "><p>'+data[0]+'</p><div class="thumbnail"><div class="centered"><img alt="" draggable="false" src="'+data[1]+'"></div></div></div>');
								
							} 

						); 
						//...one commented line, that was to add files into HTML structure - works     perfect, but only once
						});
						
						
					});
					//Open the uploader dialog
					custom_uploader.open();
			 
				});
				
					var image_id = '';
					
					var phoen_cat_key = '';
					
				jQuery(document).on('click','.phoen_del_btn',function(){

					var image_id = jQuery(this).parent().find("input:hidden[name=image_id]").val();

					var phoen_cat_key = jQuery(this).parent().find("input:hidden[name=phoen_cat_id]").val();

					var phoen_ajax_url = '<?php echo admin_url('admin-ajax.php') ;?>';
					
					jQuery(this).closest('.phoen_img').hide();
					
					/* document.getElementById(image_id).style.display = "none";  */

					jQuery.post(

						phoen_ajax_url,
						{
							'action'	:  'phoen_del_btn_action',
							'phoen_img_id'		:	image_id,
							'phoen_cat_key'	:    phoen_cat_key,
						},
						function(value){
							 /* jQuery(this).closest('.phoen_img').hide(); */
						} 

					);

				});
				jQuery(document).on('click','.cat_delete_button',function(){
					
				var phoen_del_cat_id = jQuery(this).parent().find("input:hidden[name=delete_cat]").val();
				
				var phoen_ajax_del_url = '<?php echo admin_url('admin-ajax.php') ;?>';
				
					jQuery(this).closest("li").hide();
					
					/* document.getElementById(image_id).style.display = "none";  */

					jQuery.post(

						phoen_ajax_del_url,
						{
							'action'	:  'phoen_cat_del_action',
							'phoen_del_cat_id'	:	phoen_del_cat_id,
						},
						function(response){
						
						window.location.reload();
					
						} 
					);

				}); 
	   
			});
			
		</script>		<?php
	}
?>

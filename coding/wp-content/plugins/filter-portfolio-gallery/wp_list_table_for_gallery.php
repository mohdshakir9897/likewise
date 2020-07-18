<?php
if( ! class_exists( 'WP_List_Table' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	} 
	class Phoen_Fil_Port_Gall_Table extends WP_List_Table
	{ 
		function get_columns(){ 
			$columns = array(
			'cb'        => '<input type="checkbox" />',
			'gallery_title' => 'Gallery Title',
			'phoen_gal_slug'    => 'Short Code',
			'descriptrion'    => 'Descriptrion',
			);
			return $columns;
		}
		 
		function process_bulk_action(){
			if(isset($_POST['action']) && !empty($_POST['action']) ){
				/* print_r($_POST);die(); */
				
			 $id=$_POST['gallary_id'];
				$phoen_array=(array)get_option('phoen_gallery_list_one');
				$cid=count($id);
				for($i=0;$i<=$cid-1;$i++){
					foreach ($phoen_array as $key => $val) {
						if ($val['gallery_id'] == $id[$i]) {
							unset($phoen_array[$key]);	
							$newarray=array_values($phoen_array);
							update_option('phoen_gallery_list_one',$newarray);		
						}
					} 
				}

		
			}
		} 
		
		function prepare_items() {
			
			$columns = $this->get_columns();
			
			$hidden = array();
			
			$sortable = $this->get_sortable_columns();
			
			$action = $this->column_booktitle();
			
			$get_bulk_actions = $this->get_bulk_actions(); 
			
			$this->process_bulk_action();  

			$data = $this->example_data();
			if(!empty($data)){
				usort( $data, array( &$this, 'sort_data' ) );
			}
			$perPage = 7;

			$currentPage = $this->get_pagenum();

			$totalItems = count($data);

			$this->set_pagination_args( array(

				'total_items' => $totalItems,
				'per_page'    => $perPage
				) 
			);
			if(!empty($data)){	
				$data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
			}
			$this->_column_headers = array($columns, $hidden, $sortable);
			
			$this->items = $data;
		}  
		
 		function example_data(){
			
			$data=(array)get_option('phoen_gallery_list_one');
			if(empty($data[0])){
				unset($data[0]);
				update_option('phoen_gallery_list_one',$data);
			}else{}	
			
			if(isset($_POST['s']) && !empty($_POST['s'])){
		
				$query=$_POST['s'];
				
				foreach($data as $key => $val) {
					
					if($val['gallery_title']==$query) {
						
						$data_key[$key]['gallery_id'].=$data[$key]['gallery_id'];
						
						$phoen_gal_id=$data[$key]['gallery_id'];
						
						$gallery_title=$data[$key]['gallery_title'];
						
						$data_key[$key]['gallery_title'].=$gallery_title.' <div class="row-actions"><span class="view"><a href="admin.php?page=phoen_add_new_portfolio&cat_view_id='.$phoen_gal_id.'" name="view">View</a> | </span><span class="edit"><a href="admin.php?page=phoen_add_new_portfolio&gal_edit_id='.$phoen_gal_id.'" name="edit">Edit</a> | </span><span class="delete"><a href="admin.php?page=phoen_filter_gallery&delete_id='.$phoen_gal_id.'" name="delete">Dlelete</a> | </span></div>';
						
						$data_key[$key]['phoen_gal_slug'].=$data[$key]['phoen_gal_slug'];
						
						$data_key[$key]['descriptrion'].=$data[$key]['descriptrion'];
					
					}
				
				}
				
				return $data_key;
				
			}else{
				
				$data=(array) get_option('phoen_gallery_list_one');

				foreach($data as $key => $values){
					
					$phoen_gal_id=$values['gallery_id'];
					
					$gallery_title=$values['gallery_title'];
					
					$data[$key]['gallery_title']=$gallery_title.' <div class="row-actions"><span class="view"><a href="admin.php?page=phoen_add_new_portfolio&cat_view_id='.$phoen_gal_id.'" name="view">View</a> | </span><span class="edit"><a href="admin.php?page=phoen_add_new_portfolio&gal_edit_id='.$phoen_gal_id.'" name="edit">Edit</a> | </span><span class="delete"><a href="admin.php?page=phoen_filter_gallery&delete_id='.$phoen_gal_id.'" name="delete">Dlelete</a> | </span></div>';
				
				}
				/* print_r($data); */
				return $data; 
				
			}
			
		}

				
		function column_default( $item, $column_name ) {
			
			switch( $column_name ) { 
				
				case 'gallery_id':
				
				case 'gallery_title':
				
				case 'descriptrion':
				
				case 'phoen_gal_slug':
				
				return $item[ $column_name ];
				
				default:
				
				return print_r( $item, true ) ;  //Show the whole array for troubleshooting purposes
			
			}		
		} 
		
		function get_sortable_columns() {
			
			$sortable_columns = array(
			
				'gallery_title'  => array('gallery_title',true)
			
			);
			
			return $sortable_columns;
		} 
				
		function sort_data( $a, $b )
		{
			// Set defaults
			$orderby = 'id';
			$order = 'asc';
			// If orderby is set, use this as the sort column
			if(!empty($_GET['orderby']))
			{
				$orderby = $_GET['orderby'];
			}
			// If order is set use this as the order
			if(!empty($_GET['order']))
			{
				$order = $_GET['order'];
			}
			$result = strcmp( $a[$orderby], $b[$orderby] );
			if($order === 'asc')
			{
				return $result;
			}
			return -$result;
		} 
			
		function column_cb($item) {
			return sprintf( 
			'<input type="checkbox" name="gallary_id[]" value="%d" />',$item['gallery_id']
			);    
		} 
		
		function get_bulk_actions() {
		
			?>
			<form method="post"><?php
				$actions = array(
				'delete'    => 'Delete'
				);
				return $actions;
			?>
			</form><?php
		} 
	}
?>
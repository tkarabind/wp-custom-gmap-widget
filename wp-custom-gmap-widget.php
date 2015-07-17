<?php
/* Plugin Name: Custom Gmap Widget
Plugin URI: http://arabindtk.in/
Description: A plugin for get direction in google map from current location or a Manually Entered Source Location to the Target Location
Version: 1.0
Author: Arabind TK, arjun.r65
Author URI: http://arabindtk.in/
License: GPLv2 or later
*/

// Creating the widget 
class wpb_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'wpb_widget',
		
		// Widget name will appear in UI
		__('Custom Gmap Widget', 'wpb_widget_domain'),
		
		// Widget description
		array( 'description' => __( 'Custom GMAP Widget for Get Directions', 'wpb_widget_domain' ), )
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		// This is where you run the code and display the output	
		?>
		<script>
			var x=document.getElementById("saddr_id");
			function getLocation()
			  {
			  if (navigator.geolocation)
				{
				navigator.geolocation.getCurrentPosition(showPosition);
				}
			  else{x.innerHTML="Geolocation is not supported by this browser.";}
			  
			  	form_submission();
	 		}
			
			temp_flag = 1;
			
			/* Function for submitting the form starts here */
			function form_submission() {
				window.setInterval(function () {
					if((jQuery('#saddr_id').val()!='') && temp_flag){
						jQuery('#mapForm').submit();
						temp_flag = 0;
					}
				}, 1000); // repeat forever, polling every 3 seconds
			}
			/* Function for submitting the form Ends here */
			
			function showPosition(position)
			  {
			  x.value=" " + position.coords.latitude + "," + position.coords.longitude;
			  }
			  
		</script>
        <style type="text/css">
			#mapForm {
				margin-top: 16px;
			}
			#mapForm #submit_id{
				margin-top:10px;
				background-color:<?php echo $instance['button_bg_color']; ?>;
				color:<?php echo $instance['button_color']; ?>;
				height:<?php echo $instance['button_height']; ?>;
				width:<?php echo $instance['button_width']; ?>;
			}
			#get_location{
				background-color:<?php echo $instance['button_bg_color']; ?>;
				color:<?php echo $instance['button_color']; ?>;
				height:<?php echo $instance['button_height']; ?>;
				width:<?php echo $instance['button_width']; ?>;
			}
		</style>
        <div id="map_canvas"></div>
		<button id="get_location" class="cgmap_button" onclick="getLocation()">Use Current Location</button>
        <br/>
        <form id="mapForm" action="http://maps.google.co.za/maps" method="get" target="_blank">
            <input id="saddr_id" type="text" name="saddr" value="" Placeholder="Source Address">
            <input id="submit_id" type="submit" value="Get Directions">
            <input id="daddr_id" type="hidden" name="daddr" value="<?php echo $instance[ 'ta_address' ]; ?>">
            <input type="hidden" name="hl" value="en"><p></p>
        </form>

		<?php
		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Custom GMAP Widget', 'wpb_widget_domain' );
		}
		if ( isset( $instance[ 'ta_address' ] ) ) {
			$ta_address = $instance[ 'ta_address' ];
		}
		else {
			$ta_address = __( '', 'wpb_widget_domain' );
		}
		if ( isset( $instance[ 'button_bg_color' ] ) ) {
			$button_bg_color = $instance[ 'button_bg_color' ];
		}
		else {
			$button_bg_color = "#ccc";
		}
		if ( isset( $instance[ 'button_color' ] ) ) {
			$button_color = $instance[ 'button_color' ];
		}
		else {
			$button_color = "#fff";
		}
		if ( isset( $instance[ 'button_height' ] ) ) {
			$button_height = $instance[ 'button_height' ];
		}
		else {
			$button_height = "30px";
		}
		if ( isset( $instance[ 'button_width' ] ) ) {
			$button_width = $instance[ 'button_width' ];
		}
		else {
			$button_width = "175px";
		}
		// Widget admin form
		?>
        <p>
        	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'ta_address' ); ?>"><?php _e( 'Target Address:' ); ?></label> 
        	<input class="widefat" id="<?php echo $this->get_field_id( 'ta_address' ); ?>" name="<?php echo $this->get_field_name( 'ta_address' ); ?>" type="text" value="<?php echo esc_attr( $ta_address ); ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'button_bg_color' ); ?>"><?php _e( 'Button Background Color:' ); ?></label> 
        	<input class="widefat" id="<?php echo $this->get_field_id( 'button_bg_color' ); ?>" name="<?php echo $this->get_field_name( 'button_bg_color' ); ?>" type="text" value="<?php echo esc_attr( $button_bg_color ); ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'button_color' ); ?>"><?php _e( 'Button Text Color:' ); ?></label> 
        	<input class="widefat" id="<?php echo $this->get_field_id( 'button_color' ); ?>" name="<?php echo $this->get_field_name( 'button_color' ); ?>" type="text" value="<?php echo esc_attr( $button_color ); ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'button_height' ); ?>"><?php _e( 'Button Height:' ); ?></label> 
        	<input class="widefat" id="<?php echo $this->get_field_id( 'button_height' ); ?>" name="<?php echo $this->get_field_name( 'button_height' ); ?>" type="text" value="<?php echo esc_attr( $button_height ); ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'button_width' ); ?>"><?php _e( 'Button Width:' ); ?></label> 
        	<input class="widefat" id="<?php echo $this->get_field_id( 'button_width' ); ?>" name="<?php echo $this->get_field_name( 'button_width' ); ?>" type="text" value="<?php echo esc_attr( $button_width ); ?>" />
        </p>
	<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['ta_address'] = ( ! empty( $new_instance['ta_address'] ) ) ? strip_tags( $new_instance['ta_address'] ) : '';
		$instance['button_bg_color'] = ( ! empty( $new_instance['button_bg_color'] ) ) ? strip_tags( $new_instance['button_bg_color'] ) : '';
		$instance['button_color'] = ( ! empty( $new_instance['button_color'] ) ) ? strip_tags( $new_instance['button_color'] ) : '';
		$instance['button_height'] = ( ! empty( $new_instance['button_height'] ) ) ? strip_tags( $new_instance['button_height'] ) : '';
		$instance['button_width'] = ( ! empty( $new_instance['button_width'] ) ) ? strip_tags( $new_instance['button_width'] ) : '';
		return $instance;
	}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
?>

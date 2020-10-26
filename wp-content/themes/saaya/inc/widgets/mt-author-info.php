<?php
/**
 * MT: Author Info
 *
 * Widget show the author information
 *
 * @package Mystery Themes
 * @subpackage Saaya
 * @since 1.0.0
 */

class Saaya_Author_Info extends WP_widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'saaya_author_info',
            'description' => __( 'Select the user to display the author info.', 'saaya' )
        );
        parent::__construct( 'saaya_author_info', __( 'MT: Author Info', 'saaya' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $fields = array(

            'widget_title' => array(
                'saaya_widgets_name'         => 'widget_title',
                'saaya_widgets_title'        => __( 'Widget title', 'saaya' ),
                'saaya_widgets_field_type'   => 'text'
            ),

            'user_id' => array(
                'saaya_widgets_name'         => 'user_id',
                'saaya_widgets_title'        => __( 'Select Author', 'saaya' ),
                'saaya_widgets_default'      => '',
                'saaya_widgets_field_type'   => 'user_dropdown'
            ),

            'user_thumb' => array(
                'saaya_widgets_name'         => 'user_thumb',
                'saaya_widgets_title'        => __( 'Author Image', 'saaya' ),
                'saaya_widgets_field_type'   => 'upload'
            ),

        );
        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        if( empty( $instance ) ) {
            return ;
        }

        $saaya_widget_title = empty( $instance['widget_title'] ) ? '' : $instance['widget_title'];
        $saaya_user_id      = empty( $instance['user_id'] ) ? '' : $instance['user_id'];
        $saaya_user_image   = empty( $instance['user_thumb'] ) ? '' : $instance['user_thumb'];

        echo $before_widget;
    ?>
            <div class="mt-author-info-wrapper">
                <?php
                    if( !empty( $saaya_widget_title ) ) {
                        echo $before_title . esc_html( $saaya_widget_title ) . $after_title;
                    }
                ?>
                <div class="author-bio-wrap">
                    <div class="author-avatar">
                        <?php
                            if( !empty( $saaya_user_image ) ) {
                                echo '<img src="'. esc_url( $saaya_user_image ) .'" />';
                            } else {
                                echo get_avatar( $saaya_user_id, '132' );
                            }
                        ?>
                    </div>
                    <h3 class="author-name"><?php echo wp_kses_post( get_the_author_meta( 'nickname', $saaya_user_id ) ); ?></h3>
                    <div class="author-description"><?php echo wp_kses_post( wpautop( get_the_author_meta( 'description', $saaya_user_id ) ) ); ?></div>
                    <div class="author-social">
                        <?php saaya_social_media_content(); ?>
                    </div><!-- .author-social -->
                </div><!-- .author-bio-wrap -->
            </div><!-- .mt-author-info-wrapper -->
    <?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param   array   $new_instance   Values just sent to be saved.
     * @param   array   $old_instance   Previously saved values from database.
     *
     * @uses    saaya_widgets_updated_field_value()     defined in mt-widget-fields.php
     *
     * @return  array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            extract( $widget_field );

            // Use helper function to get updated field values
            $instance[$saaya_widgets_name] = saaya_widgets_updated_field_value( $widget_field, $new_instance[$saaya_widgets_name] );
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param   array $instance Previously saved values from database.
     *
     * @uses    saaya_widgets_show_widget_field()       defined in mt-widget-fields.php
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            // Make array elements available as variables
            extract( $widget_field );
            $saaya_widgets_field_value = !empty( $instance[$saaya_widgets_name] ) ? wp_kses_post( $instance[$saaya_widgets_name] ) : '';
            saaya_widgets_show_widget_field( $this, $widget_field, $saaya_widgets_field_value );
        }
    }
}
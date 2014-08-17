<?php

/**
 * Single Forum Content Part
 *
 * @package bbPress
 * @subpackage Theme
 * This template part modified for use in WB's own site -- not part of Responsive child theme package.
 */

?>
<!-- 
     WB DIAGNOSTICS: ENTERING /home/wbtest/public_html/wp-content/themes/responsivepro-wbchild/bbpress/content-single-forum.php 
    <?php echo 'parent:' . bbp_get_forum_parent_id(bbp_get_forum_id()); ?> 
     <?php $forum_id=bbp_get_forum_id();
            if ( !bbp_get_forum_subforum_count( $forum_id, false ) ) {echo 'no children';} else { echo bbp_get_forum_subforum_count( $forum_id, false ). ' children';} ?> 
 -->

<div id="bbpress-forums">

	<?php bbp_breadcrumb(); ?>

	<?php bbp_forum_subscription_link(); ?>

	<?php do_action( 'bbp_template_before_single_forum' ); ?>

	<?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>

		<?php bbp_single_forum_description(); ?>

		<?php if ( bbp_has_forums() ) : ?>

			<?php bbp_get_template_part( 'loop', 'forums' ); ?>

		<?php endif; ?>

		<?php if ( !bbp_is_forum_category() && bbp_has_topics() ) : ?>

			<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

			<?php bbp_get_template_part( 'loop',       'topics'    ); ?>

			<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>
        <!-- wb added conditions to suppress topic form on top-level container forums and on document and news forums in have topics case -->
			<?php if( bbp_get_forum_parent_id(bbp_get_forum_id()) > 0 && 
			         bbp_get_forum_parent_id(bbp_get_forum_id())!= 22097 &&
			         bbp_get_forum_parent_id(bbp_get_forum_id())!= 22207
			          )
			               { bbp_get_template_part( 'form',       'topic'     );} ?>

        <!-- wb added conditions to suppress no topic feedback and topic form on top-level container forums and on document and news forums in no topics case -->
		<?php elseif ( 
		      !bbp_is_forum_category() && 
		       bbp_get_forum_parent_id(bbp_get_forum_id()) > 0 && 
		       bbp_get_forum_parent_id(bbp_get_forum_id())!= 22097 && 
		       bbp_get_forum_parent_id(bbp_get_forum_id())!= 22207 
		       ) : ?> 

        <!-- wb added conditions to suppress no topic feedback on forums that are parents -->
			<?php if( bbp_get_forum_subforum_count( $forum_id, false ) == 0){ bbp_get_template_part( 'feedback',   'no-topics' );} ?>
 			<?php bbp_get_template_part( 'form',       'topic'     ); ?>
		<?php endif; ?>

	<?php endif; ?>

	<?php  // do_action( 'bbp_template_after_single_forum' ); ?>

</div>



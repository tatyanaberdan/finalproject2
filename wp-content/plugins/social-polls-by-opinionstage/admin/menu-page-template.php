<?php
// block direct access to plugin PHP files:
defined( 'ABSPATH' ) or die();
?>

<script type='text/javascript'>
	jQuery(document).ready(function($) {
		var callbackURL = "<?php echo opinionstage_callback_url()?>";
		var toggleSettingsAjax = function(currObject, action) {
			$.post(ajaxurl, {action: action, activate: currObject.is(':checked')}, function(response) { });
		};
		var updatePageLink = function() {
			var page_id = $('select.os-page-select').val();
			var edit_url = "<?php echo admin_url()?>" + 'post.php?post=' + page_id +'&action=edit';
			$("a.os-edit-page").attr("href", edit_url);
		}
		$('#os-start-login').click(function(){
			var emailInput = $('#os-email');
			var email = $(emailInput).val();
			var new_location = "<?php echo OPINIONSTAGE_LOGIN_PATH.'?o='.OPINIONSTAGE_WIDGET_API_KEY.'&callback=' ?>" + encodeURIComponent(callbackURL) + "&email=" + email;
			window.location = new_location;
		});

		$('#os-switch-email').click(function(){
			var new_location = "<?php echo OPINIONSTAGE_LOGIN_PATH.'?o='.OPINIONSTAGE_WIDGET_API_KEY.'&callback=' ?>" + encodeURIComponent(callbackURL);
			window.location = new_location;
		});

		$('#os-email').keypress(function(e){
			if (e.keyCode == 13) {
				$('#os-start-login').click();
			}
		});

		$('#fly-out-switch').change(function(){
			toggleSettingsAjax($(this), "opinionstage_ajax_toggle_flyout");
		});

		$('#article-placement-switch').change(function(){
			toggleSettingsAjax($(this), "opinionstage_ajax_toggle_article_placement");
		});

		$('#sidebar-placement-switch').change(function(){
			toggleSettingsAjax($(this), "opinionstage_ajax_toggle_sidebar_placement");
		});
		$("input[name='os-section']").change(function(e){
			if ($('#feed_top_content').is(':checked')) {
				$('#os-section-shortcode').val('[os-section]');
			} else {
				$('#os-section-shortcode').val('[os-section kind="my"]');
			}
		});
		$('select.os-page-select').change(function() {
			updatePageLink();
		});
		$('#opinionstage-content').on('click', '#os-section-shortcode', function(e) {
			$(this).focus();
			$(this).select();
		});

		updatePageLink();
	});

</script>
<div id="opinionstage-content">
	<div class="opinionstage-header-wrapper">
		<div class="opinionstage-logo-wrapper">
			<div class="opinionstage-logo"></div>
		</div>
		<div class="opinionstage-status-content">
			<?php if($first_time) {?>
			<div class='opinionstage-status-title'>Connect WordPress with Opinion Stage to enable all features</div>
			<i class="os-icon icon-os-poll-client"></i>
			<input id="os-email" type="email" placeholder="Enter Your Email">
			<button class="opinionstage-blue-btn" id="os-start-login">CONNECT</button>
			<?php } else { ?>
			<div class='opinionstage-status-title'><b>You are connected</b> to Opinion Stage with the following email</div>
			<i class="os-icon icon-os-form-success"></i>
			<label class="checked" for="user-email"></label>
			<input id="os-email" type="email" disabled="disabled" value="<?php echo($os_options["email"]) ?>">
			<a href="javascript:void(0)" id="os-switch-email" >Switch account</a>
			<?php } ?>
		</div>
	</div>
	<div class="opinionstage-dashboard">
		<div class="opinionstage-dashboard-left">
			<div id="opinionstage-section-create" class="opinionstage-dashboard-section">
				<div class="opinionstage-section-header">
					<div class="opinionstage-section-title">Content</div>
					<?php if ( !$first_time ) {?>
					<a href="<?php echo OPINIONSTAGE_SERVER_BASE.'/dashboard/content'; ?>" target="_blank" class="opinionstage-section-action opinionstage-blue-bordered-btn">VIEW MY CONTENT</a>
					<?php } ?>
				</div>
				<div class="opinionstage-section-content">
					<div class="opinionstage-section-raw">
						<div class="opinionstage-section-cell opinionstage-icon-cell">
							<div class="os-icon icon-os-reports-polls"></div>
						</div>
						<div class="opinionstage-section-cell opinionstage-description-cell">
							<div class="title">Poll</div>
							<div class="example">e.g. What's your favorite color?</div>
						</div>
						<div class="opinionstage-section-cell opinionstage-btn-cell">
							<?php echo opinionstage_create_poll_link('opinionstage-blue-btn'); ?>
						</div>
					</div>
					<div class="opinionstage-section-raw">
						<div class="opinionstage-section-cell opinionstage-icon-cell">
							<div class="os-icon icon-os-reports-set"></div>
						</div>
						<div class="opinionstage-section-cell opinionstage-description-cell">
							<div class="title">Survey</div>
							<div class="example">e.g. Help us improve our site</div>
						</div>
						<div class="opinionstage-section-cell opinionstage-btn-cell">
							<?php echo opinionstage_create_widget_link('survey', 'opinionstage-blue-btn'); ?>
						</div>
					</div>
					<div class="opinionstage-section-raw">
						<div class="opinionstage-section-cell opinionstage-icon-cell">
							<div class="os-icon icon-os-reports-trivia"></div>
						</div>
						<div class="opinionstage-section-cell opinionstage-description-cell">
							<div class="title">Trivia Quiz</div>
							<div class="example">e.g. How well do you know dogs?</div>
						</div>
						<div class="opinionstage-section-cell opinionstage-btn-cell">
							<?php echo opinionstage_create_widget_link('quiz', 'opinionstage-blue-btn'); ?>
						</div>
					</div>
					<div class="opinionstage-section-raw">
						<div class="opinionstage-section-cell opinionstage-icon-cell">
							<div class="os-icon icon-os-reports-personality"></div>
						</div>
						<div class="opinionstage-section-cell opinionstage-description-cell">
							<div class="title">Outcome Quiz</div>
							<div class="example">e.g. What's your most dominant trait?</div>
						</div>
						<div class="opinionstage-section-cell opinionstage-btn-cell">
							<?php echo opinionstage_create_widget_link('outcome', 'opinionstage-blue-btn'); ?>
						</div>
					</div>
					<div class="opinionstage-section-raw">
						<div class="opinionstage-section-cell opinionstage-icon-cell">
							<div class="os-icon icon-os-widget-slideshow"></div>
						</div>
						<div class="opinionstage-section-cell opinionstage-description-cell">
							<div class="title">Slideshow</div>
							<div class="example">e.g. Browse the most watched TV series</div>
						</div>
						<div class="opinionstage-section-cell opinionstage-btn-cell">
							<?php echo opinionstage_create_slideshow_link( 'opinionstage-blue-btn' ); ?>
						</div>
					</div>
					<div class="opinionstage-section-raw">
						<div class="opinionstage-section-cell opinionstage-icon-cell">
							<div class="os-icon icon-os-widget-form"></div>
						</div>
						<div class="opinionstage-section-cell opinionstage-description-cell">
							<div class="title">Contact Form</div>
							<div class="example">e.g. Collect email addresses</div>
						</div>
						<div class="opinionstage-section-cell opinionstage-btn-cell">
							<?php echo opinionstage_create_widget_link('contact_form', 'opinionstage-blue-btn'); ?>
						</div>
					</div>
					<div class="opinionstage-section-raw">
						<div class="opinionstage-section-cell opinionstage-icon-cell">
							<div class="os-icon icon-os-reports-list"></div>
						</div>
						<div class="opinionstage-section-cell opinionstage-description-cell">
							<div class="title">List</div>
							<div class="example">e.g. Top 10 movies of all times</div>
						</div>
						<div class="opinionstage-section-cell opinionstage-btn-cell">
							<?php echo opinionstage_create_widget_link('list', 'opinionstage-blue-btn'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="opinionstage-dashboard-right">
			<div id="opinionstage-section-placements" class="opinionstage-dashboard-section <?php echo($first_time ? "opinionstage-disabled-section" : "")?>">
				<div class="opinionstage-section-header">
					<div class="opinionstage-section-title">Placements</div>
				</div>
				<div class="opinionstage-section-content-wrapper">
					<div class="opinionstage-section-content">
						<div class="opinionstage-section-raw">
							<div class="opinionstage-section-cell opinionstage-toggle-cell">
								<div class="opinionstage-onoffswitch <?php echo($first_time ? "disabled" : "")?>">
									<input type="checkbox" name="fly-out-switch" class="opinionstage-onoffswitch-checkbox" <?php echo($first_time ? "disabled" : "")?> id="fly-out-switch" <?php echo(!$first_time && $os_options['fly_out_active'] == 'true' ? "checked" : "") ?>>
									<label class="opinionstage-onoffswitch-label" for="fly-out-switch">
										<div class="opinionstage-onoffswitch-inner"></div>
										<div class="opinionstage-onoffswitch-switch"></div>
									</label>
								</div>
							</div>
							<div class="opinionstage-section-cell opinionstage-description-cell">
								<div class="title">Popup</div>
								<div class="example">Add a content popup to your site</div>
							</div>
							<div class="opinionstage-section-cell opinionstage-btns-cell">
								<a href="<?php echo opinionstage_flyout_edit_url('content'); ?>" class='opinionstage-blue-bordered-btn opinionstage-edit-content <?php echo($first_time ? "disabled" : "")?>' target="_blank">EDIT CONTENT</a>
								<a href="<?php echo opinionstage_flyout_edit_url('settings'); ?>" class='opinionstage-blue-bordered-btn opinionstage-edit-settings <?php echo($first_time ? "disabled" : "")?>' target="_blank">
									<div class="os-icon icon-os-common-settings"></div>
								</a>
							</div>
						</div>
						<div class="opinionstage-section-raw">
							<div class="opinionstage-section-cell opinionstage-toggle-cell">
								<div class="opinionstage-onoffswitch <?php echo($first_time ? "disabled" : "")?>">
									<input type="checkbox" name="article-placement-switch" class="opinionstage-onoffswitch-checkbox" <?php echo($first_time ? "disabled" : "")?> id="article-placement-switch" <?php echo(!$first_time && $os_options['article_placement_active'] == 'true' ? "checked" : "") ?>>
									<label class="opinionstage-onoffswitch-label" for="article-placement-switch">
										<div class="opinionstage-onoffswitch-inner"></div>
										<div class="opinionstage-onoffswitch-switch"></div>
									</label>
								</div>
							</div>
							<div class="opinionstage-section-cell opinionstage-description-cell">
								<div class="title">Article</div>
								<div class="example">Add a content section to all posts</div>
							</div>
							<div class="opinionstage-section-cell opinionstage-btns-cell">
								<a href="<?php echo opinionstage_article_placement_edit_url('content'); ?>" class='opinionstage-blue-bordered-btn opinionstage-edit-content <?php echo($first_time ? "disabled" : "")?>' target="_blank">EDIT CONTENT</a>
								<a href="<?php echo opinionstage_article_placement_edit_url('settings'); ?>" class='opinionstage-blue-bordered-btn opinionstage-edit-settings <?php echo($first_time ? "disabled" : "")?>' target="_blank">
									<div class="os-icon icon-os-common-settings"></div>
								</a>
							</div>
						</div>
						<div class="opinionstage-section-raw">
							<div class="opinionstage-section-cell opinionstage-toggle-cell">
								<div class="opinionstage-onoffswitch <?php echo($first_time ? "disabled" : "")?>">
									<input type="checkbox" name="sidebar-placement-switch" class="opinionstage-onoffswitch-checkbox" <?php echo($first_time ? "disabled" : "")?> id="sidebar-placement-switch" <?php echo(!$first_time && $os_options['sidebar_placement_active'] == 'true' ? "checked" : "") ?>>
									<label class="opinionstage-onoffswitch-label" for="sidebar-placement-switch">
										<div class="opinionstage-onoffswitch-inner"></div>
										<div class="opinionstage-onoffswitch-switch"></div>
									</label>
								</div>
							</div>
							<div class="opinionstage-section-cell opinionstage-description-cell">
								<div class="title">Sidebar Widget</div>
								<div class="example">
									<?php if($first_time) {?>
									Add content to your sidebar
									<?php } else { ?>
									<div class="os-long-text">
										<a href="<?php echo $url = get_admin_url('', '', 'admin') . 'widgets.php' ?>">Add widget to your sidebar</a>
									</div>
									<?php } ?>
								</div>
							</div>
							<div class="opinionstage-section-cell opinionstage-btns-cell">
								<a href="<?php echo opinionstage_sidebar_placement_edit_url('content'); ?>" class='opinionstage-blue-bordered-btn opinionstage-edit-content <?php echo($first_time ? "disabled" : "")?>' target="_blank">EDIT CONTENT</a>
								<a href="<?php echo opinionstage_sidebar_placement_edit_url('settings'); ?>" class='opinionstage-blue-bordered-btn opinionstage-edit-settings <?php echo($first_time ? "disabled" : "")?>' target="_blank">
									<div class="os-icon icon-os-common-settings"></div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="opinionstage-dashboard-left">
			<div id="opinionstage-section-help" class="opinionstage-dashboard-section">
				<div class="opinionstage-section-header">
					<div class="opinionstage-section-title">Help</div>
				</div>
				<div class="opinionstage-section-content">
					<div class="opinionstage-help-row">
						<a href="http://blog.opinionstage.com/how-to-add-interactive-content-on-wordpress/?o=wp35e8" class="opinionstage-help-link" target="_blank">How to use this plugin</a>
					</div>
					<div class="opinionstage-help-row">
						<?php echo opinionstage_create_link('Poll examples', 'showcase', '', 'opinionstage-help-link'); ?>
					</div>
					<div class="opinionstage-help-row">
						<?php echo opinionstage_create_link('Quiz, Survey, Form & List examples', 'discover', '', 'opinionstage-help-link'); ?>
					</div>
					<div class="opinionstage-help-row">
						<a href="http://blog.opinionstage.com/video-tutorials" class="opinionstage-help-link" target="_blank">View video tutorials</a>
					</div>
					<div class="opinionstage-help-row">
						<a href="https://opinionstage.zendesk.com/anonymous_requests/new" class="opinionstage-help-link" target="_blank">Contact us</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

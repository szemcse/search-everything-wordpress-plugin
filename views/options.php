<?php

Class se_admin {

	var $version = '6';

	function se_admin() {

		// Load language file
		$locale = get_locale();
		if ( !empty($locale) )
			load_textdomain('SearchEverything', SE_ABSPATH .'lang/SE4-'.$locale.'.mo');


		add_action('admin_head', array(&$this, 'se_options_style'));
		add_action('admin_menu', array(&$this, 'se_add_options_panel'));

        }

	function se_add_options_panel() {
		add_options_page('Search', 'Search Everything', 7, 'extend_search', array(&$this, 'se_option_page'));
	}

	//build admin interface
	function se_option_page() 
	{
		global $wpdb, $table_prefix, $wp_version;
			
			$new_options = array(
				'se_exclude_categories'		=> $_POST["exclude_categories"],
				'se_exclude_categories_list'	=> $_POST["exclude_categories_list"],
				'se_exclude_posts'				=> $_POST["exclude_posts"],
				'se_exclude_posts_list'		=> $_POST["exclude_posts_list"],
				'se_use_page_search'			=> $_POST["search_pages"],
				'se_use_comment_search'		=> $_POST["search_comments"],
				'se_use_tag_search'			=> $_POST["search_tags"],
				'se_use_category_search'		=> $_POST["search_categories"],
				'se_approved_comments_only'	=> $_POST["appvd_comments"],
				'se_approved_pages_only'		=> $_POST["appvd_pages"],
				'se_use_excerpt_search'		=> $_POST["search_excerpt"],
				'se_use_draft_search'			=> $_POST["search_drafts"],
				'se_use_attachment_search'		=> $_POST["search_attachments"],
				'se_use_authors'				=> $_POST['search_authors'],
				'se_use_metadata_search'		=> $_POST["search_metadata"]

			);
			
		if($_POST['action'] == "save") 
		{
			echo "<div class=\"updated fade\" id=\"limitcatsupdatenotice\"><p>" . __("Your default search settings have been <strong>updated</strong> by Search Everything. </p><p> What are you waiting for? Go check out the new search results!") . "</p></div>";
			update_option("se_options", $new_options);

		}
		
		if($_POST['action'] == "reset") 
		{ 
			echo '<div id="message" class="updated fade"><p><strong>Your settings have been reset.</strong></p></div>';
			delete_option("se_options", $new_options);
		}
		

		$options = get_option('se_options');

		?>

	<div class="wrap">
		<h2><?php _e('Search Everything Version:') ?> <?php echo $this->version; ?></h2>
			<form method="post">
		
				<div style="float: right; margin-bottom:10px; padding:0; " id="top-update" class="submit">
					<input type="hidden" name="action" value="save" />
					<input type="submit" value="<?php _e('Update Options', 'SearchEverything') ?>" />
				</div>

				
				<table style="margin-bottom: 20px;"></table>
				<table class="widefat fixed">
					<thead>
						<tr class="title">
							<th scope="col" class="manage-column"><?php _e('Basic Configuration') ?></th>
							<th scope="col" class="manage-column"></th>
						</tr>
					</thead>
		
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every page','SearchEverything'); ?>:<br/><small><?php _e('(non-password protected)','SearchEverything'); ?></small></td>
				        <td class="forminp">
				            <select id="search_pages" name="search_pages">
				                <option<?php if ($options['se_use_page_search'] == 'No') { echo ' selected="selected"'; } ?>>&nbsp;&nbsp;</option>
								<option<?php if ($options['se_use_page_search'] == 'Yes') { echo ' selected="selected"'; } ?>>Yes</option>
				            </select>
							
				        </td>
				    </tr>
				
					<tr class="mainrow"> 
				        <td class="titledesc">&nbsp;&nbsp;&nbsp;<?php _e('Search approved pages only','SearchEverything'); ?>:</td>
				        <td class="forminp">
				            <select id="appvd_pages" name="appvd_pages">
				                <option<?php if ($options['se_approved_pages_only'] == 'No') { echo ' selected="selected"'; } ?>>&nbsp;&nbsp;</option>
								<option<?php if ($options['se_approved_pages_only'] == 'Yes') { echo ' selected="selected"'; } ?>>Yes</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<?php
					// Show tags only for WP 2.3+
					if ($wp_version >= '2.3') : ?>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every tag name','SearchEverything'); ?>:</td>
				        <td class="forminp">
				            <select id="search_tags" name="search_tags" >
				                <option<?php if ($options['se_use_tag_search'] == 'No') { echo ' selected="selected"'; } ?>>&nbsp;&nbsp;</option>
								<option<?php if ($options['se_use_tag_search'] == 'Yes') { echo ' selected="selected"'; } ?>>Yes</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<?php endif; ?>
					<?php
					// Show categories only for WP 2.5+
					if ($wp_version >= '2.5') : ?>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every category name','SearchEverything'); ?>:</td>
				        <td class="forminp">
				            <select id="search_categories" name="search_categories">
				                <option<?php if ($options['se_use_category_search'] == 'No') { echo ' selected="selected"'; } ?>>&nbsp;&nbsp;</option>
								<option<?php if ($options['se_use_category_search'] == 'Yes') { echo ' selected="selected"'; } ?>>Yes</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<?php endif; ?>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every comment','SearchEverything'); ?>:</td>
				        <td class="forminp">
				            <select name="search_comments" id="search_comments">
				                <option<?php if ($options['se_use_comment_search'] == 'No') { echo ' selected="selected"'; } ?>>&nbsp;&nbsp;</option>
								<option<?php if ($options['se_use_comment_search'] == 'Yes') { echo ' selected="selected"'; } ?>>Yes</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<tr class="mainrow"> 
				        <td class="titledesc">&nbsp;&nbsp;&nbsp;<?php _e('Search approved comments only','SearchEverything'); ?>:</td>
				        <td class="forminp">
				            <select id="appvd_comments" name="appvd_comments">
				                <option<?php if ($options['se_approved_comments_only'] == 'No') { echo ' selected="selected"'; } ?>>&nbsp;&nbsp;</option>
								<option<?php if ($options['se_approved_comments_only'] == 'Yes') { echo ' selected="selected"'; } ?>>Yes</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every excerpt','SearchEverything'); ?>:</td>
				        <td class="forminp">
				            <select id="search_excerpt" name="search_excerpt">
				                <option<?php if ($options['se_use_excerpt_search'] == 'No') { echo ' selected="selected"'; } ?>>&nbsp;&nbsp;</option>
								<option<?php if ($options['se_use_excerpt_search'] == 'Yes') { echo ' selected="selected"'; } ?>>Yes</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<?php
					// Show categories only for WP 2.5+
					if ($wp_version >= '2.5') : ?>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every draft','SearchEverything'); ?>:</td>
				        <td class="forminp">
				            <select id="search_drafts" name="search_drafts">
				                <option<?php if ($options['se_use_draft_search'] == 'No') { echo ' selected="selected"'; } ?>>&nbsp;&nbsp;</option>
								<option<?php if ($options['se_use_draft_search'] == 'Yes') { echo ' selected="selected"'; } ?>>Yes</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<?php endif; ?>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every attachment','SearchEverything'); ?>:</td>
				        <td class="forminp">
				            <select id="search_authors" name="search_authors">
				                <option<?php if ($options['se_use_attachment_search'] == 'No') { echo ' selected="selected"'; } ?>>&nbsp;&nbsp;</option>
								<option<?php if ($options['se_use_attachment_search'] == 'Yes') { echo ' selected="selected"'; } ?>>Yes</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every custom field','SearchEverything'); ?>:<br/><small><?php _e('(metadata)','SearchEverything'); ?></small></td>
				        <td class="forminp">
				            <select id="search_metadata" name="search_metadata">
				                <option<?php if ($options['se_use_metadata_search'] == 'No') { echo ' selected="selected"'; } ?>>&nbsp;&nbsp;</option>
								<option<?php if ($options['se_use_metadata_search'] == 'Yes') { echo ' selected="selected"'; } ?>>Yes</option>
				            </select>
							
				        </td>
				    </tr>
					<tr class="mainrow"> 
				        <td class="titledesc"><?php _e('Search every author','SearchEverything'); ?>:</td>
				        <td class="forminp">
				            <select id="search_authors" name="search_authors">
				                <option<?php if ($options['se_use_authors'] == 'No') { echo ' selected="selected"'; } ?>>&nbsp;&nbsp;</option>
								<option<?php if ($options['se_use_authors'] == 'Yes') { echo ' selected="selected"'; } ?>>Yes</option>
				            </select>
							<br/><small></small>
				        </td>
				    </tr>
				</table>
				<table style="margin-bottom: 20px;"></table>
					
				<table class="widefat">
					<thead>
						<tr class="title">
							<th scope="col" class="manage-column"><?php _e('Advanced Configuration - Exclusion') ?></th>
							<th scope="col" class="manage-column"></th>
						</tr>
					</thead>
				
					<tr class="mainrow"> 
					    <td class="titledesc"><?php _e('Exclude some post or page IDs','SearchEverything'); ?>:</td>
					    <td class="forminp">
					        <input type="text" id="exclude_posts_list" name="exclude_posts_list" value="<?php echo $options['se_exclude_posts_list'];?>" />
						    <br/><small><?php _e('Comma separated Post IDs (example: 1, 5, 9)','SearchEverything'); ?></small>
					    </td>
					</tr>
					<tr class="mainrow"> 
					    <td class="titledesc"><?php _e('Exclude Categories','SearchEverything'); ?>:</td>
					    <td class="forminp">
					        <input type="text" id="exclude_categories_list" name="exclude_categories_list" value="<?php echo $options['se_exclude_categories_list'];?>" />
						    <br/><small><?php _e('Comma separated category IDs (example: 1, 4)','SearchEverything'); ?></small>
					    </td>
					</tr>
					
				</table>


		<p class="submit">
			<input type="hidden" name="action" value="save" />
			<input type="submit" value="<?php _e('Update Options', 'SearchEverything') ?>" />
		</p>
	</form>

	<div class="info">
		<div style="float: left; padding-top:4px;"><?php _e('Developed by Dan Cameron of') ?> <a href="http://sproutventure.com" title="custom WordPress development"><?php _e('Sprout Venture') ?></a>. <?php _e('We Provide custom WordPress Plugins and Themes and a whole lot more.', 'SearchEverything') ?>
		</div>
		<div style="float: right; margin:0; padding:0; " class="submit">
			<form method="post">
				<input name="reset" type="submit" value="Reset Button" />
				<input type="hidden" name="action" value="reset" />
			</form>
		<div style="clear:both;"></div>
	</div>

<div style="clear: both;"></div>

<small><?php _e('Find a bug?') ?> <a href="https://redmine.sproutventure.com/projects/search-everything/issues" target="blank"><?php _e('Post it as a new issue','SearchEverything')?></a>.</small>
</div>			

				<table style="margin-bottom: 20px;"></table>
				<table class="widefat">
					<thead>
						<tr class="title">
							<th scope="col" class="manage-column"><?php _e('Test Search Form', 'SearchEverything'); ?></th>
							<th scope="col" class="manage-column"></th>
						</tr>
					</thead>
				
					<tr class="mainrow"> 
						<td class="thanks">
							<p><?php _e('Use this search form to run a live search test.', 'SearchEverything'); ?></p>
						</td>
						<td>
							<form method="get" id="searchform" action="<?php bloginfo('home'); ?>">
							<p class="srch submit">
								<input type="text" class="srch-txt" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" size="30" />
								<input type="submit" class="SE5_btn" id="searchsubmit" value="<?php _e('Run Test Search', 'SearchEverything'); ?>" />
							</p>
			      			</form>
						</td>
					</tr>
				</table>
				
				<table style="margin-bottom: 20px;"></table>
				<table class="widefat">
					<thead>
						<tr class="title">
							<th scope="col" class="manage-column"><?php _e('Thank You!') ?></th>
							<th scope="col" class="manage-column"><?php _e('Development Support') ?></th>
							<th scope="col" class="manage-column"><?php _e('Localization Support') ?></th>
						</tr>
					</thead>
				
					<tr class="mainrow"> 
					    <td class="thanks">
						<p><?php _e('The development of Search Everything since Version one has primarily come from the WordPress community, I&#8217;m grateful for their dedicated and continued support.') ?></p>
						</td>
				        <td>
							<ul class="SE_lists">
								<li><a href="#">Gary Traffanstedt</a> (<a href="https://redmine.sproutventure.com/projects/search-everything/issues" target="blank">#43</a>)</li>
								<li><a href="#">Eric Le Bail</a> (<a href="https://redmine.sproutventure.com/projects/search-everything/issues" target="blank">#44 and #60</a>)</li>
								<li><a href="#">Gary Traffanstedt</a> (<a href="https://redmine.sproutventure.com/projects/search-everything/issues" target="blank">#43</a>)</li>
								<li><a href="http://codium.co.nz"  target="blank">Matias Gertel</a></li>
								<li><a href="http://striderweb.com/" target="blank">Stephen Rider</a></li>
								<li><a href="http://chrismeller.com/" target="blank">Chris Meller</a></li>
								<li><a href="http://kinrowan.net/" target="blank">Cori Schlegel</a></li>
								<li>and many more...<a href="https://redmine.sproutventure.com/projects/search-everything/issues" target="blank">how about you?</a></li>
							</ul>
					    </td>
						<td>
							<ul class="SE_lists">
								<li><a href="#">hit1205 (CN and TW)</a></li>
								<li><a href="#">Silver Ghost (RU)</a></li>
								<li><a href="http://beyn.org/" target="blank">Barış Ünver (FR)</a></li>
								<li><a href="http://www.alohastone.com" target="blank">alohastone (DE)</a></li>
								<li><a href="http://gidibao.net/" target="blank">Gianni Diurno (ES)</a></li>
								<li><a href="#">János Csárdi-Braunstein (HU)</a></li>
								<li><a href="http://gidibao.net/" target="blank">Gianni Diurno (IT)</a></li>
								<li><a href="http://wppluginsj.sourceforge.jp/i18n-ja_jp/" target="blank">Naoko McCracken (JA)</a></li>
								<li><a href="http://idimensie.nl" target="blank">Joeke-Remkus de Vries (NL)</a></li>
								<li><a href="#">Silver Ghost (RU)</a></li>
								<li><a href="http://mishkin.se" target="blank">Mikael Jorhult (RU)</a></li>
								<li><a href="#">Baris Unver (TR)</a></li>
							</ul>
					    </td>
						
					</tr>
				</table>
			</div>


		<?php
	}	//end se_option_page

	//styling options page
	function se_options_style() {
		?>
		<style type="text/css" media="screen">
			.titledesc {width:300px;}
			.thanks {width:400px; }
			.thanks p {padding-left:20px; padding-right:20px;}
			.info { background: #FFFFCC; border: 1px dotted #D8D2A9; padding: 10px; color: #333; }
			.info a { color: #333; text-decoration: none; border-bottom: 1px dotted #333 }
			.info a:hover { color: #666; border-bottom: 1px dotted #666; }
		</style>
		<?php
	}

}
?>
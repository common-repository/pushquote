(function() {
    tinymce.create('tinymce.plugins.pullquote', {
        init : function(ed, url) {
            ed.addButton('pullquote', {
                title : 'Add a Pull-Quote',
                image : url+'/images/pullquote.png',
                onclick : function() {
					// triggers the thickbox
					jQuery('#pullquote-form').dialog({                   
						'dialogClass'   : 'wp-dialog',           
						'modal'         : true,
						'width'			: 400,
						'height'		: 80,
						'autoOpen'      : true, 
						'closeOnEscape' : true
					});
					
					// handles the click event of the submit button
					jQuery('#pullquote-form').find('#pullquote-submit').unbind('click').click(function(){
						// defines the options and their default values
						// again, this is not the most elegant way to do this
						// but well, this gets the job done nonetheless
						var options = { 
							position: "left"
						};
						var table = jQuery('#pullquote-form').find('table');
						var shortcode = '[pullquote';
						
						for( var index in options) {
							var value = table.find('#pullquote-' + index).val();
							
							// attaches the attribute to the shortcode only if it's different from the default value
							if ( value !== options[index] )
								shortcode += ' ' + index + '="' + value + '"';
						}
						
						shortcode += ']' + ed.selection.getContent({format : 'text'}) +'[/pullquote]';
						// inserts the shortcode into the active editor
						tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
						
						// closes Thickbox
						jQuery("#pullquote-form").dialog("close");
					});
				}
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('pullquote', tinymce.plugins.pullquote);
    
    // executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="pullquote-form" title="Add a Pullquote" class="dp_dialogModal"><table id="pullquote-table" class="form-table">\
			<tr class="row">\
				<td><span>Position</span></td>\
				<td><select id="pullquote-position" name="position">\
				<option value="left">Left</option>\
				<option value="right">Right</option>\
				</select><br />\
			    </td>\
				<td>\
				<input type="button" id="pullquote-submit" class="button" value="Make it so" name="submit" />\
				</td>\
			</tr>\
		</table>\
		</div>');
		
		form.appendTo('body').hide();
		
		
	});
})();

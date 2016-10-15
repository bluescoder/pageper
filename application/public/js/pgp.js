/**
 * Applies icon hover to an img element. Changes the image from 'original.extension' 
 * to 'original-hover.extension'
 * @param cl Class for elements over which apply hover
 */
function icon_hover(cl) {
	$('.' + cl).each(function() {
		$(this).mouseover(function() {
			var src = $(this).attr('src');
			if(src.lastIndexOf("-hover") == -1) {
				var dot = src.lastIndexOf(".");
				var newSrc = src.substring(0, dot) + "-hover" + src.substring(dot);
				$(this).attr('src', newSrc);
			}
		});
		
		$(this).mouseout(function() {
			var src = $(this).attr('src');
			if(src.lastIndexOf("-hover") >= 0) {
				var hover = src.lastIndexOf("-hover");
				var dot = src.lastIndexOf(".");
				var newSrc = src.substring(0, hover) + src.substring(dot);
				$(this).attr('src', newSrc);
			}
		});
	});
}
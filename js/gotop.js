/**
 * G4HDU Goto Top plugin
 *
 * Copyright (C) 2008-2016 Barry Keal G4HDU http://e107.keal.me.uk
 * blankd under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * @author Barry Keal e107@keal.me.uk>
 * @copyright Copyright (C) 2008-2016 Barry Keal G4HDU
 * @license GPL
 * @version 1.0.0
 *
 *
*/
$(document).ready(function () {
	gotopUp='';
	if (gotopText==1) {
		gotopUp='<div id="gotopWord">Top</div>';
	}
	$("<div id='gotopContainer' class='scrollToTop'> \
		<div id='gotopInner'> \
			<div id='gotopIcon'> \
				<i id='gotopbox' class='fa fa-arrow-up'  aria-hidden='true' /> \
			"+gotopUp+" \
			</div> \
		</div> \
	</div>").appendTo(document.body);

	//Check to see if the window is top if not then display button
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollToTop').fadeIn();
		} else {
			$('.scrollToTop').fadeOut();
		}
	});

	//Click event to scroll to top
	$('.scrollToTop').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});

});
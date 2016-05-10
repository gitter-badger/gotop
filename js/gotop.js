$(document).ready(function(){
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
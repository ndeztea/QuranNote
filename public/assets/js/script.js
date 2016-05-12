var QuranJS = {
	siteUrl : '',
	loadingText : ['"Hai orang-orang yang beriman. Bersabarlah kamu, dan kuatkanlah kesabaranmu dan tetaplah bersiaga-siaga (diperbatasan negrimu) dan bertaqwalah kepada Allah supaya kamu beruntung." (Ali-Imran 200).','"Tetapi orang yang bersabar dan memaafkan sesungguhnya (perbuatan) yang demikian itu termasuk hal-hal yang diutamakan" (Asy-Syuura 43)','"Sesengguhnya kesabaran itu hanyalah pada pukulan yang pertama dari bala" (Hadist Muttafaq\'alaih)'],

	modalLoading : function(){
		randomInt = Math.floor(Math.random() * (3 - 1)) + 1;

		$('.modal-title').html('<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>');
		
		$('.modal-body').html(this.loadingText[randomInt]);
		$('.modal-header button').hide();
	},

	modalLoadingBlock : function(){

	},

	removeModalClass : function(){
		$('#QuranModal').removeClass('login-mode');
		$('#QuranModal').removeClass('register-mode');
		$('#QuranModal').removeClass('share-mode');
		$('#QuranModal').removeClass('content-mode');
	},

	changePage : function (elm){
		page = $(elm).data('value');
		if(typeof page=='undefined'){
			page = $('.'+elm).val();
		}
		if(page!=''){
			// @todo : use ajax
			$('#preloader').css('height','2000px');
			$('#preloader').show();
			location.href=this.siteUrl+'/mushaf/page/'+page;
		}
		
	},

	changeSurah : function (surah){
		// @todo : use ajax
		location.href=this.siteUrl+'/mushaf/surah/'+$(surah).val();
	},

	fillAyatEnd : function(ayatEnd){
		if(jQuery('#fill_ayat_end').is(':checked')){
			$('.ayat_end').show();
		}else{
			$('.ayat_end').hide();
		}
		
	},

	callModal : function(url){
		$('#QuranModal').modal('show');
		this.modalLoading();
		this.removeModalClass();
		$.getJSON(this.siteUrl+'/'+url,{},function(response){
			$('.modal-title').html(response.modal_title);
			$('.modal-body').html(response.modal_body);
			if(response.modal_footer!=''){
				$('.modal-footer').show();
				$('.modal-footer').html(response.modal_footer);
			}
			
			
			$('#QuranModal').addClass(response.modal_class);
			$('.modal-header button').show();
		})

		//$('.modal-title').html('Title');
		//$('.modal-body').html('body');
		//$('.modal-footer').html('footer');
	},

	createMemoz : function(url){
		this.modalLoading();

		$.getJSON(this.siteUrl+'/'+url,{},function(response){
			$('.modal-title').html(response.modal_title);
			$('.modal-body').html(response.modal_body);
			$('.modal-footer').html(response.modal_footer);

			$('.modal-header button').show();
		})

	},


	/** AUTH code**/
	showRegister  : function(){
		this.removeModalClass();
		$('.modal-title').html('Daftar');
		$('.login_form').hide();
		$('.register_form').show();
		$('#QuranModal').addClass('register-mode');
	},
	registerProcess : function(){
		this.modalLoadingBlock();

		name = $('#name').val();
		email = $('#email').val();
		password = $('#password').val();

		$.post(this.siteUrl+'/auth/registerProcess',{
					name : name,
					email : email,
					password : password
				}, function (reponse){
					console.log(reponse);
				}
			);
	},

	showLogin  : function(){
		this.removeModalClass();
		$('.modal-title').html('Masuk Dahulu');
		$('.login_form').show();
		$('.register_form').hide();
		$('#QuranModal').addClass('login-mode');
	},

	// show & hide player
	togglePlayer : function (){

		$('.openThis').hide();

			$('.btn-toggle-player').click(function() {

			    $('.quran_player').slideToggle( function() {

			    	$('.openThis').show();
						
				});

			});

	},

	generateTransHeight : function (importantTag){
		$( ".trans").each(function( index,element ) {
				className = '.'+$(element).attr('class').split(' ').join('.');
				height = $(className).outerHeight();
				$(className).attr('style', 'height:'+height+'px');
				//$(className).css('height','100%');     
			});
	},

	generateArHeight : function  (importantTag){
			$( ".arabic" ).each(function( index,element ) {
				className = '.'+$(element).attr('class').split(' ').join('.');
				height = $(className).outerHeight();
				$(className).attr('style', 'height:'+height+'px');
				//$(className).css('height','100%');     
			});
	},

	redHightlight:function (){
		$('.trans').highlight('Allah','highlight-red', { wordsOnly: true });
        $('.arabic').highlight('للَّهِ','highlight-red');
        $('.arabic').highlight('ٱللَّهُ','highlight-red');
        $('.arabic').highlight('ٱللَّهَ','highlight-red');
        $('.arabic').highlight('لِلَّهِ','highlight-red');
        
	},

	memorized:function(ayat) {
		$('.'+ayat).addClass('memorized');
		$('.'+ayat+' .action-footer').remove();
	},

	showMushafAction : function(show) {
		$('.footer_action').val(show);
		if(show==true){
			$('.action-footer').show();
		}else{
			$('.action-footer').hide();
		}
	}

} 


@extends('layouts.master')

@section('title', 'Menghafal Al-Quran')

<?php $prev_surah = $tempCountSpaces = $countSpaces = '';  ?>
@section('content')
@include('errors.errors_message')
<div class="main-content-wrap">
	<div class="main-content">
		<div class="backdrop">
			<div class="backdrop-inner"></div>
		</div>
		<!-- /backdrop -->
		<div class="single-column">
			<div class="page-title">
				<h2>Menghafal</h2>
				<a class="pull-right gp-link" target="_blank"  href="https://play.google.com/store/apps/details?id=com.ndeztea.quranmemo"><img src="{{url('assets/images/button-google-play.png')}}" width="150"></a>
				
			</div>
			<div class="nav-top clearfix">
			<div style="display:{{!empty($ayats)?'none':''}}">
				<div class="select-surah pull-left">
					<form class="form-inline" action="<?php echo url('memoz/search')?>" method="post" onsubmit="cookieLastMemo()">
							<!--span class="search-title">Surah</span-->
							<div class="form-group">
								<select name="surah_start"  id="surah_start" class="form-control">
									@foreach($surahs as $surah)
									<option {{$surah->id==$surah_start?'selected':''}} value="{{$surah->id}}">{{$surah->id}}. {{$surah->surah_name}} ({{$surah->type}})</option>
									@endforeach
								</select>
							</div>
							<!--div class="form-group display-inline-block-xs">
								<input class="form-control search_ayat" type="number" name="ayat_start" value="<?php echo $ayat_start?$ayat_start:''?>">
							</div>
							<!--div class="checkbox display-inline-block-xs">
								<label>
									<input type="checkbox" value="1" id="fill_ayat_end" <?php echo !empty($fill_ayat_end)?'checked':''?> name="fill_ayat_end" onclick="QuranJS.fillAyatEnd(this)">  <span>Sampai ayat </span>
								</label>
							</div>

							-->
							<div class="form-group display-inline-block-xs">
								<div class="input-group memoz-form">
								  <input class="form-control search_ayat" id="ayat_start" type="number" min="1" name="ayat_start" placeholder="Ayat" aria-label="Ayat"  value="{{$ayat_start?$ayat_start:''}}">
								  <span class="input-group-addon">Sampai Ayat</span>
								  <input class="form-control search_ayat" id="ayat_end" type="number" min="1" name="ayat_end" id="ayat_end" placeholder="Ayat" aria-label="Ayat"  value="{{$ayat_end?$ayat_end:''}}">
								</div>
							</div>
							
							<button class="btn btn-cari-ayat" type="submit" name="btnSubmit"><i class="fa fa-search"></i><span class="sr-only">Cari</span></button>
							
							@if(isset($_COOKIE['coo_last_memoz']))
							<a class="btn btn-cari-ayat btn-last-memoz" href="{{$_COOKIE['coo_last_memoz']}}"><i class="fa fa-sign-in"></i> Hafalan Terakhir</a>
							@endif
					</form>
				</div>
			</div>
			@if(!empty($ayats))
				<div class="select-surah pull-left">
					<a class="btn btn-green-small" href="javascript:;" onclick="QuranJS.createMemoModal()"><i class="fa fa-plus"></i> Hafalan baru</a>
					<!--a class="btn btn-green-small" href="{{url('memoz')}}"><i class="fa fa fa-thumbs-up"></i> Hafal</a-->
					<a class="btn btn-green-small" href="javascript:;" onclick="QuranJS.showInfoMemoz();$('.info').html('Lanjutkan menghafal');$('.cont_hide_memoz_info').hide()"><i class="fa fa-info"></i> Info</a>
				</div>
			@endif
			
				@if(!empty($ayats))

				<div class="memoz_options">

					<div class="btn-group">
					  <button type="button" href="#" onclick="QuranJS.callModal('memoz/config?repeat='+$('.repeat').val())" class="btn btn-green-small">
					    &nbsp;<i class="fa fa-cog"></i>&nbsp;
					  </button>
					  
					</div>
					
				</div>
				<!-- /memoz-player -->
				@endif
				<input type="hidden" name="repeat" class="repeat" value="1" />

			</div>
			<!-- /nav-top -->
			<input type="hidden" name="puzzle_ayat" id="puzzle_ayat" value="">
			<input type="hidden" name="puzzle_word" id="puzzle_word" value="">
			@if(!empty($ayats))
			<div class="container-fluid">
				<div class="row">
					<div class="">

						<div class="mushaf mushaf-hafalan">
							<div class="step-wrap">
								<div class="steps clearfix btn-group btn-breadcrumb" role="group" aria-label="steps">
									<a href="javascript:void(0)" onclick="QuranJS.stepMemoz('1')" class="btn btn-default steps_1 selected"># 1</a>
									<a href="javascript:void(0)" onclick="QuranJS.stepMemoz('2')" class="btn btn-default steps_2"># 2</a>
									<a href="javascript:void(0)" onclick="QuranJS.stepMemoz('3')" class="btn btn-default steps_3"># 3</a>
									<a href="javascript:void(0)" onclick="QuranJS.stepMemoz('4');QuranJS.showAyat('start')" class="btn btn-default steps_4"># 5</a>
									<a href="javascript:void(0)" onclick="QuranJS.stepMemoz('5');" class="btn btn-default steps_5"># 6</a>
								</div>
							</div>
							<!-- /step-wrap -->
							<!--div class="pull-right hafalan-actions">
								<button class="btn"  data-toggle="modal" data-target="#QuranModal" onclick="QuranJS.callModal('memoz/create')">Simpan Hafalan</button>
								<button class="btn btn-success">Sudah Hafal</button>
							</div-->
							<!-- /hafalan-actions -->
							<div class="clearfix"></div>
							<div class="steps_desc">
								<div class="alert alert-success">
									<p> Hafalkan dengan teliti target hafalan arabic dan terjemahannya, ulangi muratal sebanyak-banyaknya sampai hafal</p>
								</div>
							</div>
							<?php  $a=0; ?>
							<div class="memoz_nav" style="display: none">
								<a href="javascript:;" class="btn" onclick="QuranJS.showAyat('start')">Awal</a>
								<a href="javascript:;" class="btn" onclick="QuranJS.showAyat('middle')">Tengah</a>
								<a href="javascript:;" class="btn" onclick="QuranJS.showAyat('end')">Akhir</a>
								<a href="javascript:;" class="btn" onclick="QuranJS.showAyat('mix')">Awal+Akhir</a>
								<a href="javascript:;" class="btn" onclick="QuranJS.showAyat('random')">Acak</a>
							</div>
							<script>
								QuranJS.totalAyat = {{count($ayats)}}
							</script>
							
							@foreach($ayats as $ayat)
							@if(($prev_surah!=$ayat->surah && $ayat->surah!=1 && $prev_surah!='') || ($prev_surah=='' && $ayat->ayat==1 && $ayat->surah!=1 ) || ($ayat->surah==1 && $ayat->ayat==1))
							<a name="head_surah_{{$ayat->surah}}"></a>
							<div class="clearfix ayat_section section_{{$ayat->page}}_{{$ayat->surah}}_0 play_0 surah_title head_surah_{{$ayat->surah}}"  >
								<div class="surah_name">
									<strong>{{$ayat->surah}}. Surah {{$ayat->surah_name}}</strong><br/>
									<small>{{$ayat->type}} ( turun  #{{$ayat->order}} ) | {{$ayat->count_ayat}} ayat </small>
								</div>
								@if($ayat->surah!=1 || $ayat->ayat!=1)
								<div class="head_surah" >
								بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ
								</div>
								@else 
								<?php $a++; ?>
								@endif
								<div class="clearfix"></div>
							</div>
							<!-- /ayat-section -->
							@endif
														<div class="clearfix ayat_section section_{{$ayat->page}}_{{$ayat->surah}}_{{$ayat->ayat}}">
								@if($a!=0)
								<div id="play_{{$a + 1}}"></div>
								@endif
								<div class="arabic arabic_{{$a}}">
									
									<span class="content_ayat">
										<?php $arr_ayats = (explode(' ', trim($ayat->text)));$per=0;
										$countSpaces = count($arr_ayats); 
										?>
										<script>
											QuranJS.totalAyatSpaces[{{$a}}] = {{$countSpaces}}
										</script>
										@foreach($arr_ayats as $per_ayat)
											<?php $per++;?>
											<span class="puzzle_border puzzle_no_border">
												<span class="ayat_arabic ayat_arabic_memoz per_words_<?php echo $per?>"  data-css=".arabic_{{$a}} .per_words_{{$per}}">{{$per_ayat}}</span>
											</span>
										@endforeach

										<span class="no_ayat_arabic_memoz">
											<img src="{{url('assets/images/frame-ayat.png')}}">
											<span>{{arabicNum($ayat->ayat)}}</span> 
										</span>
									</span> 

								</div>
								<!-- PUZZLE -->
								<div class="puzzle puzzle_{{$a}}" style="display:none">
								<?php $per = 0?>
								@foreach($arr_ayats as $per_ayat)
									<?php $per++;?>
										<span class="arabic"><a onclick="QuranJS.puzzleAnswer(this)" href="javascript:;" data-css=".arabic_{{$a}} .per_words_{{$per}}">{{$per_ayat}}</a></span>
								@endforeach
								</div>
								<!-- END -->

								<div class="trans trans_{{$a}}"> 
									<span class="no_ayat">( {{$ayat->ayat}} )</span> 
									<span class="content_ayat">{{$ayat->text_indo}}</span> 
								</div>
								
								<div class="action-footer">
					                <div class="btn-group">
					                  <a class="btn btn-play-ayat play_{{$a}}" href="javascript:;"><i class="fa fa-play"></i> Putar</a>
					                  <a class="btn btn-share-ayat" href="#"  onclick="QuranJS.callModal('bookmarks?url={{url('mushaf/surah/'.$ayat->surah.'/'.$ayat->ayat)}}')"><i class="fa fa-share-alt"></i> Berbagi</a>
					                  <a class="memozed btn-share-ayat btn" style="display:none" href="javascript:void(0)" onclick="QuranJS.memorized('section_{{$ayat->page}}_{{$ayat->surah}}_{{$ayat->ayat}}')"><i class="fa fa-thumbs-up"></i> Hafal</a>
					                </div>
					            </div>
							</div>

							<?php $prev_surah = $ayat->surah; $tempCountSpaces = $countSpaces?>
							<?php $a++;?>
							@endforeach
						
						</div>
						<!-- /mushaf -->

						<?php else:?>
							<div class="alert alert-warning memoz-message">
								<p>Tentukan surah dan ayat yang Anda ingin hafal, di sarankan target hafalan jangan terlalu panjang, perkirakan sesuai kemampuan hafalan Anda.</p>
								<!--p>Dalam proses hafalan terdapat 5 tahapan, yaitu : </p>
								<br>
								<ul>
									<li>Menghafal target hafalan arabic dan terjemahannya, jalankan dan dengarkan qori dengan teliti. Proses ini jangan terlalu lama dan lanjut ke tahap selanjutnya</li>
									<li>Menghafal target hafalan arabic nya saja, perhatikan tajwid nya dan tata letak hurufnya, dan bayangkan setiap gambaran hurufnya</li>
									<li>Menghafal target hafalan arabic dan terjemahanya, perhatikan terjemahan dari setiap kata arabic-nya</li>
									<li>Menghafal target hafalan terjemahanya, dalam tahap ini antum harus setidaknya hafal banyak arabic-nya, dan kuat kan hafalan dengan terjemahannya</li>
									<li>Menghafal target hafalan arabic dan terjemahannya, jalankan dan dengarkan qori dengan teliti, ulangi sampai berulang-ulang sampai hafal, dan yang perhatikan makhrajul huruf-nya</li>
								</ul>
								<br>
								<p>Jangan lupa untuk berdo'a kepada Allah Ta'ala untuk di mudahkan dalam penghafalan dan pemahaman terhadap target hafalan antum.</p-->

							</div>
						<?php endif?>

						

					</div>
				</div>



			</div>
		<!-- end single-column-->
		</div>
	<!-- end main main-content -->	
	</div>
<!-- end main main-content-wrap -->	
</div>


<script type="text/javascript">
$(document).ready(function(){
	QuranJS.fillAyatEnd();

	<?php if(!empty($ayats) && empty($_COOKIE['coo_hide_info'])):?>
	QuranJS.showInfoMemoz();
	<?php endif?>

	$(document).ready(function () {
		var jQuerywindow = jQuery(window);
			QuranJS.generateArHeight('!important');
			QuranJS.generateTransHeight('!important');

			$('.quran_player').hide();

			//show & hide search setting
			// $('.openThis').hide();
			// $('.btn-toggle-player').click(function() {
			//     $('.quran_player').slideToggle( function() {
			//     	$('.openThis').show();						
			// 	});
			//     return false;
			// });

			$('.dropdown-menu').on('click', function(event) {
			    event.stopPropagation();
			});

			$('.collapse').on('click', function(event) {
			    event.stopPropagation();
			});

			resizeDiv();

			window.onresize = function(event) {
				resizeDiv();
			}

			function resizeDiv() {
				vpw = $(window).width();
				vph = $(window).height();

				if (vpw <= 767) {
						$('#surah-collapse').removeClass('in');
						
					}
					else {
						$('#surah-collapse').addClass('in');
					}
			}
			//show & hide search setting

		});

		var stickyOffset = $('.qm-navbar').offset().top;
		var scrollTrigger = 100;

		$(window).scroll(function(){
			var sticky = $('.qm-navbar'),
			scroll = $(window).scrollTop();

			if (scroll > stickyOffset) {
					$(sticky).addClass('fixed'); 
				}	
			else 
				{
					$(sticky).removeClass('fixed');
					$('.navbar-nav li.active').removeClass('active');
				}
		});

		jQuery('.memozed').hide();
	});

	function hideInfo(){
		if($('input[name="hide_memoz_info"]:checked').val()){
			document.cookie = 'coo_hide_info="true";path=/';
		}else{
			document.cookie = 'coo_hide_info="false;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/"';
		}
	}

</script>

@endsection
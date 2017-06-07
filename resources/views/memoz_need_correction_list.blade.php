<div class="memoz_filter_others">
@if(!empty($list))
	<ul class="correction-list list-unstyled">
	@foreach($list as $row)
	<?php $ayat_target = $row->ayat_end==0?$row->ayat_start:$row->ayat_start.'-'.$row->ayat_end?>
	<li class="correction-list-item">
		<div class="koreksi-box">
			<div class="koreksi-avatar img-circle">
				<img src="{{getAvatar($row)}}"  class="img-circle">
			</div>
			<div class="koreksi-desc">
				<span class="username">{{$row->name}}</span>
				<span class="ayat-target"><a href="{{url('memoz/correction/'.$row->surah_start.'/'.$ayat_target.'/'.$row->id)}}">{{$row->surah}} : {{$ayat_target}}</a></span>
				<span class="spacer1">&bullet;</span> <i class="fa fa-commenting"> {{empty($row->count_correction)?0:$row->count_correction}} koreksi</i>
			</div>
			<!--/koreksi-desc-->
		</div>
	</li>
	@endforeach
	</ul>
	@if($start==0 && count($list)>10)
		<a href="javascript:void(0)" onclick="QuranJS.needCorrections('next')" class="btn btn-green btn-loadmore">Selanjutnya</a>
	@endif
@else
	@if($start==0)
	<p class="alert alert-warning no-content-center">Hafalan belum ada</p>
	@endif
@endif
</div>
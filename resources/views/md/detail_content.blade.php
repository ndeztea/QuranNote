@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
@include('errors.errors_message')
<div class="main-content-wrap">
	<div class="main-content">
		<div class="single-column dashboard-wrap">
			<div id="content" class="boxcontent">
				@if (!empty($content))
				<div class="dash-profile-detail-wrap">
					<div class="dash-profile-detail">
						<div class="dash-profile-desc">
							<div style="padding:10px">
								<div class="sub_title">Kategory : {{$content->category}}</div>
								<strong class="dash-profile-name">{{$content->title}}</strong>
							</div>
						</div>
					</div>
				</div>
				<div  style="padding:10px">
					<h4><i class="mdi mdi-book-open-page-variant"></i> Penjelasan</h4>
					<div class="content_detail">
						@if ($content->type=='video')
							<video src="{{url($content->content)}}" style="width:100%" controls></video>
						@elseif($content->type=='audiobook')
							<audio src="{{url($content->content)}}" style="width:100%" controls></audio>
						@else
						<embed src="{{url($content->content)}}" type="application/pdf" width="100%" height="600px" />

						@endif
					</div>
				</div>
				@else
				@include('errors.data_empty')
				@endif
    </div>
  </div>
</div>

@endsection

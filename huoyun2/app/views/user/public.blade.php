@section('title', $user->fullName)

@section('scripts')
<script>
$(document).ready(function(){

});

function toggleFollow(){		
	$.ajax({ 
        url: "{{URL::route('user.follow')}}",
        dataType: 'json', 
        data: {'follow_id': "{{$user->id}}", _token: "{{ csrf_token() }}"} ,
        type: "POST", 
        success: function(output){ 
            if(output.result) {
            $('#follow').text("unfollow");
            } else {
            	   $('#follow').text("follow");
                }
            
        }
	});
	
}

</script>

@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="content-box">
                <div class="trick-user">
                    <div class="trick-user-image">
                        <img src="{{ $user->photocss }}" class="user-avatar">
                    </div>
                    <div class="trick-user-data">
                        <h1 class="page-title">
                            {{ $user->fullName }}
                        </h1>
                        <div class="text-muted">
                            <b>{{ trans('user.joined') }}</b> {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
               
                </div>
              <div class="text-muted">
                      <b>followers</b> {{count($user->followers)}}
                </div>
                 <div class="text-muted">
                            <b>followings:</b>  {{count($user->followings)}}
                  </div>
                  
                  
                  <div class="btn btn-primary" onclick="toggleFollow()">
                  @if($followed)
                            <p id="follow">unfollow</b>
                  @else 
                   <p id="follow">follow</b>
                  @endif
                  </div>

            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-title">{{ trans('portfolio.research') }}</h1>
        </div>
        
        
    </div>


    <div class="row push-down">
        <div class="col-lg-12">
            <h1 class="page-title">{{ trans('portfolio.portfolio') }}</h1>
        </div>
    </div>

    @include('portfolio.grid', [ 'portfolios' => $portfolios ])
</div>


@stop

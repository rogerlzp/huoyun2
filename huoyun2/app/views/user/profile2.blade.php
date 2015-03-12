@section('title', trans('user.profile')) 
@section('styles')
<link rel="stylesheet"
	href="{{ URL::asset('css/user.css') }}">

@stop 

@section('scripts')
<script type="text/javascript">
function getMyPorfile() {
	$.ajax({ 
        url: "",
        dataType: 'json', 
        type: "GET", 
        success: function(output){ 
            alert(output);     
            $('#user-info').css('display','none');;
        } 
    }); 
}

function getOrderlist() {
	$.ajax({ 
        url: "{{URL::route('user.order')}}",
        dataType: 'json', 
        type: "GET", 
        success: function(output){ 
               
            $.each(output, function(key, value){
				alert(value.id);
               })   
           
        } 
    }); 
}


jQuery(function ($){
	$('#myinvest').click(function(){
		getMyPorfile() ;
		});
	
});


function getWatchlist() {
	alert('get watch list');
	$.ajax({ 
        url: "",
        dataType: 'json', 
        type: "GET", 
        success: function(output){ 
            $.each(output, function(key, value){
				alert(value.id);
               })   
        } 
    }); 


}

</script>




@stop


@section('content')
<div class="container">
	<div class="uc-full-box">
	
			<div class="span16 col-md-9">
				<div class="xm-box uc-box">
					<div class="xm-line-box uc-info-box">
						<div class="box-bd" id="user-info">
							<img class="uc-avatar"
								src=""
								alt="">

					</div>
					<!-- .uc-info-box END -->


					<div class="row">

					</div>

				</div>
			</div>


		</div>

	</div>
</div>

@stop




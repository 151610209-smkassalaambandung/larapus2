<!-- <a href="{{$edit_url}}">UBAH </a> 
{!! Form::model($model, ['url'=>$form_url,'method'=>'delete','class'=>'form-inline']) !!} 
	<a class="btn btn-xs btn-success" href="{{$edit_url}}"> Ubah </a>|
{!! Form::submit('Hapus',['class'=>'btn btn-xs btn-danger']) !!}
{!! Form::close() !!} -->

{!! Form::model($model,['url'=>$form_url,'method'=>'delete','class'=>'form-inline js\-confirm','data-confirm'=>$confirm_message]) !!}
		<a href="{{$edit_url}}" class="btn btn-xs btn-success">Ubah</a> 
		{!! Form::submit('Hapus',['class'=>'btn btn-xs btn-danger']) !!}
{!! Form::close() !!}
@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Perfil</div>
				<div class="panel-body">
					<div class="col-sm-3">
						<img src="{{URL::to('/images/profileAvatar.png')}}" class="user-img" alt="Profile">
					</div>
					<div class="col-sm-9">
						<div class="col-sm-12">
							<label><b>Nombre: </b> {{$data->name}}</label>
						</div>
						<div class="col-sm-12">
							<label><b>Correo: </b> {{$data->email}}</label>
						</div>
					</div>
					<div class="row col-sm-12">
					<hr>
				</div>
					<div class="row col-sm-12">
						<form class="form-horizontal" method="POST" action="{{URL::to('/perfil').'/'.$data->id.'/change-password'}}">
							  <input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="form-group">
								<label class="control-label col-sm-2">
									Contraseña Actual:
								</label>
								<div class="col-md-10">
									<input type="password" name="actual_password" class="form-control"  required/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2">
									Nueva Contraseña:
								</label>
								<div class="col-md-10">
									<input type="password" name="new_password" class="form-control" required/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2">
									Confirmar Contraseña:
								</label>
								<div class="col-md-10">
									<input type="password" name="confirm_password" class="form-control" required/>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-10">
										<input type="submit" name="enviar" value="Cambiar" class="btn btn-primary" />
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

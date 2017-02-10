@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading text-center">房屋管理</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-4">
							添加房屋
						</div>
						<div class="col-xs-4">
							修改房屋
						</div>
						<div class="col-xs-4">
							添加数据
						</div>
					</div>
				</div>
				<data-table></data-table>
			</div>
		</div>
	</div>
</div>
@endsection
@section('footer')
<script src="/js/house.js"></script>
@endsection
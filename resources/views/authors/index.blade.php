@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Authors</div>

                <div class="panel-body">
                    
					@if(count($errors)>0)
						<div class="alert alert-danger">
							<ul>
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ isset($edit_author) ? route('authors.update', ['id' => $edit_author->id]) : route('authors.store') }}">

						{{ csrf_field() }}

						@if(isset($edit_author))
							{{ method_field('PUT') }}
							<input type="hidden" name="id" value="{{ $edit_author->id }}"/>
						@endif
						
						<div class="form-group">
							<label for="author" class="col-md-4 control-label">Author name</label>
							<div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ isset($edit_author) ? $edit_author->name : old('name') }}" required/>
                            </div>
						</div>

						<div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    @if(isset($edit_author))
                                    	Update
                                    @else
                                    	Add new
                                    @endif
                                </button>
                            </div>
                        </div>

                    </form>

					@if($authors->count())
						<div class="form-group">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Books</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($authors as $author)
										<tr>
											<td>{{ $author->id }}</td>
											<td>{{ $author->name }}</td>
											<td>
												{{ implode(', ', array_column($author->books->toArray(), 'name')) }}
											</td>
											<td>
												<form method="POST" action="{{ route('authors.destroy', ['author' => $author->id]) }}" onsubmit="return confirm('r u sure?');">

													{{ csrf_field() }}
													{{ method_field('DELETE') }}

													<input type="hidden" name="id" value="{{ $author->id }}"/>
													<div class="btn-group">

														<div class="btn-group">
															<a href="{{ route('authors.edit', ['author' => $author->id]) }}">
																<button type="button" class="btn btn-sm btn-primary">
																	Edit
																</button>
															</a>
														</div>
														<button type="submit" class="btn btn-sm btn-danger">
															X
														</button>
													</div>
												</form>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
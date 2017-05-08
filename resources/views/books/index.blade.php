@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Books</div>

                <div class="panel-body">
                    
					@if(count($authors)>0)

						@if(count($errors)>0)
							<div class="alert alert-danger">
								<ul>
									@foreach($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						@if(Session::has('success'))
							<div class="alert alert-success">
								<ul>
									<li>{{ Session::get('success') }}</li>
								</ul>
							</div>
						@endif

						<form class="form-horizontal" role="form" method="POST" action="{{ isset($edit_book) ? route('books.update', ['id' => $edit_book->id]) : route('books.store') }}">

							{{ csrf_field() }}

							@if(isset($edit_book))
								{{ method_field('PUT') }}
								<input type="hidden" name="id" value="{{ $edit_book->id }}"/>
							@endif
							
							<div class="form-group">
								<label for="name" class="col-md-4 control-label">Book name</label>
								<div class="col-md-6">
	                                <input id="name" type="text" class="form-control" name="name" value="{{ isset($edit_book) ? $edit_book->name : old('name') }}" required/>
	                            </div>
							</div>

							<div class="form-group">
								<label for="author" class="col-md-4 control-label">Author</label>
								<div class="col-md-6">
									<select id="author" class="form-control" name="author_id">
										@foreach($authors as $author)
											<option 
												@if(isset($edit_book) && $edit_book->author->id == $author->id)
													selected
												@endif
												value="{{ $author->id }}">{{ $author->name }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
	                            <div class="col-md-8 col-md-offset-4">
	                                <button type="submit" class="btn btn-primary">
	                                    @if(isset($edit_book))
	                                    	Update
	                                    @else
	                                    	Add new
	                                    @endif
	                                </button>
	                            </div>
	                        </div>

	                    </form>
					
					@else

						<h2>No authors found!</h2>
						<p>Please submit at least one author first.</p>

                    @endif

					@if($books->count())
						<div class="form-group">
							<table class="table table-striped">
								<thead>
									<tr>
										<th class="text-center"><input type="checkbox" onClick="toggle(this)"/></th>
										<th>#</th>
										<th>Name</th>
										<th>Author</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($books as $book)
										<tr>
											<td class="text-center"><input name="delete_many" value="{{ $book->id }}" type="checkbox"/></td>
											<td>{{ $book->id }}</td>
											<td>{{ $book->name }}</td>
											<td>{{ $book->author->name }}</td>
											<td>
												<form method="POST" action="{{ route('books.destroy', ['book' => $book->id]) }}" onsubmit="return confirm('r u sure?');">

													{{ csrf_field() }}
													{{ method_field('DELETE') }}
													
													<input type="hidden" name="id" value="{{ $book->id }}"/>
													<div class="btn-group">

														<div class="btn-group">
															<a href="{{ route('books.edit', ['book' => $book->id]) }}">
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
									<tr>
										<th class="text-center">
											<form method="POST" action="{{ route('books.destroy', ['book' => 'many']) }}" onsubmit="return delete_many();" id="delete_many">

												{{ csrf_field() }}
												{{ method_field('DELETE') }}

												<button type="submit" class="btn btn-sm btn-danger">Delete selected</button>

											</form>
										</th>
									</tr>
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
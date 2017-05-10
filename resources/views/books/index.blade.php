@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('lang.books') }}</div>

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

						<form class="form-horizontal" role="form" method="POST" action="{{ isset($edit_book) ? route('books.update', ['id' => $edit_book->id]) : route('books.store') }}" enctype="multipart/form-data">

							{{ csrf_field() }}

							@if(isset($edit_book))
								{{ method_field('PUT') }}
								<input type="hidden" name="id" value="{{ $edit_book->id }}"/>
							@endif
							
							<div class="form-group">
								<label for="name" class="col-md-4 control-label">{{ __('lang.book_name') }}</label>
								<div class="col-md-6">
	                                <input id="name" type="text" class="form-control" name="name" value="{{ isset($edit_book) ? $edit_book->name : old('name') }}" required/>
	                            </div>
							</div>

							@if(isset($edit_book))
								<div class="form-group">
									<label for="image" class="col-md-4 control-label">{{ __('lang.cur_image') }}</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="image" value="{{ asset('images/books/'.$edit_book->image) }}" onclick="select(this)"/>
									</div>
								</div>
							@endif

							<div class="form-group">
	                            <label for="new_image" class="col-md-4 control-label">{{ __('lang.new_image') }}</label>
								<div class="col-md-6">
	                                <input 
	                                	type="file" 
	                                	class="form-control" 
	                                	name="new_image"
	                                	{{ (isset($edit_book) ? '' : 'required') }}/>
	                            </div>
							</div>

							<div class="form-group">
								<label for="author" class="col-md-4 control-label">{{ __('lang.author') }}</label>
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
	                                    	{{ __('lang.update') }}
	                                    @else
	                                    	{{ __('lang.add_new') }}
	                                    @endif
	                                </button>
	                            </div>
	                        </div>

	                    </form>
					
					@else

						<h2>{{ __('lang.no_authors') }}</h2>
						<p>{{ __('lang.submit_author') }}</p>

                    @endif

					@if($books->count())
						<div class="form-group">
							<table class="table table-striped">
								<thead>
									<tr>
										<th class="text-center"><input type="checkbox" onClick="toggle(this)"/></th>
										<th>#</th>
										<th>{{ __('lang.name') }}</th>
										<th>{{ __('lang.authors') }}</th>
										<th>{{ __('lang.action') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($books as $book)
										<tr>
											<td class="text-center"><input name="delete_many" value="{{ $book->id }}" type="checkbox"/></td>
											<td>{{ $book->id }}</td>
											<td>
												<a target="_blank" href="{{ asset('storage/images/books/'.$book->image) }}">
													{{ $book->name }}
												</a>
											</td>
											<td>{{ $book->author->name }}</td>
											<td>
												<form method="POST" action="{{ route('books.destroy', ['book' => $book->id]) }}" onsubmit="return confirm('{{ __('lang.r_u_sure') }}');">

													{{ csrf_field() }}
													{{ method_field('DELETE') }}
													
													<input type="hidden" name="id" value="{{ $book->id }}"/>
													<div class="btn-group">

														<div class="btn-group">
															<a href="{{ route('books.edit', ['book' => $book->id]) }}">
																<button type="button" class="btn btn-sm btn-primary">
																	{{ __('lang.edit') }}
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

												<button type="submit" class="btn btn-sm btn-danger">{{ __('lang.delete_selected') }}</button>

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
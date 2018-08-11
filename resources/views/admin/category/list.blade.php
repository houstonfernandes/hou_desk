@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    	<div>
    		Categories
    	</div>
        	<table class='table table-stripped'>
            	<thead>
                	<tr>        	
                		<th>id</th>
                		<th>Nome</th>
                	</tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                    </tr>
                @endforeach
            	</tbody>        	
        	</table>
        </div>
</div>
@endsection

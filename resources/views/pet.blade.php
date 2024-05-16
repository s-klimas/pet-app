@extends('layout')

@section('content')
    <form action="{{ route('pet.update', $data['id']) }}" method="post">
        @csrf
        @method('PUT')
        <label for="name">Name:</label> <input id="name" name="name" value="{{ $data['name'] }}"/><br>
        <label for="category-id">Category id:</label> <input id="category-id" name="category-id" value="{{ $data['category']['id'] }}"/><br>
        <label for="category-name">Category name:</label> <input id="category-name" name="category-name" value="{{ $data['category']['name'] }}"/><br>
        @foreach($data['photoUrls'] as $key => $photoUrl)
            <label for="photo-urls-{{ $key }}">Photo url:</label> <input id="photo-urls-{{ $key }}" name="photo-urls[{{$key}}]" value="{{ $photoUrl }}"/><br>
        @endforeach
        @foreach($data['tags'] as $key => $tag)
            <label for="tag-id-{{ $key }}">Tag id:</label> <input id="tag-id-{{ $key }}" name="tags[{{$key}}][id]" value="{{ $tag['id'] }}"/><br>
            <label for="tag-name-{{ $key }}">Tag name:</label> <input id="tag-name-{{ $key }}" name="tags[{{$key}}][name]" value="{{ $tag['name'] }}"/><br>
        @endforeach
        <label for="status">Status:</label> <input id="status" name="status" value="{{ $data['status'] }}"/><br>
        <button type="submit">Send changes</button>
    </form>
    <hr>
    <a>If you want to delete this pet click this button.
        <form action="{{ route('pet.delete', $data['id']) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit">Delete pet</button>
        </form>
    </a>
@endsection

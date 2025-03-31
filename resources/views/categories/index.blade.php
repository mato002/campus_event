@extends('layouts.app')

@section('content')
<div class="page-container">
    <h1 class="page-title">Event Categories</h1>
    
    <div class="categories-container">
        @foreach ($categories as $category)
            <div class="category-item">
                <div class="category-icon"></div>
                <h3><a href="{{ route('events.byCategory', ['category' => $category->id]) }}">{{ $category->name }}</a></h3>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    .page-container {
        width: 80%;
        margin: 30px auto;
        padding: 20px;
        background: white;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .page-title {
        font-size: 28px;
        margin-bottom: 20px;
        text-align: center;
        color: #0056b3;
    }

    .categories-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        padding: 10px 0;
    }

    .category-item {
        background: #f4f4f4;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .category-item:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
    }

    .category-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    .category-item h3 {
        margin: 0;
        font-size: 18px;
    }

    .category-item h3 a {
        text-decoration: none;
        color: #0056b3;
        font-weight: bold;
        transition: color 0.3s;
    }

    .category-item h3 a:hover {
        color: #003d80;
    }
</style>
@endsection

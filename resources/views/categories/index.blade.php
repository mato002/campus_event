@extends('layouts.app')

@section('content')
<div class="page-container">
    <h1 class="page-title">Event Categories</h1>
    
    <div class="categories-container">
        <div class="category-item">
            <div class="category-icon">🎤</div>
            <h3><a href="#">Music & Entertainment</a></h3>
        </div>
        
        <div class="category-item">
            <div class="category-icon">📚</div>
            <h3><a href="#">Educational & Workshops</a></h3>
        </div>
        
        <div class="category-item">
            <div class="category-icon">⚽</div>
            <h3><a href="#">Sports & Fitness</a></h3>
        </div>
        
        <div class="category-item">
            <div class="category-icon">🎭</div>
            <h3><a href="#">Cultural & Arts</a></h3>
        </div>
        
        <div class="category-item">
            <div class="category-icon">🎓</div>
            <h3><a href="#">Career & Networking</a></h3>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* General Page Styles */
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

    /* Categories Container */
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

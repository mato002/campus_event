<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event; // Import Event model
use Carbon\Carbon;

class UserCategoryController extends Controller
{
    // Method to display the categories to the regular user
    public function index()
    {
        // Fetch all categories for regular users
        $categories = Category::all(); // You can paginate this if needed

        return view('categories.index', compact('categories'));
    }

    // Method to fetch events under a specific category
    public function eventsByCategory($categoryId)
    {
        // Fetch the category
        $category = Category::findOrFail($categoryId);

        // Fetch the events under this category with their relationships (image, venue, start and end date)
        $events = $category->events()->with('venue')->get(); // Assuming the Event model has a `venue` relationship

        // Pass the events and category to the view
        return view('events.category', compact('events', 'category'));
    }
}

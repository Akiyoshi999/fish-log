<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    public function show(string $name): View
    {
        $tag = Tag::where('name', $name)->first();
        return view('tags.show', [
            'tag' => $tag,
        ]);
    }
}
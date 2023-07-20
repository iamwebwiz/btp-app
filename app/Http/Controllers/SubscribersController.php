<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class SubscribersController extends Controller
{
    public function index()
    {
        return Inertia::render('Subscribers/Index');
    }

    public function create()
    {
        return Inertia::render('Subscribers/Create');
    }

    public function show(int $id)
    {
        return Inertia::render('Subscribers/Show', compact('id'));
    }
}

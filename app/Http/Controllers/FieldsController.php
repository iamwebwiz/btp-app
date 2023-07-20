<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class FieldsController extends Controller
{
    public function index()
    {
        return Inertia::render('Fields/Index');
    }

    public function create()
    {
        return Inertia::render('Fields/Create');
    }

    public function show(int $id)
    {
        return Inertia::render('Fields/Show', compact('id'));
    }
}

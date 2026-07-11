<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
   public function index(Request $request)
    {

        $query = Activity::with('causer')
            ->latest();


        // Recherche
        if($request->filled('search')){

            $search = $request->search;

            $query->where('description','LIKE',"%$search%");

        }


        // Filtre utilisateur
        if($request->filled('user')){

            $query->where('causer_id',$request->user);

        }


        $activities = $query->paginate(10);


        $users = User::all();


        return view('activities.index', compact(
            'activities',
            'users'
        ));
        
        $activities = Activity::latest()->get();

        return view('activities.index', compact('activities'));
    }


}



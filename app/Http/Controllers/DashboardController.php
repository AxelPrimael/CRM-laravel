<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Statistiques utilisateurs
        $totalUsers = User::count();

        $totalAdmins = User::role(['Admin', 'Super Admin'])->count();

        $totalSuperAdmins = User::role('Super Admin')->count();

        $totalRoles = Role::count();


        // Statistiques contacts
        $totalContacts = Contact::count();

        $emailsCount = Contact::whereNotNull('email')->count();

        $phonesCount = Contact::whereNotNull('phone')->count();

        $latestContact = Contact::latest()->first();


        // Contacts par mois (compatible PostgreSQL)
        $contactsPerMonth = Contact::selectRaw(
                "EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total"
            )
            ->groupByRaw("EXTRACT(MONTH FROM created_at)")
            ->orderByRaw("EXTRACT(MONTH FROM created_at)")
            ->get()
            ->map(function ($item) {

                $months = [
                    1 => 'Jan',
                    2 => 'Fév',
                    3 => 'Mar',
                    4 => 'Avr',
                    5 => 'Mai',
                    6 => 'Juin',
                    7 => 'Juil',
                    8 => 'Août',
                    9 => 'Sep',
                    10 => 'Oct',
                    11 => 'Nov',
                    12 => 'Déc',
                ];

                return [
                    'month' => $months[(int) $item->month],
                    'total' => $item->total
                ];
            })
            ->toArray();


        // Derniers contacts
        $recentContacts = Contact::latest()
            ->take(5)
            ->get();


        return view('dashboard', [
            'user' => $user,

            'totalContacts' => $totalContacts,
            'emailsCount' => $emailsCount,
            'phonesCount' => $phonesCount,
            'latestContact' => $latestContact,

            'contactsPerMonth' => $contactsPerMonth,
            'recentContacts' => $recentContacts,

            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalSuperAdmins' => $totalSuperAdmins,
            'totalRoles' => $totalRoles,
        ]);
    }
}
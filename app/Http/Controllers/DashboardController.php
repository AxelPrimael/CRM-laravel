<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {

    $totalUsers = User::count();

    $totalAdmins = User::role('Admin')->count();

     $totalSuperAdmins = User::role('Super Admin')->count();

    $totalRoles = Role::count();

        $user = auth()->user();

        $totalContacts = Contact::count();

        $emailsCount = Contact::whereNotNull('email')->count();

        $phonesCount = Contact::whereNotNull('phone')->count();

        $latestContact = Contact::latest()->first();
$contactsPerMonth = Contact::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
    ->groupBy('month')
    ->orderBy('month')
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
            'month' => $months[$item->month],
            'total' => $item->total
        ];
    })  ->toArray();
    $recentContacts = Contact::latest()->take(5)->get();

return view('dashboard', [
    'user' => $user,
    'totalContacts' => $totalContacts,
    'emailsCount' => $emailsCount,
    'phonesCount' => $phonesCount,
    'latestContact' => $latestContact,
    'contactsPerMonth' => $contactsPerMonth,
    'recentContacts'=> $recentContacts,
    'totalUsers'=> $totalUsers,
    'totalAdmins'=> $totalAdmins,
    'totalSuperAdmins'=> $totalSuperAdmins,
    'totalRoles'=> $totalRoles
]);
    }
}
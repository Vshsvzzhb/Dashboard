<?php

namespace App\Http\Controllers;

use App\Models\Blast;

class BlastHistoryController extends Controller
{
    public function index()
    {
        $blasts = Blast::latest()->paginate(15);
        $stats  = [
            'total'   => Blast::count(),
            'done'    => Blast::where('status', 'done')->count(),
            'failed'  => Blast::where('status', 'failed')->count(),
            'sent'    => Blast::sum('sent'),
        ];

        return view('blast-history', compact('blasts', 'stats'));
    }

    public function show(Blast $blast)
    {
        return view('blast-history-show', compact('blast'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\Invoice;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        $tags = Tag::all();
        $stats = [];
        $colors = [];
        $labels = [];

        
        foreach ($tags as $tag) {
            $stats[$tag->id] = 0;
            $labels[$tag->id] = $tag->name;
            
            
            $colorMap = [
                'bg-blue-500' => '#3B82F6',
                'bg-pink-500' => '#EC4899',
                'bg-purple-500' => '#8B5CF6',
                'bg-green-500' => '#10B981',
                'bg-orange-500' => '#F97316',
                'bg-gray-500' => '#6B7280',
                'bg-yellow-500' => '#EAB308',
                'bg-red-500' => '#EF4444',
            ];
            $colors[] = $colorMap[$tag->color] ?? '#cccccc';
        }

      
        $paidInvoices = Invoice::with('project.tags')
            ->whereHas('project', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('status', 'paid')
            ->get();

       
        foreach ($paidInvoices as $invoice) {
            $projectTags = $invoice->project->tags;
            
            if ($projectTags->count() > 0) {
               
                $amountPerTag = $invoice->amount / $projectTags->count();
                
                foreach ($projectTags as $tag) {
                    if (isset($stats[$tag->id])) {
                        $stats[$tag->id] += $amountPerTag;
                    }
                }
            }
        }

       
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => []
        ];

        $i = 0;
        foreach ($stats as $tagId => $amount) {
            if ($amount > 0) {
                $chartData['labels'][] = $labels[$tagId];
                $chartData['data'][] = round($amount, 2);
                $chartData['backgroundColor'][] = $colors[$i];
            }
            $i++;
        }

        return view('analytics.index', compact('chartData'));
    }
}
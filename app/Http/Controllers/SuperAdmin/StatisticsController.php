<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\User;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        // Date range filter
        $startDate = $request->get('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $filters = [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        // Summary stats
        $summary = $this->reportService->getStatisticsSummary($filters);

        // Per quiz report
        $quizStats = $this->reportService->getPerQuizReport($filters);

        // Period report (daily)
        $periodStats = $this->reportService->getPeriodReport(array_merge($filters, ['group_by' => 'day']));

        // Top performers
        $topPerformers = Result::with('user:id,name,avatar')
            ->whereNotNull('completed_at')
            ->whereBetween('completed_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])
            ->orderBy('percentage', 'desc')
            ->limit(10)
            ->get();

        return view('superadmin.statistics.index', compact(
            'summary',
            'quizStats',
            'periodStats',
            'topPerformers',
            'startDate',
            'endDate'
        ));
    }
}

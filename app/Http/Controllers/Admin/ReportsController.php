<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    public function index()
    {
        $reportTypes = [
            'sales' => [
                'name' => 'Sales Report',
                'icon' => 'fa-dollar-sign',
                'description' => 'View revenue and orders',
                'color' => 'primary'
            ],
            'products' => [
                'name' => 'Product Report',
                'icon' => 'fa-box',
                'description' => 'Top selling products',
                'color' => 'success'
            ],
            'customers' => [
                'name' => 'Customer Report',
                'icon' => 'fa-users',
                'description' => 'Customer analytics',
                'color' => 'info'
            ],
            'analytics' => [
                'name' => 'Analytics Report',
                'icon' => 'fa-chart-line',
                'description' => 'Traffic and conversion',
                'color' => 'warning'
            ],
        ];

        return view('admin.reports.index', compact('reportTypes'));
    }

    public function generate(Request $request)
    {
        try {
            Log::info('Report generation started', ['type' => $request->type, 'format' => $request->format]);

            $request->validate([
                'type' => 'required|in:sales,products,customers,analytics',
                'format' => 'required|in:csv,excel,pdf'
            ]);

            $type = $request->type;
            $format = $request->format;

            $data = $this->getReportData($type);
            
            Log::info('Report data generated', ['type' => $type, 'rows_count' => count($data['rows'])]);

            $fileName = $this->generateFileName($type, $format);

            return $this->downloadFile($data, $format, $fileName);
            
        } catch (\Exception $e) {
            Log::error('Report generation error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getReportData($type)
    {
        $data = [];

        switch ($type) {
            case 'sales':
                $data['title'] = 'Sales Report';
                $data['headers'] = ['Order ID', 'Customer', 'Amount', 'Status', 'Date'];
                
                $orders = DB::table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->select('orders.id', 'users.name', 'orders.total', 'orders.status', 'orders.created_at')
                    ->orderBy('orders.created_at', 'desc')
                    ->limit(100)
                    ->get();

                $data['rows'] = $orders->map(function($item) {
                    return [
                        $item->id,
                        $item->name,
                        '$' . number_format($item->total, 2),
                        ucfirst($item->status),
                        Carbon::parse($item->created_at)->format('Y-m-d')
                    ];
                })->toArray();

                $data['summary'] = [
                    'Total Orders' => DB::table('orders')->count(),
                    'Total Revenue' => '$' . number_format(DB::table('orders')->sum('total'), 2),
                ];
                break;

            case 'products':
                $data['title'] = 'Product Report';
                $data['headers'] = ['Product ID', 'Product Name', 'Category', 'Price', 'Stock', 'Sales'];
                
                $products = DB::table('products')
                    ->join('categories', 'products.category_id', '=', 'categories.id')
                    ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                    ->select(
                        'products.id',
                        'products.name',
                        'categories.name as category',
                        'products.price',
                        'products.stock_quantity as stock',
                        DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sales')
                    )
                    ->groupBy('products.id', 'products.name', 'categories.name', 'products.price', 'products.stock_quantity')
                    ->orderBy('total_sales', 'desc')
                    ->limit(100)
                    ->get();

                $data['rows'] = $products->map(function($item) {
                    return [
                        $item->id,
                        $item->name,
                        $item->category,
                        '$' . number_format($item->price, 2),
                        $item->stock,
                        $item->total_sales
                    ];
                })->toArray();

                $data['summary'] = [
                    'Total Products' => DB::table('products')->count(),
                    'Total Categories' => DB::table('categories')->count(),
                    'Low Stock Items' => DB::table('products')->where('stock_quantity', '<', 10)->count(),
                ];
                break;

            case 'customers':
                $data['title'] = 'Customer Report';
                $data['headers'] = ['Customer ID', 'Name', 'Email', 'Orders', 'Total Spent', 'Joined'];
                
                $customers = DB::table('users')
                    ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                    ->select(
                        'users.id',
                        'users.name',
                        'users.email',
                        DB::raw('COUNT(orders.id) as order_count'),
                        DB::raw('COALESCE(SUM(orders.total), 0) as total_spent'),
                        'users.created_at'
                    )
                    ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
                    ->orderBy('total_spent', 'desc')
                    ->limit(100)
                    ->get();

                $data['rows'] = $customers->map(function($item) {
                    return [
                        $item->id,
                        $item->name,
                        $item->email,
                        $item->order_count,
                        '$' . number_format($item->total_spent, 2),
                        Carbon::parse($item->created_at)->format('Y-m-d')
                    ];
                })->toArray();

                $data['summary'] = [
                    'Total Customers' => DB::table('users')->count(),
                    'New This Month' => DB::table('users')
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->count(),
                    'Active Customers' => DB::table('users')
                        ->whereHas('orders', function($q) {
                            $q->where('created_at', '>=', Carbon::now()->subDays(30));
                        })->count(),
                ];
                break;

            case 'analytics':
                $data['title'] = 'Analytics Report';
                $data['headers'] = ['Date', 'Visitors', 'Page Views', 'Orders', 'Conversion Rate'];
                
             
                $analytics = DB::table('analytics')
                    ->orderBy('date', 'desc')
                    ->limit(30)
                    ->get();

                if ($analytics->isNotEmpty()) {
                    $data['rows'] = $analytics->map(function($item) {
                        $conversion = $item->visitors > 0 ? round(($item->orders / $item->visitors) * 100, 2) : 0;
                        return [
                            $item->date,
                            $item->visitors,
                            $item->page_views,
                            $item->orders,
                            $conversion . '%'
                        ];
                    })->toArray();
                } else {
                  
                    $data['rows'] = [];
                }

                $data['summary'] = [
                    'Total Visitors' => DB::table('analytics')->sum('visitors') ?: 0,
                    'Total Page Views' => DB::table('analytics')->sum('page_views') ?: 0,
                    'Total Orders' => DB::table('orders')->count(),
                ];
                break;
        }

        return $data;
    }

    private function generateFileName($type, $format)
    {
        $date = Carbon::now()->format('Y-m-d');
        $ext = $format == 'excel' ? 'xlsx' : $format;
        return "{$type}_report_{$date}.{$ext}";
    }

    private function downloadFile($data, $format, $fileName)
    {
        if ($format == 'csv') {
            return $this->generateCSV($data, $fileName);
        }
        
        if ($format == 'excel') {
            return $this->generateExcel($data, $fileName);
        }
        
        if ($format == 'pdf') {
            return $this->generatePDF($data, $fileName);
        }
        
        return $this->generateCSV($data, str_replace(['xlsx', 'pdf'], 'csv', $fileName));
    }

    private function generateCSV($data, $fileName)
    {
        $fileName = str_replace(['xlsx', 'xls', 'pdf'], 'csv', $fileName);
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public'
        ];

        $callback = function() use ($data) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            
            fputcsv($handle, [$data['title']]);
            fputcsv($handle, ['Generated: ' . Carbon::now()->format('Y-m-d H:i:s')]);
            fputcsv($handle, []);
            
            if (isset($data['summary']) && !empty($data['summary'])) {
                fputcsv($handle, ['SUMMARY']);
                foreach ($data['summary'] as $key => $value) {
                    fputcsv($handle, [$key, $value]);
                }
                fputcsv($handle, []);
            }
            
            fputcsv($handle, $data['headers']);
            
            if (!empty($data['rows'])) {
                foreach ($data['rows'] as $row) {
                    fputcsv($handle, $row);
                }
            } else {
                fputcsv($handle, ['No data available']);
            }
            
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generateExcel($data, $fileName)
    {
        $fileName = str_replace('csv', 'xlsx', $fileName);
        
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
        ];

        $callback = function() use ($data) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            
            fwrite($output, $data['title'] . "\n");
            fwrite($output, 'Generated: ' . Carbon::now()->format('Y-m-d H:i:s') . "\n\n");
            
            if (isset($data['summary']) && !empty($data['summary'])) {
                fwrite($output, "SUMMARY\n");
                foreach ($data['summary'] as $key => $value) {
                    fwrite($output, "{$key},{$value}\n");
                }
                fwrite($output, "\n");
            }
            
            fputcsv($output, $data['headers']);
            
            if (!empty($data['rows'])) {
                foreach ($data['rows'] as $row) {
                    fputcsv($output, $row);
                }
            } else {
                fputcsv($output, ['No data available']);
            }
            
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function generatePDF($data, $fileName)
    {
        $fileName = str_replace(['csv', 'xlsx'], 'pdf', $fileName);
        $html = $this->generatePDFHTML($data);
        
        if (class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            return $pdf->download($fileName);
        }
        
        return response()->stream(function() use ($html) {
            echo $html;
        }, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => "attachment; filename=\"" . str_replace('pdf', 'html', $fileName) . "\""
        ]);
    }

    private function generatePDFHTML($data)
    {
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>' . $data['title'] . '</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; padding: 20px; }
                h1 { color: #db4444; text-align: center; font-size: 24px; }
                .meta { text-align: center; color: #888; margin-bottom: 20px; }
                .summary { background: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0; }
                .summary h3 { margin-top: 0; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background: #db4444; color: #fff; padding: 10px; text-align: left; }
                td { padding: 8px; border-bottom: 1px solid #ddd; }
                .footer { text-align: center; margin-top: 30px; color: #888; font-size: 10px; }
                tr:nth-child(even) { background: #f9f9f9; }
            </style>
        </head>
        <body>
            <h1>' . $data['title'] . '</h1>
            <div class="meta">Generated: ' . Carbon::now()->format('Y-m-d H:i:s') . '</div>';
            
            if (isset($data['summary']) && !empty($data['summary'])) {
                $html .= '<div class="summary"><h3>📊 Summary</h3>';
                foreach ($data['summary'] as $key => $value) {
                    $html .= '<p><strong>' . $key . ':</strong> ' . $value . '</p>';
                }
                $html .= '</div>';
            }
            
            $html .= '<table><thead><tr>';
            foreach ($data['headers'] as $header) {
                $html .= '<th>' . $header . '</th>';
            }
            $html .= '</tr></thead><tbody>';
            
            if (!empty($data['rows'])) {
                foreach ($data['rows'] as $row) {
                    $html .= '<tr>';
                    foreach ($row as $cell) {
                        $html .= '<td>' . $cell . '</td>';
                    }
                    $html .= '</tr>';
                }
            } else {
                $html .= '<tr><td colspan="' . count($data['headers']) . '" style="text-align:center;">No data available</td></tr>';
            }
            
            $html .= '</tbody></table>
            <div class="footer">Generated by StyleHub Admin Panel</div>
        </body>
        </html>';
        
        return $html;
    }
}
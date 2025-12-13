<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function export(Request $request) {
        $id = $request->ids;
        $items = Contact::with('category')->whereIn('id', $id)->get();
        // $csvContent = fopen('php://output', 'r+');
        // // fputcsv($csvContent, ['id', 'category_id']);
        // foreach ($items as $row) {
        //     fputcsv($csvContent, $row);
        // }
        // rewind($csvContent);

        // $csvData = stream_get_contents($csvContent);
        // $sjisData = mb_convert_encoding($csvData, 'SJIS-win', 'UTF-8');
        // fclose($csvContent);

        // $filename = sprintf('contact-%s.csv', date('Ymd'));

        // return Response::make($sjisData, 200, [
        // 'Content-Type' => 'text/csv',
        // 'Content-Disposition' => 'attachment; filename = $filename',
        // ]);

        $response = new StreamedResponse(function () use ($items) {
            $handle = fopen('php://output', 'w');
            $heading = ['ID', '姓', '名', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせカテゴリ', 'お問い合わせ内容'];
            mb_convert_variables('SJIS-win', 'UTF-8', $heading);
            fputcsv($handle, $heading);

            foreach ($items as $item) {
                switch($item->gender){
                    case(1):
                        $gender = "男性";
                        break;
                    case(2):
                        $gender = "女性";
                        break;
                    case(3):
                        $gender = "その他";
                        break;
                }
                $row = [
                    $item->id,
                    $item->last_name,
                    $item->first_name,
                    $gender,
                    $item->email,
                    $item->tel,
                    $item->address,
                    $item->building,
                    $item->category->content,
                    $item->detail
                ];

                mb_convert_variables('SJIS-win', 'UTF-8', $row);
                fputcsv($handle, $row);
            }
            fclose($handle);
        });

        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set(
            'Content-Disposition',
            "attachment; filename={$filename}"
        );

        return $response;
    }
}

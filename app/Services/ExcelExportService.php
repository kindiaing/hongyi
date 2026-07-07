<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelExportService
{
    /**
     * Export data to Excel/CSV file
     *
     * @param array $headers Column headers [key => label]
     * @param array $rows Data rows
     * @param string $filename Output filename (without extension)
     * @param string $format 'xlsx' or 'csv'
     * @return StreamedResponse
     */
    public static function export(array $headers, array $rows, string $filename = 'export', string $format = 'xlsx'): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $col = 1;
        foreach ($headers as $label) {
            $sheet->setCellValue([$col, 1], $label);
            $col++;
        }

        // Style header row
        $sheet->getStyle([1, 1, count($headers), 1])->getFont()->setBold(true);
        $sheet->getStyle([1, 1, count($headers), 1])->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E5E7EB');

        // Set data rows
        $rowNum = 2;
        foreach ($rows as $row) {
            $col = 1;
            foreach (array_keys($headers) as $key) {
                $value = $row[$key] ?? '';
                $sheet->setCellValue([$col, $rowNum], $value);
                $col++;
            }
            $rowNum++;
        }

        // Auto width for columns
        $col = 1;
        foreach (array_keys($headers) as $key) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
            $col++;
        }

        $extension = $format === 'csv' ? 'csv' : 'xlsx';
        $contentType = $format === 'csv'
            ? 'text/csv; charset=UTF-8'
            : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        $response = new StreamedResponse(function () use ($spreadsheet, $format) {
            if ($format === 'csv') {
                $writer = new Csv($spreadsheet);
                $writer->setUseBOM(true);
                $writer->setDelimiter(',');
                $writer->save('php://output');
            } else {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            }
        });

        $response->headers->set('Content-Type', $contentType);
        $response->headers->set('Content-Disposition', "attachment; filename=\"{$filename}.{$extension}\"");
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}

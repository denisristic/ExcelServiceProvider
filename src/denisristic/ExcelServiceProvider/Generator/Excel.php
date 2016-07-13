<?php

namespace denisristic\ExcelServiceProvider\Generator;

class Excel
{
    public function generateXLS($headers, $data)
    {
        $objPHPExcel = new \PHPExcel(); // Create new PHPExcel object

        $A = 65;
        foreach ($headers as $k => $headerValue) {
            $cellReference = chr($A + $k).'1';
            $objPHPExcel->getActiveSheet()->setCellValue($cellReference, $headerValue); // Add column heading data
        }

        foreach ($data as $k => $row) {
            foreach (array_keys($row) as $number => $field) {
                $cellLetter = chr($A + $number);
                $cellNumber = $k + 2; // start from the row below the headings
                $objPHPExcel->getActiveSheet()->setCellValue($cellLetter.$cellNumber, $row["$field"]);
            }
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_start();
        $objWriter->save('php://output');
        $contents = ob_get_clean();

        return $contents;
    }
}

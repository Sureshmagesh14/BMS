<?php
    try {
        error_reporting(E_ALL);
        ini_set('display_errors', true);
        ini_set('display_startup_errors', true);
        define('EOL', PHP_SAPI == 'cli' ? PHP_EOL : '<br />');
        date_default_timezone_set('Europe/London');

        /** PHPExcel_IOFactory */
        require_once '../vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
        
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load('../vendor/phpoffice/phpexcel/Examples/templates/respondents/respondents.xlsx');

        $styleSectionHeader = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '0070C0')
            ),
            'font'  => array(
                'name'  => 'Arial',
                'color' => array('rgb' => 'FFFFFF'),
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                )
            )
        );

        $styleSection = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
            'font'  => array(
                'name'  => 'Arial'
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                )
            )
        );

        $filenme = 'Cashout Respondents Export';
        $objPHPExcel->setActiveSheetIndex(0);
        $row = 1;

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, "MSISDN");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, "Network");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, "Value");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, "Reference");
        
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->applyFromArray($styleSectionHeader);
        
        $row++;

        if($form == "cashout"){
            if ($id_value == '6') {
                $filenme = 'Cashout Respondents Export';
                
                $cashout_details = DB::table('cashouts')->select('cashouts.*','respondents.name','respondents.surname','networks.name as network_name')
                    ->join('respondents','cashouts.respondent_id','respondents.id')
                    ->join('networks','cashouts.mobile_network','networks.id')
                    ->where("type_id", 2)
                    ->whereNull('cashouts.deleted_at')
                    ->get();

                foreach ($cashout_details as $key => $cashout) {
                    $respondent_name = $cashout->name.' '.$cashout->surname.'_'.$cashout->id;
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, "ID");
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $cashout->network_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $cashout->amount);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $respondent_name);

                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->applyFromArray($styleSection);
                    $row++;
                }

                

                // Log::debug($respondents_details);
              
                
            }
        }
        

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filenme . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0 

       

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($filenme . '.xlsx');

        echo $filenme . '.xlsx';
    }
    catch (\Throwable $th) {
        $err = 'Error';
        echo $th;
        return $th;
    }
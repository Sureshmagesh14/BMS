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

        $styleSection = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '0070C0')
            ),
            'font'  => array(
                'name'  => 'Arial'
            ),
            'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => 'FFFFFF')
                )
            )
        );

        $filenme = 'Respondents';
        $objPHPExcel->setActiveSheetIndex(0);
        $row = 1;

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, "Profile ID");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, "Name");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, "Surname");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, "Phone Number");
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, "WhatsApp Number");
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, "Email");
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, "Date of Birth");

        if($form == "respondents"){
            if ($id_value == '7') {
                $filenme = 'Deactivated Respondents';
                
                $respondents_details = DB::table('respondents')->select('profile.field_name')
                    ->where("active_status_id", 2)->where('visible_on_export',1)
                    ->join('respondent_profiles as profile','respondents.id','profile.respondent_id')
                    ->groupBy('profile.field_name')->get();

                    // Log::debug($respondents_details);
              
                $alpha_string = 'H';

                for ($n = 0; $n < 6; $n++) {
                     ++$s;
                }
                

                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':AT'.$row)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':AT'.$row)->applyFromArray($styleSection);
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
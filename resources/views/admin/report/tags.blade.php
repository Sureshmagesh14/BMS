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

        $filenme = 'Tags Respondents Export';
        $objPHPExcel->setActiveSheetIndex(0);
        $row = 1;

        

        if($form == "tags"){
            if ($id_value == 'respondents') {
                
                $filenme = 'Tags Respondents Export';
                if($checkbox_value != null){
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, "Profile ID");
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, "Full Name");
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, "Tag Name");
                
                    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->applyFromArray($styleSectionHeader);
                    $row++;

                    $tags_details = DB::table('tags')->select('tags.id as tag_id','tags.name as tag_name','respondents.id','respondents.name','respondents.surname')
                        ->join('respondent_tag','tags.id','respondent_tag.tag_id')
                        ->join('respondents','respondent_tag.respondent_id','respondents.id')
                        ->whereIn('tags.id',$checkbox_value)
                        ->whereNull('tags.deleted_at')
                        ->orderBy('tags.id','ASC')
                        ->get();

                    foreach ($tags_details as $key => $tags) {
                        $respondent_name = $tags->name.' '.$tags->surname;
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $tags->id);
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $respondent_name);
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $tags->tag_name);

                        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->getAlignment()->setWrapText(true);
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->applyFromArray($styleSection);
                        $row++;
                    }
                }
            }
            else if ($id_value == 'panels') {
                $filenme = 'Panels Export';

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, "Panel ID");
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, "Panel Name");
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, "Panel Description");
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, "Panel Colour");
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, "Panel Setings");
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, "Panel Size");
            
                $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray($styleSectionHeader);
                $row++;
                
                $tags_details = DB::table('tags')->select('tags.*')->whereNull('tags.deleted_at')->orderBy('tags.id','ASC')->get();

                foreach ($tags_details as $key => $panel) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $panel->id);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $panel->name);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $panel->colour);

                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray($styleSection);
                    $row++;
                }
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
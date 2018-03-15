<?php
/**
 * author: lly
 * date : 2018-03-15
 * 数据表格导出报表控制器
**/
namespace Admin\Controller;
use Think\Controller;

class ExcelController extends Controller
{
	
	/**
	 * used : 项目币币收益excel导出
	 * addby : lly
	 * date : 2018-03-15
	**/
	public function outBiBiReport($data=array())
	{
		Vendor('Excel.PHPExcel');
		$objPHPExcel = new \PHPExcel();
		//横向单元格标识  
    	$cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');  
		//时间参考http://www.w3school.com.cn/php/func_date_date.asp
		$fileName = '项目币币收益 '.date('n月j日G点');
		//设置sheet名称 
		$objPHPExcel->getActiveSheet(0)->setTitle('创世资本投资项目及回报率');
		//设置纵向单元格标识
    	$_row = 1;
    	$_cnt = 10;
    	$objPHPExcel->getActiveSheet(0)->mergeCells('A'.$_row.':'.$cellName[$_cnt-1].$_row);   //合并单元格  
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$_row, '创世资本投资项目及回报率【币币（ETH）收益率】'.date('Y.j.j G:i'));  //设置合并后的单元格内容  
        $_row++;  
        $i = 0;
        $title = array('投资项目','代币名称','额度','折合代币数','交易所','锁仓情况','ICO成本(ETH)','现价(ETH)','目前收益率','平均收益率');
        foreach($title AS $v){   //设置列标题  
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].$_row, $v);
            $objPHPExcel->getActiveSheet()->getStyle($cellName[$i].$_row)->getAlignment()->setHorizontal('CENTER');
            $i++;
        }  
        $_row++;
        if($data){  
	        $i = 0;
	        foreach($data AS $_v){
	            $j = 0;  
	            foreach($_v AS $_cell){
	            	if($j==8 || $j==9){
	            		$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i+$_row), $_cell.'%');
	            	}else{
	            		$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i+$_row), $_cell);
	            	}
	                
	                //设置居中
	                $objPHPExcel->getActiveSheet()->getStyle($cellName[$j].($i+$_row))->getAlignment()->setHorizontal('CENTER');
	                $objPHPExcel->getActiveSheet()->getStyle($cellName[$j].($i+$_row))->getAlignment()->setVertical('CENTER');
	                if($j== 8 && $_cell<0)
	                {
	                	$line_index = 'I'.($i+$_row);
	                	//设置背景色 ，在office中有效在wps中无效
	    				//$objPHPExcel->getActiveSheet()->getComment("$line_index")->getFillColor()->setRGB('FFFFFF');
	    				$objPHPExcel->getActiveSheet()->getStyle("$line_index")->getFont()->getColor()->setRGB('FF0000');
	                }
	                if($j==9 && $_cell<0)
	                {
	                	$vag_index = 'J'.($i+$_row);
	                	//设置背景色 ，在office中有效在wps中无效
	    				//$objPHPExcel->getActiveSheet()->getComment("$line_index")->getFillColor()->setRGB('FFFFFF');
	    				$objPHPExcel->getActiveSheet()->getStyle("$vag_index")->getFont()->getColor()->setRGB('FF0000');
	                }

	                if($j==5 && $_cell !=='')
	                {
	                	$block_index = 'F'.($i+$_row);
	                	$objPHPExcel->getActiveSheet()->getStyle("$block_index")->getAlignment()->setWrapText(true);
	                }
	                $j++; 
	            }  
	            $i++;
	        }  
	    }
	    /*
		 * 设置样式
	    */
		//设置宽度
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
	    //合并平均收益
	    $last_row = 'J3:J'.(count($data)+2);
	    $objPHPExcel->getActiveSheet()->mergeCells($last_row);
	    //平均收益在垂直方向上居中
	    $objPHPExcel->getActiveSheet()->getStyle($last_row)->getAlignment()->setVertical('CENTER');
	    //设置标题水平居中
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('CENTER');
	    $this->_export($objPHPExcel, $fileName);
	}
	public function biAction()
	{
		Vendor('Excel.PHPExcel');
		$objPHPExcel = new \PHPExcel();

		/** 
		 * 数据导出 
		 * @param array $title   标题行名称 
		 * @param array $data   导出数据 
		 * @param string $fileName 文件名 
		 * @param string $savePath 保存路径 
		 * @param $type   是否下载  false--保存   true--下载 
		 * @return string   返回文件全路径 
		 * @throws PHPExcel_Exception 
		 * @throws PHPExcel_Reader_Exception 
		**/

		//横向单元格标识  
    	$cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');  
		//时间参考http://www.w3school.com.cn/php/func_date_date.asp
		$fileName = '项目币币收益 '.date('n月j日G点');
		//设置sheet名称 
		$objPHPExcel->getActiveSheet(0)->setTitle('创世资本投资项目及回报率');



		//设置纵向单元格标识
    	$_row = 1;
    	$_cnt = 10;
    	$objPHPExcel->getActiveSheet(0)->mergeCells('A'.$_row.':'.$cellName[$_cnt-1].$_row);   //合并单元格  
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$_row, '创世资本投资项目及回报率【币币（ETH）收益率】'.date('Y.j.j G:i'));  //设置合并后的单元格内容  
        $_row++;  
        $i = 0;
        $title = array('投资项目','代币名称','额度','折合代币数','交易所','锁仓情况','ICO成本(ETH)','现价(ETH)','目前收益率','平均收益率');
        foreach($title AS $v){   //设置列标题  
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].$_row, $v);
            $objPHPExcel->getActiveSheet()->getStyle($cellName[$i].$_row)->getAlignment()->setHorizontal('CENTER');
            $i++;
        }  
        $_row++;
        //填写数据
        $data = array(
        	array('你好啊','HOC','1000','5000','BIT-Z','锁仓50%,另外每月10%','0.00009589','0.00006545','-31.7447','-30.82591%'),
        	array('TTT','TTC','300','3666600','coinegg',"第一个月解锁40%，首月的40%分四次打\r\n过来，后五个月每个月12%",'0.00008182','0.00005735','-29.9071','-30.82591%')
        );
	    if($data){  
	        $i = 0;
	        foreach($data AS $_v){
	            $j = 0;  
	            foreach($_v AS $_cell){
	                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i+$_row), $_cell);
	                //设置居中
	                $objPHPExcel->getActiveSheet()->getStyle($cellName[$j].($i+$_row))->getAlignment()->setHorizontal('CENTER');
	                $objPHPExcel->getActiveSheet()->getStyle($cellName[$j].($i+$_row))->getAlignment()->setVertical('CENTER');
	                if($j== 8 && $_cell<0)
	                {
	                	$line_index = 'I'.($i+$_row);
	                	//设置背景色 ，在office中有效在wps中无效
	    				//$objPHPExcel->getActiveSheet()->getComment("$line_index")->getFillColor()->setRGB('FFFFFF');
	    				$objPHPExcel->getActiveSheet()->getStyle("$line_index")->getFont()->getColor()->setRGB('FF0000');
	                }
	                if($j==9 && $_cell<0)
	                {
	                	$vag_index = 'J'.($i+$_row);
	                	//设置背景色 ，在office中有效在wps中无效
	    				//$objPHPExcel->getActiveSheet()->getComment("$line_index")->getFillColor()->setRGB('FFFFFF');
	    				$objPHPExcel->getActiveSheet()->getStyle("$vag_index")->getFont()->getColor()->setRGB('FF0000');
	                }

	                if($j==5 && $_cell !=='')
	                {
	                	$block_index = 'F'.($i+$_row);
	                	$objPHPExcel->getActiveSheet()->getStyle("$block_index")->getAlignment()->setWrapText(true);
	                }
	                $j++; 
	            }  
	            $i++;
	        }  
	    }

	    /*
			设置样式
	    */
		//设置宽度
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
	    //合并平均收益
	    $objPHPExcel->getActiveSheet()->mergeCells( 'J3:J4');
	    //平均收益在垂直方向上居中
	    $objPHPExcel->getActiveSheet()->getStyle('J3:J4')->getAlignment()->setVertical('CENTER');
	    //设置标题水平居中
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('CENTER');
	    
	    //$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('FF808080');
	    $this->_export($objPHPExcel, $fileName);
	}
	public function indexAction()
	{
		Vendor('Excel.PHPExcel');
		$objPHPExcel = new \PHPExcel();
		$objPHPExcel->getProperties()->setCreator("珂兰官网")->setLastModifiedBy("珂兰官网")->setTitle("导购评论上传格式样板")->setSubject("导购评论上传格式样板" . date('Y-m-d'))->setDescription("导购评论上传格式样板")->setKeywords("导购评论上传格式样板")->setCategory("导购评论上传格式样板");
        $i = 1;
        $x = 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", "导购专题ID")
            ->setCellValue("B$i", "评论内容")
            ->setCellValue("C$i", "评论时间")
            ->setCellValue("A$x", "1")
            ->setCellValue("B$x", "导购做的不错，非常喜欢")
            ->setCellValue("C$x", "2015/5/18  10:59:12");

        $filename = '导购评论上传格式样板';
        $this->_export($objPHPExcel, $filename);
	}
	//公共导出
    private function _export($objPHPExcel, $filename = 'BiReport')
    {
        ob_clean();
        $objPHPExcel->getActiveSheet()->setTitle($filename);
        $objPHPExcel->setActiveSheetIndex(0);
        $file_name = $filename . ".xlsx";
        header("Content-Type: application/force-download");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition:attachment;filename =$file_name");
        header('Cache-Control: max-age=0');
        header("Content-Transfer-Encoding:8bit");

        Vendor('Excel.PHPExcel.IOFactory');
        require(PHPEXCEL_ROOT . 'PHPExcel/Shared/ZipArchive.php');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}
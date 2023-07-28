<?php

namespace app\controllers;

use Yii;
use app\models\Country;
use app\models\CountrySearch;
use app\models\Status;
use app\models\QcSlitter;
use app\models\Packing;
use app\models\Period;
use app\models\FoilstockRequest;
use app\models\NcrProblem;
use app\models\NcrQcProblem;
use app\models\QcCode;
use app\models\DailyQc;
use app\models\Profile;
use app\models\ParamProfile;
use app\models\TableTestData;
use app\models\TableTestFormula;
use app\models\KpiOperatorSupervisor;
use app\models\TrackLocation;
use app\models\FlatnessStandard;
use app\models\AbsenceWebOut;
use app\models\AbsenceWeb;
use app\models\AbsenceScheduleUpload;
use app\models\StripMaterialInspect;
use app\models\Blowknox;
use app\models\Kobe2;
use app\models\Kobe1;
use app\models\Vonroll;
use app\models\Pittsburgh;
use app\models\MutasiConf;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\helpers\Json;
use app\models\FgCogsBag1;
use app\models\FgCogsBag2;
use app\models\MutasiCogs;
use app\models\PpvCogsBag1;
use app\models\PpvCogsBag2;
use app\models\PpvCogsBag3;
use app\models\PpvCogsBag4;
use app\models\NcProblem;
use app\models\ListDate;
use app\models\Dashboard;
use app\models\DashboardName;
use app\models\Caster;
use app\models\Caf;
use app\models\CafDetail;
use app\models\UploadForm2;
use app\models\Report;
use app\models\Employee;
use app\models\ScrapStandard;
use app\models\Slitter;
use app\models\Doubler2;
use app\models\DoublerSisa;
use app\models\CoilImport;
use app\models\Delivery;
use app\models\TableHelp;
use yii\web\UploadedFile;
use Da\QrCode\QrCode;
use app\models\Roll;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use app\models\uploadForm;
use app\models\Separator;
use app\models\SeparatorC;
use app\models\DowntimePittsburgh;

// use CUploadedFile;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FlxZipArchive;
/**
 * CountryController implements the CRUD actions for Country model.
 */
// class CountryController extends Controller
class CountryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

   //  function terbilang($number) {
   //    $number = abs($number); // Mengubah angka menjadi positif
   //
   //    $terbilang = array(
   //        "", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
   //    );
   //
   //    $result = "";
   //
   //    if ($number < 12) {
   //        $result = $terbilang[$number];
   //    } elseif ($number < 20) {
   //        $result = $this->terbilang($number - 10) . " belas";
   //    } elseif ($number < 100) {
   //        $result = $this->terbilang($number / 10) . " puluh " . terbilang($number % 10);
   //    } elseif ($number < 200) {
   //        $result = " seratus " . $this->terbilang($number - 100);
   //    } elseif ($number < 1000) {
   //        $result = $this->terbilang($number / 100) . " ratus " . terbilang($number % 100);
   //    } elseif ($number < 2000) {
   //        $result = " seribu " . $this->terbilang($number - 1000);
   //    } elseif ($number < 1000000) {
   //        $result = $this->terbilang($number / 1000) . " ribu " . $this->terbilang($number % 1000);
   //    } elseif ($number < 1000000000) {
   //        $result = $this->terbilang($number / 1000000) . " juta " . $this->terbilang($number % 1000000);
   //    } elseif ($number < 1000000000000) {
   //        $result = $this->terbilang($number / 1000000000) . " miliar " . $this->terbilang(fmod($number, 1000000000));
   //    } elseif ($number < 1000000000000000) {
   //        $result = $this->terbilang($number / 1000000000000) . " triliun " . $this->terbilang(fmod($number, 1000000000000));
   //    }
   //
   //    return $result;
   // }


   function convertNumberToWord($nilai) {
 		 $nilai = abs($nilai);
 		 $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
 		 $temp = "";
 		 if ($nilai < 12) {
 			 $temp = " ". $huruf[$nilai];
 		 } else if ($nilai <20) {
 			 $temp = $this->convertNumberToWord($nilai - 10). " belas";
 		 } else if ($nilai < 100) {
 			 $temp = $this->convertNumberToWord($nilai/10)." puluh". $this->convertNumberToWord($nilai % 10);
 		 } else if ($nilai < 200) {
 			 $temp = " seratus" . $this->convertNumberToWord($nilai - 100);
 		 } else if ($nilai < 1000) {
 			 $temp = $this->convertNumberToWord($nilai/100) . " ratus" . $this->convertNumberToWord($nilai % 100);
 		 } else if ($nilai < 2000) {
 			 $temp = " seribu" . $this->convertNumberToWord($nilai - 1000);
 		 } else if ($nilai < 1000000) {
 			 $temp = $this->convertNumberToWord($nilai/1000) . " ribu" . $this->convertNumberToWord($nilai % 1000);
 		 } else if ($nilai < 1000000000) {
 			 $temp = $this->convertNumberToWord($nilai/1000000) . " juta" . $this->convertNumberToWord($nilai % 1000000);
 		 } else if ($nilai < 1000000000000) {
 			 $temp = $this->convertNumberToWord($nilai/1000000000) . " milyar" . $this->convertNumberToWord(fmod($nilai,1000000000));
 		 } else if ($nilai < 1000000000000000) {
 			 $temp = $this->convertNumberToWord($nilai/1000000000000) . " trilyun" . $this->convertNumberToWord(fmod($nilai,1000000000000));
 		 }
 		 return ucwords($temp);
  }

  function getNumberWord($nilai) {
 	 if($nilai<0) {
 		 $result = "minus ". trim($this->convertNumberToWord($nilai));
 	 } else {
 		 $result = trim($this->convertNumberToWord($nilai));
 	 }
 	 return $result;
  }



    public function actionPrintSlip(){


      // pr($this->getNumberWord("1500"));
      // pr(trim($this->terbilangRupiah("1500")));

      return $this->renderPartial('print-slip', []);
        // $model = $this->findModel($id)->suratJalanDetail;
        // pr($model);exit;
        // return $this->renderPartial('print-slip', [
        //
        //         'model' => $this->findModel($id),
        //         'details' => $this->findModel($id)->suratJalanDetail,
        // ]);
    }


    public function actionTes3(){
      // $data1 = Separator::getModel('SEPC');
      //



      // pr($data1);
      // $coil_number = 'A-0124115-23F-B';
      // $coil_number_parts = 'A-0124115-23F';
      // $datetime_finish = '2023-02-21 16:40:00';
      // $table = new Separator('SEPC');
      //
      // $cekEdit = $table->cekUpdateSep($coil_number,$coil_number_parts,$datetime_finish);
      //
      // pr(!$cekEdit);
      // pr($table->cekUpdateSep($coil_number,$coil_number_parts,$datetime_finish));

      // pr($table->test);

      // $as = $table->model('SeparatorC')::find()->limit(1)->one();
      //
      // pr($as);

      //
      // echo $table->test();

      // $table = Separator::test('SeparatorC');
      // pr($table);

      // $a = 'app\models\\'.$data1::find()->limit(1);

      // pr($a);exit;
      // $data = SeparatorC::find()->limit(1)->asArray()->one();
      // $a = Separator::getModel('SEPC');
      // $data = Separator::className();
      // pr($data);
    }


    function _group_by($array, $key) {
      $return = array();
      foreach($array as $val) {
          $return[$val[$key]][] = $val;
      }
      return $return;
    }

    function multiexplode ($delimiters,$string) {
      $txtReplace = str_replace($delimiters, $delimiters[0], $string);
      $txtExplode = explode($delimiters[0], $txtReplace);
      return  $txtExplode;
    }

    public function actionCekCoilMother(){

      $coil_number = 'WT.105738-2';

      $cek = Yii::$app->General->checkAlloyOriginal($coil_number);

      pr($cek);exit;


      $coil_numberz = $this->multiexplode(["+",","],$coil_number);
      $coil_number_first = $coil_numberz[0];

      $replaceText = ["-A", "-B", "-C", "-D", "-E" , "-F" , "-G"];
      $changeReplace   = [""];
      $newCoilReplace = str_replace($replaceText, $changeReplace, $coil_number_first);

      $sql = "select * from v_coil_awal where coil_number = '".$newCoilReplace."' ";
      $data = \Yii::$app->db->createCommand($sql)
      ->queryOne();

      pr($newCoilReplace);
      pr($data);

    }

    public function actionCekCoil(){

      $track = \Yii::$app->db->createCommand("call tracking_coil(:coil_number)")
                    ->bindValue(':coil_number' , '112241-9' )
                    ->queryAll();


      // pr($track);exit;

      // $track_filter = array_filter($track, function ($item) {
    	// 		if($item['weight_exit'] == '4670' ){
    	// 			return $item;
    	// 		}
    	// });

      $track_filter = array_filter($track, function ($item) {
          if (in_array($item['machine'], ["VR","PB","KOBE1","KOBE2"])){
            return $item;
          }
      });

      $before_phase = 2;
      if(!empty($track_filter)){
        $before_phase = end($track_filter)['phase'];
      }

      // pr($before_phase);
      //
      // pr(end($track_filter));

      return $before_phase;

      //
      // pr(end($track_filter));

    }


    public function countGroupArraybyValues($data,$field){
      $out = array();
      foreach ($data as $key => $value){
          $out[] = $value[$field];
      }
      foreach(array_count_values($out) as $key => $value) {
        $outjum[] = [$field => $key , 'jumlah' => $value];
      }
      $keys = array_column($outjum, 'jumlah');
      array_multisort($keys, SORT_DESC, $outjum);

      $result = [];
      if(!empty($outjum)){
        $result = [$field => $outjum[0][$field] , 'jumlah' => $outjum[0]['jumlah']];
      }

      return $result;
    }


    public function actionTestingQuery(){


      $data = \Yii::$app->db->createCommand("call get_listcoa_by_nomor(:nomor)")
                    ->bindValue(':nomor' , '22120051' )
                    ->queryAll();

      // $as = $this->countGroupArraybyValues($data,'coil_number');

      $as = Yii::$app->General->countGroupArraybyValues($data , 'coil_number');

      pr($as);exit;

      // $out = array();
      // foreach ($data as $key => $value){
      //     $out[] = $value['coil_number'];
      // }
      //
      // // pr($out);
      //
      // foreach(array_count_values($out) as $key => $value) {
      //   $outjum[] = ['coil_number' => $key , 'jumlah' => $value];
      // }
      //
      // // asort($outjum, function($a, $b) {
      // //   return $a['jumlah'] <=> $b['jumlah'];
      // // });
      //
      // $keys = array_column($outjum, 'jumlah');
      // array_multisort($keys, SORT_DESC, $outjum);
      //
      // pr($outjum);
      // //
      // // $as = max(array_column($outjum, 'jumlah'));
      // // pr($as);
      // pr($data);



      exit;

      // $ag = 'Slitter';
      // $abj = "app\models\\".$ag;
      // // $instance = new $abj();
      //
      // $data = $abj::find()->where(['act_date' => '2022-12-20'])->asArray()->all();
      //
      // pr("sdsdsd");

      // $model = new Country();
      // $data = $model->tesQuery();
      // pr($data);
      // exit;
      $a = 'F090';
      $type = (strpos("F090", "F090") === false);

      pr($type);
      exit;



      echo "sdsd";

      $a = strpos('', 'Titik');

      if($a !== false){
        echo "ada";
      }else{
        echo "tidak ada";
      }

      pr($a);exit;


      $list= [
      [   'No' => 101,
          'Paper_id' => 'WE3P-1',
          'Title' => "a1",
          'Author' => 'ABC',
          'Aff_list' => "University of South Florida, Tampa, United States",
          'Abstracts' => "SLA"
      ] ,
      [   'No' => 101,
          'Paper_id' => 'WE3P-1',
          'Title' => "a2",
          'Author' => 'DEF',
          'Aff_list' => "University of South Florida, Tampa, United States",
          'Abstracts' => "SLA"
      ] ,
      [    'No' => 104,
          'Paper_id' => 'TUSA-3',
          'Title' => "a3",
          'Author' => 'GH1',
          'Aff_list' => "University of Alcala, Alcala de Henares, Spain",
          'Abstracts' => "Microwave"
      ] ];

      pr($this->_group_by($list, 'No'));
      exit;

      $value = 40;
      $dataCek['min'] = 60;
      $dataCek['max'] = 100;
      $dataCek['parameter'] = "60-100";

      $status = 0;
      $parameter = "";
      $color = "black";
      $parameter = "";
      if(!empty($dataCek)){
        if($value < 60 || $value > 100 ){
          $status = 1;
          $color = 'red';
          echo "tidak std";
        }else{
          $status = 0;
          $color = 'black';
          echo "std";
        }

        $parameter = $dataCek['parameter'];
      }

      $result = ["status" => $status,"color" => $color , "parameter" => $parameter, "min" => $dataCek['min'], "max" => $dataCek['max']];

      pr($result);
    }


    public function actionGetYieldByCoil(){

      // $queryBK = "select * from ctm_dpr_trx_blowknox_tab where coil_number like '%".$coil_number."%' and thick_exit = 105";
      // $dataBK = \Yii::$app->db->createCommand($queryBK)->queryAll();

      $coilCaster = "
                    SELECT
                    MONTH(act_date) as bulan,
                    coil_number,
                    alloy_code,
                    alloy_type,
                    actual_thickness,
                    width,
                    sum(actual_out) as weight_entry
                    from
                    ctm_dpr_trx_caster_tab
                    where
                    MONTH(act_date) = '01'
                    AND
                    YEAR(act_date) = '2022'
                    AND
                    alloy_type = 'FOIL'
                    GROUP BY coil_number
      ";

      $dataCaster = \Yii::$app->db->createCommand($coilCaster)->queryAll();


      foreach ($dataCaster as $i => $v) {

        $mother_coil = $v['coil_number'];

        $yieldCoil[$i]['coil_number'] = $v['coil_number'];
        $yieldCoil[$i]['bulan'] = $v['bulan'];
        $yieldCoil[$i]['thickness'] = $v['actual_thickness'];
        $yieldCoil[$i]['width'] = $v['width'];
        $yieldCoil[$i]['weight'] = $v['weight_entry'];
        $yieldCoil[$i]['finish_bk'] = \Yii::$app->db->createCommand("CALL get_finish_bk_by_coil_number(:coil_number)")
        ->bindValue(':coil_number' , $v['coil_number'] )
        ->queryAll();

        if(!empty($yieldCoil[$i]['finish_bk'])){
          foreach ($yieldCoil[$i]['finish_bk'] as $j => $k) {
            $yieldCoil[$i]['finish_bk'][$j]['coil_dpo'] = \Yii::$app->db->createCommand("CALL get_dpo_by_coil_number(:coil_number)")
            ->bindValue(':coil_number' , $mother_coil)
            ->queryAll();

            if(!empty($yieldCoil[$i]['finish_bk'][$j]['coil_dpo'])){

              foreach ($yieldCoil[$i]['finish_bk'][$j]['coil_dpo'] as $p => $q) {
                $yieldCoil[$i]['finish_bk'][$j]['coil_dpo'][$p]['supply'] = $this->__getRollSupply($q['coil_number']);
              }

            }

          }
        }

      }

      pr($yieldCoil);


      // pr($dataCaster);exit;


    }


    public function __getRollSupply($coil_number){

      $sql = "SELECT
              'SEP' as machine,
              coil_number,
              thickness_actual as thickness,
              sum(weight) as weight
              from
              v_separator where coil_number in ('".$coil_number."') group by coil_number

              UNION ALL

              select
              'SLTR' as machine,
              coil_number,
              thickness,
              sum(weight) as weight
              from
              ctm_dpr_trx_slitter_tab
              where coil_number in ('".$coil_number."') group by coil_number
              ";

      $dataSupply = \Yii::$app->db->createCommand($sql)
      ->queryAll();

      return $dataSupply;

    }

    public function actionUpdateRuntime(){
        // $load_no = 5221;
        // $dataSlit = Slitter::find()->where(['load_no' => $load_no])->orderBy('roll_no asc')->asArray()->one();
        //
        // pr($dataSlit['roll_no']);

        // foreach (range('A', 'AH') as $letra) {
        //   pr($letra);
        // }

        for ($i = 'A'; $i !== 'AI'; $i++){
          pr($i);
        }
    }


    public function actionUpdateDownsize(){

      $querySlitter = "SELECT
                      coil_number_mother,
                      group_concat(coil_number) as coil_number,
                      width,
                      sum(weight) as weight,
                      sum(total_scrap) as total_scrap
                      from
                      (
                      select
                      coil_number,
                      SUBSTRING_INDEX(coil_number, '-',2 ) as coil_number_mother,
                      width,
                      weight,
                      ifnull(trimming,0) + ifnull(scrap_sisa_spoll,0) + ifnull(scrap_order,0) as total_scrap
                      from
                      ctm_dpr_trx_slitter_tab where MONTH(act_date) = '09' and YEAR(act_date) = '2022' and thickness = '105'
                    ) x group by x.coil_number_mother";

      $dataSlitter = \Yii::$app->db->createCommand($querySlitter)->queryAll();

      foreach ($dataSlitter as $key => $value) {
        $coil_number = $value['coil_number_mother'];
        $width = $value['width'];
        $weight = $value['weight'];
        $total_scrap = $value['total_scrap'];


        $queryBK = "select * from ctm_dpr_trx_blowknox_tab where coil_number like '%".$coil_number."%' and thick_exit = 105";
        $dataBK = \Yii::$app->db->createCommand($queryBK)->queryAll();

        if(!empty($dataBK)){

          pr($dataBK);

          foreach ($dataBK as $key1 => $valueBK) {
            $idBK = $valueBK['id'];

            $widthChange = $width;
            $weightChange = $weight;
            $totalScrapChange = $valueBK['total_scrap'] + $total_scrap;

            pr($widthChange." ".$weightChange." ".$totalScrapChange);

            // Yii::$app->db->createCommand()
            // ->update('ctm_dpr_trx_blowknox_tab', ['trimming'=> $total_scrap, 'width_exit' => $widthChange , 'weight_exit' =>  $weightChange, 'total_scrap'=> $totalScrapChange], ['id'=> $idBK ])
            // ->execute();


          }


        }


      }



      exit;

    }


    public function actionTesCode(){


      $_POST['Pittsburgh']['trans_date'] = '2023-04-12';
      $_POST['Pittsburgh']['start'] = '23:05:00';
      $_POST['Pittsburgh']['finish'] = '01:45:00';

      $date = date('Y-m-d', strtotime($_POST['Pittsburgh']['trans_date']));
      $startx = date("H:i:s", strtotime($_POST['Pittsburgh']['start']));
      $stopx = date("H:i:s" , strtotime($_POST['Pittsburgh']['finish']));
      $start = date("Y-m-d H:i:s", strtotime($date.' '.$_POST['Pittsburgh']['start']));
      $stop = date("H:i:s" , strtotime($date.' '.$_POST['Pittsburgh']['finish']));
      $datevalid = '2023-04-12 02:16:28';
      $tanggal = '2023-04-12';

      if($stopx < $startx){
        $stop = date("Y-m-d H:i:s" , strtotime("+1 days", strtotime($date.' '.$_POST['Pittsburgh']['finish'])));

      }
      else $stop = date("Y-m-d H:i:s" , strtotime($date.' '.$_POST['Pittsburgh']['finish']));


      pr($start." ".$stop);

      $hour = date_parse(DowntimePittsburgh::getDatediff($start,$stop));
			$runtime = ($hour['hour']*60)+$hour['minute'];

      pr($runtime);

      exit;

      $_POST['Pittsburgh']['phase'] = 4;

      $phase='';
      if(substr($_POST['Pittsburgh']['phase'],-1) == 'T'){
				if(strlen($_POST['Pittsburgh']['phase']) <= 2){
				$phase = substr($_POST['Pittsburgh']['phase'],0,1);
				$phase_note = substr($_POST['Pittsburgh']['phase'],1,1);
				}
				else{
				$phase = substr($_POST['Pittsburgh']['phase'],0,2);
				$phase_note = substr($_POST['Pittsburgh']['phase'],2,1);
				}
			}

      pr($phase);
      exit;

      // if ($pos === false) {
      //   echo "The string '$findme' was not found in the string '$mystring'";
      // } else {
      //   echo "The string '$findme' was found in the string '$mystring'";
      //   echo " and exists at position $pos";
      // }

      exit;

      $coil_number = 'A-0901003-22F++-A+A-0901003-22F++-C-A';
      $coil_number_parts = null;
      $from_machine = 'PB';
      // $data = Pittsburgh::find()->where(['coil_number' => 'A-0901003-22F++-A+A-0901003-22F++-C-A' , 'coil_number_parts' => $coil_number_parts])->asArray()->all();
      // pr($data);exit;


      $query = new Query;
  		$query->select(new \yii\db\Expression('weight'))
  		->from('v_lov_separator_grouped')
  		->where(['v_lov_separator_grouped.coil_number'=>$coil_number])
  		->andWhere(['v_lov_separator_grouped.coil_number_parts'=>$coil_number_parts])
  		->andWhere(['v_lov_separator_grouped.from_machine'=>$from_machine]);
  		$command = $query->createCommand();
  		$weight_dpo = $command->queryOne();

      pr($weight_dpo);exit;


      $coil_number = [['coil_number' => 'A-0901003-22F++-A+A-0901003-22F++-C-D' , 'Im' => 'Foil3i']];
      $coil_numbers = [];
      foreach($coil_number as $i => $v){
          $v['coil_number'] = str_replace('++','',$v['coil_number']);
          if(strpos($v['coil_number'], '+')){
              $coil_numberz = explode("+", $v['coil_number']);
              foreach($coil_numberz as $j=>$k){
                  $coil_numbers[] = $k.'_'.$v['Im'];
              }
          }
          else $coil_numbers[] = $v['coil_number'].'_'.$v['Im'];
      }

      foreach($coil_numbers as $i =>$v){

          $coilz[] = explode("_", $v);
          if($coilz[$i][1] == 'Foilim'){
              $char = strpos($coilz[$i][0], "-");
              if(!is_numeric(substr($coilz[$i][0], -1))) {
                  $coilz[$i][0] = substr($coilz[$i][0], 0, -2);
                  if(!is_numeric(substr($coilz[$i][0], -1))) {
                      $coilz[$i][0] = substr($coilz[$i][0], 0, -2);
                      if(!is_numeric(substr($coilz[$i][0], -1))) {
                          $coilz[$i][0] = substr($coilz[$i][0], 0, -2);
                          if(!is_numeric(substr($coilz[$i][0], -1))) {
                              $coilz[$i][0] = substr($coilz[$i][0], 0, -2);
                          }
                      }
                  }
              }
          }
          else if($coilz[$i][1] == 'Foil3i'){

              $char = strpos($coilz[$i][0], "F");
              $length_str = strlen($coilz[$i][0]);

              if(!($char == ($length_str-1))){
                  $coilz[$i][0] = substr($coilz[$i][0], 0, -2);
                  $char = strpos($coilz[$i][0], "F");
                  $length_str = strlen($coilz[$i][0]);
                  if(!($char == ($length_str-1))){
                      $coilz[$i][0] = substr($coilz[$i][0], 0, -2);
                      $char = strpos($coilz[$i][0], "F");
                      $length_str = strlen($coilz[$i][0]);
                      if(!($char == ($length_str-1))){
                          $coilz[$i][0] = substr($coilz[$i][0], 0, -2);
                      }
                  }
              }
          }

      }

      pr($coil_numbers);
      pr($coilz);

    }

    public function actionTesExcel1(){

      // echo "Sdsd";
      return $this->render('excel', []);
    }

    public function actionUpdateAbsenError(){

      $startInShift1 = '2022-07-14 05:00:00';
      $endInShift1 = '2022-07-14 07:00:00';

      $startOutShift1 = '2022-07-14 13:30:00';
      $endOutShift1 = '2022-07-14 15:00:00';

      $data = AbsenceWeb::find()->where(" absen_datetime > '".$startInShift1."' and absen_datetime < '".$endInShift1."' and code=1 ")->asArray()->all();

      foreach ($data as $key => $value) {

        $absenOut = AbsenceWeb::find()->where(" absen_datetime > '".$startOutShift1."' and absen_datetime < '".$endOutShift1."' and code=3 AND nik='".$value['nik']."' ")->asArray()->one();

        if(!empty($absenOut)){
          pr($value['nik']." ".$value['absen_datetime']." OUT = ".$absenOut['absen_datetime']);
        }else{
          pr($value['nik']." ".$value['absen_datetime']." OUT = kosong");

          // $model = new AbsenceWeb();
          // $model->nik = $value['nik'];
          // $model->absen_datetime = '2022-07-14 17:40:00';
          // $model->book_code = 38;
          // $model->code = 3;
          // $model->image_url = '20220714/'.$value['nik'].".png";
          //
          // $model->save();


        }



      }

    }

    public function actionUpdateAlloy(){
      $data = CoilImport::find()->where(['alloy_code' =>'AA80'])->asArray()->all();

      if(!empty($data)){

        foreach ($data as $key => $value) {
          $tracking = \Yii::$app->db->createCommand("call tracking_coil(:coil_number)")
                        ->bindValue(':coil_number' , $value['coil_number'] )
                        ->queryAll();

          echo $value['coil_number'];
          pr($tracking);

        }



      }

    }

    public function actionTesCaster(){
      // $coil_number  = 'A-0712010-22ST';
      // $caster = Caster::find()->where(['coil_number'=>$coil_number])->all();
      //
      // if(!empty($caster)){
      //   foreach($caster as $casters){
      //     if(substr($coil_number,-2) == 'ST') $casters->scenario = 'upload';
      //     $casters->is_processed = 1;
      //     $casters->save();
      //     pr($casters);
      //   }
      // }

      $start = '2022-07-01';
      $finish = '2022-07-31';

      $slitter=Slitter::find()->select(new \yii\db\Expression('
        *,
        get_totscrap_sltr(load_no) as tot_scrap,
        if(runtime != "",
        (actual_in - total_exit_by_load - get_totscrap_sltr(load_no) - ifnull(sisa,0)),"") as hasilcontrol')
        )->where(' act_date between "'.  $start . '" and "' .  $finish . '"' )->orderBy('act_date, roll_no , shift asc')->asArray()->all();

      pr($slitter);

			// if(!empty($caster)){
			// 	foreach($caster as $casters){
			// 		$casters->is_processed = 1;
			// 		$casters->save();
      //
			// 	}
      // }
    }

    public function actionTesFormula(){

      // $data = Caster::find()->select([new \yii\db\Expression('max(datetime_finish) as finish_process')])->where(['coil_number' => 'A-0118093-22C'])->groupBy('coil_number')->asArray()->one();

      // pr(Yii::$app->user->identity);
      // exit;
      // $coil_number = 'A-0901003-22F++-A+A-0901003-22F++-C-A';
      // $coil_number_parts = '';
      // $phase = '3';
      // $data = Pittsburgh::find()->where(['coil_number' => $coil_number , 'coil_number_parts' => $coil_number_parts , 'phase' => $phase])->asArray()->one();
      //
      // pr($data);exit;
      $id = '2613';
      $modelsCaf = CafDetail::find()->where(['caf_id'=>$id])->asArray()->all();

      pr($modelsCaf);
      exit;


      $prod_type = 'SHEET';
      $alloy = '1100';

      // if($prod_type == 'SHEET' && $alloy=='1100'){
      //   $next_machine = 'SLTR';
      // }else if( ($prod_type == 'SHEET' || $prod_type == 'PLATE' ) && $alloy == '3105'){
      //   $next_machine = 'PACKING';
      // }else{
      //   $next_machine='BK';
      // }

      if($prod_type == 'SHEET' && $alloy=='1100') $next_machine = 'SLTR';
      elseif( ($prod_type == 'SHEET' || $prod_type == 'PLATE' ) && $alloy=='3105') $next_machine = 'PACKING';
      else $next_machine='BK';

      pr($next_machine);

      exit;

      $dataCoil = ["A-2222-22F","A-2222-22F"];



      $abj = 'A';
      foreach ($dataCoil as $key => $v) {
        $model = new Slitter();

        $model->coil_number = $v;
        if(count($dataCoil) > 1) $model->coil_number = $v.'-'.$abj;

        $model->roll_no = $model->coil_number;
        if(count($dataCoil) > 1) $model->roll_no = $model->coil_number;


        pr($model);
        $abj++;
      }





      exit;


      $error=1;

      $coil_number = 'A-0731125-21F';
      $coil_number_parts = '';


      $data1 = Vonroll::find()->where(['coil_number' =>[$coil_number] , 'coil_number_parts' => $coil_number_parts , 'next_machine' => ['SEPC','SEPD','SEPE','SLTR'] ])->asArray()->all();

      // if(!VonRoll::updateAll(['is_processed'=>'1'], ['coil_number' => [$coil_number] , 'coil_number_parts' => $coil_number_parts , 'next_machine' => ['SEPC','SEPD','SEPE','SLTR'] ] )){
      //     $error = 0;
      // }

      // echo $error;

      pr($data1);

      exit;

      $coil_number1 = "a-1";
      $coil_number_parts1 = "a";
      $coil_number2 = "b-1";
      $coil_number_parts2 = "b";

      if(!empty($coil_number1)){
        echo "ada";
        return true;
      }else{
        echo "tidak ada";
      }

      echo "gas";
      // return true;
      exit;


      $coil_number = 'A-0412076-22F-A';
      $coil_number2 = 'A-0412076-22F-B';
      $from_machine_before = 'KOBE2';

      $cekSisa = DoublerSisa::find()->select([new \yii\db\Expression('coil_number_parts as coil_number , sum(weight) as weight_sisa')])->where(['coil_number'=>[$coil_number,$coil_number2], 'from_machine' => $from_machine_before])->groupBy('coil_number_parts')->asArray()->one();

      // pr($cekSisa);exit;

      if(!empty($cekSisa)){

        $coilDoub = $cekSisa['coil_number'];
        $doub2 = Doubler2::find()->select([new \yii\db\Expression('coil_number , coil_number_parts, SUM(ifnull(weight_exit, 0) + ifnull(weight_exit2, 0)) AS weight_exit')])->where(['coil_number' => $coilDoub,'from_machine' => $from_machine_before])->groupBy('coil_number')->asArray()->one();

        // pr($doub2);exit;

        if(!empty($doub2)){

          $weightSisa = $cekSisa['weight_sisa'];
          $weight_doub2 = $doub2['weight_exit'];

          $sisa = (double)$weightSisa - (double)$weight_doub2;

          pr($cekSisa);
          pr($doub2);
          pr($sisa);

          if($sisa == 0){
              // Yii::$app->db->createCommand()
    					// ->update('ctm_dpr_trx_doubler2_tab', ['is_processed'=>1,'next_machine'=>'DOUB2'], ['coil_number'=>$doub2['coil_number'],'coil_number_parts'=>$doub2['coil_number_parts','next_machine' => 'DOUB2']])
    					// ->execute();
              // return 1;
          }

        }


      }



    }

    public function actionUpdateWip(){

      $vr = "select * from ctm_dpr_trx_pittsburgh_tab where is_processed is null and next_machine in ('SEPC','SEPD','SEPE','SLTR') AND YEAR(act_date) = '2021'  order by act_date asc";
      $resultVr = \Yii::$app->db->createCommand($vr)->queryAll();

      foreach ($resultVr as $key => $v) {

        $coil_number = $v['coil_number'];
        $coil_number_parts = $v['coil_number_parts'];

        $ceksisa = "select * from v_lov_separator_grouped where coil_number = '".$coil_number."' and coil_number_parts = '".$coil_number_parts."' and from_machine = 'PB' ";
        $resultSisa = \Yii::$app->db->createCommand($ceksisa)->queryAll();


        foreach ($resultSisa as $key1 => $vSisa) {

          if($vSisa['weight'] < 200){
            Yii::$app->db->createCommand()
            ->update('ctm_dpr_trx_pittsburgh_tab', ['is_processed' => '1' ], ['coil_number'=> $vSisa['coil_number'],'coil_number_parts' => $vSisa['coil_number_parts'], 'next_machine' => ['SEPC','SEPD','SEPE','SLTR'] ])
            ->execute();

            pr($vSisa['coil_number']." flag ".$vSisa['weight']);
          }else{
            pr($vSisa['coil_number']." tidak flag ".$vSisa['weight']);
          }


        }

      }


      // $ceksisa = "SELECT SUM(weight_exit) FROM ctm_dpr_trx_vonroll_tab WHERE coil_number = '180413041-1-A'  and next_machine in ('SEPC','SEPD','SEPE','SLTR') AND qc_status IN ( 'C', 'K', 'O' ) GROUP by coil_number";


    }

    public function actionTesCogs(){
      return $this->render('index-cogs');
    }

    public function actionTesBarcode(){
      echo __DIR__;exit;
      $codeIn = "testing";
      $qrCodeIn = (new QrCode($codeIn))
      ->useLogo()
      ->setSize(100)
      ->setMargin(5)
      ->useForegroundColor(0, 0, 0);

      $qrCodeIn->writeFile(__DIR__ . '/code.png'); // writer defaults to PNG when none is specified

      // display directly to the browser
      // header('Content-Type: '.$qrCodeIn->getContentType());
      // echo $qrCodeIn->writeString();

      // pr($qrCodeIn);

    }

    public function actionGetFileDashboard($id){
      // $url = Yii::$app->basePath.'/views/country/tes.php';

      // $dashboard = json_decode($nameDash);

      // pr($id);exit;

      $dashboard = explode(",", $id);

      // pr($dashboard);exit;

      if(!empty($dashboard)){

        $arrayFile = '';
        foreach ($dashboard as $v) {
          $das = DashboardName::find()->where(['id' => $v ])->asArray()->one();
          $url = Yii::$app->basePath.'/views/site/dashboard-layout/'.$das['file_dashboard'].'.php';
          $string = file_get_contents($url,TRUE);

          // $arrayFile .= htmlentities(file_get_contents($url,TRUE));
          //
          // pr($url);
        }

      }

      include($url);

      // ob_start(); // Start output buffer capture.
      // include($url); // Include your template.
      // $output = ob_get_contents(); // This contains the output of yourtemplate.php
      // // Manipulate $output...
      // ob_end_clean(); // Clear the buffer.
      // return $string;



      // exit;

      // return $arrayFile;

      // pr($arrayFile);

      // pr($string);

      // ob_start();
      // include $url;
      // $string = ob_get_clean();



      // ob_start();
      // include $url;
      // $string = ob_get_clean();
      //
      // pr($string);
      // pr($url);
    }


    public function actionIndexTest(){


      // $route = '/report/estimation-request/index';
      //
      // if (!empty($route)) {
      //     $url = [];
      //     $r = explode('&', $route);
      //     $url[0] = $r[0];
      //     unset($r[0]);
      //     foreach ($r as $part) {
      //         $part = explode('=', $part);
      //         $url[$part[0]] = isset($part[1]) ? $part[1] : '';
      //     }
      //
      //   pr($url);
      // };
      //
      // exit;


      // echo html_entity_decode(\app\widgets\AmChecklist::widget([]));
      // pr((\app\widgets\AmChecklistJson::widget([])));


      // pr($as);
      // exit;

        $this->layout= 'main2.php';
        //
        //
        //
        // //
        // // exit;
        //
        //

        $dashboard_daily_technic= \Yii::$app->db->createCommand("call get_dashboard_dailyreport_tech(:date)")
            ->bindValue(':date' , '2022-09-05' )
            ->queryAll();


        $phpDevsOver40 = array_filter($dashboard_daily_technic, function ($value) {
          return ($value["shift"] == 2);
        });


        // pr($phpDevsOver40);
        //
        //
        // pr($dashboard_daily_technic);exit;

        $coil_number = [];
        $sql = "select coil_number from ctm_dpr_daily_qc where coil_number NOT IN ('TRANSFER') group by coil_number";

        $result_coil = \Yii::$app->db->createCommand($sql)
                          ->queryAll();

        $coil_number = ArrayHelper::getColumn($result_coil, 'coil_number');



        $dashboard = DashboardName::find()->where('group_div is not null')->all();
        $dataDashboard=ArrayHelper::map($dashboard,'id','nama');

        // pr($dataDashboard);exit;

        // pr($coil_number);exit;



        return $this->render('index-test',[
          'dashboard_daily_technic' =>   $dashboard_daily_technic,
          'coil_number' => $coil_number,
          'dataDashboard' => $dataDashboard,
        ]);
    }

    public function actionUploadMulti(){
      $upload = new UploadForm();
      $uploads = UploadedFile::getInstances($upload, 'File');
      pr($uploads);exit;
      // pr($_FILES);
      // pr($_POST);exit;
    }

    public function actionIndexCoba(){
      $model = new Country();
      $upload = new UploadForm();

      if ($model->load(Yii::$app->request->post())) {
        $uploads = UploadedFile::getInstances($upload, 'File');

        // $model->name = UploadedFile::getInstances($model,'name');

        pr($uploads);

        pr($_POST);exit;
      }

      return $this->render('index-coba',[
        'model' => $model,
  			'upload' => $upload,
  		]);
    }


    public function actionIndexDashboard($id){

      // return $this->render("site/dashboard_layout/machine_status_dashboard",[]);
      $this->layout= 'main_guest.php';

      $dashboard = explode(",", $id);

      $urlDash = [];
      if(!empty($dashboard[0] != '')){
        foreach ($dashboard as $key => $v) {
          $das = DashboardName::find()->where(['id' => $v ])->asArray()->one();
          $urlDash[] = Yii::$app->basePath.'/views/site/dashboard-layout/'.$das['file_dashboard'].'.php';
        }
      }
      $siteLay = "/country/dashboard-layout";
      $server = Yii::$app->request->hostInfo;
      $base = Yii::$app->homeUrl;

      return $this->render($siteLay,[
        'server' => $server,
        'base' => $base,
        'urlDash' => $urlDash,
      ]);
      // return $this->redirect([$redir]);
    }


    public function actionDashAm(){
      // $as = Yii::$app->Dashboard->testing();

      $as = \app\widgets\AmChecklist::widget([]);

      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return [
        'test' => $as,
      ];

    }


    public function actionUpload(){
      $model = new UploadForm2();
      $report_model = new Report();

      if (Yii::$app->request->post()) {

        $model->load(Yii::$app->request->post());
        // pr($model);exit;
        $model->excelFile = UploadedFile::getInstance($model, 'excelFile');

        if ($model->upload()) {

          $data = \moonland\phpexcel\Excel::widget([
          'mode' => 'import',
          'fileName' => '../uploads/files/excels/'.$model['excelFile']->name,
          'setFirstRecordAsKeys' => true,
          // 'isMultipleSheet' => true,
          // 'getOnlySheet' => 'DPR'
          ]);

          $opname = [];
          foreach ($data as $key => $v) {
            $coil_number = $v['No Coil'];
            $qty = $v['Qty'];

            $track = \Yii::$app->db->createCommand("call tracking_coil(:coil_number)")
                          ->bindValue(':coil_number' , $coil_number )
                          ->queryAll();

            $track_filter = array_filter($track, function ($item) use ($v) {
          			if($item['weight_exit'] == $v['Qty'] && $item['machine'] != 'BA' ){
          				return $item;
          			}
          	});

            $opname[] = end($track_filter);
            //
            // pr(end($track_filter));

          }



          $objPHPExcel = new Spreadsheet();

        	// Calculation::getInstance($objPHPExcel)->disableCalculationCache();

        	// $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        	// $writer->setPreCalculateFormulas(false);

        	// $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
        	// $writer->setPreCalculateFormulas(false);

          $objPHPExcel->getProperties()->setCreator("Central Data Komputindo")
                         ->setLastModifiedBy("Central Data Komputindo")
                         ->setTitle("Office 2007 XLSX Budget Report Document")
                         ->setSubject("Office 2007 XLSX Budget Report Document")
                         ->setDescription("Budget Report document for Office 2007 XLSX, generated using PHP classes.")
                         ->setKeywords("office 2007 openxml php")
                         ->setCategory("invoices");

          $sheet = $objPHPExcel->getActiveSheet();

          // SET DEFAULT
          $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
          $objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
          $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);
          $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

          $numberSheet = 0;

          $objPHPExcel->setActiveSheetIndex($numberSheet);
        	$sheet = $objPHPExcel->getActiveSheet();
        	$sheet->setTitle('OPNAME COIL');

          $row = 1;
          foreach ($opname as $key => $x) {

            $A='A';
            $objPHPExcel->getActiveSheet()->setCellValue($A++.$row, $x['coil_number']);

            $B='B';
            $objPHPExcel->getActiveSheet()->setCellValue($B++.$row, $x['machine']);

            $C='C';
            $objPHPExcel->getActiveSheet()->setCellValue($C++.$row, $x['weight_exit']);

            $D='D';
            $objPHPExcel->getActiveSheet()->setCellValue($D++.$row, $x['act_date']);

            $row++;
          }

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="opname tgl proses coil.xls"');
          header('Cache-Control: max-age=0');

          $writer = new Xlsx($objPHPExcel);
        	$writer->setPreCalculateFormulas(false);
          $writer->save('php://output');

          exit;


        }

      }

      return $this->render('upload', [
        'model' => $model,
        'report_model'=>$report_model
      ]);

    }


    public function actionUploadRoll(){
      $model = new UploadForm2();
      $report_model = new Report();

      if (Yii::$app->request->post()) {

        $model->load(Yii::$app->request->post());
        // pr($model);exit;
        $model->excelFile = UploadedFile::getInstance($model, 'excelFile');

        if ($model->upload()) {

          $data = \moonland\phpexcel\Excel::widget([
          'mode' => 'import',
          'fileName' => '../uploads/files/excels/'.$model['excelFile']->name,
          'setFirstRecordAsKeys' => true,
          // 'isMultipleSheet' => true,
          // 'getOnlySheet' => 'DPR'
          ]);

          // pr($data);exit;

          $opname = [];
          foreach ($data as $key => $v) {
            $roll_no = $v['No Roll'];
            $qty = $v['Qty'];

            $track = \Yii::$app->db->createCommand("call tracking_roll(:roll_no)")
                          ->bindValue(':roll_no' , $roll_no )
                          ->queryAll();

            $track_filter = array_filter($track, function ($item) use ($v) {
          			if($item['weight'] == $v['Qty'] ){
          				return $item;
          			}
          	});

            if(!empty($track_filter)){
              $opname[] = reset($track_filter);
            }else{
              $opname[] = ['roll_no' => $roll_no , 'machine' => '' , 'weight' => $qty , 'act_date' => ''];
            }

          }

          // pr($opname);
          // exit;

          // pr($opname);exit;


          $objPHPExcel = new Spreadsheet();

        	// Calculation::getInstance($objPHPExcel)->disableCalculationCache();

        	// $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        	// $writer->setPreCalculateFormulas(false);

        	// $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
        	// $writer->setPreCalculateFormulas(false);

          $objPHPExcel->getProperties()->setCreator("Central Data Komputindo")
                         ->setLastModifiedBy("Central Data Komputindo")
                         ->setTitle("Office 2007 XLSX Budget Report Document")
                         ->setSubject("Office 2007 XLSX Budget Report Document")
                         ->setDescription("Budget Report document for Office 2007 XLSX, generated using PHP classes.")
                         ->setKeywords("office 2007 openxml php")
                         ->setCategory("invoices");

          $sheet = $objPHPExcel->getActiveSheet();

          // SET DEFAULT
          $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
          $objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
          $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);
          $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

          $numberSheet = 0;

          $objPHPExcel->setActiveSheetIndex($numberSheet);
        	$sheet = $objPHPExcel->getActiveSheet();
        	$sheet->setTitle('OPNAME ROLL');

          $row = 1;
          foreach ($opname as $key => $x) {
            $A='A';
            $objPHPExcel->getActiveSheet()->setCellValue($A++.$row, $x['roll_no']);

            $B='B';
            $objPHPExcel->getActiveSheet()->setCellValue($B++.$row, $x['machine']);

            $C='C';
            $objPHPExcel->getActiveSheet()->setCellValue($C++.$row, $x['weight']);

            $D='D';
            $objPHPExcel->getActiveSheet()->setCellValue($D++.$row, $x['act_date']);

            $row++;
          }

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="opname ROLL.xls"');
          header('Cache-Control: max-age=0');

          $writer = new Xlsx($objPHPExcel);
        	$writer->setPreCalculateFormulas(false);
          $writer->save('php://output');

          exit;


        }

      }

      return $this->render('upload', [
        'model' => $model,
        'report_model'=>$report_model
      ]);

    }


    public function actionUpdateRuleDashboard(){
      pr(Yii::$app->user->identity->username);
      exit;

      $nik = ["administrator"];
      // $nik = ["950465","930224"];

      $dasName = DashboardName::find()->where('id not in("18","19")')->asArray()->all();

      // pr($dasName);exit;

      foreach ($dasName as $key => $v) {

          foreach ($nik as $key1 => $vNik) {

            $model = new Dashboard();
            $model->nik = $vNik;
            $model->dashboard_id = $v['id'];

            $model->save();

          }
      }

    }

    function addLetters($letter,$lettersToAdd){
       for ($i=0;$i<$lettersToAdd;$i++){
          $letter++;
       }
       return $letter;
    }

    public function actionPrint(){


      // echo html_entity_decode(app\widgets\AmChecklist::widget([]));


      $abj = 'Z';

      $next = $this->addLetters($abj,2);

      pr($next);

      exit;


      $text = "6 - 12 Micron";

      $find = ['/Micron/','/ /'];
      $replace = ['',''];
      $result = trim(preg_replace($find, $replace, $text));

      $thick = explode("-",$result);
      pr($thick);exit;

      // pr($result);exit;



      $month='2022-02';

      echo date('M',strtotime($month));
      exit;

      $start = '2022-03-01';
      $finish = '2022-03-21';



      $begin = strtotime($start);
      $end   = strtotime($finish);



      $dashboard_output = \Yii::$app->db->createCommand("call output_dashboard(:start,:finish)")
                    ->bindValue(':start' , $start )
          ->bindValue(':finish' , $finish )
          ->queryAll();


      $x=0;
      for ( $j = $end; $j >= $begin; $j = $j - 86400 ) {
        $i = date( 'Y-m-d', $j );

          $data[$x]['tanggal'] = $i;
          foreach ($dashboard_output as $key => $v) {
            $data[$x][$v['machine']] = $v[$i];
          }

          $x++;

      }

      pr($data);


      exit;


      $array1 = array_filter($dashboard_output, function ($item) {
          if (in_array($item['machine'] , array('CSTA', 'BK', 'KOBE1', 'KOBE2','VR','PB'))) {
            return $item;
          }
      });

      $array2 = array_filter($dashboard_output, function ($item) {
          if (in_array($item['machine'] , array('SEPC', 'SEPD', 'SEPE', 'SLTR'))) {
            return $item;
          }
      });


      $das1['machine'] = 'PROD1';
      $das2['machine'] = 'PROD2';

      for ( $j = $begin; $j <= $end; $j = $j + 86400 ) {
        $i = date( 'Y-m-d', $j );

        $b = array_sum(array_column($array1, $i));
        $c = array_sum(array_column($array2, $i));

        $das1[$i] = $b/1000;
        $das2[$i] = $c/1000;

        $dasfull = [$das1,$das2];

      }


      $merg = array_merge($dashboard_output,$dasfull);
      // pr($das1);
      // pr($das2);
      // pr($dasfull);
      pr($merg);
      exit;


      // $schedule = Schedule::find()->joinWith('employee')->where('tanggal between "'.$start.'" and "'.date('Y-m-d', strtotime('+3 days', strtotime($start))).'"')->orderBy('tanggal, shift')->asArray()->all();

      $nik = '211484';
      // $data = DashboardName::find()->joinWith('Dashboard')->select([new \yii\db\Expression('ctm_dpr_dashboard_tab.*')])->where('nik = "'.$nik.'" ')->asArray()->all();
      $query = new Query;
      $query->select('ctm_dpr_dashboard_tab.*')
      ->from('ctm_mst_dashboard_name_tab')
      ->join(	'LEFT JOIN',
          'ctm_dpr_dashboard_tab',
          'ctm_dpr_dashboard_tab.dashboard_id =ctm_mst_dashboard_name_tab.id'
      )->where(['nik' => $nik]);
      $command = $query->createCommand();
      $data = $command->queryAll();



      // $s = "";
      // if(empty($s)){
      //   echo "kosong";
      // }else{
      //   echo "tidak kosong";
      // }
      // exit;

      pr($data);
      exit;


      // $data = Caster::find()->select([new \yii\db\Expression('max(datetime_finish) as finish_process')])->where(['coil_number' => 'A-0118093-22C'])->groupBy('coil_number')->asArray()->one();
      //
      // pr($data);exit;

      $load_no = 461222;
      $data1 = Slitter::find()->select('sum(weight) as total_exit')->where(['load_no' => $load_no])->groupBy('load_no')->asArray()->one();

      if(!empty($data1)){
        pr($data1);
      }else{
        echo "kosong 22";
      }

      exit;


      $text = "dsadsad||dsadsad";
      $a =explode("|",$text);
      $b = array_filter($a, function($value) { return !is_null($value) && $value !== ''; });
      pr($a);
      exit;


      return $this->renderPartial('print');

      $content =  $this->renderPartial('print');

      $mpdf=new \Mpdf\Mpdf([
  			'mode'=>'utf-8',
  			'format'=>'A4'
  		]);

          $mpdf->SetHTMLFooter("<p style='font-size:10px;' align='center'>Head Office / Factory : Jln. Inspeksi Kalimalang KM. 24, Desa Gandamekar, Cikarang Barat, Bekasi 17520 Indonesia<br/>
          Phone : +62 21 88320058 (hunting) - Fax. +62 21 88320584 or 88320025</p>");
          $mpdf->WriteHTML($content);
          $mpdf->Output('PI.pdf', 'D');
          exit;


    }

    public function actionTesChart(){

      $data = \Yii::$app->db->createCommand("CALL get_dmbd_downtime_machine(:tgl_awal,:tgl_akhir,:machine)")
                        ->bindValue(':tgl_awal' , '2021-10-26' )
                        ->bindValue(':tgl_akhir' , '2021-10-31' )
                        ->bindValue(':machine' , 'BK' )
                        ->queryAll();

      pr($data);

    }

    public function actionTesCoba(){

      pr("sdsdsd sdsd 1212");exit;

      $tech_shift_date = '2022-08-16';

      $time = date('h:i');

      if($time > '12:00'){
        echo date('d F Y',strtotime($tech_shift_date));
      }else{
        echo date('d F Y',strtotime('-1 days' , strtotime($tech_shift_date)));
      }

      exit;



      $total1 = 0;
      $total2=0;
      $total3=0;
      $total4=0;
      $total5=0;

      for ($i=1; $i <= 10 ; $i++) {

        if($i == 1){
          $total1 += $i;
        }else if($i == 2){
          $total2 += $i;
        }else if($i == 3 || $i == 4 || $i == 5){
          $total3 += $i;

          if($i == 4){
            $total4 += $i;
          }else if($i == 5){
            $total5 += $i;
          }
        }

        // switch ($i) {
        //   case $i == 1 :
        //     $total1 += $i;
        //     break;
        //   case $i == 2:
        //     $total2 += $i;
        //     break;
        //   case ($i == 3 || $i == 4 || $i == 5):
        //     $total3 += $i;
        //     break;
        //   case $i == 4 :
        //     $total4 += $i;
        //     break;
        // }

      }



      // echo $total1." ".$total2." ".$total3;



      echo $total1." ".$total2." ".$total3." ".$total4." ".$total5;

    }

    public function actionOraclePdo(){

      // 'dsn' => 'oci:dbname=//150.100.10.51:1521/IFSAPP',
      // 'username' => 'M1_01',
      // 'password' => 'ial_m101',
      // 'charset' => 'utf8'

    //   $tns = "150.100.10.51:1521/IFSAPP";
    //
    // try{
    //   $pdo = new PDO('OCI:dbname='.$tns ,'username','password');
    //   pr($pdo);
    // } catch(PDOException $e){
    //     echo $e->getMessage();
    // }
    //

    $username='M1_01';
    $password='ial_m101';
    $db='(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 150.100.10.51)(PORT = 1521))
    (CONNECT_DATA =
    (SERVER = DEDICATED)
    (SERVICE_NAME = PROD)
    )
    )';
    $connection = oci_connect($username, $password, $db);
    if (!$connection) {
      $e = oci_error();
      echo htmlentities($e[‘message’]);
    }else{
      echo "konek";
    }


    }



    function getDateFromDay($day) {
      return date('Y-m-d', strtotime("first $day of this month"));
    }


    public function actionWeekTes(){
      // echo $this->getDateFromDay('Sunday');

      $a = "Screenshot from ".date('Y-m-d H-i-s',strtotime(" +2 sec")).".png";
      echo $a;

      $a = "Screenshot from ".date('Y-m-d H-i-s' , strtotime(" +2 sec")).".png";
      echo $a;

    }


    public function actionDir(){
      echo file_exists("dashboard_yield");

      $begin = strtotime('2021-01-01');
      $end = strtotime('2021-12-31');

      for ($i=$begin; $i <= $end ; $i= $i+86400) {
         $i = date('Y-m-d', $j);

      }

      echo file_exists("dashboard_yield");

    }


    public function actionListDate(){
      $begin = strtotime('2021-01-01');
      $end   = strtotime('2021-12-31');
      for ( $j = $begin; $j <= $end; $j = $j + 86400 ) {
         $i = date( 'Y-m-d', $j );

           $model = new ListDate();
           $model->tanggal = $i;

           $model->save();


         echo $i."<br>";
       }

    }

    function number_unformat($number, $force_number = true, $dec_point = '.', $thousands_sep = ',') {
    	if ($force_number) {
    		$number = preg_replace('/^[^\d-]+/', '', $number);
    	} else if (preg_match('/^[^\d-]+/', $number)) {
    		return false;
    	}
    	$type = (strpos($number, $dec_point) === false) ? 'int' : 'float';
    	$number = str_replace(array($dec_point, $thousands_sep), array('.', ''), $number);
    	settype($number, $type);
    	return $number;

    }

    public function actionTesCalc(){
      $a= "96.50";

      pr($this->number_unformat($a));
      exit;

      $a = 5;
      $b = 100;

      if($a != 0 && $b != 0){
        $persen_distilation_ratio = number_format(($a / $b) * 100, 2);
      }else{
        $persen_distilation_ratio = 0;
      }
      pr($persen_distilation_ratio);

    }

    public function actionWeek(){
        $month = 5;
        $year = 2020;

        $date = new \DateTime("now");
        $date->setDate($year, $month, 1);
        $date->setTime(0, 0, 0);

        //last day of the month
        $maxDay = intval($date->format("t"));

        //getting the first monday
        $dayOfTheWeek = intval($date->format("N"));
        // pr($dayOfTheWeek);exit;
        if($dayOfTheWeek != 1) {
        //print a partial week if needed
        $diff = 8 - $dayOfTheWeek;
        if($dayOfTheWeek <= 7) {
          $from = $date->format("Y-m-d");
          // echo $from;
          $diff2 = 7 - $dayOfTheWeek;
          $date->modify(sprintf("+%d days", $diff2));
          $to = $date->format("Y-m-d");
          // echo sprintf("from: %s to %s\n", $from, $to);
          $exfrom = explode("-",$from);
          $exto = explode("-",$to);
          $range[] = ["id" => $exfrom[2]."-".$exto[2], "from" => $from , "to" => $to];
          $diff -= $diff2;
        }
        $date->modify(sprintf("+%d days", $diff));
        }

        //iterate while we are in the current month
        while(intval($date->format("n")) == $month) {
        $from = $date->format("Y-m-d");
        // echo $from;
        $date->modify("+6 days");
        if(intval($date->format("n")) > $month) {
          $date->setDate($year, $month, $maxDay);
        }
        $to = $date->format("Y-m-d");
        $date->modify("+1 days");

        $exfrom = explode("-",$from);
        $exto = explode("-",$to);
        $range[] = ["id" => $exfrom[2]."-".$exto[2], "from" => $from , "to" => $to];

        // echo sprintf("from: %s to %s\n", $from, $to);
        }


        foreach ($range as $key => $v) {

          $dataWeek[$v['id']] = $v['from']." sampai ".$v['to'];
        }

        pr($dataWeek);
    }

    public function actionTesPmAm(){

      // $query = new Query;
      // $trans_date = date('Y-m-d', strtotime('-1 days'));
  		// $query	->select(new \yii\db\Expression("distinct(machine)"))
  		// ->from('ctm_dpr_trx_am_tab');
  		// $command = $query->createCommand();
  		// $listMachine = $command->queryAll();
  		// if(!empty($listMachine)){
  		// 	$summ_am=[];
  		// 	foreach($listMachine as $i =>$v){
  		// 		$summ = Yii::$app->General->getAmDailyVerify($v['machine'],'43836');
  		// 		if(is_array($summ)) $summ_am = array_merge($summ_am, $summ);
  		// 	}
      //
      //   pr($summ_am);exit;
      //
      // }

      // $data = Yii::$app->General->cekOutrangeAM('VR','44390','Briedleroll_putaran');

      // pr($data);

      // pr(Yii::$app->homeUrl);

      // echo date('Ym');

      // $d = 'foo099';
      // for ($n=1; $n<=1; $n++) {
      //     $a = ++$d;
      // }
      //
      // echo $a;
      // exit;

      $num=9999;
      $count = 0;
      while ($num > 9) {
        $num = array_product(str_split($num));
        $count++;
      }

      echo $count;

  exit;




      $count  = 0;
      $num = 999;
      $mult  = $num;

      while (true) {
        if($mult < 10){
          return $count;
        }

        $multStr = str_split($mult);

        $newMult=1;

        for ($i=0; $i < count($multStr) ; $i++) {
          $newMult = $newMult * $multStr[$i];
        }

        $mult = $newMult;

        $count++;

      }

      echo $count;

      exit;

      $begin = strtotime('2021-02-24');
      $end   = strtotime('2021-03-08');

      for ( $i = $begin; $i <= $end; $i = $i + 86400 ) {
          $thisDate = date( 'Y-m-d', $i ); // 2010-05-01, 2010-05-02, etc
          echo $thisDate."<br>";
      }


    }

    function tesf(){
      $a = 0;

      return $a;
    }

    public function actionTesTemplate(){

      // pr("dsdd");
      // exit;



      error_reporting(0);
      $bulan = "01";
      $tahun='2021';
      $periode='202101';

      $jurnal_conf = \Yii::$app->db->createCommand("CALL get_export_jurnal_cogs(:periode)")
                        ->bindValue(':periode' , '202101' )
                        ->queryAll();

      $acctbook_conf = \Yii::$app->db->createCommand("CALL get_export_acctbook_cogs(:periode)")
                        ->bindValue(':periode' , '202101' )
                        ->queryAll();

      $sheet_conf = \Yii::$app->db->createCommand("CALL get_export_sheet_cogs(:periode)")
                        ->bindValue(':periode' , '202101' )
                        ->queryAll();

      $costsheet_conf = \Yii::$app->db->createCommand("CALL get_export_costsheet_cogs(:periode)")
                        ->bindValue(':periode' , '202101' )
                        ->queryAll();

      $invmove_conf = \Yii::$app->db->createCommand("CALL get_export_invmove_cogs(:periode)")
                        ->bindValue(':periode' , '202101' )
                        ->queryAll();


      $fg_conf1 = FgCogsBag1::find()->where(['periode' => '202101'])->asArray()->all();


      $rowAkhirFg1 = 4 + count($fg_conf1);


      $fg2_conf2 = \Yii::$app->db->createCommand("CALL fg_cogs_bag2_conf(:periode)")
                        ->bindValue(':periode' , '202101' )
                        ->queryAll();


      $rowFirstFg2 = $rowAkhirFg1 + 4;
      $rowEndFg2 = $rowFirstFg2 + count($fg2_conf2) - 1;


      $mutasi_conf = MutasiCogs::find()->where(['periode' => '202101'])->orderBy('row asc')->asArray()->all();

      $ppv_conf1 = PpvCogsBag1::find()->where(['periode' => $periode])->asArray()->all();
      $ppv_conf2 = PpvCogsBag2::find()->where(['periode' => $periode])->asArray()->all();
      $ppv_conf3 = PpvCogsBag3::find()->where(['periode' => $periode])->asArray()->all();


      $rowFirstPpv2 = $ppv_conf2[0]['row'];
      $rowEndPpv2 = $rowFirstPpv2 + count($ppv_conf2) - 1;



      // pr($acctbook_conf);exit;



      $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
      $objPHPExcel = $objReader->load(Yii::$app->basePath."/templates/Template-COGS.xlsx");

      ///-----JURNAL---////
      $objPHPExcel->setActiveSheetIndex(0);
			$sheet = $objPHPExcel->getActiveSheet();
      ///------END----////



      ///-----ACCT BOOK--///
      $objPHPExcel->setActiveSheetIndex(1);
			$sheet = $objPHPExcel->getActiveSheet();
      if(!empty($acctbook_conf)){

        foreach ($acctbook_conf as $key => $v) {

          if($v['kolom_A'] != '') $objPHPExcel->setActiveSheetIndex(1)->setCellValue($v['kolom_A'],$v['nilai_A']);
          if($v['kolom_B'] != '') $objPHPExcel->setActiveSheetIndex(1)->setCellValue($v['kolom_B'],$v['nilai_B']);
          if($v['kolom_C'] != '') $objPHPExcel->setActiveSheetIndex(1)->setCellValue($v['kolom_C'],$v['nilai_C']);
          if($v['kolom_D'] != '') $objPHPExcel->setActiveSheetIndex(1)->setCellValue($v['kolom_D'],$v['nilai_D']);
          if($v['kolom_E'] != '') $objPHPExcel->setActiveSheetIndex(1)->setCellValue($v['kolom_E'],$v['nilai_E']);
        }


        $objPHPExcel->setActiveSheetIndex(1)
        ->setCellValueByColumnAndRow(0,2,'Periode : '.\Yii::$app->General->getMonthName($bulan).' '.$tahun);


        for ($i=233; $i <= 236 ; $i++) {
          $rumusFg = '=SUMIF(FG!C$4:$G'.$rowAkhirFg1.',A'.$i.',FG!$G$4:$G$'.$rowAkhirFg1.') + SUMIF(FG!C$4:$G'.$rowAkhirFg1.',A'.$i.',FG!$J$4:$J$'.$rowAkhirFg1.') + SUMIF(FG!C$4:$G'.$rowAkhirFg1.',A'.$i.',FG!$K$4:$K$'.$rowAkhirFg1.') + SUMIF(FG!C$4:$G'.$rowAkhirFg1.',A'.$i.',FG!$L$4:$L$'.$rowAkhirFg1.') + SUMIF(FG!C$4:$G'.$rowAkhirFg1.',A'.$i.',FG!$M$4:$M$'.$rowAkhirFg1.')';

          $objPHPExcel->setActiveSheetIndex(1)
          ->setCellValueByColumnAndRow(1,$i,$rumusFg);
        }


        $rumusCoilFm='=SUMIF(FG!$C$4:$G$'.$rowAkhirFg1.',"Plate",FG!$G$4:$G$'.$rowAkhirFg1.')';
        $rumusPlateR2='=SUMIF(FG!$C$4:$G$'.$rowAkhirFg1.',"Jan!A237",FG!$G$4:$G$'.$rowAkhirFg1.')*0.188';
        $rumusPlateR4='=SUMIF(FG!$C$4:$G$'.$rowAkhirFg1.',"Jan!A238",FG!$G$4:$G$'.$rowAkhirFg1.')*0.382';



        $objPHPExcel->setActiveSheetIndex(1)
        ->setCellValueByColumnAndRow(2,236,$rumusCoilFm);

        $objPHPExcel->setActiveSheetIndex(1)
        ->setCellValueByColumnAndRow(2,237,$rumusPlateR2);

        $objPHPExcel->setActiveSheetIndex(1)
        ->setCellValueByColumnAndRow(2,238,$rumusPlateR4);



      }
    ///-------END------///


    ///-----SHEET--///
    $objPHPExcel->setActiveSheetIndex(2);
    $sheet = $objPHPExcel->getActiveSheet();
    if(!empty($sheet_conf)){
      foreach ($sheet_conf as $key => $v) {

        if($v['kolom_B'] != '') $objPHPExcel->setActiveSheetIndex(2)->setCellValue($v['kolom_B'],$v['nilai_B']);
        if($v['kolom_C'] != '') $objPHPExcel->setActiveSheetIndex(2)->setCellValue($v['kolom_C'],$v['nilai_C']);
        if($v['kolom_D'] != '') $objPHPExcel->setActiveSheetIndex(2)->setCellValue($v['kolom_D'],$v['nilai_D']);
        if($v['kolom_E'] != '') $objPHPExcel->setActiveSheetIndex(2)->setCellValue($v['kolom_E'],$v['nilai_E']);
        if($v['kolom_F'] != '') $objPHPExcel->setActiveSheetIndex(2)->setCellValue($v['kolom_F'],$v['nilai_F']);
        if($v['kolom_G'] != '') $objPHPExcel->setActiveSheetIndex(2)->setCellValue($v['kolom_G'],$v['nilai_G']);
        if($v['kolom_H'] != '') $objPHPExcel->setActiveSheetIndex(2)->setCellValue($v['kolom_H'],$v['nilai_H']);
        if($v['kolom_I'] != '') $objPHPExcel->setActiveSheetIndex(2)->setCellValue($v['kolom_I'],$v['nilai_I']);
        if($v['kolom_J'] != '') $objPHPExcel->setActiveSheetIndex(2)->setCellValue($v['kolom_J'],$v['nilai_J']);
      }

      for ($i=315; $i <= 317 ; $i++) {
         $rumusFgSheet = '=SUMIF(FG!$C$'.$rowFirstFg2.':$C$'.$rowEndFg2.',SHEET!A'.$i.',FG!$G$'.$rowFirstFg2.':$G$'.$rowEndFg2.') + SUMIF(FG!$C$'.$rowFirstFg2.':$C$'.$rowEndFg2.',SHEET!A'.$i.',FG!$J$'.$rowFirstFg2.':$J$'.$rowEndFg2.') + SUMIF(FG!$C$'.$rowFirstFg2.':$C$'.$rowEndFg2.',SHEET!A'.$i.',FG!$K$'.$rowFirstFg2.':$K$'.$rowEndFg2.') + SUMIF(FG!$C$'.$rowFirstFg2.':$C$'.$rowEndFg2.',SHEET!A'.$i.',FG!$L$'.$rowFirstFg2.':$L$'.$rowEndFg2.') + SUMIF(FG!$C$'.$rowFirstFg2.':$C$'.$rowEndFg2.',SHEET!A'.$i.',FG!$M$'.$rowFirstFg2.':$M$'.$rowEndFg2.')  ';

         $objPHPExcel->setActiveSheetIndex(2)
         ->setCellValueByColumnAndRow(3,$i,$rumusFgSheet);
      }


      $objPHPExcel->setActiveSheetIndex(2)
      ->setCellValueByColumnAndRow(3,318,'=SUMIF(FG!$C$'.$rowFirstFg2.':$C$'.$rowEndFg2.',SHEET!A318,FG!$G$'.$rowFirstFg2.':$G$'.$rowEndFg2.')');


      $objPHPExcel->setActiveSheetIndex(2)
      ->setCellValueByColumnAndRow(7,318,'=SUMIF(FG!$C$'.$rowFirstFg2.':$C$'.$rowEndFg2.',"Plate",FG!$G$'.$rowFirstFg2.':$G$'.$rowEndFg2.')');

      $objPHPExcel->setActiveSheetIndex(2)
      ->setCellValueByColumnAndRow(7,319,'=SUMIF(FG!$C$'.$rowFirstFg2.':$C$'.$rowEndFg2.',"Jan!A237",FG!$G$'.$rowFirstFg2.':$G$'.$rowEndFg2.') + SUMIF(FG!$C$'.$rowFirstFg2.':$C$'.$rowEndFg2.',"Jan!A238",FG!$G$'.$rowFirstFg2.':$G$'.$rowEndFg2.')');

    }
  ///-------END------///


  ///-----COST SHEET--///
  $objPHPExcel->setActiveSheetIndex(3);
  $sheet = $objPHPExcel->getActiveSheet();
  if(!empty($costsheet_conf)){
    foreach ($costsheet_conf as $key => $v) {

      if($v['kolom_B'] != '') $objPHPExcel->setActiveSheetIndex(3)->setCellValue($v['kolom_B'],$v['nilai_B']);
      if($v['kolom_C'] != '') $objPHPExcel->setActiveSheetIndex(3)->setCellValue($v['kolom_C'],$v['nilai_C']);
      if($v['kolom_D'] != '') $objPHPExcel->setActiveSheetIndex(3)->setCellValue($v['kolom_D'],$v['nilai_D']);
      if($v['kolom_E'] != '') $objPHPExcel->setActiveSheetIndex(3)->setCellValue($v['kolom_E'],$v['nilai_E']);
      if($v['kolom_F'] != '') $objPHPExcel->setActiveSheetIndex(3)->setCellValue($v['kolom_F'],$v['nilai_F']);
      if($v['kolom_G'] != '') $objPHPExcel->setActiveSheetIndex(3)->setCellValue($v['kolom_G'],$v['nilai_G']);
      if($v['kolom_H'] != '') $objPHPExcel->setActiveSheetIndex(3)->setCellValue($v['kolom_H'],$v['nilai_H']);
    }

  }


  $objPHPExcel->setActiveSheetIndex(3)
  ->setCellValueByColumnAndRow(6,310,'=PPV!J'.($rowEndPpv2+3));

  $objPHPExcel->setActiveSheetIndex(3)
  ->setCellValueByColumnAndRow(8,310,($rowEndPpv2+3));

///-------END------///




///-----INVMOVE--///
$objPHPExcel->setActiveSheetIndex(4);
$sheet = $objPHPExcel->getActiveSheet();
if(!empty($invmove_conf)){
  foreach ($invmove_conf as $key => $v) {

    if($v['kolom_C'] != '') $objPHPExcel->setActiveSheetIndex(4)->setCellValue($v['kolom_C'],$v['nilai_C']);
    if($v['kolom_D'] != '') $objPHPExcel->setActiveSheetIndex(4)->setCellValue($v['kolom_D'],$v['nilai_D']);
    if($v['kolom_G'] != '') $objPHPExcel->setActiveSheetIndex(4)->setCellValue($v['kolom_G'],$v['nilai_G']);
  }

  $objPHPExcel->setActiveSheetIndex(4)
  ->setCellValueByColumnAndRow(2,6,'=FG!K'.($rowAkhirFg1+1).'/-1');

}
///-------END------///


///-----FG--///
$objPHPExcel->setActiveSheetIndex(5);
$sheet = $objPHPExcel->getActiveSheet();
if(!empty($fg_conf1)){

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(0,4,'Part Description')
  ->setCellValueByColumnAndRow(1,4,'Items no')
  ->setCellValueByColumnAndRow(2,4,'Type')
  ->setCellValueByColumnAndRow(3,4,'Beginning')
  ->setCellValueByColumnAndRow(4,4,'Purchase')
  ->setCellValueByColumnAndRow(5,4,'Count-OUT/IN')
  ->setCellValueByColumnAndRow(6,4,'Receipt')
  ->setCellValueByColumnAndRow(7,4,'Return')
  ->setCellValueByColumnAndRow(8,4,'Sales')
  ->setCellValueByColumnAndRow(9,4,'Reject')
  ->setCellValueByColumnAndRow(10,4,'Reprocess')
  ->setCellValueByColumnAndRow(11,4,'Wrong Entry')
  ->setCellValueByColumnAndRow(12,4,'Cost')
  ->setCellValueByColumnAndRow(13,4,'SIR')
  ->setCellValueByColumnAndRow(14,4,'Ending')
  ;

  $objPHPExcel->getActiveSheet()->getStyle('A4:O4')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A4:O4')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

  $rowFg=5;

  foreach ($fg_conf1 as $key => $v) {

    $A='A';
    $objPHPExcel->getActiveSheet()->setCellValue($A++.$rowFg,$v['A']);

    $B='B';
    $objPHPExcel->getActiveSheet()->setCellValue($B++.$rowFg,$v['B']);

    $C='C';
    $objPHPExcel->getActiveSheet()->setCellValue($C++.$rowFg,$v['C']);

    $D='D';
    $objPHPExcel->getActiveSheet()->setCellValue($D++.$rowFg,$v['D']);

    $E='E';
    $objPHPExcel->getActiveSheet()->setCellValue($E++.$rowFg,$v['E']);

    $F='F';
    $objPHPExcel->getActiveSheet()->setCellValue($F++.$rowFg,$v['F']);

    $G='G';
    $objPHPExcel->getActiveSheet()->setCellValue($G++.$rowFg,$v['G']);

    $H='H';
    $objPHPExcel->getActiveSheet()->setCellValue($H++.$rowFg,$v['H']);

    $I='I';
    $objPHPExcel->getActiveSheet()->setCellValue($I++.$rowFg,$v['I']);

    $J='J';
    $objPHPExcel->getActiveSheet()->setCellValue($J++.$rowFg,$v['J']);

    $K='K';
    $objPHPExcel->getActiveSheet()->setCellValue($K++.$rowFg,$v['K']);

    $L='L';
    $objPHPExcel->getActiveSheet()->setCellValue($L++.$rowFg,$v['L']);

    $M='M';
    $objPHPExcel->getActiveSheet()->setCellValue($M++.$rowFg,$v['M']);

    $N='N';
    $objPHPExcel->getActiveSheet()->setCellValue($N++.$rowFg,$v['N']);

    $O='O';
    $objPHPExcel->getActiveSheet()->setCellValue($O++.$rowFg,$v['O']);


    $rowFg++;
  }


  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(1,$rowFg,'Total');

  $style = array(
     'borders' => array(
      'outline' => array(
        'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
        'color' => array('rgb' => '000000')
      ),
      'inside' => array (
        'style' => \PHPExcel_Style_Border::BORDER_THIN,
        'color' => array('rgb' => '000000')
      ),
    ),
  );

  $objPHPExcel->getActiveSheet()->getStyle('A4:O'.$rowFg)->applyFromArray($style);
  unset($style);

  $abj='C';
  for ($i=3; $i <= 14 ; $i++) {
    $abj++;
    $objPHPExcel->setActiveSheetIndex(5)
    ->setCellValueByColumnAndRow($i,$rowFg,$this->getTotalFg1('202101',$abj));
  }

  $objPHPExcel->getActiveSheet()->getStyle('A'.$rowFg.':O'.$rowFg)->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$rowFg.':O'.$rowFg)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

  $rowFg+=1;

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(3,$rowFg,'=Mutasi!C85');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(7,$rowFg,'Sales Report');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(8,$rowFg,'=-Mutasi!M85');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(14,$rowFg,'=Mutasi!Q85');

  $rowFg+=1;

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(7,$rowFg,'Selisih');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(8,$rowFg,'=I'.($rowFg-2).' + H'.($rowFg-2).' + I'.($rowFg-1) );

}



if(!empty($fg2_conf2)){

  $rowAwalFg2 = $rowFg+1;
  $rowFg2 = $rowFg+1;
  foreach ($fg2_conf2 as $key => $v) {

    $A='A';
    $objPHPExcel->getActiveSheet()->setCellValue($A++.$rowFg2,$v['A']);

    $B='B';
    $objPHPExcel->getActiveSheet()->setCellValue($B++.$rowFg2,$v['B']);

    $C='C';
    $objPHPExcel->getActiveSheet()->setCellValue($C++.$rowFg2,$v['C']);

    $D='D';
    $objPHPExcel->getActiveSheet()->setCellValue($D++.$rowFg2,$v['D']);

    $E='E';
    $objPHPExcel->getActiveSheet()->setCellValue($E++.$rowFg2,$v['E']);

    $F='F';
    $objPHPExcel->getActiveSheet()->setCellValue($F++.$rowFg2,$v['F']);

    $G='G';
    $objPHPExcel->getActiveSheet()->setCellValue($G++.$rowFg2,$v['G']);

    $H='H';
    $objPHPExcel->getActiveSheet()->setCellValue($H++.$rowFg2,$v['H']);

    $I='I';
    $objPHPExcel->getActiveSheet()->setCellValue($I++.$rowFg2,$v['I']);

    $J='J';
    $objPHPExcel->getActiveSheet()->setCellValue($J++.$rowFg2,$v['J']);

    $K='K';
    $objPHPExcel->getActiveSheet()->setCellValue($K++.$rowFg2,$v['K']);

    $L='L';
    $objPHPExcel->getActiveSheet()->setCellValue($L++.$rowFg2,$v['L']);

    $M='M';
    $objPHPExcel->getActiveSheet()->setCellValue($M++.$rowFg2,$v['M']);

    $N='N';
    $objPHPExcel->getActiveSheet()->setCellValue($N++.$rowFg2,$v['N']);

    $O='O';
    $objPHPExcel->getActiveSheet()->setCellValue($O++.$rowFg2,$v['O']);

    $rowFg2++;
  }


  $style = array(
     'borders' => array(
      'outline' => array(
        'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
        'color' => array('rgb' => '000000')
      ),
      'inside' => array (
        'style' => \PHPExcel_Style_Border::BORDER_THIN,
        'color' => array('rgb' => '000000')
      ),
    ),
  );

  $objPHPExcel->getActiveSheet()->getStyle('A'.$rowAwalFg2.':O'.$rowFg2)->applyFromArray($style);
  unset($style);



  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(1,$rowFg2,'Total');


  $abj='C';
  for ($i=3; $i <= 14 ; $i++) {
    $abj++;
    $objPHPExcel->setActiveSheetIndex(5)
    ->setCellValueByColumnAndRow($i,$rowFg2,'=SUM('.$abj.''.$rowAwalFg2.':'.$abj.''.($rowFg2-1).')');
  }

  $objPHPExcel->getActiveSheet()->getStyle('A'.$rowFg2.':O'.$rowFg2)->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$rowFg2.':O'.$rowFg2)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);


  $rowFg2+=3;
  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(2,$rowFg2,'B');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(3,$rowFg2,'Angka Merah artinya sudah di rubah Standar Cost');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(6,$rowFg2,'=G'.($rowFg2-1).' - G'.($rowFg2-3));

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(11,$rowFg2,'=J'.($rowFg2-3).' + L'.($rowFg2-3).' - L'.($rowFg2-1));

  $rowFg2+=1;
  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(2,$rowFg2,'B');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(3,$rowFg2,'Angka Hitam artinya belum di rubah Standar Cost');

  $rowFg2+=1;
  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(13,$rowFg2,'Rekonsel :');

  $rowFg2+=2;
  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(13,$rowFg2,'manual');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(14,$rowFg2,'=O'.($rowFg2-7));

  $rowFg2+=1;
  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(13,$rowFg2,'Subledger');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(14,$rowFg2,'=Mutasi!R85');

  $rowFg2+=1;
  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(13,$rowFg2,'Ledger');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(14,$rowFg2,'=Ledger!H71+Ledger!H70');

  $rowFg2+=2;

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(13,$rowFg2,'Selisih');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(14,$rowFg2,'=O'.($rowFg2-3).' - O'.($rowFg2-2));


  $rowFg2+=2;

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(13,$rowFg2,'Selisih');

  $objPHPExcel->setActiveSheetIndex(5)
  ->setCellValueByColumnAndRow(14,$rowFg2,'=O'.($rowFg2-6).' - O'.($rowFg2-5));

}
///-------END------///



///-----MUTASI--///

$objPHPExcel->setActiveSheetIndex(6);
$sheet = $objPHPExcel->getActiveSheet();
if(!empty($mutasi_conf)){

  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(0,3,'Part No')->mergeCells('A3:A4');

  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(1,3,'Part Description')->mergeCells('B3:B4');

  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(2,3,'Saldo Awal')->mergeCells('C3:D3');

  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(4,3,'Beli')->mergeCells('E3:F3');

  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(6,3,'COUNT-IN/OUT')->mergeCells('G3:H3');

  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(8,3,'Terima')->mergeCells('I3:J3');

  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(10,3,'Pakai')->mergeCells('K3:L3');

  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(12,3,'Jual')->mergeCells('M3:N3');

  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(14,3,'INV Scrap')->mergeCells('O3:P3');

  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(16,3,'Saldo Akhir')->mergeCells('Q3:R3');

  $col=1;
  for ($i=1; $i <= 15 ; $i++) {

    $col++;
    $objPHPExcel->setActiveSheetIndex(6)
    ->setCellValueByColumnAndRow($col,4,'Qty');

    $col++;
    $objPHPExcel->setActiveSheetIndex(6)
    ->setCellValueByColumnAndRow($col,4,'Amount');
  }

  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(18,4,'');


  $rowMut = 5;

  foreach ($mutasi_conf as $key => $v) {

    $A='A';
    $objPHPExcel->getActiveSheet()->setCellValue($A++.$rowMut,$v['part_no']);

    $B='B';
    $objPHPExcel->getActiveSheet()->setCellValue($B++.$rowMut,$v['part_desc']);

    $C='C';
    $objPHPExcel->getActiveSheet()->setCellValue($C++.$rowMut,$v['C']);

    $D='D';
    $objPHPExcel->getActiveSheet()->setCellValue($D++.$rowMut,$v['D']);

    $E='E';
    $objPHPExcel->getActiveSheet()->setCellValue($E++.$rowMut,$v['E']);

    $F='F';
    $objPHPExcel->getActiveSheet()->setCellValue($F++.$rowMut,$v['F']);

    $G='G';
    $objPHPExcel->getActiveSheet()->setCellValue($G++.$rowMut,$v['G']);

    $H='H';
    $objPHPExcel->getActiveSheet()->setCellValue($H++.$rowMut,$v['H']);

    $I='I';
    $objPHPExcel->getActiveSheet()->setCellValue($I++.$rowMut,$v['I']);

    $J='J';
    $objPHPExcel->getActiveSheet()->setCellValue($J++.$rowMut,$v['J']);

    $K='K';
    $objPHPExcel->getActiveSheet()->setCellValue($K++.$rowMut,$v['K']);

    $L='L';
    $objPHPExcel->getActiveSheet()->setCellValue($L++.$rowMut,$v['L']);

    $M='M';
    $objPHPExcel->getActiveSheet()->setCellValue($M++.$rowMut,$v['M']);

    $N='N';
    $objPHPExcel->getActiveSheet()->setCellValue($N++.$rowMut,$v['N']);

    $O='O';
    $objPHPExcel->getActiveSheet()->setCellValue($O++.$rowMut,$v['O']);

    $P='P';
    $objPHPExcel->getActiveSheet()->setCellValue($P++.$rowMut,$v['P']);

    $Q='Q';
    $objPHPExcel->getActiveSheet()->setCellValue($Q++.$rowMut,$v['Q']);

    $R='R';
    $objPHPExcel->getActiveSheet()->setCellValue($R++.$rowMut,$v['R']);

    $S='S';
    $objPHPExcel->getActiveSheet()->setCellValue($S++.$rowMut,$v['S']);


    $rowMut++;
  }

  $rowAkhirMut = $rowMut-1;

  $rowMut+=3;
  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(1,$rowMut,'Total');


  $abj='B';
  for ($i=2; $i <= 17 ; $i++) {
    $abj++;

    $objPHPExcel->setActiveSheetIndex(6)
    ->setCellValueByColumnAndRow($i,$rowMut,'=SUM('.$abj.'5:'.$abj.''.($rowAkhirMut).')');
  }

  $rowMut+=2;

  $field = ['Row Material Purchase','Raw Material Purchase','Indirect Materials','FG','WIP','Coil ex Import to Cold Rolling'];

  $row=$rowMut;
  foreach ($field as $key => $v) {
    $objPHPExcel->setActiveSheetIndex(6)
    ->setCellValueByColumnAndRow(1,$row,$v);
    $row++;
  }


  $abj='B';
  for ($i=2; $i <= 17 ; $i++) {
    $abj++;
    $objPHPExcel->setActiveSheetIndex(6)
    ->setCellValueByColumnAndRow($i,$rowMut,$this->getTotalSumMutasi('202101',$abj,'RMP'));
  }


  $rowMut+=1;
  $abj2='B';
  for ($i=2; $i <= 17 ; $i++) {
    $abj2++;
    $objPHPExcel->setActiveSheetIndex(6)
    ->setCellValueByColumnAndRow($i,$rowMut,$this->getTotalSumMutasi('202101',$abj2,'IM'));
  }

  $rowMut+=1;
  $abj3='B';
  for ($i=2; $i <= 17 ; $i++) {
    $abj3++;
    $objPHPExcel->setActiveSheetIndex(6)
    ->setCellValueByColumnAndRow($i,$rowMut,$this->getTotalSumMutasi('202101',$abj3,'FG'));
  }

  $rowMut+=1;
  $abj4='B';
  for ($i=2; $i <= 17 ; $i++) {
    $abj4++;
    $objPHPExcel->setActiveSheetIndex(6)
    ->setCellValueByColumnAndRow($i,$rowMut,$this->getTotalSumMutasi('202101',$abj4,'WIP'));
  }

  $rowMut+=1;
  $abj5='B';
  for ($i=2; $i <= 17 ; $i++) {
    $abj5++;
    $objPHPExcel->setActiveSheetIndex(6)
    ->setCellValueByColumnAndRow($i,$rowMut,$this->getTotalSumMutasi('202101',$abj5,'EX-COIL'));
  }


  $rowMut+=2;
  $objPHPExcel->setActiveSheetIndex(6)
  ->setCellValueByColumnAndRow(1,$rowMut,'Selisih');

  $abj='B';
  for ($i=2; $i <= 17 ; $i++) {
    $abj++;
    $objPHPExcel->setActiveSheetIndex(6)
    ->setCellValueByColumnAndRow($i,$rowMut,'='.$abj.''.($rowMut-9).' - SUM('.$abj.''.($rowMut-7).':'.$abj.''.($rowMut-2).')');
  }


}

///-------END------///

///-----PPV--///
$objPHPExcel->setActiveSheetIndex(7);
$sheet = $objPHPExcel->getActiveSheet();
if(!empty($ppv_conf1)){

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,50,'LC/numbers')->mergeCells('B50:B51');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,50,'Rate Actual')->mergeCells('C50:C51');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(3,50,'Rate In Rp')->mergeCells('D50:D51');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(4,50,'Qty Beginning')->mergeCells('E50:E51');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(5,50,'Beginning PPV in Rp')->mergeCells('F50:F51');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(6,50,'Add. WIP & SFG Rate Adj')->mergeCells('G50:G51');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(7,50,'Addition in RP')->mergeCells('H50:H51');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(8,50,'Qty Consumption')->mergeCells('I50:I51');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(9,50,'PPV to COGS')->mergeCells('J50:J51');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(10,50,'Qty Ending')->mergeCells('K50:K51');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(11,50,'Ending PPV in Rp')->mergeCells('L50:L51');

  $objPHPExcel->getActiveSheet()->getStyle('A50:L50')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A50:L50')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);


  $rowPpv=52;
  $rowAwal=52;
  foreach ($ppv_conf1 as $key => $v) {

    $B='B';
    $objPHPExcel->getActiveSheet()->setCellValue($B++.$rowPpv,$v['B']);

    $C='C';
    $objPHPExcel->getActiveSheet()->setCellValue($C++.$rowPpv,$v['C']);

    $D='D';
    $objPHPExcel->getActiveSheet()->setCellValue($D++.$rowPpv,$v['D']);

    $E='E';
    $objPHPExcel->getActiveSheet()->setCellValue($E++.$rowPpv,$v['E']);

    $F='F';
    $objPHPExcel->getActiveSheet()->setCellValue($F++.$rowPpv,$v['F']);

    $G='G';
    $objPHPExcel->getActiveSheet()->setCellValue($G++.$rowPpv,$v['G']);

    $H='H';
    $objPHPExcel->getActiveSheet()->setCellValue($H++.$rowPpv,$v['H']);

    $I='I';
    $objPHPExcel->getActiveSheet()->setCellValue($I++.$rowPpv,$v['I']);

    $J='J';
    $objPHPExcel->getActiveSheet()->setCellValue($J++.$rowPpv,$v['J']);

    $K='K';
    $objPHPExcel->getActiveSheet()->setCellValue($K++.$rowPpv,$v['K']);

    $L='L';
    $objPHPExcel->getActiveSheet()->setCellValue($L++.$rowPpv,$v['L']);

    $rowPpv++;
  }

  $rowPpv1Total = $rowPpv;


  $style = array(
     'borders' => array(
      'outline' => array(
        'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
        'color' => array('rgb' => '000000')
      ),
      'inside' => array (
        'style' => \PHPExcel_Style_Border::BORDER_THIN,
        'color' => array('rgb' => '000000')
      ),
    ),
  );

  $objPHPExcel->getActiveSheet()->getStyle('A50:L'.$rowPpv)->applyFromArray($style);
  unset($style);


  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv,'Total');

  $abj='B';
  for ($i=2; $i <= 11 ; $i++) {
    $abj++;

    if($i==2 || $i == 3){
      $rumus = '=AVERAGE('.$abj.''.$rowAwal.':'.$abj.''.($rowPpv-1).')';
    }else if($i == 6){
      $rumus = '=Adjust_Cost!H88';
    }else{
      $rumus = '=SUM('.$abj.''.$rowAwal.':'.$abj.''.($rowPpv-1).')';
    }

    $objPHPExcel->setActiveSheetIndex(7)
    ->setCellValueByColumnAndRow($i,$rowPpv,$rumus);

  }

  $objPHPExcel->getActiveSheet()->getStyle('A'.$rowPpv.':L'.$rowPpv)->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$rowPpv.':L'.$rowPpv)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);


  $rowPpv+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(9,$rowPpv,'=J'.($rowPpv-1).'/I'.($rowPpv-1));

  $rowPpv+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv,'FOILSTOCK (Semi Finished)');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(8,$rowPpv,'=I'.($rowPpv-2).' - C47');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(10,$rowPpv,'=D47 - K'.($rowPpv-2));


  $rowPpv+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv,'1. Beginning');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,$rowPpv,'=INVMOVE!C36');

  $rowPpv+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv,'2. Purchases');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,$rowPpv,'=INVMOVE!C37');

  $rowPpv+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv,'3. Ending');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,$rowPpv,'=INVMOVE!C40/-1');

  $rowPpv+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv,'Consumption');

  $rowConsum1 = $rowPpv;

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,$rowPpv,'=SUM(C'.($rowPpv-3).':C'.($rowPpv-1).')');

  $rowPpv+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,$rowPpv,'Standard Cost');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(3,$rowPpv,'=SHEET!E59');
}


$rowPpv2 = $rowPpv+2;

if(!empty($ppv_conf2)){

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv2,'LC/numbers')->mergeCells('B'.$rowPpv2.':B'.($rowPpv2+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,$rowPpv2,'Rate Actual')->mergeCells('C'.$rowPpv2.':C'.($rowPpv2+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(3,$rowPpv2,'Rate In Rp')->mergeCells('D'.$rowPpv2.':D'.($rowPpv2+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(4,$rowPpv2,'Qty Beginning')->mergeCells('E'.$rowPpv2.':E'.($rowPpv2+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(5,$rowPpv2,'Beginning PPV in Rp')->mergeCells('F'.$rowPpv2.':F'.($rowPpv2+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(6,$rowPpv2,'Add. WIP & SFG Rate Adj')->mergeCells('G'.$rowPpv2.':G'.($rowPpv2+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(7,$rowPpv2,'Addition in RP')->mergeCells('H'.$rowPpv2.':H'.($rowPpv2+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(8,$rowPpv2,'Qty Consumption')->mergeCells('I'.$rowPpv2.':I'.($rowPpv2+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(9,$rowPpv2,'PPV to COGS')->mergeCells('J'.$rowPpv2.':J'.($rowPpv2+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(10,$rowPpv2,'Qty Ending')->mergeCells('K'.$rowPpv2.':K'.($rowPpv2+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(11,$rowPpv2,'Ending PPV in Rp')->mergeCells('L'.$rowPpv2.':L'.($rowPpv2+1));

  $objPHPExcel->getActiveSheet()->getStyle('A'.$rowPpv2.':L'.$rowPpv2)->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$rowPpv2.':L'.$rowPpv2)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);


  $rowPpv2+=2;
  $rowAwalPpv2 = $rowPpv2;
  foreach ($ppv_conf2 as $key => $v) {

    $B='B';
    $objPHPExcel->getActiveSheet()->setCellValue($B++.$rowPpv2,$v['B']);

    $C='C';
    $objPHPExcel->getActiveSheet()->setCellValue($C++.$rowPpv2,$v['C']);

    $D='D';
    $objPHPExcel->getActiveSheet()->setCellValue($D++.$rowPpv2,$v['D']);

    $E='E';
    $objPHPExcel->getActiveSheet()->setCellValue($E++.$rowPpv2,$v['E']);

    $F='F';
    $objPHPExcel->getActiveSheet()->setCellValue($F++.$rowPpv2,$v['F']);

    $G='G';
    $objPHPExcel->getActiveSheet()->setCellValue($G++.$rowPpv2,$v['G']);

    $H='H';
    $objPHPExcel->getActiveSheet()->setCellValue($H++.$rowPpv2,$v['H']);

    $I='I';
    $objPHPExcel->getActiveSheet()->setCellValue($I++.$rowPpv2,$v['I']);

    $J='J';
    $objPHPExcel->getActiveSheet()->setCellValue($J++.$rowPpv2,$v['J']);

    $K='K';
    $objPHPExcel->getActiveSheet()->setCellValue($K++.$rowPpv2,$v['K']);

    $L='L';
    $objPHPExcel->getActiveSheet()->setCellValue($L++.$rowPpv2,$v['L']);


    $rowPpv2++;
  }

  $rowPpv2Total = $rowPpv2;

  $style = array(
     'borders' => array(
      'outline' => array(
        'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
        'color' => array('rgb' => '000000')
      ),
      'inside' => array (
        'style' => \PHPExcel_Style_Border::BORDER_THIN,
        'color' => array('rgb' => '000000')
      ),
    ),
  );

  $objPHPExcel->getActiveSheet()->getStyle('A'.($rowAwalPpv2-2).':L'.$rowPpv2)->applyFromArray($style);
  unset($style);


  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv2,'Total');

  $abj='B';
  for ($i=2; $i <= 11 ; $i++) {
    $abj++;

    if($i==2){
      $rumus = '=AVERAGE('.$abj.''.$rowAwalPpv2.':'.$abj.''.($rowPpv2-1).')';
    }else if($i == 6){
      $rumus = '=Adjust_Cost!H88';
    }else{
      $rumus = '=SUM('.$abj.''.$rowAwalPpv2.':'.$abj.''.($rowPpv2-1).')';
    }

    $objPHPExcel->setActiveSheetIndex(7)
    ->setCellValueByColumnAndRow($i,$rowPpv2,$rumus);

  }

  $objPHPExcel->getActiveSheet()->getStyle('A'.$rowPpv2.':L'.$rowPpv2)->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$rowPpv2.':L'.$rowPpv2)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

  $rowPpv2+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(7,$rowPpv2,'=H'.($rowPpv2-1).'/I'.($rowPpv2-1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(9,$rowPpv2,'=J'.($rowPpv2-1).'/I'.($rowPpv2-1));

  $rowPpv2+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(5,$rowPpv2,'=F'.$rowPpv1Total.'+ F'.$rowPpv2Total);

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(6,$rowPpv2,'=G'.$rowPpv1Total.'+ G'.$rowPpv2Total);

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(7,$rowPpv2,'=H'.$rowPpv1Total.'+ H'.$rowPpv2Total);

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(8,$rowPpv2,'=C'.($rowConsum1).'- I'.($rowPpv2-2));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(9,$rowPpv2,'=J'.$rowPpv1Total.'+ J'.$rowPpv2Total);

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(10,$rowPpv2,'=C'.($rowConsum1-1).'+ K'.($rowPpv2-2));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(11,$rowPpv2,'=L'.$rowPpv1Total.'+ L'.$rowPpv2Total);

  $rowPpv2+=2;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv2,'FOILSTOCK (Flat)');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(7,$rowPpv2,'Total PPV');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(8,$rowPpv2,'=I'.$rowPpv1Total.' + I'.$rowPpv2Total);

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(9,$rowPpv2,'=J'.$rowPpv1Total.' + J'.$rowPpv2Total);

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(10,$rowPpv2,'PPV Manual');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(11,$rowPpv2,'=L'.($rowPpv2-2));


  $rowPpv2+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv2,'1. Beginning');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,$rowPpv2,'0');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(7,$rowPpv2,'Average PPV RP / Kg');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(9,$rowPpv2,'=J'.($rowPpv2-1).'/I'.($rowPpv2-1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(10,$rowPpv2,'PPV GL IFS');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(11,$rowPpv2,'=L'.($rowPpv2-1));

  $rowPpv2+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv2,'2. Purchases');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,$rowPpv2,'=Mutasi!E86');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(7,$rowPpv2,'Ingot Act cost Rp / Kg');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(8,$rowPpv2,'=D48 + J'.($rowPpv1Total+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(9,$rowPpv2,'=I'.($rowPpv1Total).' * I'.($rowPpv2));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(10,$rowPpv2,'Selisih');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(11,$rowPpv2,'=L'.($rowPpv2-2).' - L'.($rowPpv2-1));


  $rowPpv2+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv2,'3. Consumption');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,$rowPpv2,'0');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(7,$rowPpv2,'FS cost RP /Kg');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(8,$rowPpv2,'=D'.($rowConsum1+1).' +J'.($rowPpv2Total+1));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(9,$rowPpv2,'=I'.($rowPpv2Total).' *I'.($rowPpv2));

  $rowPpv2+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(1,$rowPpv2,'Ending');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,$rowPpv2,'=SUM(C'.($rowPpv2-3).':C'.($rowPpv2-1).')');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(7,$rowPpv2,'Average Actual Cost/Kg');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(8,$rowPpv2,'=J'.$rowPpv2.'/I'.($rowPpv2-4));

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(9,$rowPpv2,'=J'.($rowPpv2-2).'+J'.($rowPpv2-1));


  $rowPpv2+=1;
  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(2,$rowPpv2,'Standard Cost');

  $objPHPExcel->setActiveSheetIndex(7)
  ->setCellValueByColumnAndRow(3,$rowPpv2,'0');

}


///-------END------///









      // $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B10','9800');
      // $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C10','5');
      // $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B11','2000');
      // $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C11','7');



      // $objWorkSheet = $objPHPExcel->createSheet();
      // $objPHPExcel->setActiveSheetIndex(2);
			// $sheet = $objPHPExcel->getActiveSheet();
      // $sheet->setTitle('KKKKK');
      //
      // $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A1','TESTING');


      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename=COGS.xlsx');
      header('Cache-Control: max-age=0');

      $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');
      exit;

    }


    public function getTotalSumMutasi($periode,$column,$jenis){

      $mutasi_conf = MutasiCogs::find()->where(['periode' => '202101'])->orderBy('row asc')->asArray()->all();

      if(!empty($mutasi_conf)){

        $totalRMP=0;
        $totalRMR=0;
        $totalIM=0;
        $totalFG=0;
        $totalWip=0;
        $totalEx=0;
        foreach ($mutasi_conf as $key => $v) {

          if($v['jenis'] == "RMP"){
            $totalRMP += $v[$column];
          }else if($v['jenis'] == "RMR"){
            $totalRMR += $v[$column];
          }else if($v['jenis'] == "IM"){
            $totalIM += $v[$column];
          }else if($v['jenis'] == "FG"){
            $totalFG += $v[$column];
          }else if($v['jenis'] == "WIP"){
            $totalWip += $v[$column];
          }else if($v['jenis'] == "EX-COIL"){
            $totalEx += $v[$column];
          }
        }


        if($jenis == "RMP"){
          return $totalRMP;
        }else if($jenis == "RMR"){
          return $totalRMR;
        }else if($jenis == "IM"){
          return $totalIM;
        }else if($jenis == "FG"){
          return $totalFG;
        }else if($jenis == "WIP"){
          return $totalWip;
        }else if($jenis == "EX-COIL"){
          return $totalEx;
        }


      }

    }


    public function getTotalFg1($periode,$column){

      $fg_conf1 = FgCogsBag1::find()->where(['periode' => $periode])->asArray()->all();


      if(!empty($fg_conf1)){

        $totalnilaiR4=0;
        $totalnilaiR2=0;
        $totalnilaiAsp=0;
        $totalnilaiSisa=0;

        foreach ($fg_conf1 as $key => $v) {
          if($v['C'] == "Plate R4"){
            $totalnilaiR4 += $v[$column];
          }else if($v['C'] == "Plate R2"){
            $totalnilaiR2 += $v[$column];
          }else if($v['A'] == "ASP-3.0-1235-H18"){
            $totalnilaiAsp += $v[$column];
          }else{
            $totalnilaiSisa += $v[$column];
          }

        }

        $totalbegin = ($totalnilaiR4 * 0.382) + ($totalnilaiR2 * 0.188) + ($totalnilaiAsp * 29.63) + $totalnilaiSisa;

        return $totalbegin;
      }

    }

    public function actionUpdateFormula(){
      $data = MutasiConf::find()->asArray()->all();

      $row = 1;
      foreach ($data as $key => $value) {
        $id = $value['id'];
        $q = "Mutasi_2_".$row." + Mutasi_4_".$row." + Mutasi_6_".$row." + Mutasi_8_".$row." + Mutasi_10_".$row." + Mutasi_12_".$row." + Mutasi_14_".$row." ";
        $r = "Mutasi_3_".$row." + Mutasi_5_".$row." + Mutasi_7_".$row." + Mutasi_9_".$row." + Mutasi_11_".$row." + Mutasi_13_".$row." + Mutasi_15_".$row." ";


        Yii::$app->db->createCommand()
        ->update('ctm_dpr_mutasi_conf_tab', ['formula_Q' => $q, 'formula_R' => $r ], ['id'=> $id])
        ->execute();

        $row++;
      }

    }

    public function actionTesKpi(){

      $entry_accuracy = \Yii::$app->db->createCommand("CALL get_inspection_accuracy(:tahun)")
                  ->bindValue(':tahun' , '2020' )
                  ->queryAll();

      $new = array_filter($entry_accuracy, function ($var) {
          return ($var['jumlah'] > 0);
      });

      $a = min(array_column($new, 'jumlah'));

      pr($a);

    }


    public function actionUpdateFinishFin(){
      $query = "SELECT
                t1.id,
                t1.roll_no,
                t1.insp_date,
                t1.start_inspect,
                t1.finish_inspect,
                t3.datetime_out as finish,
                t1.create_by,
                t1.created
                FROM
                ctm_dpr_final_inspect_tab t1
                LEFT JOIN ctm_dpr_trx_faf_detail_tab t2 on t2.roll_no = t1.roll_no
                LEFT JOIN ctm_dpr_trx_faf_tab t3 on t3.id = t2.faf_id AND t3.is_delete is null
                WHERE
                YEAR(t1.insp_date) = '2020' AND finish_process is null AND t3.datetime_out is not null AND YEAR(t3.datetime_out) <> '1970' AND t1.is_delete is null limit 1000 ";


    $valueQuery = \Yii::$app->db->createCommand($query)->queryAll();


    foreach ($valueQuery as $key => $value) {
      $id = $value['id'];
      $finish = $value['finish'];

      Yii::$app->db->createCommand()
      ->update('ctm_dpr_final_inspect_tab', ['finish_process' => $finish ], ['id'=> $id])
      ->execute();

    }

    pr($valueQuery);


    }


    public function actionUpdateFinishFri(){

      $query = "SELECT
                a.id,
                a.trans_date,
                a.trans_id,
                a.coil_number,
                a.machine,
                a.start_inspect,
                a.finish_inspect,
                a.finish_process,

                CASE
                	WHEN a.machine  = 'BK' then (SELECT max(datetime_finish) FROM ctm_dpr_trx_blowknox_tab where coil_number = a.coil_number AND next_machine in('PACKING', 'SLTR', 'CAF-F') )

                	WHEN a.machine = 'VR' then (SELECT max(datetime_finish) FROM ctm_dpr_trx_vonroll_tab where coil_number = a.coil_number AND next_machine in ('SEPC','SEPD','SEPE','SLTR') )

                	WHEN a.machine = 'KOBE2' then (SELECT max(datetime_finish) FROM ctm_dpr_trx_kobe2_tab WHERE coil_number = a.coil_number AND next_machine in ('SEPC','SEPD','SEPE','SLTR') )

                	WHEN a.machine  = 'PB' then (SELECT max(datetime_finish) FROM ctm_dpr_trx_pittsburgh_tab WHERE coil_number = a.coil_number AND next_machine in ('SEPC','SEPD','SEPE','SLTR') )

                	WHEN a.machine = 'SM1' then (SELECT max(datetime_finish) FROM ctm_dpr_trx_sm1_tab WHERE coil_number = a.coil_number AND next_machine in ('SEPC','SEPD','SEPE','SLTR') )

                	WHEN a.machine = 'SM5' then (SELECT max(datetime_finish) FROM ctm_dpr_trx_sm5_tab WHERE coil_number = a.coil_number AND next_machine in ('SEPC','SEPD','SEPE','SLTR') )

                	END
                	AS finish,

                	a.created


                FROM

                (

                SELECT
                id,
                trans_date,
                trans_id ,
                coil_number ,
                machine ,
                start_inspect ,
                finish_inspect ,
                finish_process,
                created
                FROM
                ctm_dpr_trx_finish_rolling_qc_tabs WHERE finish_process2 is null limit 1000
              )a having finish is not null";


      $valueQuery = \Yii::$app->db->createCommand($query)->queryAll();


      foreach ($valueQuery as $key => $value) {

        $id = $value['id'];
        $finish = $value['finish'];

        Yii::$app->db->createCommand()
        ->update('ctm_dpr_trx_finish_rolling_qc_tabs', ['finish_process2' => $finish ], ['id'=> $id])
        ->execute();

      }

      pr($valueQuery);

    }


    public function actionUpdateFinishSltr(){

      $query = "SELECT
               a.id,
               a.coil_number,
               a.roll_no,
               a.start_inspect,
               a.finish_inspect,
               a.roll_fix,

               (SELECT max(datetime_finish) from ctm_dpr_trx_slitter_tab WHERE SUBSTRING_INDEX(roll_no, 'F', 1) = a.roll_fix AND coil_number = a.coil_number ) as finish

              FROM

              (

              SELECT
              id,
              trans_date ,
              coil_number ,
              roll_no ,
              start_inspect,
              finish_inspect ,
              finish_process,
              SUBSTRING_INDEX(roll_no, 'F', 1) AS roll_fix

              FROM ctm_dpr_trx_qc_sep_tabs WHERE YEAR(trans_date) = '2020' and substring(roll_no,1,1) not in  ('C','D','E')  AND finish_process is null  limit 1000

            ) a having finish is not null";

      $valueQuery = \Yii::$app->db->createCommand($query)->queryAll();


      foreach ($valueQuery as $key => $value) {
        $id = $value['id'];
        $finish = $value['finish'];

        Yii::$app->db->createCommand()
        ->update('ctm_dpr_trx_qc_sep_tabs', ['finish_process' => $finish ], ['id'=> $id])
        ->execute();

      }


      pr($valueQuery);

    }

    public function actionUpdateFinishSep(){
      $query = "SELECT
                a.id,
                a.coil_number,
                a.roll_no,
                CASE
                	WHEN a.type_roll = 'C'  then (SELECT max(datetime_finish) FROM ctm_dpr_trx_separator_c_tabs WHERE roll_no = a.roll_no)
                	WHEN a.type_roll = 'D'  then (SELECT max(datetime_finish) FROM ctm_dpr_trx_separator_d_tabs WHERE roll_no = a.roll_no)
                	WHEN a.type_roll = 'E'  then (SELECT max(datetime_finish) FROM ctm_dpr_trx_kampf_sep_tabs WHERE roll_no = a.roll_no)
                	END
                	as finish
                FROM

                (

                SELECT
                id,
                coil_number ,
                roll_no ,
                start_inspect ,
                finish_inspect,
                finish_process,
                substring(roll_no,1,1) as type_roll

                FROM ctm_dpr_trx_qc_sep_tabs WHERE YEAR(trans_date) = '2020' and substring(roll_no,1,1) <> 'P'  AND finish_process is null limit 1000

                )a having finish is not null";
      $valueQuery = \Yii::$app->db->createCommand($query)->queryAll();

      foreach ($valueQuery as $key => $value) {

        $id = $value['id'];
        $finish = $value['finish'];

        Yii::$app->db->createCommand()
        ->update('ctm_dpr_trx_qc_sep_tabs', ['finish_process' => $finish ], ['id'=> $id])
        ->execute();

      }

      pr($valueQuery);

    }

    public function actionUpdateFinishStp(){
      $query = "SELECT id,coil_number, trans_id , machine, phase , finish_process FROM ctm_dpr_trx_strip_material_qc_tabs WHERE YEAR(trans_date) = '2021' ";

      $valueQuery = \Yii::$app->db->createCommand($query)->queryAll();


      foreach ($valueQuery as $key => $value) {

        $machine = $value['machine'];
        $trans_id = $value['trans_id'];
        $id = $value['id'];

        if($machine == "BK"){
          $prod = Blowknox::find()->where(['id' => $trans_id ])->asArray()->one();
        }else if ($machine == "KOBE2"){
          $prod = Kobe2::find()->where(['id' => $trans_id ])->asArray()->one();
        }else if($machine == "PB"){
          $prod = Pittsburgh::find()->where(['id' => $trans_id ])->asArray()->one();
        }else if($machine == "VR"){
          $prod = Vonroll::find()->where(['id' => $trans_id ])->asArray()->one();
        }else if($machine == "KOBE1"){
          $prod = Kobe1::find()->where(['id' => $trans_id ])->asArray()->one();
        }

        if(!empty($prod)){

          Yii::$app->db->createCommand()
          ->update('ctm_dpr_trx_strip_material_qc_tabs', ['finish_process' => $prod['datetime_finish']], ['id'=> $id])
          ->execute();

        }

      }

      pr($valueQuery);

    }


    public function actionUpdateFinishProcDaily(){
      // echo "sdds";


      $query = "SELECT
                t2.coil_number as coil_number_caster,
                t2.datetime_finish,
                t1.id,
                min(t2.datetime_start) as finish,
                t1.start_inspect,
                t1.finish_inspect,
                t1.finish_process
                FROM ctm_dpr_daily_qc t1
                LEFT JOIN ctm_dpr_trx_caster_tab t2 on t2.coil_number = t1.coil_number
                WHERE
                t1.coil_number <> 'TRANSFER' AND YEAR(t1.trans_date) = '2020'
                group by t1.coil_number
               ";
      $valueQuery = \Yii::$app->db->createCommand($query)->queryAll();


      foreach ($valueQuery as $key => $value) {
        $id = $value['id'];
        $finish_process = $value['finish'];


        Yii::$app->db->createCommand()
        ->update('ctm_dpr_daily_qc', ['finish_process' => $finish_process], ['id'=> $id])
        ->execute();

      }

      pr($valueQuery);


    }

    public function actionTesAbsen(){
      // echo "sdsd";exit;
      // $data = AbsenceWebOut::find()->limit(10)->asArray()->all();

      $absence_out = AbsenceWebOut::find()->orderBy('created desc')->asArray()->one();

      pr($absence_out);
    }

    public function actionSetNcrStp(){

      $modelStp = StripMaterialInspect::find()->where("YEAR(trans_date) = '2020' AND DATE_FORMAT(trans_date,'%m') = '12' ")->asArray()->all();

      pr($modelStp);
      pr($modelStp);

    }

    public function actionTesExcel(){

      $row=-1;

      $bulan = ["Januari","Februari","Maret","April","Mei"];

      foreach ($bulan as $key => $value) {
        $row += 3;

        echo $row."<br>";
      }


    }


    public function actionUpdateAbsenOut(){

      $dataSc = AbsenceScheduleUpload::find()->orderBy('id desc')->limit('1')->asArray()->one();

      if(!empty($dataSc)){
        $min = $dataSc['min_max']+1;
        $maxdata = AbsenceWeb::find()->select('max(id) as id')->asArray()->one();
        $max = $maxdata['id'];

        $dataloc = AbsenceWeb::find()->where('id between "'.$min.'" and "'.$max.'" ')->asArray()->all();

        if(!empty($dataloc)){

          foreach ($dataloc as $key => $value) {
            $modelOut =  new AbsenceWebOut();
            $modelOut->nik = $value['nik'];
            $modelOut->absen_datetime = $value['absen_datetime'];
            $modelOut->book_code = $value['book_code'];
            $modelOut->code = $value['code'];
            $modelOut->image_url = $value['image_url'];
            $modelOut->reg_from = $value['reg_from'];
            $modelOut->created = $value['created'];

            pr($modelOut);
          }


          $updSch = new AbsenceScheduleUpload();
          $updSch->min_id = $min;
          $updSch->max_id = $max;

          pr($updSch);

        }

      }


      exit;




      // pr($data);




    }

    public function actionAbsenOut(){
      $dataloc = AbsenceWeb::find()->where('id between 34103 and 34438')->asArray()->all();


      // foreach ($dataloc as $key => $value) {
      //   $model = new AbsenceWebOut();
      //   $model->nik = $value['nik'];
      //   $model->absen_datetime = $value['absen_datetime'];
      //   $model->book_code = $value['book_code'];
      //   $model->code = $value['code'];
      //   $model->image_url = $value['image_url'];
      //   $model->reg_from = $value['reg_from'];
      //   $model->created = $value['created'];
      //
      //   $model->save();
      // }





      // $dataout = AbsenceWebOut::find()->limit('1')->orderBy('id desc')->asArray()->all();
      pr($dataloc);
    }


    public function actionAbsenOutInsert(){
      $dataloc = AbsenceWeb::find()->where('id between 29917 and 34438')->asArray()->all();


      // foreach ($dataloc as $key => $value) {
      //   $model = new AbsenceWebOut();
      //   $model->nik = $value['nik'];
      //   $model->absen_datetime = $value['absen_datetime'];
      //   $model->book_code = $value['book_code'];
      //   $model->code = $value['code'];
      //   $model->image_url = $value['image_url'];
      //   $model->reg_from = $value['reg_from'];
      //   $model->created = $value['created'];
      //
      //   $model->save();
      // }





      $dataout = AbsenceWebOut::find()->limit('1')->orderBy('id desc')->asArray()->all();
      pr($dataout);
    }

    public function replaceComma($val){
      $rep1 = str_replace('.','',$val);
      $rep2 = str_replace(',','.',$rep1);
      return $rep2;
    }

    public function actionFlushCache(){
      Yii::$app->cache->flush();
    }

    public function actionTestingRoll(){
      $a = "P200905001F3090520";
      $hasil = substr($a,0,12);
      pr($hasil);
    }

    public function actionCekFlat(){

      $a= ["0","0","0","0"];


      foreach ($a as $key => $value) {

        if($value != 0){
          $notStandFlatness[] = [
                  "nilai" => $value
                ];
        }

      }

      $b = empty($notStandFlatness) ? 0 : $notStandFlatness[0]['nilai'];
      pr($b);






    }


    public function actionCekQuery(){

      // $wetting_tension = "34";
      // $checkWettTension = NcrProblem::find()->where(['field_name' => 'wetting_tension', 'proc_category' => 'FIN'])->andWhere('"'.$wetting_tension.'" < nilai')->asArray()->one();
      // pr($checkWettTension);

      $a = "1034.700";
      $b = "1034.500";

      $c = $a - $b;
      // var_dump($c);
      pr(round($c,2));

      // pr(1034.700 - 1034.500);
    }


    public function actionCekThickness(){
      $thickness_order = $this->replaceComma('14,60');

      $machine = "VR";

      if($machine == "BK"){
        $val_standard = '10';
      }else{
        $val_standard = '2';
      }

      $a['thickness_a'] = '';
      $a['thickness_b'] = '12,50';
      $a['thickness_c'] = '14,50';
      $a['thickness_d'] = '';

      if($modelname == "StripMaterialInspect"){
        $field=['thickness_a','thickness_b','thickness_c','thickness_d'];
      }else{
        $field=['thick_gauge_top','thick_gauge_bot'];
      }


      foreach ($field as $key => $value) {
         $thickness_input = $this->replaceComma($a[$value]);
         if($thickness_input != ''){
           if($thickness_order > $thickness_input){
             $hasil = (($thickness_order - $thickness_input)/$thickness_order) * 100;
           }else{
             $hasil = (($thickness_input - $thickness_order)/$thickness_order) * 100;
           }

            $nilai_persen = number_format($hasil, 2);

            if($nilai_persen > $val_standard){
              $data[] = ["field" => $value,
                      "nilai" => $thickness_input,
                      "nilai_persen" => $nilai_persen,
                      "thickness" => $thickness_order
                    ];
            }

            // echo $nilai_persen;
         }
      }

      $dataProblem=[];
      if(!empty($data)){
        $value = $data[0]['nilai_persen'];
        $dataProblem[] = ["prob_code" => 'PB013',
                        "prob_name" => 'Over Thickness',
                        "nilai" => $value,
                        "is_ncr" => '',
                      ];

      }

      pr($dataProblem);



      exit;


      if($thickness_input > $thickness_order){
        $hasil = (($thickness_input - $thickness_order)/$thickness_order) * 100;
      }else{
        $hasil = (($thickness_order - $thickness_input)/$thickness_order) * 100;
      }



      $format_number1 = number_format($hasil, 2);

      pr($hasil);
      pr($format_number1);
    }



    public function actionTesJam(){

      $_POST['DprMachineRollshop']['trans_date'] = '2022-09-23';
      $_POST['DprMachineRollshop']['start'] = '04:15:00';
      $_POST['DprMachineRollshop']['finish'] = '05:50:00';


      $getActDate = Yii::$app->General->getActDate($_POST['DprMachineRollshop']['trans_date'],$_POST['DprMachineRollshop']['start'],$_POST['DprMachineRollshop']['finish']);

      pr($getActDate);
      exit;


      $_POST['Blowknox']['bk_date'] = '2022-09-23';
      $_POST['Blowknox']['start'] = '04:15:00';
      $_POST['Blowknox']['finish'] = '05:50:00';


      $date = date('Y-m-d', strtotime($_POST['Blowknox']['bk_date']));
			$startx = date("H:i:s", strtotime($_POST['Blowknox']['start']));
			$stopx = date("H:i:s" , strtotime($_POST['Blowknox']['finish']));
			$start = date("Y-m-d H:i:s", strtotime($date.' '.$_POST['Blowknox']['start']));
			$stop = date("H:i:s" , strtotime($date.' '.$_POST['Blowknox']['finish']));
			$datevalid = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +10 minutes"));
			$tanggal = date("Y-m-d");

      if($stopx < $startx){
        $stop = date("Y-m-d H:i:s" , strtotime("+1 days", strtotime($date.' '.$_POST['Blowknox']['finish'])));

      }
      else $stop = date("Y-m-d H:i:s" , strtotime($date.' '.$_POST['Blowknox']['finish']));

      if(date("H:i:s" , strtotime($startx)) < date("H:i:s",strtotime('06:00:00')) && date("H:i:s" , strtotime($startx)) >= date("H:i:s",strtotime('00:00:00'))){
        if($start <= $datevalid && $date == $tanggal){
          $act_date = date("Y-m-d" , strtotime("-1 days", strtotime($start)));
          $bk_date = $date;
        }
        else{
          $act_date = date("Y-m-d" , strtotime($start));
          $bk_date = $tanggal;
        }
      }
      else{
        $act_date = date("Y-m-d" , strtotime($start));
        $bk_date = $date;
      }

      // $hour = date_parse(DowntimeBlowknox::getDatediff($start,$stop));

      pr($act_date." ".$bk_date);
      exit;









      $_POST['Blowknox']['bk_date'] = '2020-10-21';
      $_POST['Blowknox']['start'] = '00:40:00';
      $_POST['Blowknox']['finish'] = '01:40:00';

      // pr($_POST);
      // exit;

      $date = date('Y-m-d', strtotime($_POST['Blowknox']['bk_date']));
			$startx = date("H:i:s", strtotime($_POST['Blowknox']['start']));
			$stopx = date("H:i:s" , strtotime($_POST['Blowknox']['finish']));
			$start1 = date("Y-m-d H:i:s", strtotime($date.' '.$_POST['Blowknox']['start']));
			$stop1 = date("H:i:s" , strtotime($date.' '.$_POST['Blowknox']['finish']));
			$datevalid = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")));

      // pr($datevalid);
      // exit;

			$tanggal = date("Y-m-d");

      if($stopx < $startx){
        $stop1 = date("Y-m-d H:i:s" , strtotime("+1 days", strtotime($date.' '.$_POST['Blowknox']['finish'])));

      }
      else $stop1 = date("Y-m-d H:i:s" , strtotime($date.' '.$_POST['Blowknox']['finish']));

      $datetime_start =  $start1;
      $datetime_finish =  $stop1;

      if(date("H:i:s" , strtotime($startx)) < date("H:i:s",strtotime('06:00:00')) && date("H:i:s" , strtotime($startx)) >= date("H:i:s",strtotime('00:00:00'))){
        if($start1 <= $datevalid && $date == $tanggal){
          $act_date = date("Y-m-d" , strtotime("-1 days", strtotime($start1)));
          $bk_date = $date;
        }
        else{
          $act_date = date("Y-m-d" , strtotime($start1));
          $bk_date = $tanggal;
        }
      }
      else{
        $act_date = date("Y-m-d" , strtotime($start1));
        $bk_date = $date;
      }

      pr($act_date." ".$bk_date);
      pr($datetime_start." ".$datetime_finish);




    }

    /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $searchModel = new CountrySearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Report();

        return $this->render('index', ['modelRange' => $model]);


        $begin = new \DateTime("2021-10-26");
        $end   = new \DateTime("2021-11-01");

        $tgl = [];
        $tanggal = [];

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            // $tgl[] = ['tanggal' => $i->format("Y-m-d")];

            $tgl[] = array("tanggalfull" => $i->format("Y-m-d"),
                           "bulan" => $i->format("F"),
                           "tanggal" => $i->format("d"),
                           "nameDay" => $i->format("D"),
                          );

            $tanggal[] = $i->format("Y-m-d");
        }


        $arr = array();

        foreach ($tgl as $key => $item) {
           $arr[$item['bulan']][$key] = $item;
        }


        $dashboard_Dmbd = \Yii::$app->db->createCommand("CALL get_dmbd_downtime_machine(:tgl_awal,:tgl_akhir,:machine)")
                          ->bindValue(':tgl_awal' , '2021-10-26' )
                          ->bindValue(':tgl_akhir' , '2021-11-01' )
                          ->bindValue(':machine' , 'BK' )
                          ->queryAll();


        foreach ($tanggal as $key => $v) {
            $hasil=0;
            $total =0;
            $persen=0;
            foreach ($dashboard_Dmbd as $key1 => $v2) {
                $hasil += $v2[$v];
                $total += $v2['total'];
                $persen += $v2['persen'];
            }
            $dt['total'] = $total;
            $dt['persen'] = $persen;
            $dt[$v] = $hasil;
        }



        $dashboard_Mtd = \Yii::$app->db->createCommand("CALL get_mtd_downtime_prod(:tgl_awal,:tgl_akhir,:machine)")
                          ->bindValue(':tgl_awal' , '2021-10-26' )
                          ->bindValue(':tgl_akhir' , '2021-11-01' )
                          ->bindValue(':machine' , 'BK' )
                          ->queryAll();

        pr($dashboard_Mtd);exit;



        $desc = [
                  ["kode" => 'AT', "description" => "Available Time"],
                  ["kode" => 'DST', "description" => "Design Time"],
                  ["kode" => 'DT', "description" => "Down Time"],
                  ["kode" => 'RT', "description" => "Running Time"],
                  ["kode" => 'MBD', "description" => "Machine Break Down (%)"],
                  ["kode" => 'ME', "description" => "Machine Effeciency (%)"],
                  ["kode" => 'MU', "description" => "Machine Utilization (%)"]
                ];

        foreach ($desc as $key => $vDesc) {

            $total = 0;
            $totalDw=$totalDsg=$totalRt=$totalAt=0;

            foreach ($dashboard_Mtd as $key2 => $vData) {

              if($vDesc['kode'] == "AT"){
                $total += $vData['available_time'];
              }else if($vDesc['kode'] == "DST"){
                $total += $vData['design_time'];
              }else if($vDesc['kode'] == "DT"){
                $total += $vData['down_time'];
              }else if($vDesc['kode'] == "RT"){
                $total += $vData['running_time'];
              }else if($vDesc['kode'] == "MBD"){
                $totalDw += $vData['down_time'];
                $totalDsg += $vData['design_time'];

                $total = round(($totalDw / $totalDsg) * 100);
              }else if($vDesc['kode'] == "ME"){
                $totalRt += $vData['running_time'];
                $totalDsg += $vData['design_time'];
                $total = round(($totalRt / $totalDsg) * 100);
              }else if($vDesc['kode'] == "MU"){
                $totalAt += $vData['available_time'];
                $totalRt += $vData['running_time'];
                $total = round(($totalRt / $totalAt) * 100);
              }



            }


            $ss[] = array("description" => $vDesc['description'],
                          "total" => $total,
                  );





        }




        foreach ($dashboard_Mtd as $key => $item) {
           $arrMtd[$item['act_date']][$key] = $item;
        }


        foreach ($arrMtd as $key => $v) {

          foreach ($v as $key1 => $vData) {

              foreach ($desc as $key2 => $vDesc) {

                if($vDesc['kode'] == "AT"){
                  $nilai =  $vData['available_time'];
                }else if($vDesc['kode'] == "DST"){
                  $nilai = $vData['design_time'];
                }else if($vDesc['kode'] == "DT"){
                  $nilai = $vData['down_time'];
                }else if($vDesc['kode'] == "RT"){
                  $nilai = $vData['running_time'];
                }else if($vDesc['kode'] == "MBD"){
                  $nilai= $vData['MBD_persen'];
                }else if($vDesc['kode'] == "ME"){
                  $nilai= $vData['ME_persen'];
                }else if($vDesc['kode'] == "MU"){
                  $nilai= $vData['MU_persen'];
                }




              }

              $s[] = [$key => $nilai];

          }


        }

        $arraySingle = call_user_func_array('array_merge', $s);


        foreach ($ss as $key => $v) {

          $ss[$key]['data'] = $arraySingle;
        }

        pr($arraySingle);
        pr($ss);
        pr($arrMtd);


        pr($ss);exit;

        $arrMtd = array();

        foreach ($dashboard_Mtd as $key => $item) {
           $arrMtd[$item['act_date']][$key] = $item;
        }


        foreach ($arrMtd as $key => $v) {


          foreach ($v as $key1 => $v1) {

            $tes[] = array("tgl" => $key,
                           "available_time" => $v1['available_time'],
                           "design_time" => $v1['design_time'],
                           "down_time" => $v1['down_time'],
                           "running_time" => $v1['running_time'],
                           "MBD_Persen" => $v1['MBD_persen'],
                           "ME_Persen" => $v1['ME_persen'],
                           "MU_Persen" => $v1['MU_persen'],
                          );
          }


        }




        return $this->render('index', [
            'tgl' => $arr,
            'dmbd' => $dashboard_Dmbd,
            'listTgl' => $tgl,
            'listTotal' => $dt,

            'mtdTotal' => $ss,
            'mtdData' => $tes,
        ]);

        // return $this->render('index', [
        //     'searchModel' => $sheet_conf,
        //     'dataProvider' => $dataProvider,
        // ]);
    }




    public function actionViewMap(){
      return $this->render('view-map');
    }

    public function actionResultLocation(){
      Yii::$app->response->format = Response::FORMAT_JSON;

      $nik = $_POST['nik'];
      $date_awal = date("Y-m-d" , strtotime($_POST['start']));
      $date_akhir = date("Y-m-d" , strtotime($_POST['finish']));

      $data = TrackLocation::find()->where(['nik' => $nik])->andWhere('date(dt_update) between "'.$date_awal.'" AND "'.$date_akhir.'"  ')->asArray()->all();

      $result = [];
      if(!empty($data)){
        foreach ($data as $key => $value) {
          $result[] = ["nik" => $value['nik'],
                     "latitude" => $value['latitude'],
                     "longitude" => $value['longitude'],
                     "tanggal" => $value['dt_update'],
                    ];
        }

      }

      if(!empty($result)){
        $response = ["code" => "0", "data" => $result , "text" => "Data Ada"];
      }else{
        $response = ["code" => "1", "data" => $result , "text" => "Data Tidak Ada"];
      }

      return $response;

    }

    public function actionFcm(){

		// $regId='dZ7t2DDiOWo:APA91bEyeYsqxniNg7rJy_2-sjf_oPQW8si8BcOeZm1mIXcO_EruLhChaoNbW3RwY3Gq0zzU9fuS5nkJ8SXhZLBsKOVAFJ8gW4NCL7I2oj9kx7kK4akpG3sTNh614dpELwMmY8gBogUU';

    $token= "dyWtfjTYcnI:APA91bHk8dNCI-hUQU9d5yxOD3B2VtYjXK8AoQF9c2IYNY7siTpglIEwJ_dFzEaKCsYTfxkGJktGiX3tcQ52Kagl3KXf-Uk432hIAwNLR37iahRl2pxHrVUV8m6hlYJFxYMtz-IMbGVf";
    $title = "Testing";
    $pesan="Ini adalah pesan";
    $click_action = "PreviewQR";


		$msg = array(
        'body'  => $pesan,
        'title' => $title,
        'click_action' => $click_action
    	);


    	$msg2=array(
    		'title'  => $title,
        	'message' => $pesan,
    		'click_action' => $click_action,
    		// 'idnotif' => $idnotif,
    		// 'jenis' => $jenis
    	);

    	// $msg2 = array(
     //    'title' => 'sadsadsad',
     //    'message' => '9273871283213278387213',
     //    'action' => 'url',
     //    'action_destination' => 'com.example.bakrie.e_pas_inout_TARGET_NOTIFICATION_NOTIF'
     //            // 'icon'  => 'myicon',/*Default Icon*/
     //            // 'sound' => 'mySound'/*Default sound*/
    	// );


			$fields = array
	    (
	        'to'        => $token,
	        'notification'  => $msg,
	        // 'click_action' => 'com.example.bakrie.e_pas_inout_TARGET_NOTIFICATION_NOTIF'
	        'data'  => $msg2
	    );


	    $headers = array
	    (
	        'Authorization: key=AAAA0sMg3qs:APA91bFpN7tdyx0KzvkP-icyi0TF8N9ujI25_nbyBlbviArzCok5A5WkU7OVQG1RplJxGesWDfAyZBIp_5NlcNnUnN8106hT9NRAX7FOqyiVUs-arYa8aFbWGASXbDi_Yt7ZxGWyhwGy',
	        'Content-Type: application/json'
	    );
	#Send Reponse To FireBase Server
	    $ch = curl_init();
	    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	    curl_setopt( $ch,CURLOPT_POST, true );
	    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	    $result = curl_exec($ch );

	    if ($result === FALSE) {
	        die('Curl failed: ' . curl_error($ch));
	    }
	    curl_close($ch);

      pr($result);
	    // return $result;

	}



    public function replaceFormula($input,$namevar){
      // $input = '$input/$output';

      $a = str_replace("$",'$'.$namevar.'->',$input);

      return $a;
    }

    public function actionTes(){

      exit;




      echo PHP_INT_SIZE;exit;


      $coil_number = 'A-0731125-21F';
      $coil_number_parts = 'AD';
      $varCoilpart = ($coil_number_parts == "") ? ' (coil_number_parts is null or coil_number_parts="") ' : ' coil_number_parts in ("'.$coil_number_parts.'") ';

      $string = 'coil_number in ("'.$coil_number.'") and '.$varCoilpart.' and next_machine in ("SEPC","SEPD","SEPE","SLTR")';

      pr($string);exit;

      $a = '';
      $b=5.5;

      $total = (int)$a + (double)$b;
      echo $total;
      exit;


      $period_bln = '09';
      $period_thn = '2020';

      //OPERATOR
      $kpi_operator = \Yii::$app->db->createCommand("CALL kpi_performance_per_operator_by_month(:bulan,:tahun)")
                        ->bindValue(':bulan' , $period_bln )
                        ->bindValue(':tahun' , $period_thn )
                        ->queryAll();

      if(!empty($kpi_operator)){
  			foreach($kpi_operator as $i=>$v){
  				$prod_performance = new KpiOperatorSupervisor();
  				$prod_performance->bln_period = $v['periode_bln'];
  				$prod_performance->thn_period = $v['periode_thn'];
  				$prod_performance->period = $v['periode_bln'].$v['periode_thn'];
  				$prod_performance->kode = 'OPERATOR';
  				$prod_performance->machine = $v['machine'];
  				$prod_performance->nik = $v['nik'];
          $prod_performance->nama = $v['nama'];
          $prod_performance->eqv_out = $v['eqv_factor'];
          $prod_performance->target = $v['target'];
          $prod_performance->downtime = $v['downtime'];
          $prod_performance->schedule_time = $v['schedule_time'];
          $prod_performance->runtime = $v['runtime'];
          $prod_performance->working_time = $v['working_time'];

          $design_time = $v['working_time'] - $v['schedule_time'];
          $productivity = @($v['eqv_factor']/($design_time/60));
          $down_time_ratio = ($v['downtime'] > $design_time) ? @(1 - ($design_time/$v['downtime'])) : @($v['downtime']/$design_time);

          $prod_performance->productivity = (!is_nan($productivity)) ? $productivity : '0';
          $prod_performance->down_time_ratio = (!is_nan($down_time_ratio)) ? $down_time_ratio : '0';



          echo $design_time;
  				pr($prod_performance);
  			}
  		}

      exit;


      $data = TableTestData::find()->asArray()->one();
      $formula = TableTestFormula::find()->asArray()->all();

      if(!empty($data)){
          foreach($data  as $i => $v){
              $$i = $v;
          }
      }
      $arr = get_defined_vars();

      foreach ($formula as $key => $value1) {
        $str = $value1['formula'];
        $value = eval("return ($str);");

        pr($value);
      }




      exit;



      foreach ($formula as $key => $value) {
        $value1 = $this->replaceFormula($value['formula'],'data');
        $hasil = eval("return $value1;");
        pr($hasil);
      }

      exit;

      // $a='122';
      // $b='232';
      // $c='';
      //
      // if($a == ''){
      //   echo "app1";
      // }else if($b == ''){
      //   echo "app2";
      // }else{
      //   echo "app3";
      // }
      //
      // exit;


      $coil_number = '200311052-3';
      $coil_number_parts = '200311052-3-A+200311052-3-B';
      $from_machine = 'VR';



      $weight = "1500";

      $query = new Query;
      $query->select('weight')
  		->from('v_lov_separator_grouped')
  		->where(['v_lov_separator_grouped.coil_number'=>$coil_number])
  		->andWhere(['v_lov_separator_grouped.coil_number_parts'=>$coil_number_parts])
  		->andWhere(['v_lov_separator_grouped.from_machine'=>$from_machine]);
  		$command = $query->createCommand();
  		$weight_dpo = $command->queryOne();

      // if($weight_dpo <= $weight){
      //   $r ="ada";
      // }else{
      //   $r = "tidak ada";
      // }

      pr($weight_dpo['weight']);
      // pr($r);
    }


    public function actionZipFilter(){
      $filename = "qrcode-absen3I.zip";
      $source = realpath('../uploads/files/qrcode-absen');
      $destination = '../uploads/files/'.$filename;

      $a = $this->ZipFilter($source, $destination,true);
      pr($a);
    }


    function ZipFilter($source,$destination,$flag = ''){
      if (!extension_loaded('zip') || !file_exists($source)) {
         return false;
      }

      $zip = new ZipArchive();
      if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
         return false;
      }

      $source = str_replace('\\', '/', realpath($source));
      if($flag)
      {
          $flag = basename($source) . '/';
      }

      if (is_dir($source) === true)
      {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
          $file = str_replace('\\', '/', realpath($file));
          if (strpos($file, '000787') !== false) {
            $file1 = str_replace('\\', '/', realpath($file));
          }

              pr($file1);
        }


      }

    }


    function Zip($source, $destination,$flag = '')
    {
      if (!extension_loaded('zip') || !file_exists($source)) {
         return false;
      }

      $zip = new ZipArchive();
      if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
         return false;
      }

      $source = str_replace('\\', '/', realpath($source));
      if($flag)
      {
          $flag = basename($source) . '/';
      }

      if (is_dir($source) === true)
      {
          $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

          foreach ($files as $file)
          {

              $file = str_replace('\\', '/', realpath($file));

              if (strpos($flag.$file,$source) !== false) { // this will add only the folder we want to add in zip

                  if (is_dir($file) === true)
                  {
                      $zip->addEmptyDir(str_replace($source . '/', '', $flag.$file . '/'));

                  }
                  else if (is_file($file) === true)
                  {
                      $zip->addFromString(str_replace($source . '/', '', $flag.$file), file_get_contents($file));
                  }
              }
          }
      }
      else if (is_file($source) === true)
      {
          $zip->addFromString($flag.basename($source), file_get_contents($source));
      }

      return $zip->close();
    }



    public function actionZip2(){

      $filename = "qrcode-absen3I.zip";
      $source = realpath('../uploads/files/qrcode-absen');
      $destination = '../uploads/files/'.$filename;

      $this->Zip($source, $destination,true);


      if(file_exists($destination)){
        \Yii::$app->response->sendFile($destination)->send();
        // unlink($path);
      }else{
        echo "gagal";
      }

      exit;


    }

    public function actionCheckQr(){
      $rootPath = realpath('../uploads/files/qrcode-absen');
      $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
      );

      foreach ($files as $name => $file){
          $filePath = $file->getRealPath();
          $relativePath = substr($filePath, strlen($rootPath) + 1);
          $exp = explode("\\",$relativePath);
          $relativePath2 = isset($exp[0]) ? $exp[0] : $relativePath;

          if(!empty($relativePath2)){
            $nik[] = ["nik" => $relativePath2];
          }
      }

      $listEmp=ArrayHelper::getColumn($nik,'nik');
      $b = implode(",",$listEmp);
      pr($b);

    }


    public function actionZip(){

      // $rootPath =
      // pr($rootPath);exit;

      $zip = new ZipArchive();
      $download = '../uploads/files/adcs.zip';
      $zip->open($download, ZipArchive::CREATE | ZipArchive::OVERWRITE);
      $rootPath = realpath('../uploads/files/qrcode-absen');
      $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
      );

      foreach ($files as $name => $file){
          if (!$file->isDir()){
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);
            $exp = explode("\\",$relativePath);
            $relativePath2 = isset($exp[1]) ? $exp[1] : $relativePath;
            $dir2 = isset($exp[0]) ? $exp[0] : $relativePath;

            // pr($filePath);
            // pr($relativePath2);

            // exit;

              // $zip->addDir($file);

              // if (!is_dir($relativePath)) {
              //     if (!mkdir($relativePath, 0755, true)) {
              //       echo "dsd";
              //       return 0;
              //     }
              //
              //     $zip->addFile($filePath, $relativePath);
              // }

              // if($zip->addEmptyDir($dir2)) {
              //     $zip->addFile($filePath, $relativePath2);
              // }

            // Add current file to archive
            $zip->addFile($filePath, $relativePath2);

          }

      }

      $zip->close();

        exit;



      $zip = new ZipArchive;
      $download = '../uploads/files/adcs.zip';
      $zip->open($download, ZipArchive::CREATE);
      foreach (glob("../uploads/files/qrcode-absen/*") as $file) { /* Add appropriate path to read content of zip */
          $zip->addFile($file);
          // pr($file);
          // exit;
      }



      $zip->close();

      // pr($zip);
      // exit;

    header('Content-Type: application/zip');
    header("Content-Disposition: attachment; filename = $download");
    header('Content-Length: ' . filesize($download));
    header("Location: $download");
    exit;


      $zipname = '../uploads/files/adcs.zip';
      $zip = new ZipArchive();
      $zip->open($zipname, ZipArchive::CREATE);

      // pr($zip);
      // exit;

      if ($handle = opendir('.')) {
        while (false !== ($entry = readdir($handle))) {
          if ($entry != "." && $entry != ".." && !strstr($entry,'.jpg')) {
              $zip->addFile($entry);
          }
        }
        closedir($handle);
      }

      // pr($handle);
      // exit;

      $zip->close();

      header('Content-Type: application/zip');
      header("Content-Disposition: attachment; filename='adcs.zip'");
      header('Content-Length: ' . filesize($zipname));
      header("Location: adcs.zip");


    }

    public function actionCheckProfileCode(){
      $my_array = DailyQc::find()->where('profile_code is not null and out_of_spec is null')->asArray()->all();


      $filter = "coil_number";

      $new_array = array_filter($my_array, function($var) use ($filter){
          return ($var == $filter);
      });

      // foreach ($exists as $key => $value) {
      //   $data[] = ["id" => $value['id'],
      //              "coil_number" => $value['coil_number'],
      //              "si" => $value['si'],
      //              "fe" => $value['fe'],
      //              "cu" => $value['cu'],
      //              "mn" => $value['mn'],
      //              "mg" => $value['mg'],
      //              "zn" => $value['zn'],
      //             ];
      //
      // }

      pr($new_array);

    }

    public function actionUpdateGrainSize(){
      $sql = "SELECT
                  id,
                  coil_number,
                  trans_date,
                  grain_size
                  FROM
                  ctm_dpr_daily_qc
                  WHERE
                  coil_number <> 'TRANSFER'
                  AND
                  grain_size != ''
               ";
      $valueSql = \Yii::$app->db->createCommand($sql)->queryAll();

      foreach ($valueSql as $key => $value) {
        $grain = explode("/",$value['grain_size']);

        // pr($grain);

        $grain_top = isset($grain[0]) ? $grain[0] : '';
        $grain_bot = isset($grain[1]) ? $grain[1] : '';

        //
        $b[] = ["id" => $value['id'],
                "coil_number" => $value['coil_number'],
                "grain_size" => $value['grain_size'],
                "top" => $grain_top,
                "bot" => $grain_bot,
               ];

         Yii::$app->db->createCommand()
         ->update('ctm_dpr_daily_qc', ['grain_size_top' => $grain_top , 'grain_size_bot' => $grain_bot], ['id'=>$value['id']])
         ->execute();


      }

      pr($b);

    }

    public function actionUpdateProdTypeQc(){
      $sql = "SELECT
              id,
              trans_date,
              coil_number,
              prod_type,
              alloy,
              SUBSTR(coil_number,-1) as type
              FROM
              ctm_dpr_daily_qc
              WHERE
              coil_number <> 'TRANSFER'
              AND
              prod_type is null";

      $valueSql = \Yii::$app->db->createCommand($sql)->queryAll();

      foreach ($valueSql as $key => $value) {
        if($value['type'] == "F"){
          $prod_type = 'FOIL';
        }else if($value['type'] == "C"){
          $prod_type = 'COIN';
        }else if($value['type'] == "S"){
          $prod_type = 'SHEET';
        }else{
          $prod_type = '';
        }

        $b[] = ["id" => $value['id'],
                "coil_number" => $value['coil_number'],
                "type" => $prod_type
               ];

         Yii::$app->db->createCommand()
         ->update('ctm_dpr_daily_qc', ['prod_type' => $prod_type], ['id'=>$value['id']])
         ->execute();

      }

      pr($b);

    }


    public function actionEx(){

      return $this->render('/report/data-analisa/excel', [
          // 'model' => $model,
      ]);

    }


    function getDatediff($start,$stop)
  	{
  			$connection = \Yii::$app->db;
  			$model = $connection->createCommand("select (TIMEDIFF('".$stop."' , '".$start."')) as timediff");

  			$timediff = $model->queryAll();
  			// print_r($timediff);exit;
  			return($timediff[0]['timediff']);
  	}


    public function actionCheckComposition(){

      $field = "fe";
      $data = DailyQc::find()->where(['id' =>'6106'])->asArray()->one();

      if(!empty($data)){
        $field_name = explode(',',$data['field_name_prob_qc']);

        if (in_array($field, $field_name)){
          echo "1";
        }else{
          echo "0";
        }

        pr($field_name);
        exit;
      }else{
        echo "0";
      }




    }

    public function actionTesPost(){

      $qc_code = $_POST['qc_code'];

      $code = QcCode::find()->where(['qc_code' => $qc_code])->asArray()->one();
      $modelname = $code['model_name'];

      $data=[];
      $problemIsNcr=[];

      foreach ($_POST[$modelname] as $key => $value) {

        $nilai = is_array($_POST[$modelname][$key]) ? $_POST[$modelname][$key][0] : $_POST[$modelname][$key];
        $problem = NcrProblem::find()->where(['field_name' => $key,'nilai' => $nilai])->asArray()->one();

        if(!empty($problem)){
          $data[]= $problem;
        }

      }


      foreach ($data as $key => $value) {
        if($value['is_ncr'] == 'Y'){
          $problemIsNcr[] =$value['prob_name'];
        }
      }

      if(!empty($problemIsNcr)){
        $textProbNcr = "Ada Kemungkinan Deteksi NCR di :  ". implode(", ",$problemIsNcr)." , Klik OK jika ingin melanjutkan , Klik Cancel jika ingin merivisi kembali ? ";
        $probNcr = ["code" => 1 ,"text" => $textProbNcr];
      }else{
        $probNcr=["code" => 0];
      }

      echo Json::encode($probNcr);


      // pr($_POST['StripMaterialInspect']['load_no']);
    }


    public function actionSaveDataProb(){

      $error=1;

      $qc_code = $_POST['qc_code'];

      $code = QcCode::find()->where(['qc_code' => $qc_code])->asArray()->one();
      $modelname = $code['model_name'];

      if(!empty($_POST[$modelname])){

        foreach ($_POST[$modelname] as $key => $value) {
          $nilai = is_array($_POST[$modelname][$key]) ? $_POST[$modelname][$key][0] : $_POST[$modelname][$key];
          $problem = NcrProblem::find()->where(['field_name' => $key,'nilai' => $nilai])->asArray()->one();
          if(!empty($problem)){
            $data[] = $problem;
          }
        }

        // pr($data);

        if(!empty($data)){
          foreach ($data as $key => $value) {
            $model = new NcrQcProblem();
            $model->qc_id = $_POST[$modelname]['qc_id'];
            $model->qc_code = $qc_code;
            $model->prob_code = $value['prob_code'];
            $model->prob_name = $value['prob_name'];
            $model->prob_value = $value['nilai'];
            $model->is_ncr = $value['is_ncr'];

            if(!$model->save()){
              $error=0;
            }

            // $model->prob_code =
          }
        }

      }

      return $error;


    }


    public function cekFieldJumlahext($code,$key,$input){


         $problem = "SELECT
                   t2.*
                   FROM
                   ctm_dpr_master_cust_profile_tab t1
                   LEFT JOIN ctm_dpr_master_cust_prof_detail_tab t2 on t1.id = t2.header_id
                   WHERE
                   t1.profile_code = '$code'
                   and
                   t2.field_name = '$key'
                  ";
         $valueProblem = \Yii::$app->db->createCommand($problem)->queryOne();

         $cektotal=0;
         $hasil='';
         if(!empty($valueProblem)){
           if($valueProblem['field_jumlah'] != ''){

             $fieldTotal = explode(",",$valueProblem['field_jumlah']);

             foreach ($fieldTotal as $key => $value) {
               $nilaiTotal = str_replace(",",".",$input[$value]);
               $cektotal += $nilaiTotal;
             }


           }

           $hasil = $cektotal.":".$valueProblem['type'];

         }



         return $hasil;



    }


    public function actionCheckNcrDaily(){

      // pr($_POST);
      // exit;

      // $id = $_POST['DailyQc']['id'];
      // $data = DailyQc::find()->where(['id' =>$id])->asArray()->one();

      $profile_code = $_POST['DailyQc']['profile_code'];
      $data = Profile::find()->where(['profile_code' => $profile_code])->asArray()->one();

      if(!empty($data)){

        // $alloy_code = $data['alloy'];
        //
        // $alloy_type = ($alloy_code == '1100') ? (($data['prod_type'] == '') ? 'AMCOR' : 'COIN') : $data['prod_type'];

        $code = $data['profile_code'];

        $problemList=[];

        foreach ($_POST['DailyQc'] as $key => $value) {

          $nilaiext = $this->cekFieldJumlahext($code,$key,$_POST['DailyQc']);

          // $b[] = ["key" =>$key,
          //         "type" => $valueProblem
          //    ];


          if(!empty($nilaiext)){

            $nilaiextfix = explode(":",$nilaiext);

            if($nilaiextfix[0] != 0){
              $nilai = $nilaiextfix[0];
            }else{
              $nilai = ($_POST['DailyQc'][$key] == '') ? '0' : str_replace(",",".",$_POST['DailyQc'][$key]);
            }

            $type = $nilaiextfix[1];

          }else{

            $nilai = ($_POST['DailyQc'][$key] == '') ? '0' : str_replace(",",".",$_POST['DailyQc'][$key]);
            $type='';
          }



          $nilaifix = str_replace("'","",$nilai);


          if($type == "STRING"){

            $problem = "SELECT
                       t2.*
                       FROM
                       ctm_dpr_master_cust_profile_tab t1
                       LEFT JOIN ctm_dpr_master_cust_prof_detail_tab t2 on t1.id = t2.header_id
                       WHERE
                       t1.profile_code = '$code'
                       and
                       t2.field_name = '$key'
                       and
                        '$nilaifix' not between t2.value and t2.value2
                      ";

          }else{

            $problem = "SELECT
                       t2.*
                       FROM
                       ctm_dpr_master_cust_profile_tab t1
                       LEFT JOIN ctm_dpr_master_cust_prof_detail_tab t2 on t1.id = t2.header_id
                       WHERE
                       t1.profile_code = '$code'
                       and
                       t2.field_name = '$key'
                       and
                       '$nilaifix' not between t2.min and t2.max

                      ";
          }



         $valueProblem = \Yii::$app->db->createCommand($problem)->queryOne();

         $cektotal = 0;
         if(!empty($valueProblem)){
           $problemList[] = $valueProblem;
         }


        }

        // pr($problemList);
        // exit;

        $problemListTotal=[];

        foreach ($_POST['DailyQc'] as $key => $value) {
          $problemWithTotal = "SELECT
                     t2.*
                     FROM
                     ctm_dpr_master_cust_profile_tab t1
                     LEFT JOIN ctm_dpr_master_cust_prof_detail_tab t2 on t1.id = t2.header_id
                     WHERE
                     t1.profile_code = '$code'
                     and
                     t2.field_name = '$key'
                     and
                     t2.total is not null
                    ";
          $valueProblemWithTotal = \Yii::$app->db->createCommand($problemWithTotal)->queryOne();

          $cektotal = 0;
          if(!empty($valueProblemWithTotal)){
            $fieldTotal = explode(",",$valueProblemWithTotal['field_total']);
            foreach ($fieldTotal as $key => $value) {
              $nilaiTotal = ($_POST['DailyQc'][$value] == '') ? '0' : str_replace(",",".",$_POST['DailyQc'][$value]);
              $cektotal += $nilaiTotal;
            }
              $namefield = $valueProblemWithTotal['field_name'];
              $nilai = $valueProblemWithTotal['total'];

              // if($cektotal > $nilai){
              //   echo "".$valueProblemWithTotal['field_name']." lebih besar";
              // }else{
              //   echo "".$valueProblemWithTotal['field_name']." lebih kecil";
              // }

              if($cektotal > $nilai){
                $problemListTotal[] = $valueProblemWithTotal;
              }

              // if()

              // echo "".$valueProblemWithTotal['field_name']." : ".$nilai." : ".$cektotal;
          }

        }




        $problemFinal = array_merge($problemList,$problemListTotal);

        $problemFinalfix = array_unique($problemFinal, SORT_REGULAR);


      }


      // pr($b);
      // exit;


      if(!empty($problemFinalfix)){
        foreach ($problemFinalfix as $key => $value) {
            $Listproblem[] =$value['description'];
        }
      }



      if(!empty($Listproblem)){
        $textProbNcr = "Ada Kemungkinan Deteksi tidak standar di :  ". implode(", ",$Listproblem)." ? ";
        $probNcr = ["code" => 1 ,"text" => $textProbNcr];
      }else{
        $probNcr=["code" => 0];
        $textProbNcr ="";
      }

      echo Json::encode($probNcr);

    }

    public function actionTes2(){


      // $urlIndex = "transaction/cogs/upload-ledger";
      // $urlReq = "transaction/cogs/upload-biaya-all";

      $urlIndex = "transaction/blowknox/index";
      $urlReq = "transaction/blowknox/create";

      // if($urlIndex == $urlReq){
      //   echo "sama";
      // }else{
      //   echo "tidak sama";
      // }
      //
      // exit;


      $a1 = explode("/",$urlIndex);
      $a2 = explode("/",$urlReq);


      $result=count(array_diff($a1,$a2));
      print_r($result);
      exit;


      $count = count(array_intersect($a1, $a2));

      pr($a1);
      pr($a2);
      pr($count);

      exit;

      // $as = strpos("master/customer-profile/index","master/customer");
      // $as = strpos("master/customer/index","master/customer");

      // $as = strpos("master/customer-profile/index","master/customer");
      //
      // $a = 'How are-pub you?';
      //
      // if (strpos($a, 'are') !== false) {
      //     echo 'true';
      // }else{
      //     echo "false";
      // }

      // $as = strpos("master/customer","master/customer-profile/index");
      // $as = strpos("master/customer","master/customer/index");

      // pr($sd);

    }



    public function actionTes1(){

      $a=0.15;
      $b=0.15;

      if($a > $b){
        echo "lebih besar";
      }else{
        echo "lebih kecil";
      }

      // if($a == $b){
      //   echo "sama";
      // }else if($a > $b){
      //   echo "lebih besar";
      // }else{
      //   echo "lebih kecil";
      // }

      // echo "sadasd";



      // $no=0;
      // for ($i=0; $i <=3 ; $i++) {
      //   $no++;
      //   $htmls []='
      //     <tr>
      //       <td>'.$no.'</td>
      //       <td> <input type="text" id="qcslitter-'.$i.'-roll_no" class="form-control" name="QcSlitter['.$i.'][roll_no]" > </td>
      //
      //     </tr>
      //   ';
      //
      // }
      //
      // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			// return [
			// 	'test' => $htmls,
			// ];

      // echo Json::encode($htmls);

      // $model = FoilstockRequest::find()->where(['id'=>'10'])->one();
      //
      // echo "<pre>";
      // pr($model);
      // exit;

      // $dashboard_time_eff = \Yii::$app->db->createCommand("call time_eff_dashboard(:tanggal)")
      //                 ->bindValue(':tanggal' , date('Y-m-d', strtotime('-1 days')) )
			// 		  ->queryAll();
      //
      // pr($dashboard_time_eff);
      // exit;



//       $myArray = [
//  'name'             => 'bert',
//  'age'              => 42,
//  'My email address' => 'my-email@example.com', //no problems with spaces in the key
//  'html'             => '<div style="font-size: 2em">asdf</div>',
// ];
//
// $sql = "SELECT
// t2.porosity_min,
// t2.porosity_max,
// t2.winding,
// t2.surface,
// t2.core_ext_min,
// t2.core_ext_max,
// t2.remarks,
// t2.est_no
// FROM
// ctm_dpr_trx_est_req_detail_tab t1
// LEFT JOIN ctm_dpr_trx_est_request_tab t2 on t2.id = t1.header_id
// WHERE
// t1.id = 1059 ";
//
// $valuesql = \Yii::$app->db->createCommand($sql)->queryOne();
//
//   echo "<pre>";
//   pr($myArray);
//
//   pr($valuesql);
//   exit;



      // $email = 'donny.kusdianto@internal.office';
      // $message = Yii::$app->mailer->compose()
      // ->setFrom('admin@internal.office')
      // ->setTo($email)
      // ->setSubject('Tes');
      //
      // $message->setHtmlBody('tes');
      //
      // pr($message->send());

      // $sql = "SELECT
      //         est_no,
      //         est_det_id,
      //         create_by
      //         FROM ctm_dpr_trx_foilstock_request_tab";
      //
      // $valuesql = \Yii::$app->db->createCommand($sql)->queryAll();
      //
      //
      // foreach ($valuesql as $value) {
      //   pr($value['est_det_id']);
      //     Yii::$app->db->createCommand()
      //   ->update('ctm_dpr_trx_est_req_detail_tab', ['is_request'=>'1'], ['id'=>$value['est_det_id']])
      //     ->execute();
      // }


    //   Yii::$app->db->createCommand()
    // ->update('ctm_dpr_trx_qc_sep_tabs', [$var_esc_date=>$escale_date, $var_esc_remark=>$escal_remark,$var_esc_name => $escal_by, 'modi_by'=>Yii::$app->user->identity->id, 'modified'=>date('Y-m-d H:i:s')], ['id'=>$id])
    //   ->execute();

      // echo "<pre>";
      // pr($value);
      exit;


      // $query = Period::find()->where('periods is null')->asArray()->all();
      // echo"<pre>";pr($query);exit;

      // $status = Status::find()->where(['field_name'=>'state'])->asArray()->all();
      // $listStatus=ArrayHelper::map($status,'kode','name');
      //
      // $listStatus['C'] ='CANCEL';
      //
      // pr($listStatus);

      // $query = QcSlitter::find()->where(['machine'=>['SLTR','EXT']])->andWhere(Yii::$app->General->getOpenPeriod('QCSLTR','read','trans_date'))->andWhere(['is_delete'=>null]);
      //
      // $query2 = QcSlitter::find()->where(['machine'=>['SLTR','EXT']])->andWhere('roll_no = "0013100101007" ')->andWhere(['is_delete'=>null]);
      //
      // $unionQuery = new Query;
			// // $query3 = $unionQuery->select('*')->from(['a'=>$query->union($query2, false)]);
      //
      // $query3 = $query->union($query2,false)->all();
      //
      // pr($query3);
      // exit;

      // $bln_now='06';
      // $thn_now='2020';
      //
      // $sql = "SELECT
      //         t1.*,
      //         t2.joint as jum_joint
      //         FROM
      //         ctm_dpr_trx_packing_tab t1
      //         LEFT JOIN ctm_dpr_final_inspect_tab t2 on t2.roll_no = t1.roll_no_sep
      //         WHERE
      //         month(t1.trans_date) = '$bln_now'
      //         and
      //         year(t1.trans_date) = '$thn_now'
      //         and
      //         (t1.roll_no like 'C%' or t1.roll_no like 'D%' or t1.roll_no like 'E%' or t1.roll_no like 'P%' or t1.ex_machine='EXT')
      //         order by t1.trans_date,t1.load_no";
      // $value = \Yii::$app->db->createCommand($sql)->queryAll();
      //
      // $packing = Packing::find()->where('month(trans_date) = "'.  $bln_now . '" and year(trans_date) = ' . $thn_now . ' and (roll_no like "C%" or roll_no like "D%" or roll_no like "E%" or roll_no like "P%" or ex_machine="EXT")')->orderBy('trans_date, load_no')->asArray()->all();
      //
      // echo "<pre>";
      // pr($value);
      // exit;

      // $error = 1;
      //
      // if($error == TRUE){
      //   echo "tidak error";
      // }else{
      //   echo "error";
      // }

      // array_push($listStatus,$listambah);
      //
      // pr($listStatus);

      // $original_roll_before = "SELECT * FROM ctm_dpr_trx_est_req_detail_tab WHERE id = '880' ";
      // $valueOriginal = \Yii::$app->db->createCommand($original_roll_before)->queryOne();
      //
      // $actual_roll = "SELECT
      // t1.est_det_id,
      // ifnull(SUM(actual_roll),0) as jum_act_roll
      // FROM
      // ctm_dpr_separator_plan_tab t1
      // LEFT JOIN ctm_dpr_separator_plan_detail_tab t2 on t2.plan_header_id = t1.id
      // where
      // t1.est_det_id = '880'
      // group by t1.est_det_id";
      // $valuePlanRoll = \Yii::$app->db->createCommand($actual_roll)->queryOne();
      //
      //
      // $original_roll_end = (int)$valueOriginal['qty_roll'] - (int)$valuePlanRoll['jum_act_roll'];
      //
      //
      //
      // echo "<pre>";
      // pr($valueOriginal['qty_roll']);
      // pr($valuePlanRoll);
      // pr($original_roll_end);
      // exit;

      // $downdate = '2020-05-25';
      // $start = '01:05:00';
      // $finish = '02:00:00';
      //
      // $getActDate = Yii::$app->General->getActDate($downdate,$start,$finish);
      //
      // echo "<pre>";
      // print_r($getActDate);
      // exit;

      // $start = '2020-06-11 08:46:05';
      // $stop = '2020-01-01 21:45:00';
      //
      //
      // $as = date("Y-m-d H:i:s", strtotime($start." +704 minutes"));
      //
      // pr($as);
      // exit;
      //
      // // if ($start > $stop){
      // //   echo "melebihi";
      // // }else{
      // //   echo "tidak";
      // // }
      // // exit;
      //
      // $hour = date_parse($this->getDatediff($start,$stop));
      //
  		// $totaltime = ($hour['hour']*60)+(int)$hour['minute'];
      //
      // pr($totaltime);

      // $model->datetime_start =  $getActDate['datetime_start'];
      // $model->datetime_finish =  $getActDate['datetime_stop'];
      // $model->act_date = $getActDate['act_date'];
      // $model->asmbl_date = $getActDate['input_date'];
      // $model->runtime = $getActDate['totaltime'];
      //
      //
      // echo "adasd";
    }

    /**
     * Displays a single Country model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Country model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Country();


        $data = Country::find()->select(new \yii\db\Expression('concat(code,"||",name) as text'))->asArray()->all();

        if(!empty($data)) $country = ArrayHelper::getColumn($data, 'text');

        // pr($country);exit;

        if ($model->load(Yii::$app->request->post())) {

            pr($_POST);exit;
            return $this->redirect(['view', 'id' => $model->code]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'country' => $country,
            ]);
        }
    }

    public function actionCountryList($q = null,$population=null) {

      Yii::$app->response->format = Response::FORMAT_JSON;

      // $data = Country::find()->select(new \yii\db\Expression('concat(code,"||",name) as text'))->asArray()->all();
      //
      // $out = [];
      // foreach ($data as $d) {
      //   $out[] = ['value' => $d['text']];
      //   // $out[] = $d['text'];
      // }
      // // echo Json::encode($out);
      //
      // return $out;

      $query = new Query;

      $query->select(new \yii\db\Expression('concat(code,"||",name) as text , name , code' ))
          ->from('country')
          ->where('name LIKE "%' . $q .'%"  and population = '.$population.' ')
          ->orderBy('name');
      $command = $query->createCommand();
      $data = $command->queryAll();
      $out = [];
      foreach ($data as $d) {
          // $out[] = $d['text'];
          $out[] = ['value' => $d['text'] , 'name' => $d['name'] , 'code' => $d['code']];
      }

    // echo Json::encode($out);

      return $out;


      // $data = Country::find()->select(new \yii\db\Expression('concat(code,"||",name) as text'))->asArray()->all();
      //
      // if(!empty($data)) $country = ArrayHelper::getColumn($data, 'text');
      //
      //  pr($country);



    }

    /**
     * Updates an existing Country model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->code]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Country model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Country the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Country::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

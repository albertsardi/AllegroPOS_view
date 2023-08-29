<?php
   
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Transaction;

class ApiController extends MainController {
	
	// api ini hanya dipakai tuk ambil data tuk android
	function trans_list($jr) {
		switch($jr) {
			case 'DO':
			case 'SI':
			case 'IN':
				$dat = DB::table('transhead')->selectRaw("TransNo,TransDate,AccName,Total,'' as Status,CreatedBy,id")->whereRaw("left(TransNo,2)='$jr' ")
						->limit(5)
						->get();
				foreach($dat as $dt) {
					$dt->Status = 'OPEN'; //$this->gettransstatus($link, $jr);   
				}
				$data = [
					'jr'        => $jr,
					'caption'   => $this->makeCaption($jr),
					'data'      => $dat,
				];
				break;
			
			default:
				return "no list from $jr";
				break;
		}
		return $data;
	}

	// api ini hanya dipakai tuk ambil data tuk android
	function trans($jr, $id) {
		switch($jr) {
			case 'DO':
			case 'SI':
			case 'IN':
				$dat = DB::table('transhead as th')
						->whereRaw("left(TransNo,2)='$jr' ")
						->where('th.TransNo', $id)
						->get();
				$detail = DB::table('transdetail as td')
						->where('td.TransNo', $id)
						->get();
				$data = [
					'jr'        => $jr,
					'caption'   => $this->makeCaption($jr).' #'.$id,
					'data'      => $dat,
					'detail'    => $detail,
				];
				break;
			
			default:
				return "no list from $jr";
				break;
		}
		return $data;
	}

}

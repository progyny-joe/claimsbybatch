<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Field;
use App\Models\Field_Taxonomy;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date, $file)
    {
        /*$fields = Field::select('fields.value', 'field_taxonomy_table.title')
            ->join('field_taxonomy_table', 'fields.field_taxonomy_id', '=', 'field_taxonomy_table.id')
            ->join('files', 'field_taxonomy_table.file_id', '=', 'files.id')
            ->where('files.parsed_title', '=', $file)
            ->get();
        dd($fields);*/
        $fields = File::join('file_field_taxonomy_table as fftt', 'fftt.file_id', '=', 'files.id')
            ->join('field_taxonomy_table as ftt', 'fftt.field_taxonomy_id', '=', 'ftt.id')
            ->where('files.parsed_title', '=', $file)
            ->select('ftt.title', 'ftt.id')
            ->groupBy('ftt.title');
        if($file === "claimsbybatch") {
            $fields = $fields->where('title', '=', 'claim_status_ud')
                            ->orWhere('title', '=','claim_procedure_status_ud')
                            ->orWhere('title', '=','from_service_date')
                            ->orWhere('title', '=', 'clean_claim_date')
                            ->orWhere('title', '=','received_date')
                            ->orWhere('title', '=','benefitplan_ud');
        }
        $titleArr = [];
        //loop through all of the results
        foreach($fields->get() as $field) {
            //split the title at the underscore
            $title = explode('_', $field->title);
            $count = 0;
            $isDate = false;
            $type = "string";
            $arrValues = [];
            //loop through the title arr
            foreach($title as $word) {
                if($word === "date") {
                    $isDate = true;
                }
                //remove the "ud" from the title arr
                if($word === "ud") {
                    unset($title[$count]);
                } else {
                    //if it's benefit plan, then split it up
                    if($title[$count] === "benefitplan") {
                        $title[$count] = "benefit plan";
                    }
                    //make each word proper case
                    $title[$count] = ucfirst($title[$count]);
                }
                $count++;
            }
            if($isDate) {
                $titleArr['date'][] = ['title' => implode(' ', $title), 'db_title' => $field->title, 'value' => $arrValues];
            } else {
                $arrValues = Field_Taxonomy::select('value')->distinct()
                        ->join('fields', 'fields.field_taxonomy_id', '=', 'field_taxonomy_table.id')
                        ->where('title', '=', $field->title)
                        ->get();
                $titleArr['other'][] = ['title' => implode(' ', $title), 'db_title' => $field->title, 'value' => $arrValues];
            }
        }

        return view("reports.main")->with('data', $titleArr);
    }

    public function getReport(Request $request)
    {
        $data = [];
        foreach($request->input() as $key => $value) {
            $date = "";
            switch($key) {
                case "_token":
                case "fromDate":
                case "toSelect":
                    break;
                case "fromSelect":
                    break;
                case "toDate":
                    break;
                default:
                    $data[] = "$key LIKE '%$value%'";
                    echo "key: $key | value:$value || ";
                break;
            }
        }
        /*$calls = IncontactCall::take(500)->where(function($query) use ($data){
                if($data !== "") {
                    $query->whereRaw($data);
                }
            })*/
        dd($data);
    }
}

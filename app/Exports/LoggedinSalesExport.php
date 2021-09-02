<?php

namespace App\Exports;

use App\LoginRecord;
use Maatwebsite\Excel\Concerns\FromQuery;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LoggedinSalesExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $year, int $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    /*public function collection()
    {
        return LoginRecord::all();
    }*/

    public function query()
    {
        return LoginRecord::query()->where('client_id','=',auth()->user()->client_id)
                ->whereYear('logged_in', $this->year)
                ->whereMonth('logged_in',$this->month)
                ->orderBy('logged_in','DESC');
                //->get();
    }

    public function map($loginrecord) : array {
        $rows = [];
        
            array_push($rows,[
                $loginrecord->users()->first()['name'],
                date('d F Y', strtotime($loginrecord->logged_in)),
                date('H:i:s', strtotime($loginrecord->logged_in)),
                date('H:i:s', strtotime($loginrecord->logged_out)),
            ]);
      
        return $rows;
    }

    public function headings() : array {
        return [
           'Sales Name',
           'Date',
           'First Logged In',
           'Last Logged Out'
        ] ;
    }
}

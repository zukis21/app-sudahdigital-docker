<?php

namespace App\Exports;

use App\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CategoryExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        return Category::where('client_id',auth()->user()->client_id)
        ->get();
    }

    public function map($category) : array {
        return[
                $category->id,
                $category->name,
                $category->parent_id,
            ];
    }

    public function headings() : array {
        return [
           'Id',
           'Category Name',
           'Parent Id',
        ] ;
    }

    
}

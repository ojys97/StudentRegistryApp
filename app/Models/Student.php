<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;
use Illuminate\Support\Facades\Log;

class Student extends Model
{
    use HasFactory;


    protected $fillable = [
        
        'name',
        'email',
        'address',
        'course',
    ];

    public static function importFromExcel($file)
    {
        try {
            $importedData = Excel::toCollection(new StudentImport, $file)->first();

            foreach ($importedData as $row) {
                if (isset($row['email'])) {
                    $student = self::updateOrCreate(
                        ['email' => $row['email']], // Unique identifier 
                        [
                            'name' => $row['name'],
                            'address' => $row['address'],
                            'course' => $row['course'],
                        ]
                    );
                }
            }

            Log::info('Import successful');
        } catch (\Exception $e) {
            Log::error('Error during import: ' . $e->getMessage());
            throw $e; 
        }
    }

}

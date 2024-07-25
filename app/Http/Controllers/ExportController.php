<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SplTempFileObject; 

class ExportController extends Controller
{
    public function export()
    {
        $users = User::all(); 
        // Create a temporary file (php://temp) to store CSV content
        $temp = new SplTempFileObject();
        $temp->fputcsv(['ID', 'Name', 'Email']); // Insert header

        foreach ($users as $user) {
            $temp->fputcsv([$user->id, $user->name, $user->email]); // Insert each user's data as CSV row
        }

        // Set file pointer to the beginning of the file
        $temp->rewind();

        $filename = 'users_data.csv';

        // Set headers to force download
        return Response::stream(function() use ($temp) {
            while(!$temp->eof()) {
                echo $temp->fgets();
            }
            $temp = null; // Close and cleanup the temporary file
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}

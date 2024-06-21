<?php
  
namespace App\Imports;
  
use App\Models\Project_respondent;
use Maatwebsite\Excel\Concerns\ToModel;
  
class RespondentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Project_respondent([
            'respondent_id' => $row['profile_id'],
            'project_id'    => $row['email'], 
        ]);
    }
}
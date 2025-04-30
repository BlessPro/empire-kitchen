namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectsExport implements FromCollection
{
    public function collection()
    {
        return Project::with('client')->get(); // also fetches related client data
    }
}
